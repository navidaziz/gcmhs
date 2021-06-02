<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Evaluations extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/evaluation_model");
		$this->lang->load("evaluations", 'english');
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
		$data = $this->evaluation_model->get_evaluation_list($where);
		 $this->data["evaluations"] = $data->evaluations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Evaluations');
		$this->data["view"] = ADMIN_DIR."evaluations/evaluations";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_evaluation($evaluation_id){
        
        $evaluation_id = (int) $evaluation_id;
        
        $this->data["evaluations"] = $this->evaluation_model->get_evaluation($evaluation_id);
        $this->data["title"] = $this->lang->line('Evaluation Details');
		$this->data["view"] = ADMIN_DIR."evaluations/view_evaluation";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "";
		$data = $this->evaluation_model->get_evaluation_list($where);
		 $this->data["evaluations"] = $data->evaluations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Evaluations');
		$this->data["view"] = ADMIN_DIR."evaluations/trashed_evaluations";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($evaluation_id, $page_id = NULL){
        
        $evaluation_id = (int) $evaluation_id;
        
        
        $this->evaluation_model->changeStatus($evaluation_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."evaluations/view/".$page_id);
    }
    
    /**
      * function to restor evaluation from trash
      * @param $evaluation_id integer
      */
     public function restore($evaluation_id, $page_id = NULL){
        
        $evaluation_id = (int) $evaluation_id;
        
        
        $this->evaluation_model->changeStatus($evaluation_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."evaluations/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft evaluation from trash
      * @param $evaluation_id integer
      */
     public function draft($evaluation_id, $page_id = NULL){
        
        $evaluation_id = (int) $evaluation_id;
        
        
        $this->evaluation_model->changeStatus($evaluation_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."evaluations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish evaluation from trash
      * @param $evaluation_id integer
      */
     public function publish($evaluation_id, $page_id = NULL){
        
        $evaluation_id = (int) $evaluation_id;
        
        
        $this->evaluation_model->changeStatus($evaluation_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."evaluations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Evaluation
      * @param $evaluation_id integer
      */
     public function delete($evaluation_id, $page_id = NULL){
        
        $evaluation_id = (int) $evaluation_id;
        //$this->evaluation_model->changeStatus($evaluation_id, "3");
        
		$this->evaluation_model->delete(array( 'evaluation_id' => $evaluation_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."evaluations/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Evaluation
      */
     public function add(){
		
    $this->data["academical_evaluation"] = $this->evaluation_model->getList("academical_evaluation", "academical_evaluation_id", "academical_evaluation_title", $where ="`academical_evaluation`.`status` IN (1) ");
    
    $this->data["classes"] = $this->evaluation_model->getList("classes", "class_id", "Class_title", $where ="`classes`.`status` IN (1) ");
    
    $this->data["sections"] = $this->evaluation_model->getList("sections", "section_id", "section_title", $where ="`sections`.`status` IN (1) ");
    
    $this->data["subjects"] = $this->evaluation_model->getList("subjects", "subject_id", "subject_title", $where ="`subjects`.`status` IN (1) ");
    
    $this->data["kpis"] = $this->evaluation_model->getList("kpis", "kpi_id", "kpi_title", $where ="`kpis`.`status` IN (1) ");
    
        $this->data["title"] = $this->lang->line('Add New Evaluation');$this->data["view"] = ADMIN_DIR."evaluations/add_evaluation";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->evaluation_model->validate_form_data() === TRUE){
		  
		  $evaluation_id = $this->evaluation_model->save_data();
          if($evaluation_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."evaluations/edit/$evaluation_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."evaluations/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Evaluation
      */
     public function edit($evaluation_id){
		 $evaluation_id = (int) $evaluation_id;
        $this->data["evaluation"] = $this->evaluation_model->get($evaluation_id);
		  
    $this->data["academical_evaluation"] = $this->evaluation_model->getList("academical_evaluation", "academical_evaluation_id", "academical_evaluation_title", $where ="`academical_evaluation`.`status` IN (1) ");
    
    $this->data["classes"] = $this->evaluation_model->getList("classes", "class_id", "Class_title", $where ="`classes`.`status` IN (1) ");
    
    $this->data["sections"] = $this->evaluation_model->getList("sections", "section_id", "section_title", $where ="`sections`.`status` IN (1) ");
    
    $this->data["subjects"] = $this->evaluation_model->getList("subjects", "subject_id", "subject_title", $where ="`subjects`.`status` IN (1) ");
    
    $this->data["kpis"] = $this->evaluation_model->getList("kpis", "kpi_id", "kpi_title", $where ="`kpis`.`status` IN (1) ");
    
        $this->data["title"] = $this->lang->line('Edit Evaluation');$this->data["view"] = ADMIN_DIR."evaluations/edit_evaluation";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($evaluation_id){
		 
		 $evaluation_id = (int) $evaluation_id;
       
	   if($this->evaluation_model->validate_form_data() === TRUE){
		  
		  $evaluation_id = $this->evaluation_model->update_data($evaluation_id);
          if($evaluation_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."evaluations/edit/$evaluation_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."evaluations/edit/$evaluation_id");
            }
        }else{
			$this->edit($evaluation_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["evaluations"] = $this->evaluation_model->getBy($where, false, "evaluation_id" );
				$j_array[]=array("id" => "", "value" => "evaluation");
				foreach($data["evaluations"] as $evaluation ){
					$j_array[]=array("id" => $evaluation->evaluation_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
