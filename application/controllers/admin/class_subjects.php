<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Class_subjects extends Admin_Controller{
    
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
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`class_subjects`.`status` IN (0, 1) ORDER BY `class_subjects`.`order`";
		$data = $this->class_subject_model->get_class_subject_list($where);
		 $this->data["class_subjects"] = $data->class_subjects;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Class Subjects');
		$this->data["view"] = ADMIN_DIR."class_subjects/class_subjects";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_class_subject($class_subject_id){
        
        $class_subject_id = (int) $class_subject_id;
        
        $this->data["class_subjects"] = $this->class_subject_model->get_class_subject($class_subject_id);
        $this->data["title"] = $this->lang->line('Class Subject Details');
		$this->data["view"] = ADMIN_DIR."class_subjects/view_class_subject";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`class_subjects`.`status` IN (2) ORDER BY `class_subjects`.`order`";
		$data = $this->class_subject_model->get_class_subject_list($where);
		 $this->data["class_subjects"] = $data->class_subjects;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Class Subjects');
		$this->data["view"] = ADMIN_DIR."class_subjects/trashed_class_subjects";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($class_subject_id, $page_id = NULL){
        
        $class_subject_id = (int) $class_subject_id;
        
        
        $this->class_subject_model->changeStatus($class_subject_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."class_subjects/view/".$page_id);
    }
    
    /**
      * function to restor class_subject from trash
      * @param $class_subject_id integer
      */
     public function restore($class_subject_id, $page_id = NULL){
        
        $class_subject_id = (int) $class_subject_id;
        
        
        $this->class_subject_model->changeStatus($class_subject_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."class_subjects/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft class_subject from trash
      * @param $class_subject_id integer
      */
     public function draft($class_subject_id, $page_id = NULL){
        
        $class_subject_id = (int) $class_subject_id;
        
        
        $this->class_subject_model->changeStatus($class_subject_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."class_subjects/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish class_subject from trash
      * @param $class_subject_id integer
      */
     public function publish($class_subject_id, $page_id = NULL){
        
        $class_subject_id = (int) $class_subject_id;
        
        
        $this->class_subject_model->changeStatus($class_subject_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."class_subjects/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Class_subject
      * @param $class_subject_id integer
      */
     public function delete($class_subject_id, $page_id = NULL){
        
        $class_subject_id = (int) $class_subject_id;
        //$this->class_subject_model->changeStatus($class_subject_id, "3");
        
		$this->class_subject_model->delete(array( 'class_subject_id' => $class_subject_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."class_subjects/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Class_subject
      */
     public function add(){
		
    $this->data["classes"] = $this->class_subject_model->getList("classes", "class_id", "Class_title", $where ="");
    
    $this->data["subjects"] = $this->class_subject_model->getList("subjects", "subject_id", "subject_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Class Subject');$this->data["view"] = ADMIN_DIR."class_subjects/add_class_subject";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->class_subject_model->validate_form_data() === TRUE){
		  
		  $class_subject_id = $this->class_subject_model->save_data();
          if($class_subject_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."class_subjects/edit/$class_subject_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."class_subjects/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Class_subject
      */
     public function edit($class_subject_id){
		 $class_subject_id = (int) $class_subject_id;
        $this->data["class_subject"] = $this->class_subject_model->get($class_subject_id);
		  
    $this->data["classes"] = $this->class_subject_model->getList("classes", "class_id", "Class_title", $where ="");
    
    $this->data["subjects"] = $this->class_subject_model->getList("subjects", "subject_id", "subject_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Class Subject');$this->data["view"] = ADMIN_DIR."class_subjects/edit_class_subject";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($class_subject_id){
		 
		 $class_subject_id = (int) $class_subject_id;
       
	   if($this->class_subject_model->validate_form_data() === TRUE){
		  
		  $class_subject_id = $this->class_subject_model->update_data($class_subject_id);
          if($class_subject_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."class_subjects/edit/$class_subject_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."class_subjects/edit/$class_subject_id");
            }
        }else{
			$this->edit($class_subject_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $class_subject_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($class_subject_id, $page_id = NULL){
        
        $class_subject_id = (int) $class_subject_id;
        
		//get order number of this record
        $this_class_subject_where = "class_subject_id = $class_subject_id";
        $this_class_subject = $this->class_subject_model->getBy($this_class_subject_where, true);
        $this_class_subject_id = $class_subject_id;
        $this_class_subject_order = $this_class_subject->order;
        
        
        //get order number of previous record
        $previous_class_subject_where = "order <= $this_class_subject_order AND class_subject_id != $class_subject_id ORDER BY `order` DESC";
        $previous_class_subject = $this->class_subject_model->getBy($previous_class_subject_where, true);
        $previous_class_subject_id = $previous_class_subject->class_subject_id;
        $previous_class_subject_order = $previous_class_subject->order;
        
        //if this is the first element
        if(!$previous_class_subject_id){
            redirect(ADMIN_DIR."class_subjects/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_class_subject_inputs = array(
            "order" => $previous_class_subject_order
        );
        $this->class_subject_model->save($this_class_subject_inputs, $this_class_subject_id);
        
        $previous_class_subject_inputs = array(
            "order" => $this_class_subject_order
        );
        $this->class_subject_model->save($previous_class_subject_inputs, $previous_class_subject_id);
        
        
        
        redirect(ADMIN_DIR."class_subjects/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $class_subject_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($class_subject_id, $page_id = NULL){
        
        $class_subject_id = (int) $class_subject_id;
        
        
        
        //get order number of this record
         $this_class_subject_where = "class_subject_id = $class_subject_id";
        $this_class_subject = $this->class_subject_model->getBy($this_class_subject_where, true);
        $this_class_subject_id = $class_subject_id;
        $this_class_subject_order = $this_class_subject->order;
        
        
        //get order number of next record
		
        $next_class_subject_where = "order >= $this_class_subject_order and class_subject_id != $class_subject_id ORDER BY `order` ASC";
        $next_class_subject = $this->class_subject_model->getBy($next_class_subject_where, true);
        $next_class_subject_id = $next_class_subject->class_subject_id;
        $next_class_subject_order = $next_class_subject->order;
        
        //if this is the first element
        if(!$next_class_subject_id){
            redirect(ADMIN_DIR."class_subjects/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_class_subject_inputs = array(
            "order" => $next_class_subject_order
        );
        $this->class_subject_model->save($this_class_subject_inputs, $this_class_subject_id);
        
        $next_class_subject_inputs = array(
            "order" => $this_class_subject_order
        );
        $this->class_subject_model->save($next_class_subject_inputs, $next_class_subject_id);
        
        
        
        redirect(ADMIN_DIR."class_subjects/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["class_subjects"] = $this->class_subject_model->getBy($where, false, "class_subject_id" );
				$j_array[]=array("id" => "", "value" => "class_subject");
				foreach($data["class_subjects"] as $class_subject ){
					$j_array[]=array("id" => $class_subject->class_subject_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
	
	public function update_class_subject_mark($class_subject_id){
		
		$class_subject_id = (int) $class_subject_id;
	$marks =  $this->input->post('marks');
	
	$query ="UPDATE `class_subjects` SET `marks`='".$marks."' WHERE `class_subject_id` = '".$class_subject_id."'";
		$result = $this->db->query($query);
		if($result){
			echo "Marks update successfuly";
			}else{
				echo "error..";
				}
		}
		
		public function update_class_subject_passing_mark($class_subject_id){
		
		$class_subject_id = (int) $class_subject_id;
	$passing_mark =  $this->input->post('passing_mark');
	
	$query ="UPDATE `class_subjects` SET `passing_mark`='".$passing_mark."' WHERE `class_subject_id` = '".$class_subject_id."'";
		$result = $this->db->query($query);
		if($result){
			echo "Marks update successfuly";
			}else{
				echo "error..";
				}
		}
		
		
    
}        
