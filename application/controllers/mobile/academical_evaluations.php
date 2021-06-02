<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Academical_evaluations extends Admin_Controller_Mobile{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/academical_evaluation_model");
		$this->lang->load("academical_evaluations", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
    }
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "";
		$data = $this->academical_evaluation_model->get_academical_evaluation_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_academical_evaluation($academical_evaluation_id){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
		$data = $this->academical_evaluation_model->get_academical_evaluation($academical_evaluation_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "";
		$data = $this->academical_evaluation_model->get_academical_evaluation_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($academical_evaluation_id){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
		$this->academical_evaluation_model->changeStatus($academical_evaluation_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor academical_evaluation from trash
      * @param $academical_evaluation_id integer
      */
     public function restore($academical_evaluation_id){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
		$this->academical_evaluation_model->changeStatus($academical_evaluation_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft academical_evaluation from trash
      * @param $academical_evaluation_id integer
      */
     public function draft($academical_evaluation_id){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
		$this->academical_evaluation_model->changeStatus($academical_evaluation_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish academical_evaluation from trash
      * @param $academical_evaluation_id integer
      */
     public function publish($academical_evaluation_id){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
		$this->academical_evaluation_model->changeStatus($academical_evaluation_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Academical_evaluation
      * @param $academical_evaluation_id integer
      */
     public function delete($academical_evaluation_id, $page_id = NULL){
        
        $academical_evaluation_id = (int) $academical_evaluation_id;
        //$this->academical_evaluation_model->changeStatus($academical_evaluation_id, "3");
        $this->academical_evaluation_model->delete(array( 'academical_evaluation_id' => $academical_evaluation_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$academical_evaluation_id = $this->academical_evaluation_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($academical_evaluation_id){
		$academical_evaluation_id = $this->academical_evaluation_model->update_data($academical_evaluation_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        
