<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Students extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/student_model");
		$this->lang->load("students", 'english');
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
		
        $where = "`students`.`status` IN (0, 1) ";
		$data = $this->student_model->get_student_list($where);
		 $this->data["students"] = $data->students;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Students');
		$this->data["view"] = ADMIN_DIR."students/students";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_student($student_id){
        
        $student_id = (int) $student_id;
        
        $this->data["students"] = $this->student_model->get_student($student_id);
        $this->data["title"] = $this->lang->line('Student Details');
		$this->data["view"] = ADMIN_DIR."students/view_student";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`students`.`status` IN (2) ";
		$data = $this->student_model->get_student_list($where);
		 $this->data["students"] = $data->students;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Students');
		$this->data["view"] = ADMIN_DIR."students/trashed_students";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($student_id, $page_id = NULL){
        
        $student_id = (int) $student_id;
        
        
        $this->student_model->changeStatus($student_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."students/view/".$page_id);
    }
    
    /**
      * function to restor student from trash
      * @param $student_id integer
      */
     public function restore($student_id, $page_id = NULL){
        
        $student_id = (int) $student_id;
        
        
        $this->student_model->changeStatus($student_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."students/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft student from trash
      * @param $student_id integer
      */
     public function draft($student_id, $page_id = NULL){
        
        $student_id = (int) $student_id;
        
        
        $this->student_model->changeStatus($student_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."students/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish student from trash
      * @param $student_id integer
      */
     public function publish($student_id, $page_id = NULL){
        
        $student_id = (int) $student_id;
        
        
        $this->student_model->changeStatus($student_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."students/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Student
      * @param $student_id integer
      */
     public function delete($student_id, $page_id = NULL){
        
        $student_id = (int) $student_id;
        //$this->student_model->changeStatus($student_id, "3");
        //Remove file....
						$students = $this->student_model->get_student($student_id);
						$file_path = $students[0]->student_image;
						$this->student_model->delete_file($file_path);
		$this->student_model->delete(array( 'student_id' => $student_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."students/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 public function remove_student($exam_id, $class_id, $section_id, $class_subject_id, $subject_id, $student_id){
        
        $student_id = (int) $student_id;
        //$this->student_model->changeStatus($student_id, "3");
        //Remove file....
						$students = $this->student_model->get_student($student_id);
						$file_path = $students[0]->student_image;
						$this->student_model->delete_file($file_path);
		$this->student_model->delete(array( 'student_id' => $student_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."exam_list/add_students_subject_result/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id/$student_id");
     }  
	 
	 
	  public function dormant_student($exam_id, $class_id, $section_id, $class_subject_id, $subject_id, $student_id){
        
        $student_id = (int) $student_id;
        
        
        $this->student_model->changeStatus($student_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
      
        redirect(ADMIN_DIR."exam_list/add_students_subject_result/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id/$student_id");
     } 
	 
	 
	 
     /**
      * function to add new Student
      */
     public function add(){
		
    $this->data["classes"] = $this->student_model->getList("classes", "class_id", "Class_title", $where ="");
    
    $this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Student');$this->data["view"] = ADMIN_DIR."students/add_student";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->student_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("student_image")){
                       $_POST['student_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $student_id = $this->student_model->save_data();
          if($student_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."students/edit/$student_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."students/add");
            }
        }else{
			$this->add();
			}
	 }
	 
	 
	 
	  public function save_student_data($exam_id, $class_id, $section_id, $class_subject_id, $subject_id){
	  
                    
		  $student_id = $this->student_model->save_data();
		  
		
		  
		  
           redirect(ADMIN_DIR."exam_list/add_students_subject_result/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id/$student_id");
          
	 }


     /**
      * function to edit a Student
      */
     public function edit($student_id){
		 $student_id = (int) $student_id;
        $this->data["student"] = $this->student_model->get($student_id);
		  
    $this->data["classes"] = $this->student_model->getList("classes", "class_id", "Class_title", $where ="");
    
    $this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Student');$this->data["view"] = ADMIN_DIR."students/edit_student";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($student_id){
		 
		 $student_id = (int) $student_id;
       
	   if($this->student_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("student_image")){
                         $_POST["student_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $student_id = $this->student_model->update_data($student_id);
          if($student_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."students/edit/$student_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."students/edit/$student_id");
            }
        }else{
			$this->edit($student_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["students"] = $this->student_model->getBy($where, false, "student_id" );
				$j_array[]=array("id" => "", "value" => "student");
				foreach($data["students"] as $student ){
					$j_array[]=array("id" => $student->student_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
	
	function update_student_info($student_id){
		$student_id = (int) $student_id;
		$student_class_no = $this->input->post('student_class_no');
		$student_name = $this->input->post('student_name');
		if($student_name!="" and $student_class_no!="" ){
		$query ="UPDATE `students` SET `student_class_no`='".$student_class_no."',`student_name`='".$student_name."' WHERE `student_id` =$student_id;";
		$result = $this->db->query($query);
		echo "student info update successfuly";
		}else{
			
			
		echo "student name or class number missing try again...";
			}
		
		
		}
    
}        
