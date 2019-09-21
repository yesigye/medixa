<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Tree Model
*
* Description:  Working with a parent child table.
*
* Requirements: PHP5 or above
*
*/

class Tree_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	function getCategoriesArray($parent_id = NULL, $padding=0)
	{
		$return = array();
		$return = $this->getSubCategoriesArray($parent_id, $padding);
		return $return;
	}

	// function getSubCategoriesArray($parent_id, $padding, $prefix){
	// 	static $i=0;
	// 	static $return = array();

	// 	$resource = $this->getAllSubCategories($parent_id);

	// 	foreach ($resource as $records_array)
	// 	{
	// 		var_dump($padding);
	// 		$return['id'][$i] = $records_array['id'];

	// 		if(is_int($padding))
	// 		{
	// 			$return['name'][$i] = "<div style='padding-left:".$padding."px'>".
	// 			$prefix ." &nbsp;".$records_array['name']."</div>";
	// 		}
	// 		else
	// 		{
	// 			$return['name'][$i] = $padding. $prefix .$records_array['name'];
	// 		}
			
	// 		$i++;
			
	// 		if(is_int($padding))
	// 		{
	// 			$this->getSubCategoriesArray($records_array['id'], ($padding+15), $prefix);
	// 		}
	// 		else
	// 		{
	// 			static $pad ="";
	// 			if($pad == ""){
	// 				$pad = $padding;
	// 			}
	// 			$this->getSubCategoriesArray($records_array['id'], $padding.$pad, $prefix);
	// 		}
	// 	}
	// 	return $return;
	// }
	
	function generate_node_tree($options = array(), $offset = 0, $child = FALSE)
	{
		static $i=0;
		static $return = array();


		if( ! isset($options['id'])) $options['id'] = 0;
		if( ! isset($options['parent_id'])) $options['parent_id'] = null;
		if( ! isset($options['table'])) $options['table'] = 'categories';
		if( ! isset($options['padding'])) $options['padding'] = 15;
		if( ! isset($options['values'])) $options['values'] = array();
		if( ! isset($options['widget'])) $options['widget'] = null;
		if( ! isset($options['active'])) $options['active'] = null;
		if( ! isset($options['link'])) $options['link'] = null;
		$options['open_tag'] = isset($options['open_tag']) ? str_replace('>', '', $options['open_tag']) : '<div';

		if( ! isset($options['close_tag'])) $options['close_tag'] = '</div>';

		$query = $this->get_SubCategories($options['id'], $options['parent_id'], $options['table']);

		foreach ($query as $record)
		{
			$return['id'][$i] = $record['id'];

			if( ! isset($options['padding'])) $options['padding'] = 0;

			$checked = (in_array($record['id'], $options['values'])) ? 'checked="checked"' : '';
			$style = 'padding-top:5px;padding-bottom:5px;';

			if (! isset($return['name'][$i]))
			{
				$return['name'][$i] = '';
			}
			$class = ($record['slug'] === $options['active']) ? 'active' : '';
			$return['name'][$i] = $options['open_tag'].' class="'.$class.'" style="padding-left:'.$offset.'px;'.$style.'">';

			if (isset($options['link'])) 
			{
				$url = current_url().'?';
				if ($this->input->get('type'))
				{
					$url .= preg_replace('/(^|&)type=[^&]*/', '&type='.$record['slug'], $_SERVER['QUERY_STRING']);
				}
				else
				{
					$url .= $_SERVER['QUERY_STRING'].'&type='.$record['slug'];
				}
				$return['name'][$i] .= '<a href="'.$url.'">';
			}

			if ($child)
			{
				if (isset($options['form']))
				{
					$return['name'][$i] .= "<input type='".$options['form']['type']."' name='".$options['form']['name']."'"."' value='".$record['id']."'".$checked."> ";
				}
				$return['name'][$i] .= $record['name'];
			}
			else
			{
				$class = ($record['slug'] === $options['active']) ? 'active' : '';
				$return['name'][$i] = $options['open_tag'].' class="'.$class.'" style="padding-left:'.$offset.'px">';
				if ($options['link']) $return['name'][$i] .= '<a href="'.$url.'">';
				$return['name'][$i] .= "<input type='".$options['form']['type']."' name='".$options['form']['name']."'"."' value='".$record['id']."'".$checked."> ";
				$return['name'][$i] .= $record['name'];
				if ($options['link']) $return['name'][$i] .= '</a>';
			}

			if ($options['widget'] === "admin")
			{
				$return['name'][$i] .= '<a class="text-primary edit-node" style="cursor:pointer;margin-left:10px" data-id="'.$record['id'].'">[edit]</a>';
				$return['name'][$i] .= '<a class="text-danger delete-node" style="cursor:pointer;margin-left:10px" data-id="'.$record['id'].'">[delete]</a>';
			}
			
			if ($options['widget'] === "link") $return['name'][$i] .= '</a>';
			$return['name'][$i] .= $options['close_tag'];			

			
			$i++;
			
			$options['parent_id'] = $record['id'];
			unset($options['id']); // This was a one time deal.
			$this->generate_node_tree($options, $offset + $options['padding'], TRUE);
		}

		$html = '';
		foreach($return['name'] as $key =>$catname)
		{
			//id---->echo $cat_array['id'][$key];
			$html .= $catname;
		}
		return $html;
	}
	
	function get_SubCategories($id, $parent_id, $table)
	{
		if ($id)
		{
			$this->db->where('id', $id);
		}
		$this->db->where('parent_id', $parent_id);
		$result = $this->db->get($table)->result_array();
		return $result;
	}

    
    private $lineage = array();
	public function get_lineage($id = null, $options = array())
	{
		// Set defaults.
		if( ! isset($options['get_data'])) $options['get_data'] = '';
		if( ! isset($options['table'])) $options['table'] = 'categories';
		if( ! isset($options['table_id'])) $options['table_id'] = 'id';

		// Get the query meta data.
		if ($id)
		{
			$query = $this->db->get_where($options['table'], array(
				$options['table_id'] => $id
			))->result();
		}
			
		// If this query has data (exists).
		if ( ! empty($query))
		{
			// Add query to lineage array.
			if ($options['get_data'] === '')
			{
				array_push($this->lineage, $query[0]);
			}
			else
			{
				array_push($this->lineage, $query[0]->$options['get_data']);
			}

			// Repeat this process.
			$this->get_lineage($query[0]->parent_id, $options);
		}

		// Reverse the lineage to get proper hierrachy.
		return array_reverse($this->lineage);
	}


	// variable include determines
	public function generate_list($table, $include = null)
	{
		$refs = array();
		$list = array();

		// Get the base categories.	
		$categories = $this->db->get($table)->result();

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
	    			'slug' => "$parent {$v['slug']}"
	    		));
	    	else
	    		array_push($this->html, array(
	    			'id' => $v['id'],
	    			'name' => "$parent {$v['name']}",
	    			'slug' => "$parent {$v['slug']}"
	    		));

	    	if (array_key_exists('children', $v)) 
	    		$this->compress($v['children'], $target, $parent . $v['name']." > ");
	    }

	    return $this->html;
	}
}