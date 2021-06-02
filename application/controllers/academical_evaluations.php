<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Academical_evaluations extends Public_Controller{
    
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
        $this->view();
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "";
		$data = $this->academical_evaluation_model->get_academical_evaluation_list($where,TRUE, TRUE);
		 $this->data["academical_evaluations"] = $data->academical_evaluations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Academical Evaluations";
         $this->data["view"] = PUBLIC_DIR."academical_evaluations/academical_evaluations";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_academical_evaluation($academical_evaluation_id){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        
        $this->data["academical_evaluations"] = $this->academical_evaluation_model->get_academical_evaluation($academical_evaluation_id);
        $this->data["title"] = "Academical Evaluations Details";
        $this->data["view"] = PUBLIC_DIR."academical_evaluations/view_academical_evaluation";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
