<?php
class Category_model extends CI_Model
{

	protected $database;

	public function __construct()
	{
		$this->load->database();
	}

	public function total() {
		return $this->db->count_all('product_categories');
	}

	public function get_category($id)
	{
		$query = $this->db->get_where('product_categories', array(
			'id' => $id
		))->result();

		if( empty($query) )
		{
			return NULL;
		}
		else
		{
			return $query[0];
		}
	}

	public function add_category()
	{
		$this->db->set('name', $this->input->post('name'));
		
		if ($this->input->post('parent'))
		{
			$this->db->set('parent_id', $this->input->post('parent'));
		}
		
		$this->db->insert('product_categories');

		$is_category_added = $this->db->affected_rows();
		$product_id = $this->db->insert_id();

		// Add slug
		$this->db->where('id', $product_id);
		$this->db->update('product_categories', array(
			'slug' => $this->gen_sku($this->input->post('name'), $product_id)
		));

		// Add attributes.
		$this->add_attributes($product_id);

		return $is_category_added;
	}

	public function update_category()
	{
		if ($this->input->post('name'))
		{
			$insert = array();

			$category_id = $this->input->post('id');

			$this->db->where('id', $category_id);
			$this->db->update('product_categories', array(
				'name' => $this->input->post('name'),
				'slug' => $this->gen_sku($this->input->post('name'), $category_id)
			));

			if ($this->db->affected_rows())
			{
				// Set a custom status message stating that data has been successfully updated.
				$this->flexi_cart_admin->set_status_message('Category has been updated.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return TRUE;
			}
			else
			{
				// Set a custom status message stating that data has been unsuccessfully inserted.
				$this->flexi_cart_admin->set_error_message('Category could not be updated.', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				return FALSE;
			}
		}
		else
		{
			// Set a custom status message stating that data has unbeen successfully inserted.
			$this->flexi_cart_admin->set_error_message('Category could not be updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

	public function delete_category()
	{
		foreach ($this->input->post('delete') as $key => $row)
		{
			$this->db->where('id', $key);
		}
		
		$this->db->delete('product_categories');

		if ($this->db->affected_rows())
		{
			// Set a custom status message stating that data has been successfully inserted.
			$this->flexi_cart_admin->set_status_message('Category has been deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Set a custom status message stating that data has been successfully inserted.
			$this->flexi_cart_admin->set_error_message('Category could not be deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->error_messages('admin'));
			return FALSE;
		}
	}

	public function get_attributes($category_id = null, $name = false, $inherit = false)
	{
		if ($name)
		{
			$this->db->where('name', $name);
		}

		if ($inherit)
		{
			// Reset value.
			$this->lineage = array();
			$this->db->where_in('category_id', $this->get_lineage($category_id, FALSE));
		}
		else
		{
			$this->db->where('category_id', $category_id);
		}

		$this->db->select('product_category_attributes.*, product_categories.name AS category_name');
		$this->db->join('product_categories', 'product_categories.id = product_category_attributes.category_id');
		$attributes = $this->db->get('product_category_attributes')->result();


		foreach ($attributes as $key => $attribute)
		{
			$attribute->descriptions =  $this->db->get_where(
				'product_category_attribute_descriptions',
				array(
					'attribute_id' => $attribute->id
				)
			)->result();
		}
		return $attributes;
	}

	public function add_attributes($category_id)
	{
		$attribute_names = $this->input->post('insert_attribute_name');
		$attribute_values = $this->input->post('insert_attribute_value');
		$attribute_options = $this->input->post('insert_attribute_is_option');

		foreach ($attribute_names as $key => $attribute_name)
		{
			// Define attribute values for this attribute.
			$values_string = trim($attribute_values[$key]);

			if ($attribute_name AND $values_string)
			{
				$where = array(
					'category_id' => $category_id,
					'name' => $attribute_name,
					'is_option' => (bool) $attribute_options[$key],
				);

				// Get the number of duplicate rows.
				$this->db->where($where);
				$dupe_num = $this->db->count_all_results('product_category_attributes');
				
				if ($dupe_num == 0)
				{
					// Only add attribute that do not exist.
					$this->db->insert('product_category_attributes', $where);

					// Confirm database update.
					if ($this->db->affected_rows())
					{
						// Get the inserted attribure id.
						$attribute_id = $this->db->insert_id();

						// Remove spaces before and after commas.
						$values_string = str_replace(', ', ',' , $values_string);
						$values_string = str_replace(' ,', ',' , $values_string);

						// Separate individual values from string of values.
						$values_array = explode(",", $values_string);

						foreach ($values_array as $value)
						{
							$where = array(
								'attribute_id' => $attribute_id,
								'name' => $value,
							);

							// Get the number of duplicate rows.
							$this->db->where($where);
							$dupe_num = $this->db->count_all_results('product_category_attribute_descriptions');

							if ($dupe_num == 0)
							{
								// Only add descriptions that do not exist.
								$this->db->insert('product_category_attribute_descriptions', $where);
							}
						}
					}
				}
			}
		}

		if ($this->db->affected_rows())
		{
			// Set a custom status message stating that data has been successfully inserted.
			$this->flexi_cart_admin->set_status_message('Attribute(s) has been added.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Set a custom status message stating that data has been successfully inserted.
			$this->flexi_cart_admin->set_error_message('Attribute(s) could not be added.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return FALSE;
		}
	}

	public function update_attributes()
	{
		$attribute_ids = $this->input->post('attribute_ids');
		$attribute_names = $this->input->post('attribute_name');
		$attribute_values = $this->input->post('attribute_values');
		$attribute_is_optoins = $this->input->post('is_option');

		foreach ($attribute_ids as $key => $attribute_id)
		{
			$update_attribute = array();
			$update_attribute['name'] = $attribute_names[$key];
			if (isset($attribute_is_optoins[$key]))
			{
				$update_attribute['is_option'] = (bool) $attribute_is_optoins[$key];
			}
			else
			{
				$update_attribute['is_option'] = 0;
			}

			$this->db->where('id', $attribute_id);
			$this->db->update('product_category_attributes', $update_attribute);

			$old_descriptions = array();

			// Get all description values of attribute.
			$descriptions_query = $this->db->get_where('product_category_attribute_descriptions', array(
				'attribute_id' => $attribute_id
			))->result();

			foreach ($descriptions_query as $description)
			{
				array_push($old_descriptions, $description->name);
			}

			// Define attribute values for this attribute.
			$values_string = trim($attribute_values[$key]);

			// Remove spaces before and after commas.
			$values_string = str_replace(', ', ',' , $values_string);
			$values_string = str_replace(' ,', ',' , $values_string);

			// Separate description values from attributes.
			$new_descriptions = explode(",", $values_string);

			foreach ($new_descriptions as $description)
			{
				if ( ! in_array($description, $old_descriptions))
				{
					// Only add descriptions that do not exist.
					$this->db->insert('product_category_attribute_descriptions', array(
						'attribute_id' => $attribute_id,
						'name' => $description
					));
				}
			}

			// Get the difference: old descriptions that do not appear in new array.
			$difference = array_diff($old_descriptions, $new_descriptions);

			if ($difference)
			{
				// Get attribute description IDs
				$this->db->where('attribute_id', $attribute_id);
				$this->db->where_in('name', $difference);
				$desc_query = $this->db->get('product_category_attribute_descriptions')->result();

				foreach ($desc_query as $key => $desc)
				{
					// Remove realationship in product attribute table.
					$this->db->where('attribute_description_id', $desc->id);
					$this->db->delete('product_attributes');
				}
				
				// Remove the attribute description.
				$this->db->where('attribute_id', $attribute_id);
				$this->db->where_in('name', $difference);
				$this->db->delete('product_category_attribute_descriptions');
			}
		}

		if ($this->input->post('new_attribute') AND $this->input->post('new_attribute_description'))
		{
			$post_attributes   = $this->input->post('new_attribute');
			$post_descriptions = $this->input->post('new_attribute_description');

			// Remove spaces before and after commas.
			$desc_values = str_replace(' ,', ',' , $post_descriptions);
			$desc_values = str_replace(', ', ',' , $desc_values);

			// Separate description values from each other.
			$new_descriptions = explode(",", $desc_values);

			// Insert a new attribute.
			$this->db->insert('product_category_attributes', array(
				'category_id' => $category_id,
				'name' => $post_attributes
			));
			$attribute_id = $this->db->insert_id();

			foreach ($new_descriptions as $description)
			{
				// Insert the attribute's descriptions.
				$this->db->insert('product_category_attribute_descriptions', array(
					'attribute_id' => $attribute_id,
					'name' => $description
				));
			}
		}

		// Set a custom status message stating that data has been successfully updated.
		$this->flexi_cart_admin->set_status_message('Category attributes have been updated.', 'admin', TRUE);
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		return TRUE;
	}

	public function delete_attribute($attribute_id)
	{
		// Remove the attribute.
		$this->db->where('id', $attribute_id);
		$this->db->delete('product_category_attributes');
		
		// Remove the attribute description.
		$this->db->where('attribute_id', $attribute_id);
		$count = $this->db->count_all_results('product_category_attribute_descriptions');
		if ($count > 0)
		{
			$this->db->where('attribute_id', $attribute_id);
			$this->db->delete('product_category_attribute_descriptions');
		}
		
		// Remove the product attribute relationship.
		$this->db->where('attribute_id', $attribute_id);
		$count = $this->db->count_all_results('product_attributes');
		if ($count > 0)
		{
			$this->db->where('attribute_id', $attribute_id);
			$this->db->delete('product_attributes');
		}

		if ($this->db->affected_rows())
		{
			// Set a custom status message stating that data has been successfully inserted.
			$this->flexi_cart_admin->set_status_message('Attribute has been deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Set a custom status message stating that data has been successfully inserted.
			$this->flexi_cart_admin->set_error_message('Attribute could not be deleted.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->error_messages('admin'));
			return FALSE;
		}
	}

	// Categories object.
	public function get_categories_list()
	{
		$refs = array();
		$list = array();

		// Get the base categories.	
		$categories = $this->db->get('product_categories')->result();

		foreach ($categories as $row)
		{
			$ref = & $refs[$row->id];

			$ref['id'] 	 = $row->id;
			$ref['name'] = $row->name;
			$ref['slug'] = $row->slug;

			if ($row->parent_id == 0)
			{
				$list[$row->id] = & $ref;
			}
			else
			{
				$refs[$row->parent_id]['children'][$row->id] = & $ref;
			}
		}

		return $this->compress($list);
	}
	private $html = array();
	private function compress($array, $target = 0, $parent = NULL)
	{
		foreach ( $array as $key => $v )
	    {
	    	if ( $key == $target )
	    		array_push($this->html, array(
	    			'id' => $v['id'],
	    			'name' => "$parent {$v['name']}",
	    			'slug' => $v['slug']
	    		));
	    	else
	    		array_push($this->html, array(
	    			'id' => $v['id'],
	    			'name' => "$parent {$v['name']}",
	    			'slug' => $v['slug']
	    		));

	    	if (array_key_exists('children', $v)) 
	    		$this->compress($v['children'], $target, $parent . $v['name']." > ");
	    }

	    return $this->html;
	}

	private $lineage = array();
	public function get_lineage($category_id = null, $get_data = TRUE)
	{
		// Get the category meta data.
		$category = $this->db->get_where('product_categories', array(
			'id' => $category_id
		))->result();
			
		// If this category has data (exists).
		if ( ! empty($category))
		{
			// Add category to lineage array.
			if ($get_data)
			{
				array_push($this->lineage, $category[0]);
			}
			else
			{
				array_push($this->lineage, $category[0]->id);
			}

			// Repeat this process.
			$this->get_lineage($category[0]->parent_id, $get_data);
		}

		// Reverse the lineage to get proper hierrachy.
		return array_reverse($this->lineage);
	}

	// Get categories
	public function get_categories($category_id = null, $verbose = TRUE)
	{
		if ( ! ctype_digit($category_id))
		{
			// When using slug to query. Get id of the category.
			$query = $this->db->get_where('product_categories', array(
				'slug' => $category_id
			))->result();

			if ($query)
			{
				$category_id = $query[0]->id;
			}
		}

		// Get data for category.
		$this->db->where('id', $category_id);
		$meta_data = $this->db->get('product_categories')->result();

		if ( ! $verbose)
		{
			return $meta_data;
		}

		if ( ! empty($meta_data))
		{
			// Sub-categories exist for this category.
			$meta_data = $meta_data[0];
		}
		else
		{
			// Sub-categories do not exist for this category.

			if ( ! $category_id)
			{
				// If this is the base category.
				$meta_data = new stdClass;
			
				// Add category id.
				$meta_data->id 	 = NULL;
				$meta_data->name = NULL;
				$meta_data->slug = NULL;
			}
		}

		if (isset($meta_data->id))
		{
		}
		
		// Add category pagination.
		$this->lineage = array();
		$meta_data->pagination = $this->get_lineage($category_id, TRUE);

		// Add category attributes.
		$this->lineage = array();

		$meta_data->attributes = $this->get_attributes($category_id, FALSE, ($category_id) ? TRUE : FALSE);

		// Add sub-categories for this category.
		$meta_data->sub_categories = $this->db->get_where('product_categories', array(
			'parent_id' => $category_id
		))->result();

		// Add attributes for each sub-category.
		foreach ($meta_data->sub_categories as $key => $category)
		{
			$category->attributes = $this->get_attributes($category->id, FALSE, TRUE);
		}

		return $meta_data;
	}

	// Get categories lists
	public function get_all_categories()
	{
		$this->db->order_by('CAT.parent_id', 'ASC');
		$this->db->select('CAT.id category_id');
		$this->db->select('CAT.name');
		$this->db->from('product_categories CAT');
		// Get and Join the parent category id
		$this->db->select('SUBCAT.id parent_id');
		$this->db->join('product_categories SUBCAT', 'SUBCAT.id = CAT.parent_id', 'left');
		// Get and Join the attributes count
		$this->db->select('IFNULL(attribute_count, 0) attribute_count');
		$this->db->join(
			'(
				SELECT category_id, COUNT(*) attribute_count  
				FROM product_category_attributes
				GROUP BY category_id
			) inner_1',
			'inner_1.category_id = CAT.id', 'left');


		return $this->db->get()->result();;
	}

	// Batch update
	public function update_categories()
	{
		$update_data = array();

		foreach ($this->input->post('update') as $key => $update)
		{
			$row['id'] = $key;
			$row['name'] = $update['name'];

			if ($update['parent'])
			{
				$row['parent_id'] = $update['parent'];
			}
			else
			{
				$row['parent_id'] = NULL;
			}

			array_push($update_data, $row);
		}
		$this->db->update_batch('product_categories', $update_data, 'id');

		if ($this->db->affected_rows())
		{
			// Set a custom status message stating that data has been successfully updated.
			$this->flexi_cart_admin->set_status_message('Categories have been updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			return TRUE;
		}
		else
		{
			// Set a custom status message stating that data has been successfully updated.
			$this->flexi_cart_admin->set_error_message('Categories could not be updated.', 'admin', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart_admin->error_messages('admin'));
			return FALSE;
		}
	}

	// Generate slug value
	private function gen_sku($string, $id = null, $length = 3) {
	    $result = ''; // empty string
	    $vowels = array('a', 'e', 'i', 'o', 'u', 'y'); // vowels

	    // Match every word that begins with a capital letter,
	    // add ucfirst() in case there is no uppercase letter
	    preg_match_all('/[A-Z][a-z]*/', ucfirst($string), $m);
	    
	    foreach($m[0] as $substring) {
	        // String to lower case and remove all vowels
	        $substring = str_replace($vowels, '', strtolower($substring));
	        $result   .= preg_replace('/([a-z]{'.$length.'})(.*)/', '$1', $substring); // Extract the first 'N' letters.
	        $result    = strtoupper($result);
	    }
	    $result .= '-'. str_pad($id, 4, 0, STR_PAD_LEFT); // Add the ID
	    
	    return $result;
	}

	// Get navigation links.
	public function get_nav_links()
	{
		// Get data for category.
		$this->db->where('parent_id', null);
		return $this->db->get('product_categories')->result();
	}
}