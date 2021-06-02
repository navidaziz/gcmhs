<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Classes extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/class_model");
		$this->lang->load("classes", 'english');
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
		$data = $this->class_model->get_class_list($where,TRUE, TRUE);
		 $this->data["classes"] = $data->classes;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Classes";
         $this->data["view"] = PUBLIC_DIR."classes/classes";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_class($class_id){
        
        $class_id = (int) $class_id;
        
        $this->data["classes"] = $this->class_model->get_class($class_id);
        $this->data["title"] = "Classes Details";
        $this->data["view"] = PUBLIC_DIR."classes/view_class";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
