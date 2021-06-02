<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Tests extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/test_model");
		$this->lang->load("tests", 'english');
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
		
        $where = "`tests`.`status` IN (1) ";
		$data = $this->test_model->get_test_list($where,TRUE, TRUE);
		 $this->data["tests"] = $data->tests;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Tests";
         $this->data["view"] = PUBLIC_DIR."tests/tests";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_test($test_id){
        
        $test_id = (int) $test_id;
        
        $this->data["tests"] = $this->test_model->get_test($test_id);
        $this->data["title"] = "Tests Details";
        $this->data["view"] = PUBLIC_DIR."tests/view_test";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
