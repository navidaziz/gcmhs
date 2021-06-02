<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Exams extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/exam_model");
		$this->lang->load("exams", 'english');
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
		$data = $this->exam_model->get_exam_list($where,TRUE, TRUE);
		 $this->data["exams"] = $data->exams;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Exams";
         $this->data["view"] = PUBLIC_DIR."exams/exams";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_exam($exam_id){
        
        $exam_id = (int) $exam_id;
        
        $this->data["exams"] = $this->exam_model->get_exam($exam_id);
        $this->data["title"] = "Exams Details";
        $this->data["view"] = PUBLIC_DIR."exams/view_exam";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
