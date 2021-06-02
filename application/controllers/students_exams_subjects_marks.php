<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Students_exams_subjects_marks extends Public_Controller{
    
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
        $this->view();
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`status` IN (1) ORDER BY `order`";
		$data = $this->student_exam_subject_mark_model->get_student_exam_subject_mark_list($where,TRUE, TRUE);
		 $this->data["students_exams_subjects_marks"] = $data->students_exams_subjects_marks;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Students Exams Subjects Marks";
         $this->data["view"] = PUBLIC_DIR."students_exams_subjects_marks/students_exams_subjects_marks";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_student_exam_subject_mark($student_exam_subject_mark_id){
        
        $student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
        
        $this->data["students_exams_subjects_marks"] = $this->student_exam_subject_mark_model->get_student_exam_subject_mark($student_exam_subject_mark_id);
        $this->data["title"] = "Students Exams Subjects Marks Details";
        $this->data["view"] = PUBLIC_DIR."students_exams_subjects_marks/view_student_exam_subject_mark";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
