<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Class_subjects extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/class_subject_model");
		$this->lang->load("class_subjects", 'english');
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
		$data = $this->class_subject_model->get_class_subject_list($where,TRUE, TRUE);
		 $this->data["class_subjects"] = $data->class_subjects;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Class Subjects";
         $this->data["view"] = PUBLIC_DIR."class_subjects/class_subjects";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_class_subject($class_subject_id){
        
        $class_subject_id = (int) $class_subject_id;
        
        $this->data["class_subjects"] = $this->class_subject_model->get_class_subject($class_subject_id);
        $this->data["title"] = "Class Subjects Details";
        $this->data["view"] = PUBLIC_DIR."class_subjects/view_class_subject";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
