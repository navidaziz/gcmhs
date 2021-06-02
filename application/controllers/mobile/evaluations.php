<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Evaluations extends Admin_Controller_Mobile{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/evaluation_model");
		$this->lang->load("evaluations", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
    }
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "";
		$data = $this->evaluation_model->get_evaluation_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_evaluation($evaluation_id){
        
        $evaluation_id = (int) $evaluation_id;
		$data = $this->evaluation_model->get_evaluation($evaluation_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "";
		$data = $this->evaluation_model->get_evaluation_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($evaluation_id){
        
        $evaluation_id = (int) $evaluation_id;
		$this->evaluation_model->changeStatus($evaluation_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor evaluation from trash
      * @param $evaluation_id integer
      */
     public function restore($evaluation_id){
        
        $evaluation_id = (int) $evaluation_id;
		$this->evaluation_model->changeStatus($evaluation_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft evaluation from trash
      * @param $evaluation_id integer
      */
     public function draft($evaluation_id){
        
        $evaluation_id = (int) $evaluation_id;
		$this->evaluation_model->changeStatus($evaluation_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish evaluation from trash
      * @param $evaluation_id integer
      */
     public function publish($evaluation_id){
        
        $evaluation_id = (int) $evaluation_id;
		$this->evaluation_model->changeStatus($evaluation_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Evaluation
      * @param $evaluation_id integer
      */
     public function delete($evaluation_id, $page_id = NULL){
        
        $evaluation_id = (int) $evaluation_id;
        //$this->evaluation_model->changeStatus($evaluation_id, "3");
        $this->evaluation_model->delete(array( 'evaluation_id' => $evaluation_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$evaluation_id = $this->evaluation_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($evaluation_id){
		$evaluation_id = $this->evaluation_model->update_data($evaluation_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        
