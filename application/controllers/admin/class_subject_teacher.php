<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Class_subject_teacher extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/class_subject_teacher_model");
		
		$this->lang->load("class_subject_teacher", 'english');
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
		
        $where = "`class_subject_teacher`.`status` IN (0, 1) ORDER BY `class_subject_teacher`.`order`";
		$data = $this->class_subject_teacher_model->get_class_subject_teacher_list($where);
		 $this->data["class_subject_teacher"] = $data->class_subject_teacher;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Class Subject Teacher');
		$this->data["view"] = ADMIN_DIR."class_subject_teacher/class_subject_teacher";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_class_subject_teacher($class_subject_teacher_id){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
        $this->data["class_subject_teacher"] = $this->class_subject_teacher_model->get_class_subject_teacher($class_subject_teacher_id);
        $this->data["title"] = $this->lang->line('Class Subject Teacher Details');
		$this->data["view"] = ADMIN_DIR."class_subject_teacher/view_class_subject_teacher";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`class_subject_teacher`.`status` IN (2) ORDER BY `class_subject_teacher`.`order`";
		$data = $this->class_subject_teacher_model->get_class_subject_teacher_list($where);
		 $this->data["class_subject_teacher"] = $data->class_subject_teacher;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Class Subject Teacher');
		$this->data["view"] = ADMIN_DIR."class_subject_teacher/trashed_class_subject_teacher";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($class_subject_teacher_id, $page_id = NULL){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
        
        $this->class_subject_teacher_model->changeStatus($class_subject_teacher_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."class_subject_teacher/view/".$page_id);
    }
    
    /**
      * function to restor class_subject_teacher from trash
      * @param $class_subject_teacher_id integer
      */
     public function restore($class_subject_teacher_id, $page_id = NULL){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
        
        $this->class_subject_teacher_model->changeStatus($class_subject_teacher_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."class_subject_teacher/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft class_subject_teacher from trash
      * @param $class_subject_teacher_id integer
      */
     public function draft($class_subject_teacher_id, $page_id = NULL){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
        
        $this->class_subject_teacher_model->changeStatus($class_subject_teacher_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."class_subject_teacher/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish class_subject_teacher from trash
      * @param $class_subject_teacher_id integer
      */
     public function publish($class_subject_teacher_id, $page_id = NULL){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
        
        $this->class_subject_teacher_model->changeStatus($class_subject_teacher_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."class_subject_teacher/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Class_subject_teacher
      * @param $class_subject_teacher_id integer
      */
     public function delete($class_subject_teacher_id, $page_id = NULL){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        //$this->class_subject_teacher_model->changeStatus($class_subject_teacher_id, "3");
        
		$this->class_subject_teacher_model->delete(array( 'class_subject_teacher_id' => $class_subject_teacher_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."class_subject_teacher/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	  public function class_subject_teacher_remove($class_subject_teacher_id, $exam_id){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
		$exam_id = $exam_id;
        //$this->class_subject_teacher_model->changeStatus($class_subject_teacher_id, "3");
        
		$this->class_subject_teacher_model->delete(array( 'class_subject_teacher_id' => $class_subject_teacher_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."exam_list/class_subjects_update/".$exam_id);
     }
	 
     /**
      * function to add new Class_subject_teacher
      */
     public function add(){
		
    $this->data["exams"] = $this->class_subject_teacher_model->getList("EXAMS", "exam_id", "term", $where ="");
    
    $this->data["class_subjects"] = $this->class_subject_teacher_model->getList("CLASS_SUBJECTS", "class_subject_id", "subject_id", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Class Subject Teacher');$this->data["view"] = ADMIN_DIR."class_subject_teacher/add_class_subject_teacher";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->class_subject_teacher_model->validate_form_data() === TRUE){
		  
		  $class_subject_teacher_id = $this->class_subject_teacher_model->save_data();
          if($class_subject_teacher_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."class_subject_teacher/edit/$class_subject_teacher_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."class_subject_teacher/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Class_subject_teacher
      */
     public function edit($class_subject_teacher_id){
		 $class_subject_teacher_id = (int) $class_subject_teacher_id;
        $this->data["class_subject_teacher"] = $this->class_subject_teacher_model->get($class_subject_teacher_id);
		  
    $this->data["exams"] = $this->class_subject_teacher_model->getList("EXAMS", "exam_id", "term", $where ="");
    
    $this->data["class_subjects"] = $this->class_subject_teacher_model->getList("CLASS_SUBJECTS", "class_subject_id", "subject_id", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Class Subject Teacher');$this->data["view"] = ADMIN_DIR."class_subject_teacher/edit_class_subject_teacher";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($class_subject_teacher_id){
		 
		 $class_subject_teacher_id = (int) $class_subject_teacher_id;
       
	   if($this->class_subject_teacher_model->validate_form_data() === TRUE){
		  
		  $class_subject_teacher_id = $this->class_subject_teacher_model->update_data($class_subject_teacher_id);
          if($class_subject_teacher_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."class_subject_teacher/edit/$class_subject_teacher_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."class_subject_teacher/edit/$class_subject_teacher_id");
            }
        }else{
			$this->edit($class_subject_teacher_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $class_subject_teacher_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($class_subject_teacher_id, $page_id = NULL){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
		//get order number of this record
        $this_class_subject_teacher_where = "class_subject_teacher_id = $class_subject_teacher_id";
        $this_class_subject_teacher = $this->class_subject_teacher_model->getBy($this_class_subject_teacher_where, true);
        $this_class_subject_teacher_id = $class_subject_teacher_id;
        $this_class_subject_teacher_order = $this_class_subject_teacher->order;
        
        
        //get order number of previous record
        $previous_class_subject_teacher_where = "order <= $this_class_subject_teacher_order AND class_subject_teacher_id != $class_subject_teacher_id ORDER BY `order` DESC";
        $previous_class_subject_teacher = $this->class_subject_teacher_model->getBy($previous_class_subject_teacher_where, true);
        $previous_class_subject_teacher_id = $previous_class_subject_teacher->class_subject_teacher_id;
        $previous_class_subject_teacher_order = $previous_class_subject_teacher->order;
        
        //if this is the first element
        if(!$previous_class_subject_teacher_id){
            redirect(ADMIN_DIR."class_subject_teacher/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_class_subject_teacher_inputs = array(
            "order" => $previous_class_subject_teacher_order
        );
        $this->class_subject_teacher_model->save($this_class_subject_teacher_inputs, $this_class_subject_teacher_id);
        
        $previous_class_subject_teacher_inputs = array(
            "order" => $this_class_subject_teacher_order
        );
        $this->class_subject_teacher_model->save($previous_class_subject_teacher_inputs, $previous_class_subject_teacher_id);
        
        
        
        redirect(ADMIN_DIR."class_subject_teacher/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $class_subject_teacher_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($class_subject_teacher_id, $page_id = NULL){
        
        $class_subject_teacher_id = (int) $class_subject_teacher_id;
        
        
        
        //get order number of this record
         $this_class_subject_teacher_where = "class_subject_teacher_id = $class_subject_teacher_id";
        $this_class_subject_teacher = $this->class_subject_teacher_model->getBy($this_class_subject_teacher_where, true);
        $this_class_subject_teacher_id = $class_subject_teacher_id;
        $this_class_subject_teacher_order = $this_class_subject_teacher->order;
        
        
        //get order number of next record
		
        $next_class_subject_teacher_where = "order >= $this_class_subject_teacher_order and class_subject_teacher_id != $class_subject_teacher_id ORDER BY `order` ASC";
        $next_class_subject_teacher = $this->class_subject_teacher_model->getBy($next_class_subject_teacher_where, true);
        $next_class_subject_teacher_id = $next_class_subject_teacher->class_subject_teacher_id;
        $next_class_subject_teacher_order = $next_class_subject_teacher->order;
        
        //if this is the first element
        if(!$next_class_subject_teacher_id){
            redirect(ADMIN_DIR."class_subject_teacher/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_class_subject_teacher_inputs = array(
            "order" => $next_class_subject_teacher_order
        );
        $this->class_subject_teacher_model->save($this_class_subject_teacher_inputs, $this_class_subject_teacher_id);
        
        $next_class_subject_teacher_inputs = array(
            "order" => $this_class_subject_teacher_order
        );
        $this->class_subject_teacher_model->save($next_class_subject_teacher_inputs, $next_class_subject_teacher_id);
        
        
        
        redirect(ADMIN_DIR."class_subject_teacher/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["class_subject_teacher"] = $this->class_subject_teacher_model->getBy($where, false, "class_subject_teacher_id" );
				$j_array[]=array("id" => "", "value" => "class_subject_teacher");
				foreach($data["class_subject_teacher"] as $class_subject_teacher ){
					$j_array[]=array("id" => $class_subject_teacher->class_subject_teacher_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
	
	
	function class_subject_teacher_update($class_subject_teacher_id){
		$class_subject_teacher_id  = (int) $class_subject_teacher_id;
		$class_teacher =  $this->input->post('class_teacher');
		$query="UPDATE `class_subject_teacher` SET `class_teacher`='".$class_teacher."' WHERE `class_subject_teacher_id` ='".$class_subject_teacher_id."'";
		$result = $this->db->query($query);
		if($result){
			echo $class_teacher;
			}else{
				echo "error..";
				}
		}
    
}        
