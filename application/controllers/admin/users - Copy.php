<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Users extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/user_model");
		
		$this->load->model("role_m");
		$this->lang->load("users", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){ 
 $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  redirect($main_page); 
		}
    //---------------------------------------------------------------
 

    /**
     * get a list of all items that are not trashed
     */
    public function view(){
        
        $fields = $fields = array("users.*"
                , "roles.role_title"
            
                , "manager.user_title as manager_title"
            
                , "ngos.ngo_name"
            
                , "manager_role.role_title as manager_role_title"
            );
        $join_table = $join_table = array(
            "roles" => "roles.role_id = users.role_id",
        
            "users as `manager`" => "manager.user_id = users.manager_id",
        
            "ngos" => "ngos.ngo_id = users.ngo_id",
        
            "roles as `manager_role`" => "manager_role.role_id = users.manager_role_id",
        );
        $where = "users.status in (0, 1) ";
        
        
        //configure the pagination
        $this->load->library("pagination");
        $config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
        $config["total_rows"] = $this->user_model->joinGet($fields, "users", $join_table, $where, true);
        $this->pagination->initialize($config);
        $this->data["pagination"] = $this->pagination->create_links();
        
        
        $this->data["title"] = $this->lang->line('Users');
		$this->data["users"] = $this->user_model->joinGet($fields, "users", $join_table, $where);
        $this->data["view"] = ADMIN_DIR."users/users";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_user($user_id){
        
        $user_id = (int) $user_id;
        
        $fields = $fields = array("users.*"
                , "roles.role_title"
            
                , "users.user_title"
            
                , "ngos.ngo_name"
            
                , "roles.role_title"
            );
        $join_table = $join_table = array(
            "roles" => "roles.role_id = users.role_id",
        
            "users" => "users.user_id = users.manager_id",
        
            "ngos" => "ngos.ngo_id = users.ngo_id",
        
            "roles" => "roles.role_id = users.manager_role_id",
        );
        $where = "user_id = $user_id";
        
        
         $this->data["title"] = $this->lang->line('User Details');$this->data["users"] = $this->user_model->joinGet($fields, "users", $join_table, $where, false, true);
        $this->data["view"] = ADMIN_DIR."users/view_user";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
        
        $fields = $fields = array("users.*"
                , "roles.role_title"
            
                , "users.user_title"
            
                , "ngos.ngo_name"
            
                , "roles.role_title"
            );
        $join_table = $join_table = array(
            "roles" => "roles.role_id = users.role_id",
        
            "users" => "users.user_id = users.manager_id",
        
            "ngos" => "ngos.ngo_id = users.ngo_id",
        
            "roles" => "roles.role_id = users.manager_role_id",
        );
        $where = "users.status in (2)";
        
        
        //configure the pagination
        $this->load->library("pagination");
        $config["base_url"] = $config["base_url"] = base_url(ADMIN_DIR.$this->uri->segment(1)."/".$this->uri->segment(2));
        $config["total_rows"] = $this->user_model->joinGet($fields, "users", $join_table, $where, true);
        $this->pagination->initialize($config);
        $this->data["pagination"] = $this->pagination->create_links();
        
		
        $this->data["title"] = $this->lang->line('Trashed Users'); $this->data["users"] = $this->user_model->joinGet($fields, "users", $join_table, $where);
        $this->data["view"] = ADMIN_DIR."users/trashed_users";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($user_id, $page_id){
        
        $user_id = (int) $user_id;
        if(isset($page_id)){
            $page_id = (int) $page_id;
        }else{
            $page_id = "";
        }
        
        $this->user_model->changeStatus($user_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."users/view/".$page_id);
    }
    
    /**
      * function to restor user from trash
      * @param $user_id integer
      */
     public function restore($user_id, $page_id){
        
        $user_id = (int) $user_id;
        if(isset($page_id)){
            $page_id = (int) $page_id;
        }else{
            $page_id = "";
        }
        
        $this->user_model->changeStatus($user_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."users/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft user from trash
      * @param $user_id integer
      */
     public function draft($user_id, $page_id){
        
        $user_id = (int) $user_id;
        if(isset($page_id)){
            $page_id = (int) $page_id;
        }else{
            $page_id = "";
        }
        
        $this->user_model->changeStatus($user_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."users/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish user from trash
      * @param $user_id integer
      */
     public function publish($user_id, $page_id){
        
        $user_id = (int) $user_id;
        if(isset($page_id)){
            $page_id = (int) $page_id;
        }else{
            $page_id = "";
        }
        
        $this->user_model->changeStatus($user_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."users/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a User
      * @param $user_id integer
      */
     public function delete($user_id, $page_id){
        
        $user_id = (int) $user_id;
        if(isset($page_id)){
            $page_id = (int) $page_id;
        }else{
            $page_id = "";
        }
        
        $this->user_model->changeStatus($user_id, "3");
        
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."users/trashed/".$page_id);
     }
     //----------------------------------------------------
    
     /**
      * function to b new User
      */
     public function add(){
		 
		 
		 
		 //var_dump($_POST);
        
		
        $validation_config = array(
            
                        array(
                            "field"  =>  "role_id",
                            "label"  =>  "Role Id",
                            "rules"  =>  "required"
                        ),
						
						
						
                        
                        array(
                            "field"  =>  "manager_id",
                            "label"  =>  "Manager Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "manager_role_id",
                            "label"  =>  "Manager Role Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "ngo_id",
                            "label"  =>  "ngo Id",
                            "rules"  =>  "required"
                        ),
                        
                       
                        array(
                            "field"  =>  "user_title",
                            "label"  =>  "User Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "user_email",
                            "label"  =>  "User Email",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "user_name",
                            "label"  =>  "User Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "user_password",
                            "label"  =>  "User Password",
                            "rules"  =>  "required"
                        ),
                        
            );
        
        
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() === TRUE){
			
		
            
            
                    $config = array(
                        "upload_path" => "./assets/uploads/".$this->router->fetch_class()."/",
                        "allowed_types" => "jpg|jpeg|bmp|png|gif",
                        "max_size" => 10000,
                        "max_width" => 0,
                        "max_height" => 0,
                        "remove_spaces" => true,
                        "encrypt_name" => true
                    );
                    if(!$this->upload_file("user_image", $config)){
                        //var_dump($this->data["upload_error"]);
                        
                    }else{
                        //var_dump($this->data["upload_data"]);
                        $user_image = $this->data["upload_data"]["file_name"];
                    }
                    
            
                    $inputs = array();
            
                    $inputs["role_id"]  =  $this->input->post("role_id");
					
					//$inputs["group_id"]  =  $this->input->post("group_id");
					//$inputs["groups_ids"]  =  $this->input->post("group_ids");
					
					$g_ids = '';
					foreach($this->input->post("group_ids") as $index => $grps)
					{
					$g_ids = $grps."-".$g_ids;
					}
					$inputs["group_id"] = $g_ids;
					
                    
                    $inputs["manager_id"]  =  $this->input->post("manager_id");
                    
                    $inputs["manager_role_id"]  =  $this->input->post("manager_role_id");
                    
                    $inputs["ngo_id"]  =  $this->input->post("ngo_id");
                    
                    $inputs["user_title"]  =  $this->input->post("user_title");
                    
                    $inputs["user_email"]  =  $this->input->post("user_email");
                    
                    $inputs["user_name"]  =  $this->input->post("user_name");
					
                    $inputs["user_password"]  =  $this->input->post("user_password");
				
                    
					
                    if($_FILES["user_image"]["size"] > 0){
					$inputs["user_image"]  =  $this->router->fetch_class()."/".$user_image; }
                    //var_dump($g_ids);        
			        //exit;
			
            
            $user_id = $this->user_model->save($inputs);
            
            if($user_id){
                
                //update the order for new record
                $order_input = array(
                    "`order`" => $user_id
                );
                $this->user_model->save($order_input, $user_id);
                
                
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."users/edit/$user_id");
            
			}else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."users/add");
            }
        }
        
        
        $this->data["roles"] = $this->user_model->getList("roles", "role_id", "role_title");
    
        //$this->data["users"] = $this->user_model->getList("users", "user_id", "user_title");
    
	
        $this->data["ngos"] = $this->user_model->getList("ngos", "ngo_id", "ngo_name");
		
		/* $gorup_types  = $this->user_model->getList("group_types", "group_type_id", "group_type_title");
		 $group_type_and_sub_types =array();
		 foreach($gorup_types as $group_type_id => $gorup_type_title ){
			 $group_type_and_sub_types[$group_type_id]['group_type_title'] = $gorup_type_title;
			 $where=array("group_type_id" => $group_type_id, "status" => 1);
			 ;
			 }*/
			 
		$this->data['groups'] = $this->user_model->getList("groups", "group_id", "group_name");
		
			 
        $this->data["title"] = $this->lang->line('Add New User');$this->data["view"] = ADMIN_DIR."users/add_user";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
	 
	  public function update_profile(){
		 
		 $user_id = (int) $this->session->userdata('user_id');
        $this->data["user"] = $this->user_model->get($user_id);
        
        
        $validation_config = array(
						array(
                            "field"  =>  "user_email",
                            "label"  =>  "User Email",
                            "rules"  =>  "required"
                        ),
                        
                        
                        array(
                            "field"  =>  "user_password",
                            "label"  =>  "User Password",
                            "rules"  =>  "required"
                        ),
						
						  array(
                            "field"  =>  "user_mobile_number",
                            "label"  =>  "Mobile Number",
                            "rules"  =>  "required"
                        ),
						
                        
            );
        
        
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() === TRUE){
            
            
                    $config = array(
                        "upload_path" => "./assets/uploads/".$this->router->fetch_class()."/",
                        "allowed_types" => "jpg|jpeg|bmp|png|gif",
                        "max_size" => 10000,
                        "max_width" => 0,
                        "max_height" => 0,
                        "remove_spaces" => true,
                        "encrypt_name" => true
                    );
                    if(!$this->upload_file("user_image", $config)){
                        //var_dump($this->data["upload_error"]);
                    }else{
                        //var_dump($this->data["upload_data"]);
                        $user_image = $this->data["upload_data"]["file_name"];
                    }
                    
            
            $inputs = array();
            
                    
                    
                     $inputs["user_email"]  =  $this->input->post("user_email");
                    
                     $inputs["user_password"]  =  $this->input->post("user_password");
					
					$inputs["user_mobile_number"]  =  $this->input->post("user_mobile_number");
					
					
                    
                    if($_FILES["user_image"]["size"] > 0){
                        $inputs["user_image"]  =  $this->router->fetch_class()."/".$user_image;
                    }
                    
            
            if($this->user_model->save($inputs, $user_id)){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."users/update_profile");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."users/update_profile");
            }
        }
        
        $this->data["title"] = $this->lang->line('Update Profile');
		$this->data["view"] = ADMIN_DIR."users/update_profile";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     
		  
	  }
	 
     //--------------------------------------------------------------------
     
     /**
      * function to edit a User
      */
     public function edit($user_id){
        
        $user_id = (int) $user_id;
        $this->data["user"] = $this->user_model->get($user_id);
		
        
        
        $validation_config = array(
            
                        array(
                            "field"  =>  "role_id",
                            "label"  =>  "Role Id",
                            "rules"  =>  "required"
                        ),
						
						
                        
                        array(
                            "field"  =>  "manager_id",
                            "label"  =>  "Manager Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "manager_role_id",
                            "label"  =>  "Manager Role Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "ngo_id",
                            "label"  =>  "ngo Id",
                            "rules"  =>  "required"
                        ),
                        
                       
                        array(
                            "field"  =>  "user_title",
                            "label"  =>  "User Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "user_email",
                            "label"  =>  "User Email",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "user_name",
                            "label"  =>  "User Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "user_password",
                            "label"  =>  "User Password",
                            "rules"  =>  "required"
                        ),
                        
            );
        
        //var_dump($_REQUEST);
		//exit;
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() === TRUE){
            
            
                    $config = array(
                        "upload_path" => "./assets/uploads/".$this->router->fetch_class()."/",
                        "allowed_types" => "jpg|jpeg|bmp|png|gif",
                        "max_size" => 10000,
                        "max_width" => 0,
                        "max_height" => 0,
                        "remove_spaces" => true,
                        "encrypt_name" => true
                    );
                    if(!$this->upload_file("user_image", $config)){
                        //var_dump($this->data["upload_error"]);
                    }else{
                        //var_dump($this->data["upload_data"]);
                        $user_image = $this->data["upload_data"]["file_name"];
                    }
                    
            
                    $inputs = array();
            
                    $inputs["role_id"]  =  $this->input->post("role_id");
                    
                    $inputs["manager_id"]  =  $this->input->post("manager_id");
					//$inputs["groups_ids"]  =  $this->input->post("groups_ids");
					
					$g_ids = '';
					foreach($this->input->post("group_id") as $index => $grps)
					{
					$g_ids = $grps."-".$g_ids;
					}
					$inputs["group_id"] = $g_ids;
					
                    
                    $inputs["manager_role_id"]  =  $this->input->post("manager_role_id");
                    
                    $inputs["ngo_id"]  =  $this->input->post("ngo_id");
                    
                   // $inputs["district_id"]  =  $this->input->post("district_id");
                    
                    $inputs["user_title"]  =  $this->input->post("user_title");
                    
                    $inputs["user_email"]  =  $this->input->post("user_email");
                    
                    $inputs["user_name"]  =  $this->input->post("user_name");
                    
                    $inputs["user_password"]  =  $this->input->post("user_password");
                    
                    if($_FILES["user_image"]["size"] > 0){
                        $inputs["user_image"]  =  $this->router->fetch_class()."/".$user_image;
                    }
                    
            //var_dump($inputs);
			//exit;
            if($this->user_model->save($inputs, $user_id)){                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."users/edit/$user_id");            
			}else{                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."users/edit/$user_id");
				 }
        }
        
        
        
        
        $this->data["roles"] = $this->user_model->getList("roles", "role_id", "role_title");
    
        //$this->data["users"] = $this->user_model->getList("users", "user_id", "user_title");
    
	
        $this->data["ngos"] = $this->user_model->getList("ngos", "ngo_id", "ngo_name");
		
		 $gorup_types  = $this->user_model->getList("group_types", "group_type_id", "group_type_title");
		 $group_type_and_sub_types =array();
		 foreach($gorup_types as $group_type_id => $gorup_type_title ){
			 $group_type_and_sub_types[$group_type_id]['group_type_title'] = $gorup_type_title;
			 $where=array("group_type_id" => $group_type_id, "status" => 1);
			 $group_type_and_sub_types[$group_type_id]['groups'] = $this->user_model->getList("groups", "group_id", "group_name", $where);
			 }
			 
		//$this->data['group_type_and_sub_types'] = $group_type_and_sub_types;
           		  
				  //$this->data["user"] 
				  $userData = $this->data["user"];				 
				  $allgroupss = explode("-" ,$userData->group_id);
				  $groupId='';				  
				  foreach($allgroupss as $index => $groupIds){
					   if($groupIds>0){$groupId.=$groupIds.",";}
					  }
					$groupId = rtrim($groupId, ",");
					
		$this->data['groupsSelectd'] = $this->user_model->getList("groups", "group_id", "group_name","group_id in (".$groupId.")");
		//var_dump($this->data['groups']);
		//exit;
		
		$this->data['groups'] = $this->user_model->getList("groups", "group_id", "group_name");
        $this->data["title"] = $this->lang->line('Edit User');$this->data["view"] = ADMIN_DIR."users/edit_user";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     
    /**
     * function to move a record up in list
     * @param $user_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($user_id, $page_id){
        
        $user_id = (int) $user_id;
        if(isset($page_id)){
            $page_id = (int) $page_id;
        }else{
            $page_id = "";
        }
        
        
        //get order number of this record
        $this_user_where = "user_id = '$user_id'";
        $this_user = $this->user_model->getBy($this_user_where, true);
        $this_user_id = $user_id;
        $this_user_order = $this_user->order;
        
        
        //get order number of previous record
        $previous_user_where = "`order` <= '$this_user_order' and user_id != '$user_id' order by `order` desc";
        $previous_user = $this->user_model->getBy($previous_user_where, true);
        $previous_user_id = $previous_user->user_id;
        $previous_user_order = $previous_user->order;
        
        //if this is the first element
        if(!$previous_user_id){
            redirect(ADMIN_DIR."users/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_user_inputs = array(
            "`order`" => $previous_user_order
        );
        $this->user_model->save($this_user_inputs, $this_user_id);
        
        $previous_user_inputs = array(
            "`order`" => $this_user_order
        );
        $this->user_model->save($previous_user_inputs, $previous_user_id);
        
        
        
        redirect(ADMIN_DIR."users/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $user_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($user_id, $page_id){
        
        $user_id = (int) $user_id;
        if(isset($page_id)){
            $page_id = (int) $page_id;
        }else{
            $page_id = "";
        }
        
        
        //get order number of this record
        $this_user_where = "user_id = '$user_id'";
        $this_user = $this->user_model->getBy($this_user_where, true);
        $this_user_id = $user_id;
        $this_user_order = $this_user->order;
        
        
        //get order number of next record
        $next_user_where = "`order` >= '$this_user_order' and user_id != '$user_id' order by `order` asc";
        $next_user = $this->user_model->getBy($next_user_where, true);
        $next_user_id = $next_user->user_id;
        $next_user_order = $next_user->order;
        
        //if this is the first element
        if(!$next_user_id){
            redirect(ADMIN_DIR."users/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_user_inputs = array(
            "`order`" => $next_user_order
        );
        $this->user_model->save($this_user_inputs, $this_user_id);
        
        $next_user_inputs = array(
            "`order`" => $this_user_order
        );
        $this->user_model->save($next_user_inputs, $next_user_id);
        
        
        
        redirect(ADMIN_DIR."users/view/".$page_id);
    }
	
	 
     /**
      * function to login a user
      */
     public function login(){
        
        //check if the user is already logedin
        if($this->user_m->loggedIn() == TRUE){
            redirect(ADMIN_DIR."users/view");
        }
        
        //load other models
        $this->load->model("role_m");
        $this->load->model("module_m");
        
        $validations = array(
            /*array(
                'field' =>  'user_email',
                'label' =>  'Email Address',
                'rules' =>  'valid_email|required'
            ),
            */
            array(
                'field' =>  'user_password',
                'label' =>  'Password',
                'rules' =>  'required'
            )
        );
        $this->form_validation->set_rules($validations);
        if($this->form_validation->run() === TRUE){
            
            $input_values = array(
                'user_name' => $this->input->post("user_email"),
                'user_password' => $this->input->post("user_password")
            );
            
            //get the user
            $user = $this->user_m->getBy($input_values, TRUE);
			//var_dump($user);
			//exit;
            
            if(count($user) > 0){
                
                //
                $role_homepage_id = $this->role_m->getCol("role_homepage", $user->role_id);
                $role_homepage_parent_id = $this->module_m->getCol("parent_id", $role_homepage_id);
                
                //now create homepage path
                $homepage_path = "";
                if($role_homepage_parent_id != 0){
                    $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_parent_id)."/";
                }
                $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_id);
				
				$fields = "roles.*";
				$join  = array();
				$where = "roles.role_id = $user->role_id";
                $role=$roles= $this->role_m->joinGet($fields, "roles", $join, $where);
				
				//get user projects  by role id
				
						
				
                $user_data = array(
					"user_id"  => $user->user_id,
                    "user_email" => $user->user_email,
                    "user_title" => $user->user_title,
                    "role_id" => $user->role_id,
					"role_level" =>  $role[0]->role_level,
					"district_id" => $user->district_id,
                    "role_homepage_id" => $role_homepage_id,
                    "role_homepage_uri" => $homepage_path,
                    "ngo_id" => $user->ngo_id,
					"user_image" => $user->user_image ,
                    "logged_in" => TRUE
                );
                
                //add to session
                $this->session->set_userdata($user_data);
				//var_dump($this->session->userdata);
				//exit;
                $this->session->set_flashdata('msg_success', "<strong>".$user->user_title.'</strong><br/><i>welcome to admin panel</i>');
                redirect(ADMIN_DIR.$homepage_path);
            }else{
                $this->session->set_flashdata('msg', 'Email or password is incorrect');
                redirect(ADMIN_DIR."users/login");
            }
        }else{
            
            $this->data['title'] = "Login to dashboard";
            $this->load->view(ADMIN_DIR."users/login", $this->data);
        }
        
     }
     
	 
	 //--------------------------------------------------------------
	 
	 
	 // shift group -----kamran
	 public function shift_group($gIds)
	 {
		 
		$this->session->unset_userdata('group_id');   
		
		$user_data['group_id'] = $gIds;
		$this->session->set_userdata($user_data);
		redirect(ADMIN_DIR."/meetings/to_entry_or_reporting");		
			
        }
        
     
		 
		 
     
     
     
     /**
      * logout a user
      */
     public function logout(){
        $this->user_m->logout();
        redirect(ADMIN_DIR."users/login");
     }
    
    
    
    /**
     * check unique on edit, custome callback validation function
     * @param $db_string string DB table and field name
     * @param $id integer id of the current edited item
     * @return boolean
     */
    public function _unique_email($email){
        
        $user_id = $this->uri->segment(3);
        
        $where = array(
            "user_email" => $email,
            "user_id != " => $user_id
        );
        $username = $this->user_m->getBy($where, TRUE);
        
        if(count($username)){
            $this->form_validation->set_message("_unique_email", "%s is already  in use, please enter another email ID");
            return false;
        }
        return true;
    }
	
    
    /**
     * get data as a json array 
     */
    public function get_json( $field_id = null ){
				/*$where = array("status" =>1);
				$where[$this->uri->segment(4)]= $this->uri->segment(5);
				$data["users"] = $this->user_model->getBy($where, false, "user_id, user_title" );
				$j_array="";
				foreach($data["users"] as $user ){
					$j_array[$user->user_id]=$user->user_title;
					}
					echo json_encode($j_array);*/
		
		
       
    }
    //-----------------------------------------------------
    
}        
