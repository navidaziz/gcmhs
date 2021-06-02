<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Sections extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/section_model");
		$this->lang->load("sections", 'english');
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
		$data = $this->section_model->get_section_list($where,TRUE, TRUE);
		 $this->data["sections"] = $data->sections;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Sections";
         $this->data["view"] = PUBLIC_DIR."sections/sections";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_section($section_id){
        
        $section_id = (int) $section_id;
        
        $this->data["sections"] = $this->section_model->get_section($section_id);
        $this->data["title"] = "Sections Details";
        $this->data["view"] = PUBLIC_DIR."sections/view_section";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
