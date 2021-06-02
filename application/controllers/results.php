<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Results extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/result_model");
		$this->lang->load("results", 'english');
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
		
        $where = "`status` IN (1) ";
		$data = $this->result_model->get_result_list($where,TRUE, TRUE);
		 $this->data["results"] = $data->results;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Results";
         $this->data["view"] = PUBLIC_DIR."results/results";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_result($result_id){
        
        $result_id = (int) $result_id;
        
        $this->data["results"] = $this->result_model->get_result($result_id);
        $this->data["title"] = "Results Details";
        $this->data["view"] = PUBLIC_DIR."results/view_result";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
