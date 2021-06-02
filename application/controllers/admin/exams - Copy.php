<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Exams extends Admin_Controller{
    
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
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`exams`.`status` IN (0, 1) ORDER BY `exams`.`order`";
		$data = $this->exam_model->get_exam_list($where);
		 $this->data["exams"] = $data->exams;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Exams');
		$this->data["view"] = ADMIN_DIR."exams/exams";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_exam($exam_id){
        
        $exam_id = (int) $exam_id;
        
        $this->data["exams"] = $this->exam_model->get_exam($exam_id);
        $this->data["title"] = $this->lang->line('Exam Details');
		$this->data["view"] = ADMIN_DIR."exams/view_exam";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`exams`.`status` IN (2) ORDER BY `exams`.`order`";
		$data = $this->exam_model->get_exam_list($where);
		 $this->data["exams"] = $data->exams;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Exams');
		$this->data["view"] = ADMIN_DIR."exams/trashed_exams";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($exam_id, $page_id = NULL){
        
        $exam_id = (int) $exam_id;
        
        
        $this->exam_model->changeStatus($exam_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."exams/view/".$page_id);
    }
    
    /**
      * function to restor exam from trash
      * @param $exam_id integer
      */
     public function restore($exam_id, $page_id = NULL){
        
        $exam_id = (int) $exam_id;
        
        
        $this->exam_model->changeStatus($exam_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."exams/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft exam from trash
      * @param $exam_id integer
      */
     public function draft($exam_id, $page_id = NULL){
        
        $exam_id = (int) $exam_id;
        
        
        $this->exam_model->changeStatus($exam_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."exams/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish exam from trash
      * @param $exam_id integer
      */
     public function publish($exam_id, $page_id = NULL){
        
        $exam_id = (int) $exam_id;
        
        
        $this->exam_model->changeStatus($exam_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."exams/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Exam
      * @param $exam_id integer
      */
     public function delete($exam_id, $page_id = NULL){
        
        $exam_id = (int) $exam_id;
        //$this->exam_model->changeStatus($exam_id, "3");
        
		$this->exam_model->delete(array( 'exam_id' => $exam_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."exams/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Exam
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Exam');$this->data["view"] = ADMIN_DIR."exams/add_exam";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->exam_model->validate_form_data() === TRUE){
		  
		  $exam_id = $this->exam_model->save_data();
          if($exam_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."exams/edit/$exam_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."exams/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Exam
      */
     public function edit($exam_id){
		 $exam_id = (int) $exam_id;
        $this->data["exam"] = $this->exam_model->get($exam_id);
		  
        $this->data["title"] = $this->lang->line('Edit Exam');$this->data["view"] = ADMIN_DIR."exams/edit_exam";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($exam_id){
		 
		 $exam_id = (int) $exam_id;
       
	   if($this->exam_model->validate_form_data() === TRUE){
		  
		  $exam_id = $this->exam_model->update_data($exam_id);
          if($exam_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."exams/edit/$exam_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."exams/edit/$exam_id");
            }
        }else{
			$this->edit($exam_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $exam_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($exam_id, $page_id = NULL){
        
        $exam_id = (int) $exam_id;
        
		//get order number of this record
        $this_exam_where = "exam_id = $exam_id";
        $this_exam = $this->exam_model->getBy($this_exam_where, true);
        $this_exam_id = $exam_id;
        $this_exam_order = $this_exam->order;
        
        
        //get order number of previous record
        $previous_exam_where = "order <= $this_exam_order AND exam_id != $exam_id ORDER BY `order` DESC";
        $previous_exam = $this->exam_model->getBy($previous_exam_where, true);
        $previous_exam_id = $previous_exam->exam_id;
        $previous_exam_order = $previous_exam->order;
        
        //if this is the first element
        if(!$previous_exam_id){
            redirect(ADMIN_DIR."exams/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_exam_inputs = array(
            "order" => $previous_exam_order
        );
        $this->exam_model->save($this_exam_inputs, $this_exam_id);
        
        $previous_exam_inputs = array(
            "order" => $this_exam_order
        );
        $this->exam_model->save($previous_exam_inputs, $previous_exam_id);
        
        
        
        redirect(ADMIN_DIR."exams/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $exam_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($exam_id, $page_id = NULL){
        
        $exam_id = (int) $exam_id;
        
        
        
        //get order number of this record
         $this_exam_where = "exam_id = $exam_id";
        $this_exam = $this->exam_model->getBy($this_exam_where, true);
        $this_exam_id = $exam_id;
        $this_exam_order = $this_exam->order;
        
        
        //get order number of next record
		
        $next_exam_where = "order >= $this_exam_order and exam_id != $exam_id ORDER BY `order` ASC";
        $next_exam = $this->exam_model->getBy($next_exam_where, true);
        $next_exam_id = $next_exam->exam_id;
        $next_exam_order = $next_exam->order;
        
        //if this is the first element
        if(!$next_exam_id){
            redirect(ADMIN_DIR."exams/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_exam_inputs = array(
            "order" => $next_exam_order
        );
        $this->exam_model->save($this_exam_inputs, $this_exam_id);
        
        $next_exam_inputs = array(
            "order" => $this_exam_order
        );
        $this->exam_model->save($next_exam_inputs, $next_exam_id);
        
        
        
        redirect(ADMIN_DIR."exams/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["exams"] = $this->exam_model->getBy($where, false, "exam_id" );
				$j_array[]=array("id" => "", "value" => "exam");
				foreach($data["exams"] as $exam ){
					$j_array[]=array("id" => $exam->exam_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
