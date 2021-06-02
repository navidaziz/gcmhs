<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Class_subject_teacher  extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/class_subject_teacher_model");
		$this->lang->load("class_subject_teacher ", 'english');
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
		$data = $this->class_subject_teacher_model->get_class_subject_teacher_list($where,TRUE, TRUE);
		 $this->data["class_subject_teacher "] = $data->class_subject_teacher ;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Class Subject Teacher ";
         $this->data["view"] = PUBLIC_DIR."class_subject_teacher /class_subject_teacher ";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_class_subject_teacher($class_subject_teacher_id){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
        $this->data["class_subject_teacher "] = $this->class_subject_teacher_model->get_class_subject_teacher($class_subject_teacher_id);
        $this->data["title"] = "Class Subject Teacher  Details";
        $this->data["view"] = PUBLIC_DIR."class_subject_teacher /view_class_subject_teacher";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
