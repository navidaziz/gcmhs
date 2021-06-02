<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Qustions extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/qustion_model");
		$this->lang->load("qustions", 'english');
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
		$data = $this->qustion_model->get_qustion_list($where,TRUE, TRUE);
		 $this->data["qustions"] = $data->qustions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Qustions";
         $this->data["view"] = PUBLIC_DIR."qustions/qustions";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_qustion($qustion_id){
        
        $qustion_id = (int) $qustion_id;
        
        $this->data["qustions"] = $this->qustion_model->get_qustion($qustion_id);
        $this->data["title"] = "Qustions Details";
        $this->data["view"] = PUBLIC_DIR."qustions/view_qustion";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
