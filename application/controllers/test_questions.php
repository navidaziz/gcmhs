<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Test_questions extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/test_questions_model");
		$this->lang->load("test_questions", 'english');
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
		
        $where = "`status` IN (1) ORDER BY `order`";
		$data = $this->test_questions_model->get_test_questions_list($where,TRUE, TRUE);
		 $this->data["test_questions"] = $data->test_questions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Test Questions";
         $this->data["view"] = PUBLIC_DIR."test_questions/test_questions";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_test_questions($test_question_id){
        
        $test_question_id = (int) $test_question_id;
        
        $this->data["test_questions"] = $this->test_questions_model->get_test_questions($test_question_id);
        $this->data["title"] = "Test Questions Details";
        $this->data["view"] = PUBLIC_DIR."test_questions/view_test_questions";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
