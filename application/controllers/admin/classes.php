<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Classes extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/class_model");
		$this->lang->load("classes", 'english');
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
		
        $where = "`classes`.`status` IN (0, 1) ";
		$data = $this->class_model->get_class_list($where);
		 $this->data["classes"] = $data->classes;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Classes');
		$this->data["view"] = ADMIN_DIR."classes/classes";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_class($class_id){
        
        $class_id = (int) $class_id;
        
        $this->data["classes"] = $this->class_model->get_class($class_id);
        $this->data["title"] = $this->lang->line('Class Details');
		$this->data["view"] = ADMIN_DIR."classes/view_class";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`classes`.`status` IN (2) ";
		$data = $this->class_model->get_class_list($where);
		 $this->data["classes"] = $data->classes;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Classes');
		$this->data["view"] = ADMIN_DIR."classes/trashed_classes";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($class_id, $page_id = NULL){
        
        $class_id = (int) $class_id;
        
        
        $this->class_model->changeStatus($class_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."classes/view/".$page_id);
    }
    
    /**
      * function to restor class from trash
      * @param $class_id integer
      */
     public function restore($class_id, $page_id = NULL){
        
        $class_id = (int) $class_id;
        
        
        $this->class_model->changeStatus($class_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."classes/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft class from trash
      * @param $class_id integer
      */
     public function draft($class_id, $page_id = NULL){
        
        $class_id = (int) $class_id;
        
        
        $this->class_model->changeStatus($class_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."classes/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish class from trash
      * @param $class_id integer
      */
     public function publish($class_id, $page_id = NULL){
        
        $class_id = (int) $class_id;
        
        
        $this->class_model->changeStatus($class_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."classes/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Class
      * @param $class_id integer
      */
     public function delete($class_id, $page_id = NULL){
        
        $class_id = (int) $class_id;
        //$this->class_model->changeStatus($class_id, "3");
        
		$this->class_model->delete(array( 'class_id' => $class_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."classes/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Class
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Class');$this->data["view"] = ADMIN_DIR."classes/add_class";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->class_model->validate_form_data() === TRUE){
		  
		  $class_id = $this->class_model->save_data();
          if($class_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."classes/edit/$class_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."classes/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Class
      */
     public function edit($class_id){
		 $class_id = (int) $class_id;
        $this->data["class"] = $this->class_model->get($class_id);
		  
        $this->data["title"] = $this->lang->line('Edit Class');$this->data["view"] = ADMIN_DIR."classes/edit_class";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($class_id){
		 
		 $class_id = (int) $class_id;
       
	   if($this->class_model->validate_form_data() === TRUE){
		  
		  $class_id = $this->class_model->update_data($class_id);
          if($class_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."classes/edit/$class_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."classes/edit/$class_id");
            }
        }else{
			$this->edit($class_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["classes"] = $this->class_model->getBy($where, false, "class_id" );
				$j_array[]=array("id" => "", "value" => "class");
				foreach($data["classes"] as $class ){
					$j_array[]=array("id" => $class->class_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
