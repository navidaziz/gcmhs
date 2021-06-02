<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Questions_answers extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/question_answer_model");
		$this->lang->load("questions_answers", 'english');
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
		$data = $this->question_answer_model->get_question_answer_list($where,TRUE, TRUE);
		 $this->data["questions_answers"] = $data->questions_answers;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Questions Answers";
         $this->data["view"] = PUBLIC_DIR."questions_answers/questions_answers";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_question_answer($question_answer_id){
        
        $question_answer_id = (int) $question_answer_id;
        
        $this->data["questions_answers"] = $this->question_answer_model->get_question_answer($question_answer_id);
        $this->data["title"] = "Questions Answers Details";
        $this->data["view"] = PUBLIC_DIR."questions_answers/view_question_answer";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
