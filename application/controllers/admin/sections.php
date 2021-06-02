<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Sections extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/section_model");
		$this->lang->load("sections", 'english');
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
		
        $where = "`sections`.`status` IN (0, 1) ";
		$data = $this->section_model->get_section_list($where);
		 $this->data["sections"] = $data->sections;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Sections');
		$this->data["view"] = ADMIN_DIR."sections/sections";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_section($section_id){
        
        $section_id = (int) $section_id;
        
        $this->data["sections"] = $this->section_model->get_section($section_id);
        $this->data["title"] = $this->lang->line('Section Details');
		$this->data["view"] = ADMIN_DIR."sections/view_section";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`sections`.`status` IN (2) ";
		$data = $this->section_model->get_section_list($where);
		 $this->data["sections"] = $data->sections;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Sections');
		$this->data["view"] = ADMIN_DIR."sections/trashed_sections";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($section_id, $page_id = NULL){
        
        $section_id = (int) $section_id;
        
        
        $this->section_model->changeStatus($section_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."sections/view/".$page_id);
    }
    
    /**
      * function to restor section from trash
      * @param $section_id integer
      */
     public function restore($section_id, $page_id = NULL){
        
        $section_id = (int) $section_id;
        
        
        $this->section_model->changeStatus($section_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."sections/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft section from trash
      * @param $section_id integer
      */
     public function draft($section_id, $page_id = NULL){
        
        $section_id = (int) $section_id;
        
        
        $this->section_model->changeStatus($section_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."sections/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish section from trash
      * @param $section_id integer
      */
     public function publish($section_id, $page_id = NULL){
        
        $section_id = (int) $section_id;
        
        
        $this->section_model->changeStatus($section_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."sections/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Section
      * @param $section_id integer
      */
     public function delete($section_id, $page_id = NULL){
        
        $section_id = (int) $section_id;
        //$this->section_model->changeStatus($section_id, "3");
        
		$this->section_model->delete(array( 'section_id' => $section_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."sections/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Section
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Section');$this->data["view"] = ADMIN_DIR."sections/add_section";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->section_model->validate_form_data() === TRUE){
		  
		  $section_id = $this->section_model->save_data();
          if($section_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."sections/edit/$section_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."sections/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Section
      */
     public function edit($section_id){
		 $section_id = (int) $section_id;
        $this->data["section"] = $this->section_model->get($section_id);
		  
        $this->data["title"] = $this->lang->line('Edit Section');$this->data["view"] = ADMIN_DIR."sections/edit_section";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($section_id){
		 
		 $section_id = (int) $section_id;
       
	   if($this->section_model->validate_form_data() === TRUE){
		  
		  $section_id = $this->section_model->update_data($section_id);
          if($section_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."sections/edit/$section_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."sections/edit/$section_id");
            }
        }else{
			$this->edit($section_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["sections"] = $this->section_model->getBy($where, false, "section_id" );
				$j_array[]=array("id" => "", "value" => "section");
				foreach($data["sections"] as $section ){
					$j_array[]=array("id" => $section->section_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
