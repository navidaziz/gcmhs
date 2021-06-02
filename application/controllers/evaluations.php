<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Evaluations extends Public_Controller{
    
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
        $this->view();
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "";
		$data = $this->evaluation_model->get_evaluation_list($where,TRUE, TRUE);
		 $this->data["evaluations"] = $data->evaluations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Evaluations";
         $this->data["view"] = PUBLIC_DIR."evaluations/evaluations";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_evaluation($evaluation_id){
        
        $evaluation_id = (int) $evaluation_id;
        
        $this->data["evaluations"] = $this->evaluation_model->get_evaluation($evaluation_id);
        $this->data["title"] = "Evaluations Details";
        $this->data["view"] = PUBLIC_DIR."evaluations/view_evaluation";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
