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
        $this->load->model("admin/exam_model");
        $this->load->model("admin/student_model");
        $this->load->model("admin/student_exam_subject_mark_model");
        $this->lang->load("artists", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
        error_reporting(14);
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

    public function add_students_subject_result($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
    {
        $this->data["class_id"] = $class_id = (int) $class_id;
        $this->data["section_id"] = $section_id = (int) $section_id;
        $this->data["exam_id"] = $exam_id = (int) $exam_id;
        $this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
        $this->data["subject_id"] = $subject_id = (int) $subject_id;



        $where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
        $exam = $this->exam_model->get_exam_list($where, false, false);
        $this->data["exam"] = $exam[0];
        $query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE 
                 `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subjects`.`subject_id` =" . $subject_id;
        $result = $this->db->query($query);
        $this->data['class_subject'] = $result->result()[0]->subject_title;



        $where = "`students`.`status` IN (1) and `students`.`class_id`='" . $class_id . "' 
				   AND `students`.`section_id` ='" . $section_id . "' ORDER by `students`.`student_class_no` ASC ";
        $this->data["students"] = $this->student_model->get_student_list($where, FALSE);

        $this->data["title"] = "Subject Marks";
        $this->data["view"] = ADMIN_DIR . "exams/students_list";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function update_student_subject_result()
    {

        $class_id =  (int) $this->input->post("class_id");
        $section_id = (int) $this->input->post("section_id");
        $subject_id =  (int) $this->input->post("subject_id");
        $exam_id =  (int) $this->input->post("exam_id");
        $class_subject_id = (int) $this->input->post("class_subject_id");
        $total_marks =  (int) $this->input->post("total_marks");
        $obtain_mark = $this->input->post("obtain_mark");
        $student_exam_subject_mark_id = (int) $this->input->post("student_exam_subject_mark_id");

        $inputs["obtain_mark"]   = $obtain_mark;
        $inputs["total_marks"]   = $total_marks;
        $inputs['passing_marks'] = round((($total_marks * 33) * .01), 2);
        $inputs['percentage'] = round((($obtain_mark * 100) / $total_marks), 2);
        $this->student_exam_subject_mark_model->save($inputs, $student_exam_subject_mark_id);

        redirect(ADMIN_DIR . "teacher_dashboard/students_result/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id");
    }

    public function students_list($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
    {
        $this->data["class_id"] = $class_id = (int) $class_id;
        $this->data["section_id"] = $section_id = (int) $section_id;
        $this->data["exam_id"] = $exam_id = (int) $exam_id;
        $this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
        $this->data["subject_id"] = $subject_id = (int) $subject_id;



        $where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
        $exam = $this->exam_model->get_exam_list($where, false, false);
        $this->data["exam"] = $exam[0];
        $query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subjects`.`subject_id` =" . $subject_id;
        $result = $this->db->query($query);
        $this->data['class_subject'] = $result->result()[0]->subject_title;



        $where = "`students`.`status` IN (1) and `students`.`class_id`='" . $class_id . "' 
				   AND `students`.`section_id` ='" . $section_id . "' ORDER by `students`.`student_class_no` ASC ";
        $this->data["students"] = $this->student_model->get_student_list($where, FALSE);

        $this->data["title"] = "Subject Marks";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/students_list";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }

    public function students_result($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
    {
        $this->data["class_id"] = $class_id = (int) $class_id;
        $this->data["section_id"] = $section_id = (int) $section_id;
        $this->data["exam_id"] = $exam_id = (int) $exam_id;
        $this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
        $this->data["subject_id"] = $subject_id = (int) $subject_id;



        $where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
        $exam = $this->exam_model->get_exam_list($where, false, false);
        $this->data["exam"] = $exam[0];
        $query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subjects`.`subject_id` =" . $subject_id;
        $result = $this->db->query($query);
        $this->data['class_subject'] = $result->result()[0]->subject_title;

        $query = "SELECT
                `students`.*
                , `students_exams_subjects_marks`.`student_exam_subject_mark_id`
                , `students_exams_subjects_marks`.`exam_id`
                , `students_exams_subjects_marks`.`class_subjec_id`
                , `students_exams_subjects_marks`.`obtain_mark`
                ,`students_exams_subjects_marks`.`total_marks`
                , `classes`.`Class_title`
                , `sections`.`section_title`
            FROM
                `students`,
            `students_exams_subjects_marks`,
            `classes`,
            `sections`
            WHERE 
            `students`.`student_id` = `students_exams_subjects_marks`.`student_id`
            AND  `classes`.`class_id` = `students`.`class_id`
            AND `sections`.`section_id` = `students`.`section_id`
                        AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
                        AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject_id . "'
                        AND  `students`.`status`=1
                        and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "' ORDER BY `students`.`student_class_no`";
        $result = $this->db->query($query);
        $this->data['students'] = $result->result();

        $this->data["title"] = "Subject Marks";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/students_result";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }

    public function students_result_update($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
    {
        $this->data["class_id"] = $class_id = (int) $class_id;
        $this->data["section_id"] = $section_id = (int) $section_id;
        $this->data["exam_id"] = $exam_id = (int) $exam_id;
        $this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
        $this->data["subject_id"] = $subject_id = (int) $subject_id;



        $where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
        $exam = $this->exam_model->get_exam_list($where, false, false);
        $this->data["exam"] = $exam[0];
        $query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subjects`.`subject_id` =" . $subject_id;
        $result = $this->db->query($query);
        $this->data['class_subject'] = $result->result()[0]->subject_title;

        $query = "SELECT
                `students`.*
                , `students_exams_subjects_marks`.`student_exam_subject_mark_id`
                , `students_exams_subjects_marks`.`exam_id`
                , `students_exams_subjects_marks`.`class_subjec_id`
                , `students_exams_subjects_marks`.`obtain_mark`
                ,`students_exams_subjects_marks`.`total_marks`
                , `classes`.`Class_title`
                , `sections`.`section_title`
            FROM
                `students`,
            `students_exams_subjects_marks`,
            `classes`,
            `sections`
            WHERE 
            `students`.`student_id` = `students_exams_subjects_marks`.`student_id`
            AND  `classes`.`class_id` = `students`.`class_id`
            AND `sections`.`section_id` = `students`.`section_id`
                        AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
                        AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject_id . "'
                        AND  `students`.`status`=1
                        and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "' ORDER BY `students`.`student_class_no`";
        $result = $this->db->query($query);
        $this->data['students'] = $result->result();

        $this->data["title"] = "Subject Marks";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/students_result";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }
    public function save_student_result()
    {

        $_POST['class_id'] = $class_id =  (int) $this->input->post("class_id");
        $_POST['section_id'] = $section_id = (int) $this->input->post("section_id");
        $_POST['subject_id'] = $subject_id =  (int) $this->input->post("subject_id");
        $_POST['exam_id'] = $exam_id =  (int) $this->input->post("exam_id");
        $_POST['class_subjec_id'] = $class_subject_id = (int) $this->input->post("class_subject_id");
        $_POST['total_marks']  = $total_marks =  (int) $this->input->post("total_marks");

        $query = "SELECT COUNT(*) as total FROM students_exams_subjects_marks
                                WHERE exam_id = '" . $exam_id . "'
                                AND class_id = '" . $class_id . "'
                                AND section_id = '" . $section_id . "'
                                AND subject_id = '" . $subject_id . "'";
        $result_entered = $this->db->query($query)->result()[0]->total;
        if ($result_entered) {
            $this->session->set_flashdata("msg_error", "Result Already Entered");
            redirect(ADMIN_DIR . "teacher_dashboard/students_result/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id");
            exit();
        }

        $query = "SELECT * FROM `teachers` WHERE teacher_id = '" . $this->session->userdata('teacher_id') . "'";
        $teacher = $this->db->query($query)->result()[0];
        $techer_name = $teacher->teacher_name;
        $passing_marks = round((($total_marks * 33) * .01), 2);


        $query = "INSERT INTO `class_subject_teacher`( `exam_id`, `class_subject_id`, `section_id`, `class_teacher`, `paper_checked_by`, `total_marks`, `passing_marks` ) VALUES ('" . $exam_id . "', '" . $class_subject_id . "', '" . $section_id . "', '" . $techer_name . "', '" . $techer_name . "', '" . $total_marks . "', '" . $passing_marks . "')";
        $this->db->query($query);

        $students_marks = $this->input->post("student_marks");
        foreach ($students_marks as $student_id => $student_mark) {
            $_POST['student_id'] = $student_id;
            $_POST['obtain_mark'] = $student_mark['marks'];
            $this->student_exam_subject_mark_model->save_data();
        }
        redirect(ADMIN_DIR . "teacher_dashboard/students_result/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id");
    }

    public function test_exams_list()
    {
        $this->data['exams'] = NULL;
        $query = "SELECT * FROM exams ORDER BY exam_id DESC LIMIT 1 ";
        $this->data['exams'] = $this->db->query($query)->result();

        $query = "SELECT ctt.subject_id, ctt.class_subject_id, 
                         ctt.color, classes.class_id,classes.Class_title, 
                         sections.section_id, sections.section_title, ctt.subject_title 
                  FROM `classes_time_tables`as ctt,classes, sections 
                  WHERE ctt.class_id = classes.class_id 
                  AND ctt.section_id = sections.section_id 
                  AND ctt.teacher_id = '" . $this->session->userdata("teacher_id") . "'
                  AND ctt.subject_id != 2
                  ORDER BY classes.class_id ASC";
        $this->data['teacher_subjects'] = $this->db->query($query)->result();
        $this->data["title"] = "Teacher Dashboard";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/test_exams_list";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }

    public function add_student_attendance_form($class, $section, $attendance_date, $evening = false)
    {
        $this->data['class_id'] = $class = (int) $class;
        $this->data['section_id'] = $section = (int) $section;
        $this->data['evening'] = $evening;
        $this->data['attendance_date'] = $attendance_date;

        $query = "SELECT * FROM students WHERE `status` IN (1,2) and section_id ='" . $section . "' and class_id='" . $class . "'
        ORDER BY  `status`, `student_class_no` ASC";
        $this->data['students'] = $this->db->query($query)->result();
        $class_title = $this->db->query("SELECT Class_title FROM classes WHERE class_id = '" . $class . "'")->result()[0]->Class_title;
        $section_title = $this->db->query("SELECT section_title FROM sections WHERE section_id = '" . $section . "'")->result()[0]->section_title;

        $this->data["title"] = "Class " . $class_title . " " . $section_title . " Attendance";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/add_student_attendance_form";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }

    public function edit_student_attendance_form($class, $section, $attendance_date, $evening = false)
    {
        $this->data['class_id'] = $class = (int) $class;
        $this->data['section_id'] = $section = (int) $section;
        $this->data['evening'] = $evening;
        $this->data['attendance_date'] = $attendance_date;

        $query = "SELECT * FROM students WHERE `status` IN (1,2) and section_id ='" . $section . "' and class_id='" . $class . "'
        ORDER BY  `status`, `student_class_no` ASC";
        $this->data['students'] = $this->db->query($query)->result();
        $class_title = $this->db->query("SELECT Class_title FROM classes WHERE class_id = '" . $class . "'")->result()[0]->Class_title;
        $section_title = $this->db->query("SELECT section_title FROM sections WHERE section_id = '" . $section . "'")->result()[0]->section_title;

        $this->data["title"] = "Class " . $class_title . " " . $section_title . " Attendance";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/edit_student_attendance_form";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }


    public function add_student_attendance($class, $section, $evening = false)
    {
        $this->data['class_id'] = $class = (int) $class;
        $this->data['section_id'] = $section = (int) $section;
        $this->data['evening'] = $evening;

        $query = "SELECT * FROM students WHERE `status` IN (1,2) and section_id ='" . $section . "' and class_id='" . $class . "'
        ORDER BY  `status`, `student_class_no` ASC";
        $this->data['students'] = $this->db->query($query)->result();
        $class_title = $this->db->query("SELECT Class_title FROM classes WHERE class_id = '" . $class . "'")->result()[0]->Class_title;
        $section_title = $this->db->query("SELECT section_title FROM sections WHERE section_id = '" . $section . "'")->result()[0]->section_title;

        $this->data["title"] = "Class " . $class_title . " " . $section_title . " Attendance";
        $this->data["view"] = ADMIN_DIR . "teacher_dashboard/add_student_attendance";
        $this->load->view(ADMIN_DIR . "layout_mobile", $this->data);
    }
    public function add_attendance()
    {

        $class_id = (int) $this->input->post('class_id');
        $section_id = (int) $this->input->post('section_id');
        if ($this->input->post('attendance_date')) {
            if (date('N', strtotime($this->input->post('attendance_date'))) == 7) {
                $this->session->set_flashdata("msg_error", "It's Sunday. School off.");
                redirect(ADMIN_DIR . "teacher_dashboard/add_student_attendance/" . $class_id . "/" . $section_id);
            }
            $attendance_date = $this->db->escape($this->input->post('attendance_date'));
            $created_date = $this->db->escape($this->input->post('attendance_date') . " " . date("H:i:s"));
        } else {
            $attendance_date = $this->db->escape(date("Y-m-d"));
            $created_date = $this->db->escape(date('Y-m-d H:i:s'));
            if (date('N') == 7) {
                $this->session->set_flashdata("msg_error", "It's Sunday. School off.");
                redirect(ADMIN_DIR . "teacher_dashboard/add_student_attendance/" . $class_id . "/" . $section_id);
            }
        }



        if ($this->input->post('Add_Evening_Attendance')) {
            $students_attendance = $this->input->post('attendance');
            foreach ($students_attendance as $student_attendance_id => $attendance) {
                $query = "UPDATE `students_attendance` SET `attendance2` = '" . $attendance . "',  
                `evening_attendance_by` = '" . $this->session->userdata('teacher_id') . "'
                WHERE student_attendance_id = '" . $student_attendance_id . "'";
                $this->db->query($query);
            }
            $this->session->set_flashdata("msg_success", "Evening Attendance Update Successfully.");
        }
        if ($this->input->post('Add_Today_Attendance')) {
            $query = "SELECT COUNT(*) as total FROM `students_attendance` WHERE 
            class_id = '" . $class_id . "' and section_id = '" . $section_id . "' and date(`created_date`) = $attendance_date";
            $today_attendance = $this->db->query($query)->result()[0]->total;
            if ($today_attendance) {
                $this->session->set_flashdata("msg_error", "Today Attendance is already added.");
            } else {
                $students_attendance = $this->input->post('attendance');
                foreach ($students_attendance as $student_id => $attendance) {
                    $query = "INSERT INTO `students_attendance`(`student_id`, `class_id`, `section_id`, `teacher_id`, `attendance`, `date`, `created_date`) 
            VALUES ('" . $student_id . "','" . $class_id . "','" . $section_id . "','" . $this->session->userdata('teacher_id') . "','" . $attendance . "'," . $attendance_date . ", " . $created_date . ")";
                    $this->db->query($query);
                }
                $this->session->set_flashdata("msg_success", "Attendance Add Successfully.");
            }
        }

        redirect(ADMIN_DIR . "teacher_dashboard/add_student_attendance/" . $class_id . "/" . $section_id);
    }

    public function update_attendance()
    {

        $class_id = (int) $this->input->post('class_id');
        $section_id = (int) $this->input->post('section_id');
        if ($this->input->post('attendance_date')) {
            $attendance_date = $this->db->escape($this->input->post('attendance_date'));
            $created_date = $this->db->escape($this->input->post('attendance_date') . " " . date("H:i:s"));
        } else {
            $attendance_date = $this->db->escape(date("Y-m-d"));
            $created_date = $this->db->escape(date('Y-m-d H:i:s'));
        }



        if ($this->input->post('Update_Attendance')) {
            $students_attendance = $this->input->post('attendance');
            foreach ($students_attendance as $student_attendance_id => $attendance) {
                $query = "UPDATE `students_attendance` SET `attendance` = '" . $attendance . "',  
                `evening_attendance_by` = '" . $this->session->userdata('teacher_id') . "'
                WHERE student_attendance_id = '" . $student_attendance_id . "'";
                $this->db->query($query);
            }
            $this->session->set_flashdata("msg_success", $this->input->post('attendance_date') . " Attendance Update Successfully.");
        }


        redirect(ADMIN_DIR . "teacher_dashboard/add_student_attendance/" . $class_id . "/" . $section_id);
    }

    public function struck_off_student()
    {
        $student_id = (int) $this->input->post("student_id");
        $class_id = (int) $this->input->post("class_id");
        $section_id = (int) $this->input->post("section_id");
        $struck_off_reason = $this->db->escape($this->input->post("struck_off_reason"));
        $query = "UPDATE students set `status` = '2' WHERE student_id = '" . $student_id . "'";
        if ($this->db->query($query)) {
            $query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
            $student = $this->db->query($query)->result()[0];
            $query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
				          VALUES ('" . $student->student_id . "','" . $student->student_admission_no . "','" . $student->session_id . "','" . $student->class_id . "','" . $student->section_id . "','Struck Off'," . $struck_off_reason . ", '" . $this->session->userdata('user_id') . "')";
            $this->db->query($query);
        }
        if ($this->input->post("redirect_page") == 'view_student_profile') {
            $this->session->set_flashdata("msg_success", "Student Strucked Off Successfully");
            redirect(ADMIN_DIR . "admission/view_student_profile/" . $student_id);
        } else {
            $this->session->set_flashdata("msg_success", "Student Strucked Off Successfully");
            redirect(ADMIN_DIR . "teacher_dashboard/add_student_attendance/" . $class_id . "/" . $section_id);
        }
    }
}
