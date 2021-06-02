<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Questions extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/question_model");
		$this->lang->load("questions", 'english');
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
		
        $where = "`questions`.`status` IN (0, 1) ORDER BY `questions`.`order`";
		$data = $this->question_model->get_question_list($where);
		 $this->data["questions"] = $data->questions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Questions');
		$this->data["view"] = ADMIN_DIR."questions/questions";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_question($question_id){
        
        $question_id = (int) $question_id;
        
        $this->data["questions"] = $this->question_model->get_question($question_id);
        $this->data["title"] = $this->lang->line('Question Details');
		$this->data["view"] = ADMIN_DIR."questions/view_question";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`questions`.`status` IN (2) ORDER BY `questions`.`order`";
		$data = $this->question_model->get_question_list($where);
		 $this->data["questions"] = $data->questions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Questions');
		$this->data["view"] = ADMIN_DIR."questions/trashed_questions";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($question_id, $page_id = NULL){
        
        $question_id = (int) $question_id;
        
        
        $this->question_model->changeStatus($question_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."questions/view/".$page_id);
    }
    
    /**
      * function to restor question from trash
      * @param $question_id integer
      */
     public function restore($question_id, $page_id = NULL){
        
        $question_id = (int) $question_id;
        
        
        $this->question_model->changeStatus($question_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."questions/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft question from trash
      * @param $question_id integer
      */
     public function draft($question_id, $page_id = NULL){
        
        $question_id = (int) $question_id;
        
        
        $this->question_model->changeStatus($question_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."questions/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish question from trash
      * @param $question_id integer
      */
     public function publish($question_id, $page_id = NULL){
        
        $question_id = (int) $question_id;
        
        
        $this->question_model->changeStatus($question_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."questions/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Question
      * @param $question_id integer
      */
     public function delete($question_id, $page_id = NULL){
        
        $question_id = (int) $question_id;
        //$this->question_model->changeStatus($question_id, "3");
        //Remove file....
						$questions = $this->question_model->get_question($question_id);
						$file_path = $questions[0]->question_image;
						$this->question_model->delete_file($file_path);
		$this->question_model->delete(array( 'question_id' => $question_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."questions/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Question
      */
     public function add(){
		
    $this->data["classes"] = $this->question_model->getList("CLASSES", "class_id", "Class_title", $where ="");
    
    $this->data["subjects"] = $this->question_model->getList("SUBJECTS", "subject_id", "subject_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Question');$this->data["view"] = ADMIN_DIR."questions/add_question";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->question_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("question_image")){
                       $_POST['question_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $question_id = $this->question_model->save_data();
          if($question_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."questions/edit/$question_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."questions/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Question
      */
     public function edit($question_id){
		 $question_id = (int) $question_id;
        $this->data["question"] = $this->question_model->get($question_id);
		  
    $this->data["classes"] = $this->question_model->getList("CLASSES", "class_id", "Class_title", $where ="");
    
    $this->data["subjects"] = $this->question_model->getList("SUBJECTS", "subject_id", "subject_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Question');$this->data["view"] = ADMIN_DIR."questions/edit_question";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($question_id){
		 
		 $question_id = (int) $question_id;
       
	   if($this->question_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("question_image")){
                         $_POST["question_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $question_id = $this->question_model->update_data($question_id);
          if($question_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."questions/edit/$question_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."questions/edit/$question_id");
            }
        }else{
			$this->edit($question_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $question_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($question_id, $page_id = NULL){
        
        $question_id = (int) $question_id;
        
		//get order number of this record
        $this_question_where = "question_id = $question_id";
        $this_question = $this->question_model->getBy($this_question_where, true);
        $this_question_id = $question_id;
        $this_question_order = $this_question->order;
        
        
        //get order number of previous record
        $previous_question_where = "order <= $this_question_order AND question_id != $question_id ORDER BY `order` DESC";
        $previous_question = $this->question_model->getBy($previous_question_where, true);
        $previous_question_id = $previous_question->question_id;
        $previous_question_order = $previous_question->order;
        
        //if this is the first element
        if(!$previous_question_id){
            redirect(ADMIN_DIR."questions/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_question_inputs = array(
            "order" => $previous_question_order
        );
        $this->question_model->save($this_question_inputs, $this_question_id);
        
        $previous_question_inputs = array(
            "order" => $this_question_order
        );
        $this->question_model->save($previous_question_inputs, $previous_question_id);
        
        
        
        redirect(ADMIN_DIR."questions/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $question_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($question_id, $page_id = NULL){
        
        $question_id = (int) $question_id;
        
        
        
        //get order number of this record
         $this_question_where = "question_id = $question_id";
        $this_question = $this->question_model->getBy($this_question_where, true);
        $this_question_id = $question_id;
        $this_question_order = $this_question->order;
        
        
        //get order number of next record
		
        $next_question_where = "order >= $this_question_order and question_id != $question_id ORDER BY `order` ASC";
        $next_question = $this->question_model->getBy($next_question_where, true);
        $next_question_id = $next_question->question_id;
        $next_question_order = $next_question->order;
        
        //if this is the first element
        if(!$next_question_id){
            redirect(ADMIN_DIR."questions/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_question_inputs = array(
            "order" => $next_question_order
        );
        $this->question_model->save($this_question_inputs, $this_question_id);
        
        $next_question_inputs = array(
            "order" => $this_question_order
        );
        $this->question_model->save($next_question_inputs, $next_question_id);
        
        
        
        redirect(ADMIN_DIR."questions/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["questions"] = $this->question_model->getBy($where, false, "question_id" );
				$j_array[]=array("id" => "", "value" => "question");
				foreach($data["questions"] as $question ){
					$j_array[]=array("id" => $question->question_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
