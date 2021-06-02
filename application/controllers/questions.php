<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Questions extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/question_model");
		$this->lang->load("questions", 'english');
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
		
        $where = "`questions`.`status` IN (1) ORDER BY `classes`.`class_id`";
	 $this->data["questions"] = $this->question_model->get_question_list($where,FALSE, TRUE);
		// $this->data["questions"] = $data->questions;
		 $this->data["pagination"] = "";
		 //$this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Questions";
         $this->data["view"] = PUBLIC_DIR."questions/questions";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_question($question_id){
        
        $question_id = (int) $question_id;
        
        $this->data["questions"] = $this->question_model->get_question($question_id);
        $this->data["title"] = "Questions Details";
        $this->data["view"] = PUBLIC_DIR."questions/view_question";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
