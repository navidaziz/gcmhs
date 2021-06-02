<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Admin_Controller_Mobile extends MY_Controller{
    
    public $controller_name = "";
    public $method_name = "";
    
    public function __construct(){
        
        parent::__construct();
        
       //$this->output->enable_profiler(TRUE);
       //var_dump($this->session->all_userdata());
        
        $this->load->helper("form");
        $this->load->helper("my_functions");
        $this->load->library('form_validation');
        $this->load->library("session");
        $this->load->model("user_m");
        $this->load->model("mr_m");
        $this->load->model("module_m");
		$this->load->model(ADMIN_DIR."message_model");
		
		$this->load->model("admin/system_global_setting_model");
		
        $this->data['controller_name'] = $this->controller_name = $this->router->fetch_class();
        $this->data['method_name'] = $this->method_name = $this->router->fetch_method();
        $this->data['menu_arr'] = $this->mr_m->roleMenu($this->session->userdata("role_id"));
        
		//get notification  start here 
		$query="SELECT
					`groups`.`group_name`
					, `groups`.`group_code`
					, `group_gender_types`.`group_gender_type_title`
					, `group_types`.`group_type_title`
					, `meeting_demands`.*
					,`demand_sub_types`.`demand_sub_type_title`
					,`administrative_demand_notifications`.*
				FROM
				`groups`
				,`administrative_demand_notifications`
				,`group_gender_types` 
				,`group_types`
				,`meeting_demands`
				,`demand_sub_types`
				,`demand_types` 
				WHERE `groups`.`group_id` = `administrative_demand_notifications`.`group_id`
				AND `group_gender_types`.`group_gender_type_id` = `groups`.`group_gender_type_id`
				AND `group_types`.`group_type_id` = `groups`.`group_type_id`
				AND `meeting_demands`.`meeting_demand_id` = `administrative_demand_notifications`.`meeting_demand_id`
				AND `demand_sub_types`.`demand_sub_type_id` = `meeting_demands`.`demand_sub_type_id`
				AND `demand_types`.`demand_type_id` = `meeting_demands`.`demand_type_id`
				AND `administrative_demand_notifications`.`new_status` = 1";
				
		$notification = $this->db->query($query);		
		$this->data['all_notifications'] = $notification->result();
		//get message notifications 
		$fields = array(
						"from.user_title as from_user_title", 
						"from_role.role_title as from_role_title",
						"from.user_image as from_user_image",
						"to.user_title as to_user_title",
						"to_role.role_title as to_role_title",
						"to.user_image as to_user_image",
						"messages.*"
            );
		$join_table = array(
            "`users` as `from`" => "from.user_id = messages.message_from_id",
			"`roles` as `from_role`" => "from.role_id = from_role.role_id",
			"`users` as `to` " => "to.user_id = messages.message_to_id",
			"`roles` as `to_role`" => "to.role_id = to_role.role_id"
        );
		
		$where = "messages.message_to_id = ".(int) $this->session->userdata('user_id')." and new_status =1";// 
		$this->data["message_notifications"] = $this->message_model->joinGet($fields, "messages", $join_table, $where, FALSE, TRUE);
		
		
		//get global settings
			 $system_global_setting_id = 1;
			 $fields = $fields = array("sytem_admin_logo", "system_title", "sytem_public_logo" );
			 $join_table = $join_table = array();
			 $where = "system_global_setting_id = $system_global_setting_id";
			 
			 $this->data["system_global_settings"] = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, false, true);
			
        
        //login check
        $exception_uri = array(
            ADMIN_DIR."users/login",
            ADMIN_DIR."users/logout"
        );
        
       //if(!in_array(uri_string(), $exception_uri)){}
    }
    
    
}