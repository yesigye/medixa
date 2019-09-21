<?php
class Product_model extends CI_Model
{

	protected $data;
	protected $count;

	public function __construct()
	{
		$this->load->database();
	}

	private $related = array();
	public function related_ids($category_id = null, $current = TRUE)
	{
		if ($current)
		{
			// Get the current category meta data.
			$current = $this->db->get_where('product_categories', array(
				'id' => $category_id
			))->result();

			if ($current)
			{
				// Add current category to children array.
				array_push($this->related, $current[0]->id);
			}
		}

		// Get the category meta data.
		$categories = $this->db->get_where('product_categories', array(
			'parent_id' => $category_id
		))->result();

		if ( ! empty($categories))
		{
			// If this category has data (exists).
			foreach ($categories as $key => $category)
			{
				// Add categories to children array.
				array_push($this->related, $category->id);
			}
			// Repeat this process using a parent id.
			$this->related_ids($categories[0]->id, FALSE);
		}

		return $this->related;
	}

	/**
	 * Return all product objects.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter product results 
	 * @return	array
	 */
	public function all($options = array())
	{
		// Set default options
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('products');
		
		$this->db->select('products.id');
		$this->db->select('products.name');
		$this->db->select('products.slug');
		$this->db->select('products.price');
		$this->db->select('products.thumb');
		
		$this->db->select('item_stock.stock_quantity AS quantity');
		$this->db->join('item_stock', 'item_stock.stock_item_fk = products.id', 'left');

		// Unless otherwise, only show active products
		if (!isset($options['ignore_status'])) $this->db->where('products.status !=', 0);
		
		// Filter result objects using the active status
		if (isset($options['status'])) {
			$this->db->where('products.status', ($options['status'] == 'active') ? 1 : 0);
		}

		// Query objects by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->where("(
				products.name LIKE '%".$options['search']."%'
				OR products.tags LIKE '%".$options['search']."%'
				OR products.description LIKE '%".$options['search']."%'
				OR item_stock.stock_quantity LIKE '%".$options['search']."%'
			)", null, false);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		if (isset($options['count'])) {
			// Option is to return number of objects in the results.
			// Don't forget to stop and clear the cache.
			$this->db->stop_cache();
			$this->db->flush_cache();

			return $this->count;
		}
		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			if ($options['order']['column'] == 'group') {
				$this->db->order_by('group_join.name', $options['order']['dir']);
			} else {
				$this->db->order_by('users.'.$options['order']['column'], $options['order']['dir']);
			}
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	public function get_products($options = array())
	{
		$result = new stdClass;

		// Re-Initialize global variable.
		// Or else results of a previous call will collide
		$this->related = array();

		$IDs = array();

		// Array to store product IDs.
		$product_ids = array();

		if (isset($options['category_id']))
		{
			$this->db->select('product_categories.id')->limit(1);
			$query = $this->db->get_where('product_categories', array(
				'slug' => $options['category_id']
			))->result();
			
			if ( ! empty($query)) $options['category_id'] = $query[0]->id;
			
			// Create a pool of category IDs under this category.
			$category_ids_pool = $this->related_ids($options['category_id']);
		}

		// We will need to cache (remember) our where clauses.
		// This allows us to get the result row count and the result object array
		// without reapeating the same query building process
		$this->db->start_cache();

		if (isset($options['attribute']))
		{
			// Adding clause for category.
			// The where clause accepts an array of category IDs because a category may have
			// multiple sub-categories which may also have other sub-categories and so on.
			$this->db->where_in('product_attributes.attribute_description_id', $options['attribute']);
			$this->db->join('product_attributes', 'product_attributes.product_id = products.id');
		}

		$this->db->select('products.id, products.name, products.slug, products.price, products.thumb');

		$this->db->from('products');

		/**
		* JOINS
		*/
		// Select the product category id and name.
		$this->db->select('inner_1.category_id, inner_1.category');

		// Do a double inner join.
		// inner 2 (inner join) gets the category name as "category" based on the category id
		// inner 1 (outer join) 'returns' data from inner join based on the product id.
		$this->db->join(
		'(
			SELECT category, product_id, category_id FROM product_category
			LEFT JOIN
			(
				SELECT product_categories.id, product_categories.name AS category  
				FROM product_categories
			) inner_2
			ON
			product_category.category_id = inner_2.id
		) inner_1',
		'inner_1.product_id = products.id', 'left');

		// Add the stock quantity
		$this->db->select('item_stock.stock_quantity AS quantity');
		$this->db->join('item_stock', 'item_stock.stock_item_fk = products.id', 'left');

		// Query products at random
		if (isset($options['random'])) $this->db->order_by('id', 'RANDOM');
		
		if (isset($options['order']))
		{
			if ($options['order'] === 'latest')
			{
				// Query products at random
				$this->db->order_by('products.id', 'DESC');
			}
			elseif ($options['order'] === 'lowpx')
			{
				// Query products at random
				$this->db->order_by('products.price', 'ASC');
			}
			elseif ($options['order'] === 'hghpx')
			{
				// Query products at random
				$this->db->order_by('products.price', 'DESC');
			}
			elseif ($options['order'] === 'alpha')
			{
				// Query products at random
				$this->db->order_by('products.name', 'ASC');
			}
		}

		// Adding clause for seller.
		if (isset($options['seller'])) $this->db->where_in('company_id', $options['seller']);

		// Category Inheritance: The where in clause accepts an array of IDs
		// that includes the category ID and IDs of the category's parents.
		if (isset($options['category_id']))
		{
			// Adding clause for category.
			// The where clause accepts an array of category IDs because a category may have
			// multiple sub-categories which may also have other sub-categories and so on.
			$this->db->where_in('product_category.category_id', $category_ids_pool);
			$this->db->join('product_category', 'product_category.product_id = products.id');
		}

		// Adding clause for price range.
		if (isset($options['price_range'])) $this->db->where('products.price <=', $options['price_range']);

		// Exclude a specific product.
		if (isset($options['exclude'])) $this->db->where('products.id !=', $options['exclude']);

		// Search by keywords
		if (isset($options['search']))
		{
			$this->db->like('products.name', $options['search']);
			$this->db->or_like('products.price', $options['search']);
		}

		// Count the items before applying pagination and limits.
		$result->count = $this->db->count_all_results();

		// Limit number of results results.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);

		$result->products = $this->db->get()->result();

		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	public function min_price($category_id = FALSE)
	{
		$this->db->limit(1);
		$this->db->select_min('price');
		$this->db->where('product_category.category_id', $category_id);
		$this->db->join('product_category', 'product_category.product_id = products.id');
		$min = $this->db->get('products')->result();

		if ($min)
		{
			return $min[0]->price;
		}
		else
		{
			return FALSE;
		}
	}

	public function max_price($category_id = FALSE)
	{
		$this->db->limit(1);
		$this->db->select_max('price');
		$this->db->where('product_category.category_id', $category_id);
		$this->db->join('product_category', 'product_category.product_id = products.id');
		$max = $this->db->get('products')->result();
		
		if ($max)
		{
			return $max[0]->price;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_product_options($product_id)
	{
		$result = array();

		$this->db->where('product_id', $product_id);
		$attributes = $this->db->get('product_attributes')->result();

		foreach ($attributes as $key => $row)
		{
			// Get attribute data.
			$this->db->where('id', $attributes[$key]->attribute_id);
			$this->db->where('is_option', 1);
			$query = $this->db->get('product_category_attributes')->result();
			
			if (!empty($query))
			{
				if (!isset($result[$row->attribute_id]))
				{
					// Define and array of new attribute values.
					$result[$row->attribute_id] = array(
						'id' => $query[0]->id,
						'name' => $query[0]->name,
						'values' => array(),
					);
				}

				// Get attribute values.
				$this->db->select('id, name');
				$this->db->where('id', $attributes[$key]->attribute_description_id);
				$query = $this->db->get('product_category_attribute_descriptions')->result_array();

				// Add values to created attribute array.
				array_push($result[$row->attribute_id]['values'], $query[0]);
			}
		}
		return $result;
	}

	public function get_product_variants($product_id)
	{

		$this->db->select('product_options.id, product_options.price, product_options.weight');
		$this->db->where('product_id', $product_id);
		$variants = $this->db->get('product_options')->result();

		foreach ($variants as $key => $row)
		{
			// Get images for variant.
			$this->db->where('product_option_id', $row->id);
			$row->images = $this->db->get('product_option_images')->result();
			foreach ($row->images as $key => $img)
			{
				// Define a proper link to file names.
				if (is_file($this->data['upload_path'].$img->url))
				{
					$img->url = base_url($this->data['upload_path'].$img->url);
				}
				else
				{
					$img->url = NULL;
				}
			}

			
			// Get attribute data.
			$this->db->where('product_option_id', $row->id);
			$query = $this->db->get('product_option_groups')->result();
			
			$row->options_set = array();
			
			foreach ($query as $item)
			{
				array_push($row->options_set, $item->attribute_description_id);
			}
		}

		return $variants;
	}

	public function get_product_variant($variant_id)
	{

		$this->db->select('product_options.id, product_options.price, product_options.weight');
		$this->db->where('id', $variant_id);
		$variants = $this->db->get('product_options')->result();

		foreach ($variants as $key => $row)
		{
			// Get attribute data.
			$this->db->where('product_option_id', $row->id);
			$query = $this->db->get('product_option_groups')->result();
			
			$row->options_set = array();
			
			foreach ($query as $item)
			{
				array_push($row->options_set, $item->attribute_description_id);
			}
		}

		if (!empty($variants)) $variants = $variants[0];

		return $variants;
	}

	public function get_product_variant_by_slug($product_id, $slug, $glue="-")
	{
		$this->db->select('product_options.id, product_options.price, product_options.weight');
		$this->db->where('product_options.product_id', $product_id);
		$this->db->where_in('product_option_groups.attribute_description_id', explode($glue, $slug));
		$this->db->join('product_options', 'product_options.id = product_option_groups.product_option_id');
		$this->db->from('product_option_groups');

		$variant = $this->db->get()->result();

		if (!empty($variant))
		{
			$variant = $variant[0];
			// Get images for variant.
			$this->db->where('product_option_id', $variant->id);
			$variant->images = $this->db->get('product_option_images')->result();
			foreach ($variant->images as $key => $img)
			{
				// Define a proper link to file names.
				if (is_file($this->data['upload_path'].$img->url))
				{
					$img->url = base_url($this->data['upload_path'].$img->url);
				}
				else
				{
					$img->url = NULL;
				}
			}
		}

		return $variant;
	}

	public function get_latest_in_category($limit)
	{
		// Get the latest product.
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$this->db->select('product_category.category_id');
		$query = $this->db->get('product_category')->result();

		if (empty($query)) return NULL;
		
		/**
		* JOINS
		*/
		// Add the category
		$this->db->select('products.id AS id');
		$this->db->select('products.name, products.price, products.thumb');

		// Add the stock quantity
		$this->db->select('item_stock.stock_quantity AS quantity');
		$this->db->join('item_stock', 'item_stock.stock_item_fk = products.id');

		// Add product category id
		$this->db->select('product_category.category_id');
		$this->db->join('product_category', 'product_category.product_id = products.id');

		// Select the product category name.
		$this->db->select('inner_1.category');

		// Do a double inner join.
		// inner 2 (inner join) gets the category name as "category" based on the category id
		// inner 1 (outer join) 'returns' data from inner join based on the product id.
		$this->db->join(
		'(
			SELECT category, product_id FROM product_category
			LEFT JOIN
			(
				SELECT product_categories.id, product_categories.name AS category  
				FROM product_categories
			) inner_2
			ON
			product_category.category_id = inner_2.id
		) inner_1',
		'inner_1.product_id = products.id', 'left');
		
		$this->db->where('product_category.category_id', $query[0]->category_id);
		
		$this->db->limit($limit);

		$this->db->from('products');

		return $this->db->get()->result();
	}

	public function get_details($slug)
	{
		/**
		* JOINS
		*/
		// Add the category
		$this->db->select('products.id AS id');
		$this->db->select('products.name, products.description, products.slug, products.tags, products.price, products.weight, products.thumb');

		// Add the stock quantity
		$this->db->select('item_stock.stock_quantity AS quantity');
		$this->db->join('item_stock', 'item_stock.stock_item_fk = products.id');

		// Add product category id
		$this->db->select('product_category.category_id');
		$this->db->join('product_category', 'product_category.product_id = products.id');
		
		(ctype_digit($slug)) ? $this->db->where('products.id', $slug) : $this->db->where('products.slug', $slug);

		$this->db->from('products');

		$products = $this->db->get()->result();

		if ($products)
		{
			$product = $products[0];

			//Define full thumb path.
			$product->thumb = base_url().$this->data['upload_path'].$product->thumb;

			// Define where cluase.
			$clause = array('product_id' => $product->id);

			// Get Category details.
			$this->db->select('id')->limit(1);
			$query = $this->db->get_where('product_categories', array(
				'id' => $product->category_id
			))->result();
			if (! empty($query))
				$category = $query[0];
			else
				$category = FALSE;

			// Add category to object.
			$product->category = $category;

			// Get images.
			$product->images = $this->db->get_where('product_images', $clause)->result();

			foreach ($product->images as $key => $img)
			{
				// Define a proper link to file names.
				if (is_file($this->data['upload_path'].$img->url))
				{
					$img->url = base_url($this->data['upload_path'].$img->url);
				}
				else
				{
					$img->url = NULL;
				}
			}

			if ($product->category)
			{
				// Get Product category attributes.
				$this->load->model('category_model');

				$product->attributes = $this->category_model->get_attributes($product->category->id, FALSE, TRUE);

				foreach ($product->attributes as $key => $attribute)
				{
					$attribute->has_descriptions = FALSE;

					// Get attribute and descriptions.
					$attribute->descriptions =  $this->db->get_where('product_category_attribute_descriptions',array(
						'attribute_id' => $attribute->id
					))->result();

					foreach ($attribute->descriptions as $index => $description)
					{
						// Check whether the product has this attribute and description
						$product_attributes = $this->db->get_where('product_attributes', array(
							'product_id' => $product->id,
							'attribute_id' => $attribute->id,
							'attribute_description_id' => $description->id
						))->result();

						$description->checked = ( empty($product_attributes) ) ? FALSE : TRUE;
						if ( ! $attribute->has_descriptions)
						{
							$attribute->has_descriptions = ( empty($product_attributes) ) ? FALSE : TRUE;
						}
					}
				}
			}


			return $product;
		}
		else
		{
			return FALSE;
		}
	}

	// Batch update
	public function update_products()
	{
		$product_data = array();
		$category_data = array();
		$quantity_data = array();

		foreach ($this->input->post('update') as $key => $update)
		{
			$product['id'] = $key;
			$product['name'] = $update['name'];
			$product['slug'] = url_title($update['name']);
			$product['price'] = $update['price'];
			array_push($product_data, $product);
			
			$category['product_id'] = $key;
			$category['category_id'] = $update['category'];
			array_push($category_data, $category);

			$quantity['stock_item_fk'] = $key;
			$quantity['stock_quantity'] = $update['quantity'];
			array_push($quantity_data, $quantity);
		}

		$this->db->update_batch('item_stock', $quantity_data, 'stock_item_fk');
		$stock_update = $this->db->affected_rows();
		$this->db->update_batch('product_category', $category_data, 'product_id');
		$categ_update = $this->db->affected_rows();
		$this->db->update_batch('products', $product_data, 'id');
		$items_update = $this->db->affected_rows();

		if ($stock_update OR $categ_update OR $items_update)
		{
			// Set a custom status message stating that data has been successfully updated.
			$this->flexi_cart_admin->set_status_message('Products have been updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Set a custom status message stating that data has been unsuccessfully updated.
			$this->flexi_cart_admin->set_error_message('Products could not be updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->error_messages('admin'));
			return FALSE;
		}
	}

	public function add_product($id = false)
	{
		// Define product key data.
		$product['name'] = $this->input->post('name');
		$similar = $this->db->get_where('products', $product)->result();

		if ( empty($similar) )
		{
			$product['slug']	= url_title($this->input->post('name'));
			$product['tags']	= $this->input->post('tags');
			$product['price']	= $this->input->post('price');
			$product['weight']  = $this->input->post('weight');
			$product['description'] = $this->input->post('description');

			if ($_FILES['userfile']['size'] > 0)
			{
				$avatar = $this->upload_image();
				if ( ! $avatar['error'])
					$product['thumb'] = $avatar['path'];
			}

			$this->db->insert('products', $product);

			$insert_id = $this->db->insert_id();

			// Insert the item stock
			$this->db->insert('item_stock', array(
				'stock_item_fk' => $insert_id,
				'stock_quantity' => $this->input->post('stock'),
				'stock_auto_allocate_status' => 1
			));

			// Insert the category
			$this->db->insert('product_category', array(
				'product_id' => $insert_id,
				'category_id' => $this->input->post('category'),
			));

			// Set a custom status message stating that data has been successfully inserted.
			$this->flexi_cart_admin->set_status_message('Your product has been added.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return $insert_id;
		}
		else
		{
			// Set a custom status message stating that the product already exists.
			$this->flexi_cart_admin->set_error_message('A similar product already exists.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

	public function add_product_option($product_id)
	{
		$this->db->where('product_id', $product_id);
		$this->db->where('price', $this->input->post('option_price'));
		$this->db->where('weight', $this->input->post('option_weight'));

		if ($this->db->count_all_results('product_options') == 0)
		{
			$this->db->set('product_id', $product_id);
			$this->db->set('price', $this->input->post('option_price'));
			$this->db->set('weight', $this->input->post('option_weight'));
			$this->db->insert('product_options');

			$product_option_id = $this->db->insert_id();

			if ($this->db->affected_rows())
			{
				$upload_path = $this->app['file_path'];

				// load and initialize the CI upload library
				$this->load->library('upload', array(
					"upload_path" 	=> $upload_path,
					"encrypt_name" 	=> TRUE,
					"allowed_types" => "jpg|png|jpeg|JPEG|PNG",
					"max_size" 		=> 2000,
					"xss_clean" 	=> TRUE, // Turn false for PDF
				));

				if ($this->upload->do_multi_upload('files'))
				{
					$images = $this->upload->get_multi_upload_data();

					$insert_images = array();

					// resize each uploaded image
					foreach ($images as $key => $image)
					{
						array_push($insert_images, array(
							'product_option_id' => $product_option_id,
							'url' => $upload_path.$image['file_name']
						));
					}
					
					// Insert images into product_option_images table.
					$this->db->insert_batch('product_option_images', $insert_images);
				}

				foreach ($this->input->post('option') as $key => $value_id)
				{
					if ($value_id)
					{
						$this->db->where('product_option_id', $product_option_id);
						$this->db->where('attribute_description_id', $value_id);
						if ($this->db->count_all_results('product_option_groups') == 0)
						{
							$this->db->set('product_option_id', $product_option_id);
							$this->db->set('attribute_description_id', $value_id);
							$this->db->insert('product_option_groups');
						}
					}
				}

				$this->session->set_flashdata('alert', array('location'=> 'options'));

				$this->flexi_cart_admin->set_status_message('Product option was added.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return TRUE;
			}
			else
			{
				// Tell view where error occured.
				$this->session->set_flashdata('alert', array('location'=> 'options'));

				$this->flexi_cart_admin->set_error_message('Product option could not be added.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return FALSE;
			}
		}
	}

	public function get_product_option($option_id)
	{
		$this->db->where('id', $option_id);
		$option = $this->db->get('product_options')->result();

		if (!empty($option))
		{
			$option = $option[0];
			// Get images for variant.
			$this->db->where('product_option_id', $option->id);
			$option->images = $this->db->get('product_option_images')->result();
			foreach ($option->images as $key => $img)
			{
				// Define a proper link to file names.
				if (is_file($this->data['upload_path'].$img->url))
				{
					$img->url = base_url($this->data['upload_path'].$img->url);
				}
				else
				{
					$img->url = NULL;
				}
			}

			$values = $this->db->where('product_option_id', $option_id)->get('product_option_groups')->result();
			$option->values = array();
			foreach ($values as $key => $value) array_push($option->values, $value->attribute_description_id);
		}

		return $option;
	}

	public function update_product_option($option_id)
	{
		$this->db->set('price', $this->input->post('option_price'));
		$this->db->set('weight', $this->input->post('option_weight'));

		$this->db->where('id', $option_id);
		$this->db->update('product_options');

		$upload_path = $this->app['file_path'];

		// load and initialize the CI upload library
		$this->load->library('upload', array(
			"upload_path" 	=> $upload_path,
			"encrypt_name" 	=> TRUE,
			"allowed_types" => "jpg|png|jpeg|JPEG|PNG",
			"max_size" 		=> 2000,
			"xss_clean" 	=> TRUE, // Turn false for PDF
		));

		if ($this->upload->do_multi_upload('files'))
		{
			$images = $this->upload->get_multi_upload_data();

			$insert_images = array();

			// resize each uploaded image
			foreach ($images as $key => $image)
			{
				array_push($insert_images, array(
					'product_option_id' => $option_id,
					'url' => $upload_path.$image['file_name']
				));
			}
			
			// Insert images into product_option_images table.
			$this->db->insert_batch('product_option_images', $insert_images);
		}

		$this->db->where('id', $option_id);
		$this->db->delete('product_option_groups');

		$this->db->set('product_option_id', $option_id);
		foreach ($this->input->post('values') as $key => $value)
		{
			if ($value > 0) $this->db->set('attribute_description_id', $value);
		}
		$this->db->insert('product_option_groups');

		if ( ! $this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_error_message('Product option could not be updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}

		$this->flexi_cart_admin->set_status_message('Product option was updated.', 'admin', TRUE);
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		return FALSE;
	}

	public function delete_product_option($option_id)
	{
		$this->db->where('id', $option_id);
		$this->db->delete('product_options');

		if ($this->db->affected_rows())
		{
			$this->session->set_flashdata('alert', array('location'=> 'options'));

			$this->flexi_cart_admin->set_status_message('Product option was deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Tell view where error occured.
			$this->session->set_flashdata('alert', array('location'=> 'options'));

			$this->flexi_cart_admin->set_error_message('Product option could not be deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
	}

	public function update_product($product_id)
	{
		$old_item = $this->db->get_where('products', array('id'=>$product_id))->result();

		if (!empty($old_item))
		{
			$old_item = $old_item[0];

			$product['name'] = $this->input->post('name');
			$product['slug'] = url_title($this->input->post('name'));
			$product['tags'] = $this->input->post('tags');
			$product['price'] = $this->input->post('price');
			$product['weight'] = $this->input->post('weight');
			$product['description'] = $this->input->post('description');

			if (isset($_FILES['userfile']['size']))
			{
				$avatar = $this->upload_image();
				if ( ! $avatar['error']) $product['thumb'] = $avatar['path'];
			}

			$this->db->where('id', $product_id);
			$this->db->update('products', $product);

			// Product details update status
			$details_update = $this->db->affected_rows() ? TRUE : FALSE;

			// Insert the category
			$this->db->where('product_id', $product_id);
			$this->db->update('product_category', array(
				'category_id' => $this->input->post('category'),
			));
			// Product category update status
			$category_update = $this->db->affected_rows() ? TRUE : FALSE;

			// Tell view where we are updating.
			if ($details_update) $this->session->set_flashdata('alert', array('location' => 'details'));

			if ($details_update OR $category_update OR $attribute_update OR $images_update)
			{
				$this->flexi_cart_admin->set_status_message(($category_update) ? 'Item category has changed, You may want to update attributes' : 'Item has been updated.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return TRUE;
			}
			else
			{
				// Tell view where error occured.
				$this->session->set_flashdata('alert', array('location'=> 'details'));

				$this->flexi_cart_admin->set_error_message(($category_update) ? 'Item could not be updated.' : 'Item has been updated.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return TRUE;
			}
		}

		else
		{
			// Tell view where error occured.
			$this->session->set_flashdata('alert', array('location'=> 'details'));

			$this->flexi_cart_admin->set_error_message('You tried to update an item that does not exist.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
	}

	public function update_product_attributes($product_id, $attributes)
	{
		// Delete current relationships.
		$this->db->where('product_id', $product_id);
		$this->db->delete('product_attributes');

		foreach ($attributes as $key => $data)
		{
			$segment = explode("_", $data);

			// Insert new relationships.
			$this->db->insert('product_attributes', array(
				'product_id' => $product_id,
				'attribute_id' => $segment[0],
				'attribute_description_id' => $segment[1]
			));
		}

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Item attributes have updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			$this->flexi_cart_admin->set_error_message('Item attributes could not be updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
	}

	public function get_product_defaults($product_id)
	{
		// Delete current relationships.
		$this->db->select('attribute_description_id');
		$this->db->where('product_id', $product_id);
		$this->db->from('product_option_defaults');
		$dbResult = $this->db->get()->result();

		$defaults = array();

		foreach ($dbResult as $key => $value) array_push($defaults, $value->attribute_description_id);

		return $defaults;
	}

	public function update_product_defaults($product_id)
	{
		// Delete current relationships.
		$this->db->where('product_id', $product_id);
		$this->db->delete('product_option_defaults');

		$defaults = $this->input->post('default');

		foreach ($defaults as $key => $value)
		{
			if ($value > 0)
			{
				// Insert new relationships.
				$this->db->insert('product_option_defaults', array(
					'product_id' => $product_id,
					'attribute_description_id' => $value
				));
			}
		}

		if ($this->db->affected_rows())
		{
			$this->flexi_cart_admin->set_status_message('Item default options have updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			$this->flexi_cart_admin->set_error_message('Item default options could not be updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
	}

	public function update_product_images($product_id)
	{
		$upload_path = $this->app['file_path'];

		// load and initialize the CI upload library
		$this->load->library('upload', array(
			"upload_path" 	=> $upload_path,
			"encrypt_name" 	=> TRUE,
			"allowed_types" => "jpg|png|jpeg|JPEG|PNG",
			"max_size" 		=> 2000,
			"xss_clean" 	=> TRUE, // Turn false for PDF
		));

		if ($this->upload->do_multi_upload('files'))
		{
			$images = $this->upload->get_multi_upload_data();

			$insert_images = array();

			// resize each uploaded image
			foreach ($images as $key => $image)
			{
				array_push($insert_images, array(
					'product_id' => $product_id,
					'url' => $upload_path.$image['file_name']
				));
			}
			
			// Insert images into product_images table.
			$this->db->insert_batch('product_images', $insert_images);

			if ($this->db->affected_rows())
			{
				$this->flexi_cart_admin->set_status_message('Item images have updated.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return TRUE;
			}
			else
			{
				$this->flexi_cart_admin->set_error_message('Item images could not be updated.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return FALSE;
			}
		}
		else
		{
			$this->flexi_cart_admin->set_error_message('Item images could not be uploaded.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

	public function update_product_thumbnail($product_id, $file_id)
	{
		$is_uploaded = FALSE;

		if ( ! $file_id)
		{
			$is_uploaded = TRUE;
			// Uplaod file.
			$fileIDs = $this->upload_product_images($product_id);

			if ($fileIDs)
			{
				$file_id = $fileIDs[0];
			}
			else
			{
				return FALSE;
			}
		}

		$upload_path = $this->app['file_path'];
		
		$files = $this->db->get_where('product_images', array(
			'id' => $file_id
		))->result();

		if ( ! empty($files))
		{
			$this->load->helper('file');


			$path = $upload_path.$files[0]->filename;
			$file = get_file_info($path);

			// At every '.' break string up into segments
			$segments  = explode('.', $file['name']);
			$file_ext  = $segments[count($segments)-1]; // absolute last segment.
			unset($segments[count($segments)-1]); // remove absolute last segment.
			$file_name = implode('.', $segments);  // rebuild the string.

			$image_path = $upload_path.$file['name'];
			$thumb_name = $product_id.$file_name.'-thumb.'.$file_ext;
			$thumb_path = $upload_path.$thumb_name;

			// load the CI image manipulation library with these configurations
			$config['source_image']		= $image_path;
			$config['new_image']		= $thumb_path;
			$config['width']	 		= 150;
			$config['height']			= 150;

			$this->load->library('image_lib', $config);

			if ($this->image_lib->resize())
			{
				$products = $this->db->get_where('products', array(
					'id' => $product_id
				))->result();

				foreach ($products as $key => $product)
				{
					// Delete old thumbnail from local storage.
					$path = $upload_path.$product->thumb;
					unlink($path);
				}

				$this->db->where('id', $product_id);
				$this->db->update('products', array(
					'thumb' => $thumb_name,
				));
				return TRUE;
			}
		}
		else
		{
			if ($is_uploaded)
			{
				// Remove uploaded products image from which thumnail was created.
				$this->delete_product_image($file_id);
			}

			return FALSE;
		}
	}

	public function delete_product_image($file_id)
	{
		$upload_path = $this->app['file_path'];
		
		$files = $this->db->get_where('product_images', array(
			'id' => $file_id
		))->result();
		foreach ($files as $key => $file)
		{
			// Delete files from local storage.
			$path = $file->url;

			if (is_file($path)) unlink($path);
		}
		$this->db->delete('product_images', array(
			'id' => $file_id
		));

		if ($this->db->affected_rows())
		{
			return array(
				'error' => true,
				'alert' => array(
					'type' 	  => 'success',
					'location' => 'images',
					'message' => 'Image has been deleted.'
				)
			);
		}
		else
		{
			return array(
				'error' => true,
				'alert' => array(
					'type' 	  => 'danger',
					'location' => 'images',
					'message' => 'Image could not be deleted.'
				)
			);
		}
	}

	public function delete_product_option_image($file_id)
	{
		$upload_path = $this->app['file_path'];
		
		$files = $this->db->get_where('product_option_images', array(
			'id' => $file_id
		))->result();
		foreach ($files as $key => $file)
		{
			// Delete files from local storage.
			$path = $file->url;

			if (is_file($path)) unlink($path);
		}
		$this->db->delete('product_option_images', array(
			'id' => $file_id
		));

		if ($this->db->affected_rows())
		{
			return array(
				'error' => true,
				'alert' => array(
					'type' 	  => 'success',
					'location' => 'images',
					'message' => 'Image has been deleted.'
				)
			);
		}
		else
		{
			return array(
				'error' => true,
				'alert' => array(
					'type' 	  => 'danger',
					'location' => 'images',
					'message' => 'Image could not be deleted.'
				)
			);
		}
	}

	public function delete_product($id)
	{
		$products = $this->db->get_where('products', array(
			'id' => $id
		))->result();

		$upload_path = $this->app['file_path'];
		
		// Define images associated with item.
		// Add thumbnail to item images array.
		$item_images = array($products[0]->thumb);
		// Query item images.
		$this->db->select('url');
		$images = $this->db->get_where('product_images', array(
			'product_id' => $id
		))->result();
		// Add item images to images array.
		foreach ($images as $image) array_push($item_images, $image->url);

		$this->db->select('id');
		$options = $this->db->get_where('product_options', array(
			'product_id' => $id
		))->result();
		// Add item images to images array.
		foreach ($options as $option)
		{
			$this->db->select('url');
			$option_images = $this->db->get_where('product_option_images', array(
				'product_option_id' => $option->id
			))->result();
			foreach ($option_images as $option_image) array_push($item_images, $option_image->url);
		}

		// Delete product.
		// Thanks to the DB schema, the DBMS takes care of deleting product data in foreign tables
		$this->db->delete('products', array('id' => $id));

		if ($this->db->affected_rows())
		{
			foreach ($item_images as $image)
			{
				// Delete existing associated item images from local storage.
				if (is_file($image)) unlink($image);
			}

			$this->flexi_cart_admin->set_status_message('Item(s) have been deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			$this->flexi_cart_admin->set_error_message('Item(s) could not be delete.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}


	private function upload_image($field = 'userfile', $resize = TRUE, $filename = NULL)
	{
		// Path that the thumbnail image will be uploaded to
		$uploadPath = $this->app['file_path'];

		// Ensure that the upload directory exists
		if ( ! file_exists($uploadPath) )
		{
			if ( ! mkdir($uploadPath, 0777, true) )
			{
				// Return an error if it should occur
				return array(
					"error" => 'create directory "assets/images/store" and retry'
				);
			}
		}
		// Load the CI upload library
		$config['upload_path'] 		= $uploadPath;
        $config['allowed_types']	= "jpg|png|jpeg|JPEG|PNG";
        $config['max_width'] 		= 0;
        $config['max_height'] 		= 0;
        $config['max_size'] 		= 0;
		$config['remove_spaces'] 	= FALSE;
        $config['encrypt_name'] 	= TRUE;
        $config['overwrite'] 		= FALSE;
        $this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field))
		{
			// Return an error if it should occur
			return array(
				'error' => TRUE,
				'message' => $this->upload->display_errors()
			);
		}
		else
		{
			// Remove the old thumbnail.
			if ($filename AND is_file($uploadPath.$filename))
			{
				unlink($uploadPath.$filename);
			}

			// Get file properties data.
			$imageData = $this->upload->data();
			$file_path = $uploadPath.$imageData['file_name'];

			if ($this->input->post('crop_width') AND $this->input->post('crop_height'))
			{
				// Crop Banner image.
				$this->load->library('image_lib');
				$config['source_image']	  = $file_path;
				$config['maintain_ratio'] = FALSE;
				$config['width'] 	= $this->input->post('crop_width');
				$config['height'] 	= $this->input->post('crop_height');
				$config['x_axis'] 	= $this->input->post('crop_x');
				$config['y_axis'] 	= $this->input->post('crop_y');

				$this->image_lib->initialize($config); 

				if ( ! $this->image_lib->crop())
				{
					return array(
						'error' => TRUE,
						'message' => $this->image_lib->display_errors()
					);
				}
			}

			if ($resize)
			{
				// Resize the thumbnail.
				$config['image_library'] 	= 'gd2';
				$config['source_image']		= $file_path;
				$config['file_name']		= $file_path;
				$config['create_thumb'] 	= FALSE;
				$config['maintain_ratio'] 	= TRUE;
				$config['width']	 		= 150;
				$config['height']			= 150;

				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				$this->image_lib->resize($config);
			}


			return array(
				'error' => FALSE,
				'path' => $file_path
			);
		}
	}
}

/* End of file Product_model.php */
/* Location: ./application/models/Product_model.php */