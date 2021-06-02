<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Test_questions extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/test_questions_model");
		$this->lang->load("test_questions", 'english');
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
		
        $where = "`test_questions`.`status` IN (0, 1) ORDER BY `test_questions`.`order`";
		$data = $this->test_questions_model->get_test_questions_list($where);
		 $this->data["test_questions"] = $data->test_questions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Test Questions');
		$this->data["view"] = ADMIN_DIR."test_questions/test_questions";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_test_questions($test_question_id){
        
        $test_question_id = (int) $test_question_id;
        
        $this->data["test_questions"] = $this->test_questions_model->get_test_questions($test_question_id);
        $this->data["title"] = $this->lang->line('Test Questions Details');
		$this->data["view"] = ADMIN_DIR."test_questions/view_test_questions";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`test_questions`.`status` IN (2) ORDER BY `test_questions`.`order`";
		$data = $this->test_questions_model->get_test_questions_list($where);
		 $this->data["test_questions"] = $data->test_questions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Test Questions');
		$this->data["view"] = ADMIN_DIR."test_questions/trashed_test_questions";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($test_question_id, $page_id = NULL){
        
        $test_question_id = (int) $test_question_id;
        
        
        $this->test_questions_model->changeStatus($test_question_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."test_questions/view/".$page_id);
    }
    
    /**
      * function to restor test_questions from trash
      * @param $test_question_id integer
      */
     public function restore($test_question_id, $page_id = NULL){
        
        $test_question_id = (int) $test_question_id;
        
        
        $this->test_questions_model->changeStatus($test_question_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."test_questions/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft test_questions from trash
      * @param $test_question_id integer
      */
     public function draft($test_question_id, $page_id = NULL){
        
        $test_question_id = (int) $test_question_id;
        
        
        $this->test_questions_model->changeStatus($test_question_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."test_questions/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish test_questions from trash
      * @param $test_question_id integer
      */
     public function publish($test_question_id, $page_id = NULL){
        
        $test_question_id = (int) $test_question_id;
        
        
        $this->test_questions_model->changeStatus($test_question_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."test_questions/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Test_questions
      * @param $test_question_id integer
      */
     public function delete($test_question_id, $page_id = NULL){
        
        $test_question_id = (int) $test_question_id;
        //$this->test_questions_model->changeStatus($test_question_id, "3");
        
		$this->test_questions_model->delete(array( 'test_question_id' => $test_question_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."test_questions/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Test_questions
      */
     public function add(){
		
    $this->data["tests"] = $this->test_questions_model->getList("TESTS", "test_id", "test_title", $where ="");
    
    $this->data["questions"] = $this->test_questions_model->getList("QUESTIONS", "question_id", "question_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Test Questions');$this->data["view"] = ADMIN_DIR."test_questions/add_test_questions";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->test_questions_model->validate_form_data() === TRUE){
		  
		  $test_question_id = $this->test_questions_model->save_data();
          if($test_question_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."test_questions/edit/$test_question_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."test_questions/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Test_questions
      */
     public function edit($test_question_id){
		 $test_question_id = (int) $test_question_id;
        $this->data["test_questions"] = $this->test_questions_model->get($test_question_id);
		  
    $this->data["tests"] = $this->test_questions_model->getList("TESTS", "test_id", "test_title", $where ="");
    
    $this->data["questions"] = $this->test_questions_model->getList("QUESTIONS", "question_id", "question_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Test Questions');$this->data["view"] = ADMIN_DIR."test_questions/edit_test_questions";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($test_question_id){
		 
		 $test_question_id = (int) $test_question_id;
       
	   if($this->test_questions_model->validate_form_data() === TRUE){
		  
		  $test_question_id = $this->test_questions_model->update_data($test_question_id);
          if($test_question_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."test_questions/edit/$test_question_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."test_questions/edit/$test_question_id");
            }
        }else{
			$this->edit($test_question_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $test_question_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($test_question_id, $page_id = NULL){
        
        $test_question_id = (int) $test_question_id;
        
		//get order number of this record
        $this_test_questions_where = "test_question_id = $test_question_id";
        $this_test_questions = $this->test_questions_model->getBy($this_test_questions_where, true);
        $this_test_questions_id = $test_question_id;
        $this_test_questions_order = $this_test_questions->order;
        
        
        //get order number of previous record
        $previous_test_questions_where = "order <= $this_test_questions_order AND test_question_id != $test_question_id ORDER BY `order` DESC";
        $previous_test_questions = $this->test_questions_model->getBy($previous_test_questions_where, true);
        $previous_test_questions_id = $previous_test_questions->test_question_id;
        $previous_test_questions_order = $previous_test_questions->order;
        
        //if this is the first element
        if(!$previous_test_questions_id){
            redirect(ADMIN_DIR."test_questions/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_test_questions_inputs = array(
            "order" => $previous_test_questions_order
        );
        $this->test_questions_model->save($this_test_questions_inputs, $this_test_questions_id);
        
        $previous_test_questions_inputs = array(
            "order" => $this_test_questions_order
        );
        $this->test_questions_model->save($previous_test_questions_inputs, $previous_test_questions_id);
        
        
        
        redirect(ADMIN_DIR."test_questions/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $test_question_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($test_question_id, $page_id = NULL){
        
        $test_question_id = (int) $test_question_id;
        
        
        
        //get order number of this record
         $this_test_questions_where = "test_question_id = $test_question_id";
        $this_test_questions = $this->test_questions_model->getBy($this_test_questions_where, true);
        $this_test_questions_id = $test_question_id;
        $this_test_questions_order = $this_test_questions->order;
        
        
        //get order number of next record
		
        $next_test_questions_where = "order >= $this_test_questions_order and test_question_id != $test_question_id ORDER BY `order` ASC";
        $next_test_questions = $this->test_questions_model->getBy($next_test_questions_where, true);
        $next_test_questions_id = $next_test_questions->test_question_id;
        $next_test_questions_order = $next_test_questions->order;
        
        //if this is the first element
        if(!$next_test_questions_id){
            redirect(ADMIN_DIR."test_questions/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_test_questions_inputs = array(
            "order" => $next_test_questions_order
        );
        $this->test_questions_model->save($this_test_questions_inputs, $this_test_questions_id);
        
        $next_test_questions_inputs = array(
            "order" => $this_test_questions_order
        );
        $this->test_questions_model->save($next_test_questions_inputs, $next_test_questions_id);
        
        
        
        redirect(ADMIN_DIR."test_questions/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["test_questions"] = $this->test_questions_model->getBy($where, false, "test_question_id" );
				$j_array[]=array("id" => "", "value" => "test_questions");
				foreach($data["test_questions"] as $test_questions ){
					$j_array[]=array("id" => $test_questions->test_question_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
	
	
	public function add_or_remove(){
		$test_id = $this->input->post('test_id');
		$question_id = $this->input->post('question_id');
		
		//check data is there are not 
		$query = "SELECT * FROM test_questions WHERE question_id = $question_id and test_id = $test_id";
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		if($result){
			$this->test_questions_model->delete(array( 'question_id' => $question_id, 'test_id' => $test_id, ));
			echo "Delete Successfully ....";
		}else{
			$this->test_questions_model->save_data();
			echo "Add Successfully ....";
			}
		//$this->test_questions_model->save_data();
		/**/
		}	
    
}        
