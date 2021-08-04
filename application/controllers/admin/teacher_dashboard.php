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



        $this->data['teachers'] = $teachers;
        $this->data['periods'] = $periods;


        $this->data["title"] = "Teacher Name";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/dashboard";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }
}
