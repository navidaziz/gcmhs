<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teacher_dashboard extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/artist_model");
        $this->lang->load("artists", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {




        $query = "SELECT
					`teachers`.`teacher_name`
					, `teachers`.`teacher_id`
					, `teachers`.`teacher_designation`
					, SUM(`class_subjects`.`total_class_week`) AS `class_total`
					, COUNT(`class_subjects`.`total_class_week`) AS `total_class_assigned`
					, (SELECT COUNT(*) FROM `period_subjects` WHERE `period_subjects`.`teacher_id` = `teachers`.`teacher_id`) AS period_assinged
				FROM
					`class_section_subject_teachers`
					RIGHT JOIN `teachers` 
						ON (`class_section_subject_teachers`.`teacher_id` = `teachers`.`teacher_id`)
					LEFT JOIN `class_subjects` 
						ON (`class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`)
                        WHERE `teachers`.`teacher_id` ='" . $this->session->userdata('teacher_id') . "'
				GROUP BY `teachers`.`teacher_id`
				ORDER BY `teachers`.`order` ASC;";
        $result = $this->db->query($query);
        $teachers = $result->result();

        $query = "SELECT * FROM `periods`";
        $result = $this->db->query($query);
        $periods = $result->result();

        $query = "SELECT * FROM exams ORDER BY exam_id DESC LIMIT 1";
        $this->data['exams'] = $this->db->query($query)->result();



        $this->data['teachers'] = $teachers;
        $this->data['periods'] = $periods;


        $this->data["title"] = "Teacher Dashboard";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/dashboard";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }

    public function add_student_attendance($class, $section)
    {
        $this->data['class_id'] = $class = (int) $class;
        $this->data['section_id'] = $section = (int) $section;

        $query = "SELECT * FROM students WHERE status=1 and section_id ='" . $section . "' and class_id='" . $class . "'
        ORDER BY student_class_no ASC";
        $this->data['students'] = $this->db->query($query)->result();
        $class_title = $this->db->query("SELECT Class_title FROM classes WHERE class_id = '" . $class . "'")->result()[0]->Class_title;
        $section_title = $this->db->query("SELECT section_title FROM sections WHERE section_id = '" . $section . "'")->result()[0]->section_title;

        $this->data["title"] = "Class " . $class_title . " " . $section_title . " Attendance";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/add_student_attendance";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }
    public function add_attendance()
    {
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $query = "SELECT COUNT(*) as total FROM `students_attendance` WHERE class_id = '" . $class_id . "' and section_id = '" . $section_id . "' 
        AND date = DATE(NOW())
        ";
        $today_attendance = $this->db->query($query)->result()[0]->total;
        if ($today_attendance) {
            $this->session->set_flashdata("msg_error", "Today Attendance is already added.");
        } else {
            $students_attendance = $this->input->post('attendance');
            foreach ($students_attendance as $student_id => $attendance) {
                $query = "INSERT INTO `students_attendance`(`student_id`, `class_id`, `section_id`, `teacher_id`, `attendance`, `date`) 
            VALUES ('" . $student_id . "','" . $class_id . "','" . $section_id . "','" . $this->session->userdata('teacher_id') . "','" . $attendance . "','" . date("y-m-d") . "')";
                $this->db->query($query);
            }
            $this->session->set_flashdata("msg_success", "Attendance Add Successfully.");
        }
        redirect(ADMIN_DIR . "teacher_dashboard/add_student_attendance/" . $class_id . "/" . $section_id);
    }
}
