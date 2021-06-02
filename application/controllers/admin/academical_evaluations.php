<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Academical_evaluations extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/academical_evaluation_model");
		$this->lang->load("academical_evaluations", 'english');
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
		
        $where = "";
		$data = $this->academical_evaluation_model->get_academical_evaluation_list($where);
		 $this->data["academical_evaluations"] = $data->academical_evaluations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Academical Evaluations');
		$this->data["view"] = ADMIN_DIR."academical_evaluations/academical_evaluations";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_academical_evaluation($academical_evaluation_id){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        
        $this->data["academical_evaluations"] = $this->academical_evaluation_model->get_academical_evaluation($academical_evaluation_id);
		
		
		
		$query ="SELECT
						DISTINCT `classes`.`Class_title`, `classes`.`class_id`
					FROM
					`students`,
					`classes` 
					WHERE `students`.`class_id` = `classes`.`class_id` AND `classes`.`status`=1";
		
		$result = $this->db->query($query);
		$classes = $result->result();
		//var_dump($classes);
		
		foreach($classes as $classe){
			$query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title`, 
						  `sections`.`color` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`class_id` =".$classe->class_id." Order By `sections`.`section_title` ASC";
						
			$result = $this->db->query($query);
			$sections = $result->result();	
			$classe->sections = $sections;	
			
			
			$query="SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `subjects`.`subject_id`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =".$classe->class_id." ORDER BY `subjects`.`subject_title` ASC ";
			$result = $this->db->query($query);
			$subjects = $result->result();	
			$classe->subjects = $subjects;
		}
		
		$this->data['classes'] = $classes;
		
        $this->data["title"] = $this->lang->line('Academical Evaluation Details');
		$this->data["view"] = ADMIN_DIR."academical_evaluations/view_academical_evaluation";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "";
		$data = $this->academical_evaluation_model->get_academical_evaluation_list($where);
		 $this->data["academical_evaluations"] = $data->academical_evaluations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Academical Evaluations');
		$this->data["view"] = ADMIN_DIR."academical_evaluations/trashed_academical_evaluations";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($academical_evaluation_id, $page_id = NULL){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        
        
        $this->academical_evaluation_model->changeStatus($academical_evaluation_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."academical_evaluations/view/".$page_id);
    }
    
    /**
      * function to restor academical_evaluation from trash
      * @param $academical_evaluation_id integer
      */
     public function restore($academical_evaluation_id, $page_id = NULL){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        
        
        $this->academical_evaluation_model->changeStatus($academical_evaluation_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."academical_evaluations/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft academical_evaluation from trash
      * @param $academical_evaluation_id integer
      */
     public function draft($academical_evaluation_id, $page_id = NULL){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        
        
        $this->academical_evaluation_model->changeStatus($academical_evaluation_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."academical_evaluations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish academical_evaluation from trash
      * @param $academical_evaluation_id integer
      */
     public function publish($academical_evaluation_id, $page_id = NULL){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        
        
        $this->academical_evaluation_model->changeStatus($academical_evaluation_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."academical_evaluations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Academical_evaluation
      * @param $academical_evaluation_id integer
      */
     public function delete($academical_evaluation_id, $page_id = NULL){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        //$this->academical_evaluation_model->changeStatus($academical_evaluation_id, "3");
        
		$this->academical_evaluation_model->delete(array( 'academical_evaluation_id' => $academical_evaluation_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."academical_evaluations/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Academical_evaluation
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Academical Evaluation');$this->data["view"] = ADMIN_DIR."academical_evaluations/add_academical_evaluation";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->academical_evaluation_model->validate_form_data() === TRUE){
		  
		  $academical_evaluation_id = $this->academical_evaluation_model->save_data();
          if($academical_evaluation_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."academical_evaluations/edit/$academical_evaluation_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."academical_evaluations/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Academical_evaluation
      */
     public function edit($academical_evaluation_id){
		 $academical_evaluation_id = (int) $academical_evaluation_id;
        $this->data["academical_evaluation"] = $this->academical_evaluation_model->get($academical_evaluation_id);
		  
        $this->data["title"] = $this->lang->line('Edit Academical Evaluation');$this->data["view"] = ADMIN_DIR."academical_evaluations/edit_academical_evaluation";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($academical_evaluation_id){
		 
		 $academical_evaluation_id = (int) $academical_evaluation_id;
       
	   if($this->academical_evaluation_model->validate_form_data() === TRUE){
		  
		  $academical_evaluation_id = $this->academical_evaluation_model->update_data($academical_evaluation_id);
          if($academical_evaluation_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."academical_evaluations/edit/$academical_evaluation_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."academical_evaluations/edit/$academical_evaluation_id");
            }
        }else{
			$this->edit($academical_evaluation_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["academical_evaluations"] = $this->academical_evaluation_model->getBy($where, false, "academical_evaluation_id" );
				$j_array[]=array("id" => "", "value" => "academical_evaluation");
				foreach($data["academical_evaluations"] as $academical_evaluation ){
					$j_array[]=array("id" => $academical_evaluation->academical_evaluation_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
