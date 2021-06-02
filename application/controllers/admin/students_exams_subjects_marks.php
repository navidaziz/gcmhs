<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Students_exams_subjects_marks extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/student_exam_subject_mark_model");
		$this->lang->load("students_exams_subjects_marks", 'english');
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
		
        $where = "`students_exams_subjects_marks`.`status` IN (0, 1) ORDER BY `students_exams_subjects_marks`.`order`";
		$data = $this->student_exam_subject_mark_model->get_student_exam_subject_mark_list($where);
		 $this->data["students_exams_subjects_marks"] = $data->students_exams_subjects_marks;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Students Exams Subjects Marks');
		$this->data["view"] = ADMIN_DIR."students_exams_subjects_marks/students_exams_subjects_marks";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_student_exam_subject_mark($student_exam_subject_mark_id){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
        $this->data["students_exams_subjects_marks"] = $this->student_exam_subject_mark_model->get_student_exam_subject_mark($student_exam_subject_mark_id);
        $this->data["title"] = $this->lang->line('Student Exam Subject Mark Details');
		$this->data["view"] = ADMIN_DIR."students_exams_subjects_marks/view_student_exam_subject_mark";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`students_exams_subjects_marks`.`status` IN (2) ORDER BY `students_exams_subjects_marks`.`order`";
		$data = $this->student_exam_subject_mark_model->get_student_exam_subject_mark_list($where);
		 $this->data["students_exams_subjects_marks"] = $data->students_exams_subjects_marks;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Students Exams Subjects Marks');
		$this->data["view"] = ADMIN_DIR."students_exams_subjects_marks/trashed_students_exams_subjects_marks";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($student_exam_subject_mark_id, $page_id = NULL){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
        
        $this->student_exam_subject_mark_model->changeStatus($student_exam_subject_mark_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."students_exams_subjects_marks/view/".$page_id);
    }
    
    /**
      * function to restor student_exam_subject_mark from trash
      * @param $student_exam_subject_mark_id integer
      */
     public function restore($student_exam_subject_mark_id, $page_id = NULL){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
        
        $this->student_exam_subject_mark_model->changeStatus($student_exam_subject_mark_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."students_exams_subjects_marks/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft student_exam_subject_mark from trash
      * @param $student_exam_subject_mark_id integer
      */
     public function draft($student_exam_subject_mark_id, $page_id = NULL){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
        
        $this->student_exam_subject_mark_model->changeStatus($student_exam_subject_mark_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."students_exams_subjects_marks/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish student_exam_subject_mark from trash
      * @param $student_exam_subject_mark_id integer
      */
     public function publish($student_exam_subject_mark_id, $page_id = NULL){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
        
        $this->student_exam_subject_mark_model->changeStatus($student_exam_subject_mark_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."students_exams_subjects_marks/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Student_exam_subject_mark
      * @param $student_exam_subject_mark_id integer
      */
     public function delete($student_exam_subject_mark_id, $page_id = NULL){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        //$this->student_exam_subject_mark_model->changeStatus($student_exam_subject_mark_id, "3");
        
		$this->student_exam_subject_mark_model->delete(array( 'student_exam_subject_mark_id' => $student_exam_subject_mark_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."students_exams_subjects_marks/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Student_exam_subject_mark
      */
     public function add(){
		
    $this->data["exams"] = $this->student_exam_subject_mark_model->getList("EXAMS", "exam_id", "term", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Student Exam Subject Mark');$this->data["view"] = ADMIN_DIR."students_exams_subjects_marks/add_student_exam_subject_mark";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->student_exam_subject_mark_model->validate_form_data() === TRUE){
		  
		  $student_exam_subject_mark_id = $this->student_exam_subject_mark_model->save_data();
          if($student_exam_subject_mark_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."students_exams_subjects_marks/edit/$student_exam_subject_mark_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."students_exams_subjects_marks/add");
            }
        }else{
			$this->add();
			}
	 }
	 
	 
	 
	 
	 public function save_student_exam_data(){
		 
		 $students_marks = $this->input->post("student_marks");
		 //var_dump($students_marks );
		 
		$_POST['class_id'] = $class_id =  $this->input->post("class_id");
		$_POST['section_id'] = $section_id = $this->input->post("section_id");
		$_POST['subject_id'] = $subject_id =  $this->input->post("subject_id");
		$_POST['exam_id'] = $exam_id =  $this->input->post("exam_id");
		$_POST['class_subjec_id'] = $class_subject_id = $this->input->post("class_subject_id");
		
		 
		 foreach($students_marks as $student_id => $student_mark){
			 // $student_exam_subject_mark_id = $this->student_exam_subject_mark_model->save_data();
			// echo $student_id." - ".$student_id['marks'];
			//echo $student_id." - ".$student_mark['marks']."<br />";
			$_POST['student_id'] = $student_id;
			$_POST['obtain_mark'] = $student_mark['marks'];
			
			$student_exam_subject_mark_id = $this->student_exam_subject_mark_model->save_data();
			 }
		 
		 $this->load->model("admin/class_subject_teacher_model");
		
		//$class_subject_teacher_id = $this->class_subject_teacher_model->save_data();
		 
		 
		 redirect(ADMIN_DIR."exam_list/update_students_subject_result/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id");
	 }
	 


     /**
      * function to edit a Student_exam_subject_mark
      */
     public function edit($student_exam_subject_mark_id){
		 $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        $this->data["student_exam_subject_mark"] = $this->student_exam_subject_mark_model->get($student_exam_subject_mark_id);
		  
    $this->data["exams"] = $this->student_exam_subject_mark_model->getList("EXAMS", "exam_id", "term", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Student Exam Subject Mark');$this->data["view"] = ADMIN_DIR."students_exams_subjects_marks/edit_student_exam_subject_mark";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($student_exam_subject_mark_id){
		 
		 $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
       
	   if($this->student_exam_subject_mark_model->validate_form_data() === TRUE){
		  
		  $student_exam_subject_mark_id = $this->student_exam_subject_mark_model->update_data($student_exam_subject_mark_id);
          if($student_exam_subject_mark_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."students_exams_subjects_marks/edit/$student_exam_subject_mark_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."students_exams_subjects_marks/edit/$student_exam_subject_mark_id");
            }
        }else{
			$this->edit($student_exam_subject_mark_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $student_exam_subject_mark_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($student_exam_subject_mark_id, $page_id = NULL){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
		//get order number of this record
        $this_student_exam_subject_mark_where = "student_exam_subject_mark_id = $student_exam_subject_mark_id";
        $this_student_exam_subject_mark = $this->student_exam_subject_mark_model->getBy($this_student_exam_subject_mark_where, true);
        $this_student_exam_subject_mark_id = $student_exam_subject_mark_id;
        $this_student_exam_subject_mark_order = $this_student_exam_subject_mark->order;
        
        
        //get order number of previous record
        $previous_student_exam_subject_mark_where = "order <= $this_student_exam_subject_mark_order AND student_exam_subject_mark_id != $student_exam_subject_mark_id ORDER BY `order` DESC";
        $previous_student_exam_subject_mark = $this->student_exam_subject_mark_model->getBy($previous_student_exam_subject_mark_where, true);
        $previous_student_exam_subject_mark_id = $previous_student_exam_subject_mark->student_exam_subject_mark_id;
        $previous_student_exam_subject_mark_order = $previous_student_exam_subject_mark->order;
        
        //if this is the first element
        if(!$previous_student_exam_subject_mark_id){
            redirect(ADMIN_DIR."students_exams_subjects_marks/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_student_exam_subject_mark_inputs = array(
            "order" => $previous_student_exam_subject_mark_order
        );
        $this->student_exam_subject_mark_model->save($this_student_exam_subject_mark_inputs, $this_student_exam_subject_mark_id);
        
        $previous_student_exam_subject_mark_inputs = array(
            "order" => $this_student_exam_subject_mark_order
        );
        $this->student_exam_subject_mark_model->save($previous_student_exam_subject_mark_inputs, $previous_student_exam_subject_mark_id);
        
        
        
        redirect(ADMIN_DIR."students_exams_subjects_marks/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $student_exam_subject_mark_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($student_exam_subject_mark_id, $page_id = NULL){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
        
        
        //get order number of this record
         $this_student_exam_subject_mark_where = "student_exam_subject_mark_id = $student_exam_subject_mark_id";
        $this_student_exam_subject_mark = $this->student_exam_subject_mark_model->getBy($this_student_exam_subject_mark_where, true);
        $this_student_exam_subject_mark_id = $student_exam_subject_mark_id;
        $this_student_exam_subject_mark_order = $this_student_exam_subject_mark->order;
        
        
        //get order number of next record
		
        $next_student_exam_subject_mark_where = "order >= $this_student_exam_subject_mark_order and student_exam_subject_mark_id != $student_exam_subject_mark_id ORDER BY `order` ASC";
        $next_student_exam_subject_mark = $this->student_exam_subject_mark_model->getBy($next_student_exam_subject_mark_where, true);
        $next_student_exam_subject_mark_id = $next_student_exam_subject_mark->student_exam_subject_mark_id;
        $next_student_exam_subject_mark_order = $next_student_exam_subject_mark->order;
        
        //if this is the first element
        if(!$next_student_exam_subject_mark_id){
            redirect(ADMIN_DIR."students_exams_subjects_marks/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_student_exam_subject_mark_inputs = array(
            "order" => $next_student_exam_subject_mark_order
        );
        $this->student_exam_subject_mark_model->save($this_student_exam_subject_mark_inputs, $this_student_exam_subject_mark_id);
        
        $next_student_exam_subject_mark_inputs = array(
            "order" => $this_student_exam_subject_mark_order
        );
        $this->student_exam_subject_mark_model->save($next_student_exam_subject_mark_inputs, $next_student_exam_subject_mark_id);
        
        
        
        redirect(ADMIN_DIR."students_exams_subjects_marks/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["students_exams_subjects_marks"] = $this->student_exam_subject_mark_model->getBy($where, false, "student_exam_subject_mark_id" );
				$j_array[]=array("id" => "", "value" => "student_exam_subject_mark");
				foreach($data["students_exams_subjects_marks"] as $student_exam_subject_mark ){
					$j_array[]=array("id" => $student_exam_subject_mark->student_exam_subject_mark_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
	
public function update_student_subjec_marks($student_exam_subject_mark_id){
	$student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
	$subject_mark =  $this->input->post('subject_mark');
	
	$query ="UPDATE `students_exams_subjects_marks` SET `obtain_mark`='".$subject_mark."' WHERE `student_exam_subject_mark_id` = '".$student_exam_subject_mark_id."'";
		$result = $this->db->query($query);
		if($result){
			echo "Subject Marks update successfuly";
			}else{
				echo "error..";
				}
			
		
		
}
		
    //-----------------------------------------------------
    
}        
