<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Languages_Module extends CI_Migration {

	public function up()
	{
		// Table structure for table 'languages'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => 8,
				'auto_increment' => TRUE,
				'primary' => TRUE
			),
			'language' => array(
				'type' =>'VARCHAR',
				'constraint' => '100',
				'default' => 'malay',
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
		));
        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('languages', TRUE);

		if ($this->db->count_all('languages') == 0) {
			$this->db->insert_batch('languages', [
				[
					'id' => 1,
					'language' => 'english',
					'created_on' => time(),
				],
				[
					'id' => 2,
					'language' => 'spanish',
					'created_on' => time(),
				],
			]);
		}

		// Table structure for table 'lang_sets'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => 8,
				'auto_increment' => TRUE,
				'primary' => TRUE
			),
			'set' => array(
				'type' =>'VARCHAR',
				'constraint' => '100',
			),
		));
        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('lang_sets', TRUE);

		// Table structure for table 'lang_translations'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
				'primary' => TRUE
			),
			'key' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'language_id' => array(
				'type' =>'MEDIUMINT',
				'constraint' => 8,
			),
            'set' => array(
				'type' =>'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'text' => array(
				'type' => 'TEXT',
			),
		));
        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('lang_translations', TRUE);

		if ($this->db->count_all('lang_translations') == 0) {
			// Migrate language file definitions into database
			$lang["dash_title"]                             = "Dashboard";
			$lang["dash_login_title"]                       = "Login to the admin dashboard";
			$lang["dash_welcome_msg"]                       = "Logged in as %s";
			$lang["dash_latest_users"]                      = "Latest users";
			$lang["dash_latest_hospitals"]                  = "Latest hospitals";
			$lang["dash_inactive_accounts"]                 = "%s inactive accounts";
			$lang["dash_hospital_most_doctors"]             = "hospital with the most doctors?";
			$lang["dash_hospital_most_doctors_tooltip"]     = "%s has the most with a total of %s doctors";
			$lang["dash_doctors_count"]                     = "%s registered doctors";
			$lang["dash_appointment_info"]                  = "%s booked with %s doctors";

			// User titles
			$lang["title_user"]                             = "User";
			$lang["title_doctor"]                           = "Doctor";
			$lang["title_create_user"]                      = "Create a user";
			$lang["subtitle_create_user"]                   = "Enter your details below";
			$lang["title_update_user"]                      = "Update user data";
			$lang["subtitle_update_user"]                   = "Update your details below";
			$lang["title_assign_users"]                     = "Assign users";
			$lang["subtitle_assign"]                        = "Assign users to %s";
			$lang["subtitle_assign_users"]                  = "Assign users to group %s";
			$lang["title_update_group"]                     = "Update group details";

			// Hospital titles          
			$lang["title_create_hospital"]                  = "Create a hospital";
			$lang["title_create_images"]                    = "Add hospital images";
			$lang["subtitle_create_images"]                 = "You can upload up to %s images";

			// Location titles            
			$lang["title_select_location"]                  = "Select location";

			// Tables titles            
			$lang["table_action"]                           = "Action";

			// Language titles          
			$lang["title_lang_select"]                      = "Select language to translate";
			$lang["title_lang_confirm"]                     = "Confirm this translation";
			$lang["title_lang_select_module"]               = "Select file to translate";

			// Products titles          
			$lang["title_product"]                          = "Manage products";
			$lang["title_product_add"]                      = "Add a new product";
			$lang["title_product_edit"]                     = "Edit product details";

			// Category titles          
			$lang["title_categories"]                       = "Manage Categories";
			$lang["title_categories_add"]                   = "Add a new category";
			$lang["title_categories_edit"]                  = "Edit category details";

			foreach($lang as $key => $text) {
				$this->db->insert('lang_translations', ['language_id' => 1, 'set' => 'titles', 'key' => $key, 'text' => $text]);
			}

			// Menu items
			$lang = [];
			$lang["menu_profile"]               = "Profile";
			$lang["menu_logout"]                = "Logout";
			$lang["menu_settings"]              = "Settings";
			$lang["menu_general"]               = "General";
			$lang["menu_privacy"]               = "Privacy policy";
			$lang["menu_terms"]                 = "Terms & conditions";
			$lang["menu_languages"]             = "Languages";
			$lang["menu_details"]               = "Details";
			$lang["menu_users_th"]              = "User management";
			$lang["menu_users"]                 = "Users";
			$lang["menu_user_profile"]          = "Profile";
			$lang["menu_user_profession"]       = "Profession";
			$lang["menu_groups"]                = "Groups";
			$lang["menu_group_users"]           = "Group users";
			$lang["menu_hospitals_th"]          = "Hospital management";
			$lang["menu_hospitals"]             = "Hospitals";
			$lang["menu_doctors"]               = "Doctors";
			$lang["menu_facilities"]            = "Hospital facilities";
			$lang["menu_types"]                 = "Hospital types";
			$lang["menu_types_facilities"]      = "Types & Facilities";
			$lang["menu_specialities"]          = "Specialties";
			$lang["menu_locations_th"]          = "Locations";
			$lang["menu_location_zones"]        = "Location Zones";
			$lang["menu_location_shipping"]     = "Shipping rules";
			$lang["menu_location"]              = "Location";
			$lang["menu_locations_levels"]      = "Levels";
			$lang["menu_locations_places"]      = "Places";
			$lang["menu_locations_places_in"]   = "Places under %s";
			$lang["menu_images"]                = "Images";
			$lang["menu_appointments"]          = "Appointments";

			$lang["menu_products"]              = "Products";
			$lang["menu_categories"]            = "Categories";

			foreach($lang as $key => $text) {
				$this->db->insert('lang_translations', ['language_id' => 1, 'set' => 'menus', 'key' => $key, 'text' => $text]);
			}

			// Alert messages
			$lang = [];
			$lang["alert_warning"]                      = "Warning";
			$lang["alert_success_general"]              = "Operation was successful";
			$lang["alert_fail_general"]                 = "Operation failed";
			$lang["alert_confirm_action"]               = "Confirm action";
			$lang["alert_confrim_delete_txt"]           = "This action cannot be reversed. All information will be lost.";
			
			$lang["alert_modifying_missing_item"]       = "The item you are trying to modify does not exist";

			$lang["alert_access_denied"]                = "Access denied";
			$lang["alert_logged_in"]                    = "You are now logged in";

			$lang["alert_form_errors"]                  = "Correct the errors in the form and try again";
			$lang["alert_enter_old_password"]           = "Please enter your old password";
			$lang["alert_password_incorrect"]           = "Sorry, the password you provide is incorrect";
			$lang["alert_login_required"]               = "Please login to proceed";
			$lang["alert_activate_email_sent"]          = "An activation email was been set to %s";
			$lang["alert_account_invisible"]            = "An inactive account is not visible to the public";
			$lang["alert_account_created"]              = "Your user account has been created successfully";

			$lang["alert_hospital_add_success"]         = "Hospital was created successfully. Continue to update more details";
			$lang["alert_hospital_add_fail"]            = "We could not create this hospital";

			$lang["alert_lang_no_file_match"]           = "This language does not have a corresponding file";
			$lang["alert_lang_file_location"]           = "Language files are located in application/language directory";
			$lang["alert_lang_create_file"]             = "Create this file and refresh the page";

			$lang["alert_appointment_unapproved"]       = "This appointment is not yet approved";

			foreach($lang as $key => $text) {
				$this->db->insert('lang_translations', ['language_id' => 1, 'set' => 'alerts', 'key' => $key, 'text' => $text]);
			}

			// Button labels
			$lang = [];
			$lang["btn_view"]               = "View";
			$lang["btn_view_all"]           = "View all";
			$lang["btn_assign"]             = "Assign";
			$lang["btn_select"]             = "Select";
			$lang["btn_edit"]               = "Edit";
			$lang["btn_create"]             = "Create";
			$lang["btn_delete"]             = "Delete";
			$lang["btn_update"]             = "Update";
			$lang["btn_save"]               = "Save";
			$lang["btn_login"]              = "Login";
			$lang["btn_register"]           = "Register";
			$lang["btn_confirm"]            = "Confirm";
			$lang["btn_submit"]             = "submit";
			$lang["btn_delete_selected"]    = "Delete selected";
			$lang["btn_remove_selected"]    = "Remove selected";
			$lang["btn_assign_users"]       = "Assign users";
			
			foreach($lang as $key => $text) {
				$this->db->insert('lang_translations', ['language_id' => 1, 'set' => 'buttons', 'key' => $key, 'text' => $text]);
			}

			$lang = [];
			// Form labels
			$lang["form_edit_head"]                         = "Edit form details below";
			$lang["form_create_head"]                       = "Enter form details below";
			$lang["form_forgot_password"]                   = "I forgot my password.";
			$lang["form_remember_me"]                       = "Remember me";
			$lang["form_input_placeholder"]                 = "Type your text here";

			$lang["form_name"]                              = "Name";
			$lang["form_code"]                              = "Code";
			$lang["form_email"]                             = "Email";
			$lang["form_password"]                          = "Password";
			$lang["form_status"]                            = "Active";
			$lang["form_date"]                              = "Date";
			$lang["form_description"]                       = "Description";
			$lang["form_phone"]                             = "phone";
			$lang["form_address"]                           = "Address";
			$lang["form_location"]                          = "Location";

			$lang["form_settings_sitename"]                 = "Site name";
			$lang["form_settings_sitename_txt"]             = "Name of your website";
			$lang["form_settings_description"]              = "Site description";
			$lang["form_settings_description_txt"]          = "Description of your website";
			$lang["form_settings_language"]                 = "Site language";
			$lang["form_settings_language_txt"]             = "Your default language. users may later choose a different one.";
			$lang["form_settings_noreply"]                  = "noreply email address";
			$lang["form_settings_noreply_txt"]              = "Email address for sending automated messages to your users";
			$lang["form_settings_paginate"]                 = "Pagination limit";
			$lang["form_settings_paginate_txt"]             = "Number of items to show per page";
			$lang["form_settings_uploads"]                  = "Upload limit";
			$lang["form_settings_uploads_txt"]              = "Number of uploads allowed for users";

			$lang["form_group_name"]                        = "Group name";
			$lang["form_group_description"]                 = "Description";
			$lang["form_users_avatar"]                      = "Profile photo";
			$lang["form_users_fname"]                       = "First name";
			$lang["form_users_lname"]                       = "Last name";
			$lang["form_users_username"]                    = "username";
			$lang["form_users_email"]                       = "Email";
			$lang["form_users_password"]                    = "Password";
			$lang["form_users_change_password"]             = "Change password";
			$lang["form_users_old_password"]                = "Old password";
			$lang["form_users_address"]                     = "Address";
			$lang["form_users_phone"]                       = "Phone";
			$lang["form_users_status"]                      = "Status";
			$lang["form_users_status_txt"]                  = "Activate user account";

			$lang["form_location_level"]                    = "Location level";
			$lang["form_location_place"]                    = "Name of place";
			$lang["form_location_parent"]                   = "Parent location";
			$lang["form_location_code"]                     = "Location code";
			$lang["form_location_zone"]                     = "Location zone";

			$lang["form_hospital_name"]                     = "Hospital name";
			$lang["form_hospital_slug"]                     = "Hospital slug";
			$lang["form_hospital_type"]                     = "Hospital type";
			$lang["form_hospital_slogan"]                   = "Hospital slogan";
			$lang["form_hospital_description"]              = "Hospital description";
			$lang["form_hospital_hours"]                    = "Working hours";
			$lang["form_hospital_about"]                    = "Brief description about this hospital";

			$lang["form_image_caption"]                     = "Image caption";
			$lang["form_image_placeholder"]                 = "No file selected";

			$lang["form_doctor_reg_no"]                     = "Registration Number";
			$lang["form_doctor_speciality"]                 = "Speciality";
			$lang["form_doctor_description"]                = "Description";
			$lang["form_doctor_description_txt"]            = "A brief portifolio about yourself and your practice";
			$lang["form_doctor_qualification"]              = "Qualification";
			$lang["form_doctor_qualification_txt"]          = "Highest education or training level";
			$lang["form_doctor_qualification_2"]            = "Other qualifications";
			$lang["form_doctor_qualification_2_txt"]        = "Any other certificates or awards";
			$lang["form_doctor_mobile_service"]             = "Mobile Services";
			$lang["form_doctor_mobile_service_txt"]         = "You may be required to travel to your patients";

			$lang["form_category_name"]                     = "Category name";
			$lang["form_category_parent"]                   = "Parent category";
			$lang["form_category_parent_txt"]               = "Parent category attributes will also be inherited";
			$lang["form_category_no_parent"]                = "None";

			$lang["form_translate_to"]                		= "Translate to %s";

			// Form errors
			$lang["form_error_value_missing"]               = "The %s is required";
			$lang["form_error_type_mismatch"]               = "This is not a valid %s";
			$lang["form_error_pattern_alpha_min"]           = "The %s must be alpha numeric with a minimum of %s characters";
			$lang["form_error_range_underflow"]             = "The %s must be greater than %s";
			$lang["form_error_range_overflow"]              = "The %s must be less than %s";
			$lang["form_error_too_long"]                   	= "The %s must not exceed %s characters";

			foreach($lang as $key => $text) {
				$this->db->insert('lang_translations', ['language_id' => 1, 'set' => 'buttons', 'key' => $key, 'text' => $text]);
			}
		}
	}
	
	public function down()
	{
		$this->dbforge->drop_table('languages');
	}
}
