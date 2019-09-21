<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Products_Module extends CI_Migration {

	public function up()
	{
		// Table structure for table 'cart_config'
		$this->dbforge->add_field(array(
			'config_id' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'config_pagination_limit' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '36'
			),
			'config_user_files_limit' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '5'
			),
			'config_order_number_prefix' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'config_order_number_suffix' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'config_increment_order_number' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_min_order' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'config_quantity_decimals' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_quantity_limited_by_stock' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_increment_duplicate_items' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_remove_no_stock_items' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_auto_allocate_stock' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_save_ban_shipping_items' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_weight_type' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'config_weight_decimals' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_display_tax_prices' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_price_inc_tax' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_multi_row_duplicate_items' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_dynamic_reward_points' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'config_reward_point_multiplier' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,4',
				'default' => '0.0000'
			),
			'config_reward_voucher_multiplier' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,4',
				'default' => '0.0000'
			),
			'config_reward_voucher_ratio' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'config_reward_point_days_pending' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'config_reward_point_days_valid' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'config_reward_voucher_days_valid' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'config_custom_status_1' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'config_custom_status_2' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'config_custom_status_3' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
		));
		$this->dbforge->add_key('config_id', TRUE);
		$this->dbforge->add_key('`config_id` (`config_id`) USING BTREE');
		$this->dbforge->create_table('cart_config', TRUE);
		// Dumping data for table 'cart_config'
		if ($this->db->count_all('cart_config') == 0)
		{
			$this->db->insert('cart_config', array(
				'config_id' => '1',
				'config_increment_order_number' => '1',
				'config_quantity_limited_by_stock' => '1',
				'config_increment_duplicate_items' => '1',
				'config_auto_allocate_stock' => '1',
				'config_weight_type' => 'gram',
				'config_display_tax_prices' => '1',
				'config_price_inc_tax' => '1',
				'config_dynamic_reward_points' => '1',
				'config_reward_point_multiplier' => '10.0000',
				'config_reward_voucher_multiplier' => '0.0100',
				'config_reward_voucher_ratio' => '250',
				'config_reward_point_days_pending' => '14',
				'config_reward_point_days_valid' => '365',
				'config_reward_voucher_days_valid' => '365',
			));
		}



		// Table structure for table 'cart_data'
		$this->dbforge->add_field(array(
			'cart_data_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'cart_data_user_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'cart_data_array' => array(
				'type' => 'TEXT',
			),
			'cart_data_date' => array(
				'type' => 'DATETIME',
				'default' => '0000-00-00 00:00:00'
			),
			'cart_data_readonly_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
		));
		$this->dbforge->add_key('cart_data_id', TRUE);
		$this->dbforge->create_table('cart_data', TRUE);



		// Table structure for table 'currency'
		$this->dbforge->add_field(array(
			'curr_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'curr_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'curr_exchange_rate' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,4',
				'default' => '0.0000'
			),
			'curr_symbol' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'curr_symbol_suffix' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'curr_thousand_separator' => array(
				'type' => 'VARCHAR',
				'constraint' => '10',
				'default' => ''
			),
			'curr_decimal_separator' => array(
				'type' => 'VARCHAR',
				'constraint' => '10',
				'default' => ''
			),
			'curr_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'curr_default' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
		));
		$this->dbforge->add_key('curr_id', TRUE);
		$this->dbforge->create_table('currency', TRUE);
		// Dumping data for table 'currency'
		if ($this->db->count_all('currency') == 0)
		{
			$this->db->insert_batch('currency', array(
				array(
					'curr_id' => '1',
					'curr_name' => 'AUD',
					'curr_exchange_rate' => '2.0000',
					'curr_symbol' => 'AU $',
					'curr_symbol_suffix' => '0',
					'curr_thousand_separator' => ',',
					'curr_decimal_separator' => '.',
					'curr_status' => '1',
					'curr_default' => '0'
				),
				array(
					'curr_id' => '2',
					'curr_name' => 'EUR',
					'curr_exchange_rate' => '1.1500',
					'curr_symbol' => '&euro',
					'curr_symbol_suffix' => '1',
					'curr_thousand_separator' => '.',
					'curr_decimal_separator' => ',',
					'curr_status' => '1',
					'curr_default' => '0'
				),
				array(
					'curr_id' => '3',
					'curr_name' => 'GBP',
					'curr_exchange_rate' => '1.0000',
					'curr_symbol' => '&pound',
					'curr_symbol_suffix' => '0',
					'curr_thousand_separator' => ',',
					'curr_decimal_separator' => '.',
					'curr_status' => '1',
					'curr_default' => '1'
				),
				array(
					'curr_id' => '4',
					'curr_name' => 'USD',
					'curr_exchange_rate' => '1.6000',
					'curr_symbol' => 'US $',
					'curr_symbol_suffix' => '0',
					'curr_thousand_separator' => ',',
					'curr_decimal_separator' => '.',
					'curr_status' => '1',
					'curr_default' => '0'
				)
			));
		}



		// Table structure for table 'discounts'
		$this->dbforge->add_field(array(
			'disc_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'disc_type_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'disc_method_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'disc_tax_method_fk' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'disc_user_acc_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'disc_item_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0',
				'comment' => 'Item / Product Id'
			),
			'disc_group_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'disc_location_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'disc_zone_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'disc_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => '',
				'comment' => 'Discount Code',
			),
			'disc_description' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => '',
				'comment' => 'Name shown in cart when active'
			),
			'disc_quantity_required' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0',
				'comment' => 'Quantity required for offer'
			),
			'disc_quantity_discounted' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0',
				'comment' => 'Quantity affected by offer'
			),
			'disc_value_required' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'disc_value_discounted' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00',
				'comment' => '% discount, flat fee discount, new set price - specified via calculation_fk'
			),
			'disc_recursive' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0',
				'comment' => 'Discount is repeatable multiple times on one item'
			),
			'disc_non_combinable_discount' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0',
				'comment' => 'Cannot be applied if any other discount is applied'
			),
			'disc_void_reward_points' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0',
				'comment' => 'Voids any current reward points'
			),
			'disc_force_ship_discount' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'disc_custom_status_1' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'disc_custom_status_2' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'disc_custom_status_3' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'disc_usage_limit' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0',
				'comment' => 'Number of offers available',
			),
			'disc_valid_date' => array(
				'type' => 'DATETIME',
				'default' => '0000-00-00 00:00:00'
			),
			'disc_expire_date' => array(
				'type' => 'DATETIME',
				'default' => '0000-00-00 00:00:00'
			),
			'disc_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'disc_order_by' => array(
				'type' => 'SMALLINT',
				'constraint' => '1',
				'default' => '100',
				'comment' => 'Default value of 100 to ensure non set \'order by\' values of zero are not before 1,2,3 etc.'
			)
		));
		$this->dbforge->add_key('disc_id', TRUE);
		$this->dbforge->add_key('disc_item_fk');
		$this->dbforge->add_key('disc_location_fk');
		$this->dbforge->add_key('disc_zone_fk');
		$this->dbforge->add_key('disc_method_fk');
		$this->dbforge->add_key('disc_type_fk');
		$this->dbforge->add_key('disc_group_fk');
		$this->dbforge->create_table('discounts', TRUE);



		// Table structure for table 'discount_calculation'
		$this->dbforge->add_field(array(
			'disc_calculation_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE,
				'comment' => 'Note: Do not alter the order or id\'s of records in table.'
			),
			'disc_calculation' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			)
		));
		$this->dbforge->add_key('disc_calculation_id', TRUE);
		$this->dbforge->create_table('discount_calculation', TRUE);
		// Dumping data for table 'discount_calculation'
		if ($this->db->count_all('discount_calculation') == 0)
		{
			$this->db->insert_batch('discount_calculation', array(
				array(
					'disc_calculation_id' => '1',
					'disc_calculation' => 'Percentage Based'
				),
				array(
					'disc_calculation_id' => '2',
					'disc_calculation' => 'Flat Fee'
				),
				array(
					'disc_calculation_id' => '3',
					'disc_calculation' => 'New Value'
				)
			));
		}



		// Table structure for table 'discount_columns'
		$this->dbforge->add_field(array(
			'disc_column_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE,
				'comment' => 'Note: Do not alter the order or id\'s of records in table.'
			),
			'disc_column' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			)
		));
		$this->dbforge->add_key('disc_column_id', TRUE);
		$this->dbforge->create_table('discount_columns', TRUE);
		// Dumping data for table 'discount_columns'
		if ($this->db->count_all('discount_columns') == 0)
		{
			$this->db->insert_batch('discount_columns', array(
				array(
					'disc_column_id' => '1',
					'disc_column' => 'Item Price'
				),
				array(
					'disc_column_id' => '2',
					'disc_column' => 'Item Shipping'
				),
				array(
					'disc_column_id' => '3',
					'disc_column' => 'Summary Item Total'
				),
				array(
					'disc_column_id' => '4',
					'disc_column' => 'Summary Shipping Total'
				),
				array(
					'disc_column_id' => '5',
					'disc_column' => 'Summary Total'
				),
				array(
					'disc_column_id' => '6',
					'disc_column' => 'Summary Total (Voucher)'
				)
			));
		}



		// Table structure for table 'discount_groups'
		$this->dbforge->add_field(array(
			'disc_group_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'disc_group' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'disc_group_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('disc_group_id', TRUE);
		$this->dbforge->create_table('discount_groups', TRUE);



		// Table structure for table 'discount_group_items'
		$this->dbforge->add_field(array(
			'disc_group_item_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'disc_group_item_group_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'disc_group_item_item_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('disc_group_item_id', TRUE);
		$this->dbforge->add_key('disc_group_item_group_fk');
		$this->dbforge->add_key('disc_group_item_item_fk');
		$this->dbforge->create_table('discount_group_items', TRUE);


		// Drop table 'discount_methods' if it exists
		$this->dbforge->drop_table('discount_methods', TRUE);
		// Table structure for table 'discount_methods'
		$this->dbforge->add_field(array(
			'disc_method_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE,
				'comment' => 'Note: Do not alter the order or id\'s of records in table.'
			),
			'disc_method_type_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'disc_method_column_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'disc_method_calculation_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'disc_method' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			)
		));
		$this->dbforge->add_key('disc_method_id', TRUE);
		$this->dbforge->add_key('disc_method_type_fk');
		$this->dbforge->add_key('disc_method_column_fk');
		$this->dbforge->add_key('disc_method_calculation_fk');
		$this->dbforge->create_table('discount_methods', TRUE);
		// Dumping data for table 'discount_methods'
		if ($this->db->count_all('discount_methods') == 0)
		{
			$this->db->insert_batch('discount_methods', array(
				array(
					'disc_method_id' => '1',
					'disc_method_type_fk' => '1',
					'disc_method_column_fk' => '1',
					'disc_method_calculation_fk' => '1',
					'disc_method' => 'Item Price - Percentage Based'
				),
				array(
					'disc_method_id' => '2',
					'disc_method_type_fk' => '1',
					'disc_method_column_fk' => '1',
					'disc_method_calculation_fk' => '2',
					'disc_method' => 'Item Price - Flat Fee'
				),
				array(
					'disc_method_id' => '3',
					'disc_method_type_fk' => '1',
					'disc_method_column_fk' => '1',
					'disc_method_calculation_fk' => '3',
					'disc_method' => 'Item Price - New Value'
				),
				array(
					'disc_method_id' => '4',
					'disc_method_type_fk' => '1',
					'disc_method_column_fk' => '2',
					'disc_method_calculation_fk' => '1',
					'disc_method' => 'Item Shipping - Percentage Based'
				),
				array(
					'disc_method_id' => '5',
					'disc_method_type_fk' => '1',
					'disc_method_column_fk' => '2',
					'disc_method_calculation_fk' => '2',
					'disc_method' => 'Item Shipping - Flat Fee'
				),
				array(
					'disc_method_id' => '6',
					'disc_method_type_fk' => '1',
					'disc_method_column_fk' => '2',
					'disc_method_calculation_fk' => '3',
					'disc_method' => 'Item Shipping - New Value'
				),
				array(
					'disc_method_id' => '7',
					'disc_method_type_fk' => '2',
					'disc_method_column_fk' => '3',
					'disc_method_calculation_fk' => '1',
					'disc_method' => 'Summary Item Total - Percentage Based'
				),
				array(
					'disc_method_id' => '8',
					'disc_method_type_fk' => '2',
					'disc_method_column_fk' => '3',
					'disc_method_calculation_fk' => '2',
					'disc_method' => 'Summary Item Total - Flat Fee'
				),
				array(
					'disc_method_id' => '9',
					'disc_method_type_fk' => '2',
					'disc_method_column_fk' => '4',
					'disc_method_calculation_fk' => '1',
					'disc_method' => 'Summary Shipping Total - Percentage Based'
				),
				array(
					'disc_method_id' => '10',
					'disc_method_type_fk' =>  '2',
					'disc_method_column_fk' => '4',
					'disc_method_calculation_fk' => '2',
					'disc_method' => 'Summary Shipping Total - Flat Fee'
				),
				array(
					'disc_method_id' => '11',
					'disc_method_type_fk' =>  '2',
					'disc_method_column_fk' => '4',
					'disc_method_calculation_fk' => '3',
					'disc_method' => 'Summary Shipping Total - New Value'
				),
				array(
					'disc_method_id' => '12',
					'disc_method_type_fk' =>  '2',
					'disc_method_column_fk' => '5',
					'disc_method_calculation_fk' => '1',
					'disc_method' => 'Summary Total - Percentage Based'
				),
				array(
					'disc_method_id' => '13',
					'disc_method_type_fk' =>  '2',
					'disc_method_column_fk' => '5',
					'disc_method_calculation_fk' => '2',
					'disc_method' => 'Summary Total - Flat Fee'
				),
				array(
					'disc_method_id' => '14',
					'disc_method_type_fk' =>  '3',
					'disc_method_column_fk' => '6',
					'disc_method_calculation_fk' => '2',
					'disc_method' => 'Summary Total - Flat Fee (Voucher)'
				)
			));
		}



		// Table structure for table 'discount_tax_methods'
		$this->dbforge->add_field(array(
			'disc_tax_method_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE,
				'comment' => 'Note: Do not alter the order or id\'s of records in table.'
			),
			'disc_tax_method' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			)
		));
		$this->dbforge->add_key('disc_tax_method_id', TRUE);
		$this->dbforge->create_table('discount_tax_methods', TRUE);
		// Dumping data for table 'discount_tax_methods'
		if ($this->db->count_all('discount_tax_methods') == 0)
		{
			$this->db->insert_batch('discount_tax_methods', array(
				array(
					'disc_tax_method_id' => '1',
					'disc_tax_method' => 'Apply Tax Before Discount'
				),
				array(
					'disc_tax_method_id' => '2',
					'disc_tax_method' => 'Apply Discount Before Tax'
				),
				array(
					'disc_tax_method_id' => '3',
					'disc_tax_method' => 'Apply Discount Before Tax, Add Original Tax'
				)
			));
		}



		// Table structure for table 'discount_types'
		$this->dbforge->add_field(array(
			'disc_type_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE,
				'comment' => 'Note: Do not alter the order or id\'s of records in table.'
			),
			'disc_type' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			)
		));
		$this->dbforge->add_key('disc_type_id', TRUE);
		$this->dbforge->create_table('discount_types', TRUE);
		// Dumping data for table 'discount_types'
		if ($this->db->count_all('discount_types') == 0)
		{
			$this->db->insert_batch('discount_types', array(
				array(
					'disc_type_id' => '1',
					'disc_type' => 'Item Discount'
				),
				array(
					'disc_type_id' => '2',
					'disc_type' => 'Summary Discount'
				),
				array(
					'disc_type_id' => '3',
					'disc_type' => 'Reward Voucher'
				)
			));
		}



		// Table structure for table 'item_stock'
		$this->dbforge->add_field(array(
			'stock_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'stock_item_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'stock_quantity' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'stock_auto_allocate_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('stock_id', TRUE);
		$this->dbforge->add_key('stock_item_fk');
		$this->dbforge->create_table('item_stock', TRUE);



		// Table structure for table 'locations'
		$this->dbforge->add_field(array(
			'loc_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'loc_type_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'loc_parent_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'loc_ship_zone_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'loc_tax_zone_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'loc_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'loc_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'loc_ship_default' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'loc_tax_default' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('loc_id', TRUE);
		$this->dbforge->add_key('loc_type_fk');
		$this->dbforge->add_key('loc_parent_fk');
		$this->dbforge->add_key('loc_ship_zone_fk');
		$this->dbforge->add_key('loc_tax_zone_fk');
		$this->dbforge->create_table('locations', TRUE);



		// Table structure for table 'location_type'
		$this->dbforge->add_field(array(
			'loc_type_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'loc_type_parent_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'loc_type_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
		));
		$this->dbforge->add_key('loc_type_id', TRUE);
		$this->dbforge->add_key('loc_type_parent_fk');
		$this->dbforge->create_table('location_type', TRUE);



		// Table structure for table 'location_zones'
		$this->dbforge->add_field(array(
			'lzone_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'lzone_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'lzone_description' => array(
				'type' => 'LONGTEXT',
				'default' => ''
			),
			'lzone_status' => array(
				'type' => 'SMALLINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('lzone_id', TRUE);
		$this->dbforge->create_table('location_zones', TRUE);



		// Table structure for table 'order_details'
		$this->dbforge->add_field(array(
			'ord_det_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'ord_det_order_number_fk' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'ord_det_cart_row_id' => array(
				'type' => 'VARCHAR',
				'constraint' => '32',
				'default' => ''
			),
			'ord_det_item_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'ord_det_item_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_det_item_option' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_det_quantity' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_non_discount_quantity' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_discount_quantity' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_stock_quantity' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_price' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_price_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_discount_price' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_discount_price_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_discount_description' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_det_tax_rate' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,4',
				'default' => '0'
			),
			'ord_det_tax' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_tax_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_shipping_rate' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_weight' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_weight_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_reward_points' => array(
				'type' => 'INT',
				'constraint' => '10',
				'default' => '0'
			),
			'ord_det_reward_points_total' => array(
				'type' => 'INT',
				'constraint' => '10',
				'default' => '0'
			),
			'ord_det_status_message' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_det_quantity_shipped' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_quantity_cancelled' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_det_shipped_date' => array(
				'type' => 'DATETIME',
				'default' => '0000-00-00 00:00:00'
			)
		));
		$this->dbforge->add_key('ord_det_id', TRUE);
		$this->dbforge->add_key('ord_det_order_number_fk');
		$this->dbforge->add_key('ord_det_item_fk');
		$this->dbforge->create_table('order_details', TRUE);



		// Table structure for table 'order_status'
		$this->dbforge->add_field(array(
			'ord_status_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'ord_status_description' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ord_status_cancelled' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'ord_status_save_default' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'ord_status_resave_default' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('ord_status_id', TRUE);
		$this->dbforge->create_table('order_status', TRUE);
		// Dumping data for table 'order_status'
		if ($this->db->count_all('order_status') == 0)
		{
			$this->db->insert_batch('order_status', array(
				array(
					'ord_status_id' => '1',
					'ord_status_description' => 'New Order',
					'ord_status_cancelled' => '0',
					'ord_status_save_default' => '1',
					'ord_status_resave_default' => '1',
				),
				array(
					'ord_status_id' => '2',
					'ord_status_description' => 'Processing Order',
					'ord_status_cancelled' => '0',
					'ord_status_save_default' => '0',
					'ord_status_resave_default' => '1',
				),
				array(
					'ord_status_id' => '3',
					'ord_status_description' => 'Order Complete',
					'ord_status_cancelled' => '0',
					'ord_status_save_default' => '0',
					'ord_status_resave_default' => '0',
				),
				array(
					'ord_status_id' => '4',
					'ord_status_description' => 'Order Complete',
					'ord_status_cancelled' => '1',
					'ord_status_save_default' => '0',
					'ord_status_resave_default' => '0',
				)
			));
		}



		// Table structure for table 'order_summary'
		$this->dbforge->add_field(array(
			'ord_order_number' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'ord_cart_data_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'ord_user_fk' => array(
				'type' => 'INT',
				'constraint' => '5',
				'default' => '0'
			),
			'ord_item_summary_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_item_summary_savings_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_shipping' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => ''
			),
			'ord_shipping_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_item_shipping_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_summary_discount_desc' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_summary_savings_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_savings_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_surcharge_desc' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_surcharge_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_reward_voucher_desc' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_reward_voucher_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_tax_rate' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'ord_tax_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_sub_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_total' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_total_rows' => array(
				'type' => 'INT',
				'constraint' => '10',
				'default' => '0'
			),
			'ord_total_items' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_total_weight' => array(
				'type' => 'DOUBLE',
				'constraint' => '10,2',
				'default' => '0.00'
			),
			'ord_total_reward_points' => array(
				'type' => 'INT',
				'constraint' => '10',
				'default' => '0'
			),
			'ord_currency' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'ord_exchange_rate' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0'
			),
			'ord_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'ord_date' => array(
				'type' => 'DATETIME',
				'default' => '0000-00-00 00:00:00'
			),
			'ord_demo_bill_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_bill_company' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_bill_address_01' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_bill_address_02' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_bill_city' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ord_demo_bill_state' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ord_demo_bill_post_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'ord_demo_bill_country' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ord_demo_ship_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_ship_company' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_ship_address_01' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_ship_address_02' => array(
				'type' => 'VARCHAR',
				'constraint' => '75',
				'default' => ''
			),
			'ord_demo_ship_city' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ord_demo_ship_state' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ord_demo_ship_post_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'ord_demo_ship_country' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ord_demo_email' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'ord_demo_phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'ord_demo_comments' => array(
				'type' => 'LONGTEXT'
			)
		));
		$this->dbforge->add_key('ord_order_number', TRUE);
		$this->dbforge->add_key('ord_cart_data_fk');
		$this->dbforge->add_key('ord_user_fk');
		$this->dbforge->create_table('order_summary', TRUE);



		// Table structure for table 'reward_points_converted'
		$this->dbforge->add_field(array(
			'rew_convert_id' => array(
				'type' => 'INT',
				'constraint' => '10',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'rew_convert_ord_detail_fk' => array(
				'type' => 'INT',
				'constraint' => '10',
				'default' => '10'
			),
			'rew_convert_discount_fk' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'rew_convert_points' => array(
				'type' => 'INT',
				'constraint' => '10',
				'default' => '10'
			),
			'rew_convert_date' => array(
				'type' => 'DATETIME',
				'default' => '0000-00-00 00:00:00'
			)
		));
		$this->dbforge->add_key('rew_convert_id', TRUE);
		$this->dbforge->add_key('rew_convert_ord_detail_fk');
		$this->dbforge->add_key('rew_convert_discount_fk');
		$this->dbforge->create_table('reward_points_converted', TRUE);



		// Table structure for table 'shipping_item_rules'
		$this->dbforge->add_field(array(
			'ship_item_id' => array(
				'type' => 'INT',
				'constraint' => '10',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'ship_item_item_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'ship_item_location_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'ship_item_zone_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'ship_item_value' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'null' => TRUE
			),
			'ship_item_separate' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0',
				'comment' => 'Indicate if item should have a shipping rate calculated specifically for it.'
			),
			'ship_item_banned' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'ship_item_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('ship_item_id', TRUE);
		$this->dbforge->add_key('ship_item_item_fk');
		$this->dbforge->add_key('ship_item_location_fk');
		$this->dbforge->add_key('ship_item_zone_fk');
		$this->dbforge->create_table('shipping_item_rules', TRUE);



		// Table structure for table 'shipping_options'
		$this->dbforge->add_field(array(
			'ship_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'ship_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ship_description' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => ''
			),
			'ship_location_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'ship_zone_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'ship_inc_sub_locations' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'ship_tax_rate' => array(
				'type' => 'DOUBLE',
				'constraint' => '7,4',
				'null' => TRUE
			),
			'ship_discount_inclusion' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'ship_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'ship_default' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('ship_id', TRUE);
		$this->dbforge->add_key('ship_zone_fk');
		$this->dbforge->add_key('ship_location_fk');
		$this->dbforge->create_table('shipping_options', TRUE);



		// Table structure for table 'shipping_rates'
		$this->dbforge->add_field(array(
			'ship_rate_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'ship_rate_ship_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'ship_rate_value' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'ship_rate_tare_wgt' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'ship_rate_min_wgt' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'ship_rate_max_wgt' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '9999.00'
			),
			'ship_rate_min_value' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'ship_rate_max_value' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '9999.00'
			),
			'ship_rate_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('ship_rate_id', TRUE);
		$this->dbforge->add_key('ship_rate_ship_fk');
		$this->dbforge->create_table('shipping_rates', TRUE);



		// Table structure for table 'tax'
		$this->dbforge->add_field(array(
			'tax_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'tax_location_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'tax_zone_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'tax_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '25',
				'default' => ''
			),
			'tax_rate' => array(
				'type' => 'DOUBLE',
				'constraint' => '7,4',
				'default' => '0.0000'
			),
			'tax_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			),
			'tax_default' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('tax_id', TRUE);
		$this->dbforge->add_key('tax_location_fk');
		$this->dbforge->add_key('tax_zone_fk');
		$this->dbforge->create_table('tax', TRUE);



		// Table structure for table 'tax_item_rates'
		$this->dbforge->add_field(array(
			'tax_item_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'tax_item_item_fk' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			),
			'tax_item_location_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'tax_item_zone_fk' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'default' => '0'
			),
			'tax_item_rate' => array(
				'type' => 'DOUBLE',
				'constraint' => '7,4',
				'default' => '0.0000'
			),
			'tax_item_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '0'
			)
		));
		$this->dbforge->add_key('tax_item_id', TRUE);
		$this->dbforge->add_key('tax_item_item_fk');
		$this->dbforge->add_key('tax_item_location_fk');
		$this->dbforge->add_key('tax_item_zone_fk');
		$this->dbforge->create_table('tax_item_rates', TRUE);



		// Table structure for table 'products'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			),
			'description' => array(
				'type' => 'TEXT'
			),
			'tags' => array(
				'type' => 'VARCHAR',
				'constraint' => '200',
				'default' => ''
			),
			'price' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'weight' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'thumb' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'quantity' => array(
				'type' => 'INT',
				'constraint' => '10',
				'default' => '0'
			),
			'status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '1'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('products', TRUE);



		// Table structure for table 'product_images'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'product_id' => array(
				'type' => 'INT',
				'constraint' => '11'
			),
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'sort_order' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_images_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_images', TRUE);



		// Table structure for table 'product_categories'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'parent_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'null' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50'
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => '50'
			),
			'sort_order' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			),
			'status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '1'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_categories` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_categories', TRUE);



		// Table structure for table 'product_category'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'product_id' => array(
				'type' => 'INT',
				'constraint' => '11'
			),
			'category_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'null' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_category_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->add_key('CONSTRAINT `fk_product_category_product_categories` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE');
		$this->dbforge->create_table('product_category', TRUE);



		// Table structure for table 'product_category_attributes'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'category_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50'
			),
			'is_option' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '1'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_category_attributes_product_categories` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_category_attributes', TRUE);



		// Table structure for table 'product_category_attribute_descriptions'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'attribute_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_category_attribute_descriptions_product_category_attributes` FOREIGN KEY (`attribute_id`) REFERENCES `product_category_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_category_attribute_descriptions', TRUE);



		// Table structure for table 'product_attributes'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'product_id' => array(
				'type' => 'INT',
				'constraint' => '11'
			),
			'attribute_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			),
			'attribute_description_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_attributes_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->add_key('CONSTRAINT `fk_product_attributes_product_category_attributes` FOREIGN KEY (`attribute_id`) REFERENCES `product_category_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->add_key('CONSTRAINT `fk_product_attributes_product_category_attribute_descriptions` FOREIGN KEY (`attribute_description_id`) REFERENCES `product_category_attribute_descriptions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_attributes', TRUE);



		// Table structure for table 'product_options'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'product_id' => array(
				'type' => 'INT',
				'constraint' => '11'
			),
			'price' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'weight' => array(
				'type' => 'DOUBLE',
				'constraint' => '8,2',
				'default' => '0.00'
			),
			'thumb' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'stock' => array(
				'type' => 'INT',
				'constraint' => '5'
			),
			'stock_status' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => '1',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_options_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_options', TRUE);



		// Table structure for table 'product_option_images'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'product_option_id' => array(
				'type' => 'INT',
				'constraint' => '11'
			),
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'sort_order' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_option_images_products` FOREIGN KEY (`product_option_id`) REFERENCES `product_options` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_option_images', TRUE);



		// Table structure for table 'product_option_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'product_option_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			),
			'attribute_description_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_option_groups_product_category_attributes` FOREIGN KEY (`product_option_id`) REFERENCES `product_category_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->add_key('CONSTRAINT `fk_product_option_groups_product_category_attribute_descriptions` FOREIGN KEY (`attribute_description_id`) REFERENCES `product_category_attribute_descriptions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_option_groups', TRUE);



		// Table structure for table 'product_option_defaults'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5',
				'unique' => TRUE,
				'auto_increment' => TRUE
			),
			'product_id' => array(
				'type' => 'INT',
				'constraint' => '11'
			),
			'attribute_description_id' => array(
				'type' => 'SMALLINT',
				'constraint' => '5'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('CONSTRAINT `fk_product_option_defaults_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->add_key('CONSTRAINT `fk_product_option_defaults_product_category_attribute_descriptions` FOREIGN KEY (`attribute_description_id`) REFERENCES `product_category_attribute_descriptions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION');
		$this->dbforge->create_table('product_option_defaults', TRUE);
	}
	
	public function down()
	{
		$this->dbforge->drop_table('cart_config', TRUE);
		$this->dbforge->drop_table('currency', TRUE);
		$this->dbforge->drop_table('discounts', TRUE);
		$this->dbforge->drop_table('discount_calculation', TRUE);
		$this->dbforge->drop_table('discount_columns', TRUE);
		$this->dbforge->drop_table('discount_groups', TRUE);
		$this->dbforge->drop_table('discount_group_items', TRUE);
		$this->dbforge->drop_table('discount_methods', TRUE);
		$this->dbforge->drop_table('discount_tax_methods', TRUE);
		$this->dbforge->drop_table('discount_types', TRUE);
		$this->dbforge->drop_table('item_stock', TRUE);
		$this->dbforge->drop_table('locations', TRUE);
		$this->dbforge->drop_table('location_type', TRUE);
		$this->dbforge->drop_table('location_zones', TRUE);
		$this->dbforge->drop_table('order_details', TRUE);
		$this->dbforge->drop_table('order_status', TRUE);
		$this->dbforge->drop_table('order_summary', TRUE);
		$this->dbforge->drop_table('reward_points_converted', TRUE);
		$this->dbforge->drop_table('shipping_item_rules', TRUE);
		$this->dbforge->drop_table('shipping_options', TRUE);
		$this->dbforge->drop_table('shipping_rates', TRUE);
		$this->dbforge->drop_table('tax', TRUE);
		$this->dbforge->drop_table('tax_item_rates', TRUE);
		$this->dbforge->drop_table('product_categories', TRUE);
		$this->dbforge->drop_table('products', TRUE);
		$this->dbforge->drop_table('product_images', TRUE);
		$this->dbforge->drop_table('product_category', TRUE);
		$this->dbforge->drop_table('product_option_defaults', TRUE);
		$this->dbforge->drop_table('product_option_groups', TRUE);
		$this->dbforge->drop_table('product_options', TRUE);
		$this->dbforge->drop_table('product_attributes', TRUE);
		$this->dbforge->drop_table('product_category_attribute_descriptions', TRUE);
		$this->dbforge->drop_table('product_category_attributes', TRUE);
	}
}
