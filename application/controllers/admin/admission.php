<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admission extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		//error_reporting(0);
		$this->load->model("admin/student_model");
		$this->lang->load("students", 'english');
		$this->lang->load("system", 'english');
		//$this->output->enable_profiler(TRUE);


		//test model
		$this->load->model("admin/test_model");
		$this->lang->load("tests", 'english');
		$this->lang->load("system", 'english');

		$this->load->model("admin/question_answer_model");
		$this->lang->load("questions_answers", 'english');
		$this->lang->load("system", 'english');

		$this->load->library('form_validation');
	}
	//---------------------------------------------------------------

	public function asc_report()
	{
		$this->data["view"] = ADMIN_DIR . "admission/asc_report";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function birth_certificate($student_id)
	{
		$student_id = (int) $student_id;
		$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
		$this->data['student'] = $this->db->query($query)->result()[0];
		$this->load->view(ADMIN_DIR . "admission/birth_certificate", $this->data);
	}

	public function rsr()
	{
		$query = "SELECT * FROM teachers";
		$this->data['student'] = $this->db->query($query)->result()[0];
		$this->data["view"] = ADMIN_DIR . "admission/result_submission_report";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	public function update_profile($student_id)
	{
		$student_id = (int) $student_id;
		//update_q($_POST, 'students', 'student_id');
		$input["student_class_no"] = $this->input->post("student_class_no");
		$input["student_admission_no"] = $this->input->post("student_admission_no");
		$input["student_name"] = ucwords(strtolower($this->input->post("student_name")));
		$input["student_father_name"] = ucwords(strtolower($this->input->post("student_father_name")));
		$input["student_data_of_birth"] = $this->input->post("student_data_of_birth");
		$input["form_b"] = $this->input->post("form_b");
		$input["admission_date"] = $this->input->post("admission_date");
		$input["student_address"] = ucwords(strtolower($this->input->post("student_address")));
		$input["father_mobile_number"] = $this->input->post("father_mobile_number");
		$input["father_nic"] = $this->input->post("father_nic");
		$input["guardian_occupation"] = $this->input->post("guardian_occupation");
		$input["religion"] = ucwords(strtolower($this->input->post("religion")));
		$input["nationality"] = ucwords(strtolower($this->input->post("nationality")));
		$input["private_public_school"] = ucwords(strtolower($this->input->post("private_public_school")));
		$input["school_name"] = ucwords(strtolower($this->input->post("school_name")));
		$input["orphan"] = ucwords(strtolower($this->input->post("orphan")));
		$input["vaccinated"] = ucwords(strtolower($this->input->post("vaccinated")));
		$input["is_disable"] = ucwords(strtolower($this->input->post("is_disable")));
		$input["ehsaas"] = ucwords(strtolower($this->input->post("ehsaas")));
		$input["nic_issue_date"] = $this->input->post("nic_issue_date");
		$input["hafiz"] = $this->input->post("hafiz");
		$input["place_of_birth"] = $this->input->post("place_of_birth");
		$input["mother_mobile_no"] = $this->input->post("mother_mobile_no");
		$input["father_mobile_number"] = $this->input->post("father_mobile_number");
		$input["guardian_relation"] = $this->input->post("guardian_relation");
		$input["guardian_name"] = $this->input->post("guardian_name");

		$input["mother_tongue"] = $this->input->post("mother_tongue");

		$this->db->where("student_id", $student_id);
		if ($this->db->update("students", $input)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
		}

		if ($this->input->post('redirect_to')) {
			$query = "SELECT class_id, section_id FROM students WHERE student_id = '" . $student_id . "'";
			$student = $this->db->query($query)->result()[0];

			redirect(ADMIN_DIR . "admission/" . $this->input->post('redirect_to') . "/" . $student->class_id . "/" . $student->section_id);
		} else {
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}


	public function search_student()
	{
		$search = $this->db->escape("%" . $this->input->post("search_student") . "%");
		$search2 = $this->db->escape($this->input->post("search_student"));
		$query = "SELECT s.*, c.class_title, se.section_title
		        FROM students as s,
				classes as c,
				sections as se
				WHERE s.class_id = c.class_id
				AND s.section_id = se.section_id
				AND (s.student_name LIKE $search
				OR s.student_father_name LIKE $search
				OR s.student_admission_no = $search2 )
				LIMIT 20";
		//AND s.status != 0 

		$students_list = $this->db->query($query)->result();

		$this->data['students_list'] = $students_list;
		$this->load->view(ADMIN_DIR . "admission/student_search_list", $this->data);
	}
	public function add_new_student()
	{
		$class_id = $this->input->post("class_id");
		$section_id = $this->input->post("section_id");
		$query = "SELECT * FROM session WHERE status=1";
		$session_id = $this->db->query($query)->row()->session_id;
		$data = array(
			'class_id' => $this->input->post("class_id"),
			'section_id' => $this->input->post("section_id"),
			'session_id' => $session_id,
			'student_class_no' => $this->input->post("student_class_no"),
			'student_name' => $this->input->post("student_name"),
			'student_father_name' => $this->input->post("student_father_name"),
			'student_data_of_birth' => $this->input->post("student_data_of_birth"),
			'student_address' => $this->input->post("student_address"),
			'student_admission_no' => $this->input->post("student_admission_no"),
			'religion' => $this->input->post("religion"),
			'father_nic' => $this->input->post("father_nic"),
			'nationality' => $this->input->post("nationality"),
			'guardian_occupation' => $this->input->post("guardian_occupation"),
			'admission_date' => $this->input->post("admission_date"),
			'private_public_school' => $this->input->post("private_public_school"),
			'school_name' => $this->input->post("school_name"),
			'father_mobile_number' => $this->input->post("father_mobile_number"),
			'orphan' => $this->input->post("orphan")
		);
		if ($this->db->insert('students', $data)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_students/$class_id/$section_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_students/$class_id/$section_id");
		}
	}

	/**
	 * Default action to be called
	 */

	public function index()
	{

		/*var_dump($this->session->userdata('student_name'));
		exit();
		*/
		$query = "SELECT * FROM `classes` WHERE status=1 ORDER BY class_id DESC";

		$result = $this->db->query($query);
		$classes = $result->result();
		//var_dump($classes);

		foreach ($classes as $classe) {
			$query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title`,
						  `sections`.`color` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`status` =1
						AND `students`.`class_id` =" . $classe->class_id . " ORDER BY sections.section_id ASC";

			$result = $this->db->query($query);
			$sections = $result->result();
			$classe->sections = $sections;
		}

		//var_dump($classes);
		$this->data['classes'] = $classes;
		$this->data['title'] = "Admission Section Dashboard";
		$this->data["view"] = ADMIN_DIR . "admission/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	// public function students_list($class_id, $section_id)
	// {


	// 	$class_id = (int) $class_id;
	// 	$section_id = (int) $section_id;
	// 	$where = "`students`.`status` IN (1) and `students`.`class_id`='" . $class_id . "' and `students`.`section_id` ='" . $section_id . "'
	// 	ORDER BY `student_class_no` ASC";
	// 	$this->data["students"] = $this->student_model->get_student_list($where, FALSE);

	// 	$this->data["pagination"] = "";
	// 	$this->data["title"] = "Update Students";

	// 	$this->data["view"] = PUBLIC_DIR . "student/students";
	// 	$this->load->view(PUBLIC_DIR . "layout", $this->data);
	// }

	public function promote_students($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id`='" . $class_id . "' AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "Promote Students";

		$this->data["view"] = ADMIN_DIR . "admission/promote_students";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	public function struck_off_students($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (2) and `students`.`class_id`='" . $class_id . "' 
		AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "Struck Off Students";

		$this->data["view"] = ADMIN_DIR . "admission/struck_off_students";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function students_list($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id` = '" . $class_id . "' ";
		if ($section_id) {
			$where .= " AND `students`.`section_id` ='" . $section_id . "' ";
		}
		$where .= " ORDER BY `section_id`, `student_class_no` ASC ";

		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = " Students list";

		$this->data["view"] = ADMIN_DIR . "admission/students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function award_list($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id`='" . $class_id . "' 
		AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "All Students list";

		$this->data["view"] = ADMIN_DIR . "admission/award_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function results($class_id = NULL, $section_id = NULL)
	{
		if ($class_id) {
			$this->data['class_id']  = $class_id = (int) $class_id;
		} else {
			$this->data['class_id'] = NULL;
		}
		if ($section_id) {
			$this->data['section_id']  = $section_id = (int) $section_id;
		} else {
			$this->data['section_id'] = NULL;
		}
		$where = "`students`.`status` IN (1,2)";

		if ($class_id) {
			$where .= " AND `students`.`class_id` = '" . $class_id . "' ";
		} else {
			$where .= " AND `students`.`class_id` IN (2,3,4,5,6)";
		}

		if ($section_id) {
			$where .= " AND `students`.`section_id` = '" . $section_id . "' ";
		}
		$where .= " ORDER BY `class_id`, `section_id`, `student_class_no` ASC ";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "Students Results";

		$this->data["view"] = ADMIN_DIR . "admission/results";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function all_students_data()
	{
		$where = "`students`.`status` IN (1,2) and `students`.`class_id` IN (2,3,4,5,6) 
		ORDER BY `class_id`, `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "All Students list";

		$this->data["view"] = ADMIN_DIR . "admission/students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	public function age_wise_report($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id`='" . $class_id . "' 
		AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "All Students list";

		$this->data["view"] = ADMIN_DIR . "admission/age_wise_report";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function re_admit_again()
	{
		$student_id = (int) $this->input->post("student_id");
		$class_id = (int) $this->input->post("class_id");
		$section_id = (int) $this->input->post("section_id");
		$admission_no = (int) $this->input->post("admission_no");
		$re_admit_again_reason = $this->db->escape($this->input->post("re_admit_again_reason"));
		$query = "UPDATE students set `status` = '1',  `student_admission_no` = '" . $admission_no . "' WHERE student_id = '" . $student_id . "'";
		if ($this->db->query($query)) {
			$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
			$student = $this->db->query($query)->result()[0];
			$query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
				          VALUES ('" . $student->student_id . "','" . $admission_no . "','" . $student->session_id . "','" . $student->class_id . "','" . $student->section_id . "','Re Admit'," . $re_admit_again_reason . ", '" . $this->session->userdata('user_id') . "')";
			$this->db->query($query);
		}
		if ($this->input->post("redirect_page") == 'view_student_profile') {
			$this->session->set_flashdata("msg_success", "Student Re-Admit Successfully");
			redirect(ADMIN_DIR . "admission/view_student_profile/" . $student_id);
		} else {
			$this->session->set_flashdata("msg_success", "Student Re-Admit Successfully");
			redirect(ADMIN_DIR . "admission/struck_off_students/" . $class_id . "/" . $section_id);
		}
	}

	public function withdraw_student()
	{
		$student_id = (int) $this->input->post("student_id");
		$class_id = (int) $this->input->post("class_id");
		$section_id = (int) $this->input->post("section_id");
		$admission_no = (int) $this->input->post("admission_no");
		$admission_date = $this->db->escape($this->input->post("admission_date"));
		$school_leaving_date = $this->db->escape($this->input->post("school_leaving_date"));
		$slc_issue_date = $this->db->escape($this->input->post("slc_issue_date"));
		$slc_file_no = $this->db->escape($this->input->post("slc_file_no"));
		$slc_certificate_no = $this->db->escape($this->input->post("slc_certificate_no"));
		$withdraw_reason = $this->db->escape($this->input->post("withdraw_reason"));
		$query = "UPDATE students set `status` = '3',  
		          `student_admission_no` = '" . $admission_no . "' 
				  WHERE student_id = '" . $student_id . "'";
		if ($this->db->query($query)) {
			$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
			$student = $this->db->query($query)->result()[0];

			$query = "INSERT INTO `student_leaving_certificates`(
				      `student_id`, 
			          `admission_no`, 
					  `session_id`, 
					  `class_id`, 
					  `section_id`, 
					  `admission_date`, 
					  `school_leaving_date`, 
					  `slc_issue_date`, 
					  `slc_file_no`, 
					  `slc_certificate_no`, 
					  `leaving_reason`,
					  `created_by`) 
				      VALUES ('" . $student->student_id . "',
					          '" . $admission_no . "',
							  '" . $student->session_id . "',
							  '" . $student->class_id . "',
							  '" . $student->section_id . "',
							  " . $admission_date . ",
							  " . $school_leaving_date . ",
							  " . $slc_issue_date . ",
							  " . $slc_file_no . ",
							  " . $slc_certificate_no . ",
							  " . $withdraw_reason . ", 
							  '" . $this->session->userdata('user_id') . "')";
			$this->db->query($query);

			$query = "INSERT INTO `student_history`(`student_id`, 
			          `student_admission_no`, 
					  `session_id`, 
					  `class_id`, 
					  `section_id`, 
					  `history_type`, 
					  `remarks`, 
					  `created_by`) 
				      VALUES ('" . $student->student_id . "',
					          '" . $admission_no . "',
							  '" . $student->session_id . "',
							  '" . $student->class_id . "',
							  '" . $student->section_id . "
							  ','Withdraw'," . $withdraw_reason . ", 
							  '" . $this->session->userdata('user_id') . "')";
			$this->db->query($query);
		}
		if ($this->input->post("redirect_page") == 'view_student_profile') {
			$this->session->set_flashdata("msg_success", "Student Withdraw Successfully");
			redirect(ADMIN_DIR . "admission/view_student_profile/" . $student_id);
		} else {
			$this->session->set_flashdata("msg_success", "Student Withdraw Successfully");
			redirect(ADMIN_DIR . "admission/struck_off_students/" . $class_id . "/" . $section_id);
		}
	}


	public function promote_to_next_section()
	{

		$students = $this->input->post('students');
		$students_ids = implode(",", $students);


		$class_id = (int) $this->input->post("class_id");
		$section_id = (int) $this->input->post("section_id");
		$current_session = (int) $this->input->post("current_session");
		$to_class = (int) $this->input->post("to_class");
		$to_section = (int) $this->input->post("to_section");
		$new_session = (int) $this->input->post("new_session");
		$query = "SELECT * FROM students WHERE student_id IN(" . $students_ids . ")";
		$students = $this->db->query($query)->result();

		foreach ($students as $student) {
			$query = "UPDATE students set class_id = '" . $to_class . "', section_id = '" . $to_section . "', session_id = '" . $new_session . "'
			          WHERE student_id = '" . $student->student_id . "'";
			if ($this->db->query($query)) {
				$query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
				          VALUES ('" . $student->student_id . "','" . $student->student_admission_no . "','" . $student->session_id . "','" . $student->class_id . "','" . $current_session . "','Promoted','Promoted to next class.', '" . $this->session->userdata('user_id') . "')";
				$this->db->query($query);
			}
		}

		$this->session->set_flashdata("msg_success", $this->lang->line("success"));
		redirect(ADMIN_DIR . "admission/promote_students/$class_id/$section_id");
	}


	public function promote_to_next_section_backup()
	{


		$class_id = (int) $this->input->post("class_id");
		$section_id = (int) $this->input->post("section_id");
		$current_session = (int) $this->input->post("current_session");
		$to_class = (int) $this->input->post("to_class");
		$to_section = (int) $this->input->post("to_section");
		$new_session = (int) $this->input->post("new_session");
		$query = "SELECT * FROM students WHERE students.status = 1
		          AND students.class_id = '" . $class_id . "'
				  AND students.section_id = '" . $section_id . "'
				  AND students.session_id = '" . $current_session . "'
				";
		$students = $this->db->query($query)->result();
		foreach ($students as $student) {
			$query = "UPDATE students set class_id = '" . $to_class . "', section_id = '" . $to_section . "', session_id = '" . $new_session . "'
			          WHERE student_id = '" . $student->student_id . "'";
			if ($this->db->query($query)) {
				$query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
				          VALUES ('" . $student->student_id . "','" . $student->student_admission_no . "','" . $student->session_id . "','" . $student->class_id . "','" . $student->section_id . "','Promoted','Promoted to next class.', '" . $this->session->userdata('user_id') . "')";
				$this->db->query($query);
			}
		}

		$this->session->set_flashdata("msg_success", $this->lang->line("success"));
		redirect(ADMIN_DIR . "admission/promote_students/$class_id/$section_id");
	}


	public function login($student_id)
	{

		/*$this->session->sess_destroy();
		$this->session->keep_flashdata('message');*/
		$student_id = (int) $student_id;
		$query = "SELECT
						`student_id`
						, `class_id`
						, `section_id`
						, `student_name`
						, `student_class_no`
						, `student_admission_no`
					FROM
					`students` WHERE `student_id` = " . $student_id . ";";
		$query_result = $this->db->query($query);
		$student_information = $query_result->result()[0];



		$query = $this->db->select('user_data, ip_address')->get('ci_sessions');
		$online_users = array(); /* array to store the user data we fetch */

		$uip[$student_id] = $this->input->ip_address();

		foreach ($query->result() as $row) {
			$udata = unserialize($row->user_data);
			$uip[$udata['student_id']] = $row->ip_address;
			/* put data in array using username as key */
			//$online_users[$udata['student_id']] = $udata['student_name']; 
			$online_users[] = $udata['student_id'];
		}
		$this->data['online_users'] = $online_users;


		if (in_array($student_id, $online_users) and $uip[$student_id] != $this->input->ip_address()) {
			echo "student already log in...";
			$main_page = base_url() . $this->router->fetch_class() . "/students_list/" . $student_information->class_id . "/" . $student_information->section_id;
			redirect($main_page);

			exit();
		}








		//create session here ......
		$user_data = array(
			"student_id"  => $student_information->student_id,
			"class_id" => $student_information->class_id,
			"section_id" => $student_information->section_id,
			"student_name" => $student_information->student_name,
			"student_class_no" =>  $student_information->student_class_no,
			"student_admission_no" => $student_information->student_admission_no,
			"logged_in" => TRUE
		);

		//add to session
		$this->session->set_userdata($user_data);

		$main_page = base_url() . $this->router->fetch_class() . "/view_student/" . $student_id;
		redirect($main_page);
	}

	public function logout()
	{
		$class_id = $this->session->userdata('class_id');
		$section_id = $this->session->userdata('section_id');

		$this->session->sess_destroy();
		redirect(base_url() . $this->router->fetch_class() . "/students_list/" . $class_id . "/" . $section_id);
	}

	/**
	 * get a list of all items that are not trashed
	 */
	public function view()
	{

		$where = "`students`.`status` IN (1) ";
		$data = $this->student_model->get_student_list($where, TRUE, TRUE);
		$this->data["students"] = $data->students;
		$this->data["pagination"] = $data->pagination;
		$this->data["title"] = "Students";
		$this->data["view"] = PUBLIC_DIR . "students/students";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}
	//-----------------------------------------------------

	/**
	 * get single record by id
	 */
	public function view_student_profile($student_id)
	{
		$student_id = (int) $student_id;

		$this->data["students"] = $student = $this->student_model->get_student($student_id);


		//get test by class id
		$where = "`tests`.`status` IN (1) and `tests`.`class_id` = " . $student[0]->class_id;
		$tests  = $this->test_model->get_test_list($where, FALSE);

		foreach ($tests as $index => $test) {
			$query = "SELECT
							COUNT(`question_id`) AS total_questions,
							SUM(`answer`) as got_marks
						FROM `questions_answers`
						WHERE `test_id` = " . $test->test_id . "
						AND `student_id` = " . $student_id . ";";
			$query_result = $this->db->query($query);
			$tests[$index]->result = $query_result->result()[0];
			//get the total questions 

			$query = "SELECT
							COUNT(`test_question_id`) AS total_test_questions
						FROM
						`test_questions`
						WHERE `test_id` = " . $test->test_id . ";";
			$query_result = $this->db->query($query);
			$tests[$index]->result->total_test_questions = $query_result->result()[0]->total_test_questions;
		}

		$this->data["tests"] = $tests;

		/*
		//get test result
			$query = "SELECT
							COUNT(`question_id`) AS total_questions,
							SUM(`answer`) as got_marks
						FROM `questions_answers`
						WHERE `test_id` = $test_id
						AND `student_id` =$student_id;";
			$query_result = $this->db->query($query);
			$this->data['test_result'] = $query_result->result()[0];
		*/



		$this->data["title"] = "Student Detail";
		$this->data["view"] = ADMIN_DIR . "admission/view_student_profile";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	//-----------------------------------------------------

	public function test($test_id)
	{
		$test_id = (int) $test_id;
		$student_id = $this->session->userdata('student_id');
		$check = false;
		$tests_detail = $this->test_model->get_test($test_id);

		//get test total question 
		$query = "SELECT 
				COUNT( `test_questions`.`test_question_id`) AS total_test_questions 
				FROM
				`test_questions` 
				WHERE `test_questions`.`test_id` = $test_id;";
		$query_result = $this->db->query($query);
		$this->data['total_test_questions'] = $query_result->result()[0]->total_test_questions;

		//get test total question attempted
		$query = "SELECT
			COUNT(`question_answer_id`) AS total_attempted_quetions
		FROM
		`questions_answers`
		WHERE  `test_id` = $test_id
		AND `student_id` =$student_id;";
		$query_result = $this->db->query($query);
		$this->data['total_attempted_quetions'] = $query_result->result()[0]->total_attempted_quetions;

		$query = "SELECT `question_id` FROM `questions_answers` WHERE `test_id` = $test_id and `student_id` = $student_id ";
		$query_result = $this->db->query($query);
		$question_ids = $query_result->result();

		foreach ($question_ids as $index => $question_id) {
			$question_ids[$index] = $question_id->question_id;
			$check = true;
		}
		$question_ids = implode(",", $question_ids);


		$query = "SELECT 
	`tests`.`test_id`,	
  `tests`.`test_title`,
  `subjects`.`subject_title`,
  `classes`.`Class_title`,
  `questions`.`question_id`,
  `questions`.`question_type`,
  `questions`.`chapter_name`,
  `questions`.`question_title`,
  `questions`.`question_image`,
  `questions`.`option_one`,
  `questions`.`option_two`,
  `questions`.`option_three`,
  `questions`.`option_four`,
  `questions`.`qustion_correct_answer` 
FROM
  `tests`,
  `test_questions`,
  `subjects`,
  `classes`,
  `questions` 
WHERE `tests`.`test_id` = `test_questions`.`test_id` 
  AND `subjects`.`subject_id` = `tests`.`subject_id` 
  AND `classes`.`class_id` = `tests`.`class_id` 
  AND `questions`.`question_id` = `test_questions`.`question_id` 
  AND  `test_questions`.`test_id` ='" . $test_id . "'";

		if ($check) {
			$query .= " AND `test_questions`.`question_id` NOT IN (" . $question_ids . ")";
		}
		$query .= " ORDER BY  RAND() ";

		$query_result = $this->db->query($query);
		$test_question = $query_result->result();
		$this->data['test_question'] = $test_question;

		if (!$test_question) {
			//get test result
			$query = "SELECT
							COUNT(`question_id`) AS total_questions,
							SUM(`answer`) as got_marks
						FROM `questions_answers`
						WHERE `test_id` = $test_id
						AND `student_id` =$student_id;";
			$query_result = $this->db->query($query);
			$this->data['test_result'] = $query_result->result()[0];
		}

		//get test questions 
		$this->data["title"] = $tests_detail[0]->test_title . " ( " . $tests_detail[0]->test_type . " )";
		$this->data["view"] = PUBLIC_DIR . "student/question_view";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}


	public function qustion_answer()
	{




		$test_id = (int) $this->input->post('test_id');
		$question_id = (int) $this->input->post('question_id');
		$answer = $this->input->post('answer');

		//check user already attempt this question or not 

		$query = "SELECT * FROM `questions_answers` 
			  WHERE `test_id` = $test_id 
			  AND `question_id` = $question_id
			  AND student_id = " . $this->session->userdata('student_id');
		$query_result = $this->db->query($query);
		var_dump($query_result->result());
		if (!$query_result->result()) {
			$query = "SELECT `questions`.`qustion_correct_answer` FROM `questions` WHERE `question_id` = $question_id";
			$query_result = $this->db->query($query);
			$qustion_info = $query_result->result()[0];
			if (trim($qustion_info->qustion_correct_answer) == trim($answer)) {
				$_POST['answer'] = 1;
			} else {
				$_POST['answer'] = 0;
			}

			$_POST['student_id'] = $this->session->userdata('student_id');
			$this->question_answer_model->save_data();
		} else {
		}

		$main_page = base_url() . $this->router->fetch_class() . "/test/" . $test_id;
		redirect($main_page);
	}


	public function edit_student($student_id)
	{
		$student_id = (int) $student_id;
		$this->data["student"] = $this->student_model->get($student_id);

		$this->data["classes"] = $this->student_model->getList("CLASSES", "class_id", "Class_title", $where = "");

		$this->data["sections"] = $this->student_model->getList("SECTIONS", "section_id", "section_title", $where = "");

		$this->data["title"] = $this->lang->line('Edit Student');

		$this->data["view"] = PUBLIC_DIR . "student/edit_student";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}


	public function update_data($student_id)
	{

		$student_id = (int) $student_id;

		if ($this->student_model->validate_form_data() === TRUE) {

			if ($this->upload_file("student_image")) {
				$_POST["student_image"] = $this->data["upload_data"]["file_name"];
			}

			$student_id = $this->student_model->update_data($student_id);
			if ($student_id) {

				$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
				redirect("student/view_student/$student_id");
			} else {

				$this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
				redirect("student/view_student/$student_id");
			}
		} else {
			$this->edit($student_id);
		}
	}


	public function students_result($class_id, $section_id)
	{
		/*$class_and_section = $this->input->post('class_and_section');
		$temp_var = explode("_", $class_and_section);
		$class_id = $temp_var[0];
		$section_id = $temp_var[1];*/
		$class_id = (int) $class_id;
		$section_id = (int) $section_id;

		$query = "SELECT DISTINCT 
				  `students`.*,
				  `sections`.`section_title`,
				  `classes`.`Class_title`,
				  SUM(`questions_answers`.`answer`) AS total_points 
				FROM
				  `questions_answers`,
				  `students`,
				  `classes`,
				  `sections` 
				WHERE `questions_answers`.`student_id` = `students`.`student_id` 
				  AND `classes`.`class_id` = `students`.`class_id` 
				  AND `sections`.`section_id` = `students`.`section_id` 
				  AND `students`.`status` IN (1,2) 
				  AND  `students`.`class_id`='" . $class_id . "' 
				  AND  `students`.`section_id` ='" . $section_id . "'
				GROUP BY `students`.`student_id` 
				ORDER BY total_points DESC ";
		$query_result = $this->db->query($query);
		$students = $query_result->result();



		/*$where = "`students`.`status` IN (1) 
				   and `students`.`class_id`='".$class_id."' 
				   and `students`.`section_id` ='".$section_id."'";
		$students = $this->student_model->get_student_list($where,FALSE);*/

		foreach ($students as $student_index => $student) {

			//get test by class id
			$where = "`tests`.`status` IN (1) and `tests`.`class_id` = " . $student->class_id;
			$tests  = $this->test_model->get_test_list($where, FALSE);

			foreach ($tests as $index => $test) {
				$query = "SELECT
							COUNT(`question_id`) AS total_questions,
							SUM(`answer`) as got_marks
						FROM `questions_answers`
						WHERE `test_id` = " . $test->test_id . "
						AND `student_id` = " . $student->student_id . ";";
				$query_result = $this->db->query($query);
				$tests[$index]->result = $query_result->result()[0];

				$tests[$index]->total_question = 	$query_result->result()[0]->total_questions;

				//get the total questions 


				$query = "SELECT
							COUNT(`test_question_id`) AS total_test_questions
						FROM
						`test_questions`
						WHERE `test_id` = " . $test->test_id . ";";
				$query_result = $this->db->query($query);
				$tests[$index]->result->total_test_questions = $query_result->result()[0]->total_test_questions;

				$tests[$index]->total_question = 	$query_result->result()[0]->total_test_questions;
			}



			$students[$student_index]->tests = $tests;
		}
		$this->data["students"] = $students;

		$this->data["pagination"] = "";
		$this->data["title"] = "Students";

		$this->data["view"] = PUBLIC_DIR . "student/students_result";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}



	function update_student_section()
	{
		//var_dump($_REQUEST);
		$section_id = $this->input->post("section_id");
		$class_id = $this->input->post("class_id");
		$student_id = $this->input->post("student_id");
		$student_section_id = $this->input->post("student_section_id");

		//update student section

		$this->db->query("UPDATE `students` SET `section_id`='" . $student_section_id . "' WHERE `student_id`='" . $student_id . "'");

		$main_page = site_url(ADMIN_DIR . "admission/view_students/" . $class_id . "/" . $section_id);
		redirect($main_page);
	}

	function view_students($class_id, $section_id)
	{



		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id`='" . $class_id . "' AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `student_admission_no` ASC";
		//$where = "`students`.`status` IN (1,0,2) and `students`.`class_id`='" . $class_id . "' AND `students`.`section_id` ='" . $section_id . "'
		//ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();



		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";
		$this->data["title"] = "Students";
		//var_dump($sections);
		$this->data["view"] = ADMIN_DIR . "admission/view_student";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	function update_student_info($student_id)
	{

		$student_id = (int) $student_id;
		$student_class_no = $this->input->post('student_class_no');
		$student_name = $this->input->post('student_name');
		if ($student_name != "" and $student_class_no != "") {
			$query = "UPDATE `students` SET `student_class_no`='" . $student_class_no . "',`student_name`='" . $student_name . "' WHERE `student_id` =$student_id;";
			$result = $this->db->query($query);
			echo "Student info update successfuly";
		} else {


			echo "Student name or class number missing try again...";
		}
	}



	function update_student_record()
	{

		$student_id = (int) $this->input->post('student_id');;
		$field = $this->input->post('field');
		$value = $this->db->escape(ucwords($this->input->post('value')));

		$query = "UPDATE `students` SET `" . $field . "`=" . $value . "
			     WHERE `student_id` =$student_id;";
		if ($this->db->query($query)) {
			echo $this->input->post('value');
		} else {
			echo "Error";
		}
	}


	function update_student_admission_no($student_id)
	{

		$student_id = (int) $student_id;
		$student_admission_no = $this->input->post('student_admission_no');

		$query = "UPDATE `students` SET `student_admission_no`='" . $student_admission_no . "'
			     WHERE `student_id` =$student_id;";
		$result = $this->db->query($query);
		echo "Student info update successfuly";
	}

	function save_student_data()
	{
		$section_id = $this->input->post("section_id");
		$class_id = $this->input->post("class_id");
		$student_id = $this->student_model->save_data();
		$main_page = base_url() . $this->router->fetch_class() . "/edit_students/" . $class_id . "/" . $section_id;
		redirect($main_page);
	}
	public function dormant_student($class_id, $section_id, $student_id)
	{

		$student_id = (int) $student_id;


		$this->student_model->changeStatus($student_id, "0");
		$this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));

		$main_page = base_url() . $this->router->fetch_class() . "/edit_students/" . $class_id . "/" . $section_id;
		redirect($main_page);
	}
	public function active_student($class_id, $section_id, $student_id)
	{

		$student_id = (int) $student_id;


		$this->student_model->changeStatus($student_id, "1");
		$this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));

		$main_page = base_url() . $this->router->fetch_class() . "/edit_students/" . $class_id . "/" . $section_id;
		redirect($main_page);
	}

	public function delete_student_profile($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');

		$query = "UPDATE students SET status = '0' WHERE student_id = '" . $student_id . "'";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}

	public function restore_student_profile($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');


		$query = "UPDATE students SET status = '1' WHERE student_id = '" . $student_id . "'";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}
	public function change_class_form()
	{
		$student_id = (int) $this->input->post('student_id');

		$this->data["students"]  = $this->student_model->get_student($student_id);



		$this->load->view(ADMIN_DIR . "admission/change_class_form", $this->data);
	}

	public function change_student_class()
	{
		$student_id = (int) $this->input->post('student_id');
		$class_id = (int) $this->input->post('class_id');
		$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
		$student = $this->db->query($query)->result()[0];
		$query = "SELECT  `classes`.`Class_title` FROM `classes` WHERE  `classes`.`class_id` = '" . $student->class_id . "'";
		$classes_from  = $this->db->query($query)->result()[0]->Class_title;
		$query = "SELECT  `classes`.`Class_title` FROM `classes` WHERE  `classes`.`class_id` = '" . $class_id . "'";
		$classes_to  = $this->db->query($query)->result()[0]->Class_title;
		$from_class_to = "Class Change From " . $classes_from . " To Class " . $classes_to;

		$query = "UPDATE students SET class_id = '" . $class_id . "' WHERE student_id = '" . $student_id . "'";
		if ($this->db->query($query)) {

			$query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
				          VALUES ('" . $student->student_id . "',
						  '" . (int) $student->admission_no . "',
						  '" . $student->session_id . "',
						  '" . $student->class_id . "',
						  '" . $student->section_id . "',
						  'Change Class','" . $from_class_to . "', 
						  '" . $this->session->userdata('user_id') . "')";
			$this->db->query($query);
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}

	public function change_section_form()
	{
		$student_id = (int) $this->input->post('student_id');

		$this->data["students"]  = $this->student_model->get_student($student_id);



		$this->load->view(ADMIN_DIR . "admission/change_section_form", $this->data);
	}

	public function change_student_class_section()
	{
		$student_id = (int) $this->input->post('student_id');
		$class_id = (int) $this->input->post('class_id');
		$section_id = (int) $this->input->post('section_id');

		$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
		$student = $this->db->query($query)->result()[0];

		$query = "SELECT  `classes`.`Class_title` FROM `classes` WHERE  `classes`.`class_id` = '" . $student->class_id . "'";
		$classes_from  = $this->db->query($query)->result()[0]->Class_title;

		$query = "SELECT  section_title FROM `sections` WHERE  `section_id` = '" . $student->section_id . "'";
		$classe_section_from  = $this->db->query($query)->result()[0]->section_title;
		$query = "SELECT  section_title FROM `sections` WHERE  `section_id` = '" . $section_id . "'";
		$classe_section_to  = $this->db->query($query)->result()[0]->section_title;



		$from_class_to = "Class Change From " . $classes_from . " Section " . $classe_section_from . " To Section " . $classe_section_to;

		$query = "UPDATE students SET section_id = '" . $section_id . "' WHERE student_id = '" . $student_id . "'";
		if ($this->db->query($query)) {

			$query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
				          VALUES ('" . $student->student_id . "',
						  '" . (int) $student->admission_no . "',
						  '" . $student->session_id . "',
						  '" . $student->class_id . "',
						  '" . $student->section_id . "',
						  'Change Class Section','" . $from_class_to . "', 
						  '" . $this->session->userdata('user_id') . "')";
			$this->db->query($query);
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}

	public  function get_student_update_form()
	{
		$student_id = (int) $this->input->post('student_id');

		$this->data["students"]  = $this->student_model->get_student($student_id);



		$this->load->view(ADMIN_DIR . "admission/student_update_form", $this->data);
	}
	public  function get_student_add_form()
	{
		$class_id = (int) $this->input->post('class_id');
		$section_id = (int) $this->input->post('section_id');

		$query = "SELECT class_title FROM classes WHERE class_id = '" . $class_id . "'";
		$class_name = $this->db->query($query)->result()[0]->class_title;
		$query = "SELECT section_title FROM sections WHERE section_id = '" . $section_id . "'";
		$section_title = $this->db->query($query)->result()[0]->section_title;


		$this->data["class_id"]  = $class_id;
		$this->data["class_title"]  = $class_name;
		$this->data["section_id"]  = $section_id;
		$this->data["section_title"]  = $section_title;



		$this->load->view(ADMIN_DIR . "admission/student_add_form", $this->data);
	}

	public function add_new_student_in_class()
	{

		$input["class_id"] = $class_id = $this->input->post("class_id");
		$input["section_id"] = $section_id = $this->input->post("section_id");
		$query = "SELECT * FROM session WHERE status=1";
		$input["session_id"] = $this->db->query($query)->row()->session_id;
		$input["student_class_no"] = $this->input->post("student_class_no");
		$input["student_admission_no"] = $this->input->post("student_admission_no");
		$input["student_name"] = ucwords(strtolower($this->input->post("student_name")));
		$input["student_father_name"] = ucwords(strtolower($this->input->post("student_father_name")));
		$input["student_data_of_birth"] = $this->input->post("student_data_of_birth");
		$input["form_b"] = $this->input->post("form_b");
		$input["admission_date"] = $this->input->post("admission_date");
		$input["student_address"] = ucwords(strtolower($this->input->post("student_address")));
		$input["father_mobile_number"] = $this->input->post("father_mobile_number");
		$input["father_nic"] = $this->input->post("father_nic");
		$input["guardian_occupation"] = $this->input->post("guardian_occupation");
		$input["religion"] = ucwords(strtolower($this->input->post("religion")));
		$input["nationality"] = ucwords(strtolower($this->input->post("nationality")));
		$input["private_public_school"] = ucwords(strtolower($this->input->post("private_public_school")));
		$input["school_name"] = ucwords(strtolower($this->input->post("school_name")));
		$input["orphan"] = ucwords(strtolower($this->input->post("orphan")));
		$input["vaccinated"] = ucwords(strtolower($this->input->post("vaccinated")));
		$input["is_disable"] = ucwords(strtolower($this->input->post("is_disable")));
		$input["ehsaas"] = ucwords(strtolower($this->input->post("ehsaas")));
		$input["nic_issue_date"] = $this->input->post("nic_issue_date");

		$input["hafiz"] = $this->input->post("hafiz");
		$input["place_of_birth"] = $this->input->post("place_of_birth");
		$input["mother_mobile_no"] = $this->input->post("mother_mobile_no");
		$input["father_mobile_number"] = $this->input->post("father_mobile_number");
		$input["guardian_relation"] = $this->input->post("guardian_relation");
		$input["mother_tongue"] = $this->input->post("mother_tongue");
		$input["guardian_name"] = $this->input->post("guardian_name");

		if ($input["vaccinated"] == 'Yes') {
			$input["first_dose"] = $this->input->post("first_dose");
			$input["second_dose"] = $this->input->post("second_dose");
		}
		if ($this->db->insert('students', $input)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
		}
		redirect(ADMIN_DIR . "admission/students_list/$class_id/$section_id");
	}

	// public function view_subject_result($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
	// {
	// 	$this->data["class_id"] = $class_id = (int) $class_id;
	// 	$this->data["section_id"] = $section_id = (int) $section_id;
	// 	$this->data["exam_id"] = $exam_id = (int) $exam_id;
	// 	$this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
	// 	$this->data["subject_id"] = $subject_id = (int) $subject_id;


	// 	// $where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
	// 	// $exam = $this->exam_model->get_exam_list($where, false, false);
	// 	// $this->data["exam"] = $exam[0];

	// 	$query = "SELECT 
	// 			  `class_subjects`.`class_subject_id`,
	// 			  `subjects`.`subject_title`,
	// 			  `class_subjects`.`class_id` 
	// 			FROM
	// 			  `subjects`,
	// 			  `class_subjects` 
	// 			WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
	// 			AND `class_subjects`.`class_id` = '" . $class_id . "'";
	// 	$result = $this->db->query($query);
	// 	$this->data['class_subject'] = $result->result()[0]->subject_title;
	// 	var_dump($this->data['class_subject']);


	// 	$query = "SELECT
	// 				`students`.*
	// 				, `classes`.`Class_title`
	// 				, `sections`.`section_title`
	// 			FROM
	// 				`students`,
	// 			`classes`,
	// 			`sections`
	// 			WHERE 
	// 			`classes`.`class_id` = `students`.`class_id`
	// 			AND `sections`.`section_id` = `students`.`section_id`
	// 						AND `classes`.`class_id` = '" . $class_id . "'
	// 						and `sections`.`section_id` = '" . $section_id . "'";
	// 	$result = $this->db->query($query);
	// 	$this->data['students'] = $result->result();


	// 	/*$where = "`students`.`status` IN (1) and `students`.`class_id`='".$class_id."' 
	// 			   AND `students`.`section_id` ='".$section_id."' ORDER by `students`.`student_class_no` ASC ";
	// 	$this->data["students"] = $this->student_model->get_student_list($where,FALSE);*/

	// 	$this->data["title"] = "Subject Marks";
	// 	$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
	// 	$this->load->view(ADMIN_DIR . "exams/view_subject_result", $this->data);
	// }

	public function exam_class_subject_wise_result($exam_id, $class_id, $section_id, $order = NULL)
	{

		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "' Order By `classes`.`Class_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....



		$query = "SELECT
             `students`.`student_id`
                , `students`.`student_class_no`
                , `students`.`student_name`
                , `students`.`student_father_name`
				, `students`.`status`
				
                , `students`.`student_data_of_birth`
                , `students`.`student_admission_no`
                , `students_exams_subjects_marks`.`section_id`
                , `students_exams_subjects_marks`.`class_id`
                , `students_exams_subjects_marks`.`subject_id`
            FROM
            `students_exams_subjects_marks`
            , `students`
            WHERE `students_exams_subjects_marks`.`student_id` = `students`.`student_id`
            
            AND `students`.`class_id` =" . $class_id . "
	    	AND `students`.`section_id` =" . $section_id . "
			AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
	    	GROUP BY `students`.`student_id` 
            ORDER BY `student_class_no` ASC";



		$result = $this->db->query($query);
		$students = $result->result();

		$query = "SELECT * FROM exams WHERE exam_id ='" . $exam_id . "'";
		$exam = $this->db->query($query)->result();
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
			`subjects`.`subject_title`,
			`class_subject_teacher`.`section_id`,
			`class_subjects`.`subject_id`,
			`class_subjects`.`class_subject_id`,
			`subjects`.`subject_title`,
			`subjects`.`short_title`,
			`class_subjects`.`class_id`,
			`class_subjects`.`marks`,
			`class_subjects`.`passing_mark` 
			FROM
			`class_subjects` ,
			`class_subject_teacher`,
			`subjects`  
			WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
			AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id . ' 
				AND `subjects`.`subject_id` !=2
				GROUP BY `class_subjects`.`class_subject_id`
				Order By `subjects`.`subject_title` ASC';
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();


		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`, `percentage`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {

					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = $result->result()[0];
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = NULL;
				}
			}
		}


		$query = "SELECT COUNT(DISTINCT students_exams_subjects_marks.subject_id) as total 
		FROM students_exams_subjects_marks WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		";
		$subject_total = $this->db->query($query)->row()->total;
		$this->data['subject_total'] = $subject_total * 100;



		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "admission/exam_class_subject_wise_result", $this->data);
	}

	public function dmc($exam_id, $class_id, $section_id, $order = NULL)
	{

		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "' Order By `classes`.`Class_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....



		$query = "SELECT
             `students`.`student_id`
                , `students`.`student_class_no`
                , `students`.`student_name`
                , `students`.`student_father_name`
				, `students`.`status`
				, `students`.`form_b`
                , `students`.`student_data_of_birth`
                , `students`.`student_admission_no`
                , `students_exams_subjects_marks`.`section_id`
                , `students_exams_subjects_marks`.`class_id`
                , `students_exams_subjects_marks`.`subject_id`
            FROM
            `students_exams_subjects_marks`
            , `students`
            WHERE `students_exams_subjects_marks`.`student_id` = `students`.`student_id`
            
            AND `students`.`class_id` =" . $class_id . "
	    	AND `students`.`section_id` =" . $section_id . "
			AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
	    	GROUP BY `students`.`student_id` 
            ORDER BY `student_class_no` ASC";



		$result = $this->db->query($query);
		$students = $result->result();

		$query = "SELECT * FROM exams WHERE exam_id ='" . $exam_id . "'";
		$exam = $this->db->query($query)->result();
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
			`subjects`.`subject_title`,
			`class_subject_teacher`.`section_id`,
			`class_subjects`.`subject_id`,
			`class_subjects`.`class_subject_id`,
			`subjects`.`subject_title`,
			`subjects`.`short_title`,
			`class_subjects`.`class_id`,
			`class_subjects`.`marks`,
			`class_subjects`.`passing_mark` 
			FROM
			`class_subjects` ,
			`class_subject_teacher`,
			`subjects`  
			WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
			AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id . " 
				AND `subjects`.`subject_id` IN(
					SELECT students_exams_subjects_marks.subject_id 
		FROM students_exams_subjects_marks WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = " . $section_id . " GROUP BY students_exams_subjects_marks.subject_id
				)
				
				GROUP BY `class_subjects`.`class_subject_id`
				Order By `subjects`.`subject_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();


		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`, `percentage`, `total_marks`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {

					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = $result->result()[0];
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = NULL;
				}
			}
		}


		$query = "SELECT COUNT(DISTINCT students_exams_subjects_marks.subject_id) as total 
		FROM students_exams_subjects_marks WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		";

		$subject_total = $this->db->query($query)->row()->total;
		$this->data['subject_total'] = $subject_total * 100;



		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "admission/dmc", $this->data);
	}

	public function dmc2($exam_id, $class_id, $section_id, $order = NULL)
	{

		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "' Order By `classes`.`Class_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....



		$query = "SELECT
             `students`.`student_id`
                , `students`.`student_class_no`
                , `students`.`student_name`
                , `students`.`student_father_name`
				, `students`.`status`
				, `students`.`form_b`
                , `students`.`student_data_of_birth`
                , `students`.`student_admission_no`
                , `students_exams_subjects_marks`.`section_id`
                , `students_exams_subjects_marks`.`class_id`
                , `students_exams_subjects_marks`.`subject_id`
            FROM
            `students_exams_subjects_marks`
            , `students`
            WHERE `students_exams_subjects_marks`.`student_id` = `students`.`student_id`
            
            AND `students`.`class_id` =" . $class_id . "
	    	AND `students`.`section_id` =" . $section_id . "
			AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
	    	GROUP BY `students`.`student_id` 
            ORDER BY `student_class_no` ASC";



		$result = $this->db->query($query);
		$students = $result->result();

		$query = "SELECT * FROM exams WHERE exam_id ='" . $exam_id . "'";
		$exam = $this->db->query($query)->result();
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
			`subjects`.`subject_title`,
			`class_subject_teacher`.`section_id`,
			`class_subjects`.`subject_id`,
			`class_subjects`.`class_subject_id`,
			`subjects`.`subject_title`,
			`subjects`.`short_title`,
			`class_subjects`.`class_id`,
			`class_subjects`.`marks`,
			`class_subjects`.`passing_mark` 
			FROM
			`class_subjects` ,
			`class_subject_teacher`,
			`subjects`  
			WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
			AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id . " 
				AND `subjects`.`subject_id` IN(
					SELECT students_exams_subjects_marks.subject_id 
		FROM students_exams_subjects_marks WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = " . $section_id . " GROUP BY students_exams_subjects_marks.subject_id
				)
				
				GROUP BY `class_subjects`.`class_subject_id`
				Order By `subjects`.`subject_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();


		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`, `percentage`, `total_marks`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {

					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = $result->result()[0];
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = NULL;
				}
			}
		}


		$query = "SELECT COUNT(DISTINCT students_exams_subjects_marks.subject_id) as total 
		FROM students_exams_subjects_marks WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		";

		$subject_total = $this->db->query($query)->row()->total;
		$this->data['subject_total'] = $subject_total * 100;



		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "admission/dmc2", $this->data);
	}

	public function dmc3($exam_id, $class_id, $section_id, $order = NULL)
	{

		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "' Order By `classes`.`Class_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....



		$query = "SELECT
             `students`.`student_id`
                , `students`.`student_class_no`
                , `students`.`student_name`
                , `students`.`student_father_name`
				, `students`.`status`
				, `students`.`form_b`
                , `students`.`student_data_of_birth`
                , `students`.`student_admission_no`
                , `students_exams_subjects_marks`.`section_id`
                , `students_exams_subjects_marks`.`class_id`
                , `students_exams_subjects_marks`.`subject_id`
            FROM
            `students_exams_subjects_marks`
            , `students`
            WHERE `students_exams_subjects_marks`.`student_id` = `students`.`student_id`
            
            AND `students`.`class_id` =" . $class_id . "
	    	AND `students`.`section_id` =" . $section_id . "
			AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
	    	GROUP BY `students`.`student_id` 
            ORDER BY `student_class_no` ASC";



		$result = $this->db->query($query);
		$students = $result->result();

		$query = "SELECT * FROM exams WHERE exam_id ='" . $exam_id . "'";
		$exam = $this->db->query($query)->result();
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
			`subjects`.`subject_title`,
			`class_subject_teacher`.`section_id`,
			`class_subjects`.`subject_id`,
			`class_subjects`.`class_subject_id`,
			`subjects`.`subject_title`,
			`subjects`.`short_title`,
			`class_subjects`.`class_id`,
			`class_subjects`.`marks`,
			`class_subjects`.`passing_mark` 
			FROM
			`class_subjects` ,
			`class_subject_teacher`,
			`subjects`  
			WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
			AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id . " 
				AND `subjects`.`subject_id` IN(
					SELECT students_exams_subjects_marks.subject_id 
		FROM students_exams_subjects_marks WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = " . $section_id . " GROUP BY students_exams_subjects_marks.subject_id
				)
				
				GROUP BY `class_subjects`.`class_subject_id`
				Order By `subjects`.`subject_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();


		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`, `percentage`, `total_marks`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {

					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = $result->result()[0];
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = NULL;
				}
			}
		}


		$query = "SELECT COUNT(DISTINCT students_exams_subjects_marks.subject_id) as total 
		FROM students_exams_subjects_marks WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		";

		$subject_total = $this->db->query($query)->row()->total;
		$this->data['subject_total'] = $subject_total * 100;



		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "admission/dmc3", $this->data);
	}

	public function exam_class_section_wise_result($exam_id, $class_id)
	{

		$this->data["class_id"] = $class_id = (int) $class_id;

		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "' Order By `classes`.`Class_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	



		$query = "SELECT
             `students`.`student_id`
                , `students`.`student_class_no`
                , `students`.`student_name`
                , `students`.`student_father_name`
				, `students`.`status`
				
                , `students`.`student_data_of_birth`
                , `students`.`student_admission_no`
                , `students_exams_subjects_marks`.`section_id`
                , `students_exams_subjects_marks`.`class_id`
                , `students_exams_subjects_marks`.`subject_id`
				, `sections`.`section_title`
            FROM
            `students_exams_subjects_marks`
            , `students`
			, `sections`
            WHERE `students_exams_subjects_marks`.`student_id` = `students`.`student_id`
            AND sections.section_id = students.section_id
            AND `students`.`class_id` =" . $class_id . "
			
			AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
	    	GROUP BY `students`.`student_id` 
            ORDER BY `student_class_no` ASC";



		$result = $this->db->query($query);
		$students = $result->result();

		$query = "SELECT * FROM exams WHERE exam_id ='" . $exam_id . "'";
		$exam = $this->db->query($query)->result();
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
			`subjects`.`subject_title`,
			`class_subject_teacher`.`section_id`,
			`class_subjects`.`subject_id`,
			`class_subjects`.`class_subject_id`,
			`subjects`.`subject_title`,
			`subjects`.`short_title`,
			`class_subjects`.`class_id`,
			`class_subjects`.`marks`,
			`class_subjects`.`passing_mark` 
			FROM
			`class_subjects` ,
			`class_subject_teacher`,
			`subjects`  
			WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
			AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `subjects`.`subject_id` !=2
				GROUP BY `class_subjects`.`class_subject_id`
				Order By `subjects`.`subject_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();


		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`, `percentage`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = $result->result()[0];
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['marks'] = NULL;
				}
			}
		}

		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "admission/exam_class_section_wise_result", $this->data);
	}

	public function paper_submission_report($exam_id = 14)
	{
		$this->data['exam_id'] = $exam_id;

		$query = "SELECT `classes`.`Class_title`, `classes`.`class_id`
					FROM `classes` 
					WHERE  `classes`.`status`=1
					AND `classes`.`class_id`!=1
					ORDER BY `classes`.`status`=1";

		$result = $this->db->query($query);
		$classes = $result->result();

		foreach ($classes as $classe) {
			$query = "SELECT 
			`sections`.`section_id`,
						  `sections`.`section_title`, 
						  `sections`.`color` 
						FROM
						`sections` ,
						`class_sections`
						WHERE  
						`sections`.section_id = class_sections.section_id
						AND `class_sections`.`class_id` = " . $classe->class_id . " 
						AND `sections`.`status`=1
						Order By `sections`.`section_title` ASC";

			$result = $this->db->query($query);
			$sections = $result->result();
			$classe->sections = $sections;
		}

		$query = "SELECT 
		
				  `subjects`.`subject_title`,
				  `subjects`.`subject_id`
				   
				FROM `subjects`
				WHERE subjects.subject_id != 2
				   ORDER BY `subjects`.`subject_title` ASC ";
		$result = $this->db->query($query);
		$subjects = $result->result();
		$this->data['subjects'] = $subjects;

		$this->data['classes'] = $classes;
		//$this->data["exams"] = $this->exam_model->get_exam($exam_id);
		$this->data["title"] = $this->lang->line('Exam Details');
		//$this->data["view"] = ADMIN_DIR . "admission/paper_submission_report";
		$this->load->view(ADMIN_DIR . "admission/paper_submission_report", $this->data);
	}

	public function class_dmcs($exam_id, $class_id, $section_id, $order = NULL)
	{


		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "'";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....

		//check the exam id is in section history .....

		$query = "SELECT COUNT(*) as total FROM `student_section_history` WHERE `exam_id`='" . $exam_id . "'
		AND `student_section_history`.`class_id` = '" . $class_id . "'";
		$result = $this->db->query($query);
		$exam_count = $result->result()[0]->total;

		if ($order) {
		} else {
		}

		if ($exam_count == 0) {
			$query = "SELECT
					`student_id`
					, `student_name`
					, `student_class_no`
					, `class_id`
					, `section_id`
				FROM
					`students`
					WHERE `students`.`class_id` = $class_id
					AND `students`.`section_id` = $section_id 
					AND `students`.`status` =1
					ORDER BY `student_class_no` ASC  ";
		} else {
			$query = "SELECT 
					  `students`.`student_id`,
					  `students`.`student_name`,
					  `student_section_history`.`student_class_no` as `student_class_no` ,
					  `student_section_history`.`class_id` AS `class_id`,
					  `student_section_history`.`section_id`  AS `section_id`
					FROM
					  `students`,
					  `student_section_history` 
					WHERE `students`.`student_id` = `student_section_history`.`student_id` 
					AND `student_section_history`.`class_id` = $class_id
					AND `student_section_history`.`section_id` = $section_id
					AND `students`.`status` =1  ORDER BY `student_class_no` ASC  ";
		}
		$result = $this->db->query($query);
		$students = $result->result();


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
				`subjects`.`subject_title`,
				`class_subject_teacher`.`section_id`,
				`class_subjects`.`subject_id`,
				`class_subjects`.`class_subject_id`,
				`subjects`.`subject_title`,
				`subjects`.`short_title`,
				`class_subjects`.`class_id`,
				`class_subjects`.`marks`,
				`class_subjects`.`passing_mark` 
				FROM
				`class_subjects` ,
				`class_subject_teacher`,
				`subjects`  
				WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
				AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`exam_id` =" . $exam_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id;
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();



		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = $result->result()[0]->obtain_mark;
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = "-";
				}
			}
		}

		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "exams/class_dmcs", $this->data);
	}

	public function bank_challans()
	{
		$this->data["title"] = "Bank Challans";
		$this->data["view"] = ADMIN_DIR . "admission/bank_challans";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function add_bank_challan()
	{
		$input["class"] = $this->input->post("class");
		$input["section"] = $this->input->post("section");
		$input["session"] = $this->input->post("session");
		if ($this->input->post("student_id")) {
			$input["student_id"] = $this->input->post("student_id");
		}
		if ($this->input->post("admission_no")) {
			$input["admission_no"] = $this->input->post("admission_no");
		}


		$input["student_name"] = $this->input->post("student_name");
		$input["father_name"] =  $this->input->post("father_name");
		$input["created_by"] = $this->session->userdata('user_id');
		$heads = $this->input->post("heads");

		$total_amount = 0;
		foreach ($heads as $head_id => $head_amount) {
			$total_amount += $head_amount;
		}
		$input["total_amount"] = $total_amount;
		$this->db->insert('bank_challans', $input);
		$receipt_id = $this->db->insert_id();
		$input = array();
		$this->db->where('receipt_id', $receipt_id);
		$this->db->delete('bank_challan_amounts');
		foreach ($heads as $head_id => $head_amount) {
			$input["head_id"] = $head_id;
			$input["amount"] = $head_amount;
			$input["receipt_id"] = $receipt_id;
			$this->db->insert('bank_challan_amounts', $input);
		}
		$this->session->set_flashdata("msg_success", $this->lang->line("success"));
		redirect(ADMIN_DIR . "admission/bank_challans");
	}

	public function print_bank_challan($receipt_id)
	{
		$receipt_id = (int) $receipt_id;
		$query = "SELECT * FROM bank_challans WHERE receipt_id = $receipt_id";
		$this->data['bank_challan'] = $this->db->query($query)->row();
		$this->load->view(ADMIN_DIR . "admission/print_bank_challan", $this->data);
	}

	public function drive_image()
	{







		$query = "SELECT drive_img, student_id FROM students WHERE drive_img != '' and local_image IS NULL;";
		$students = $this->db->query($query)->result();

		foreach ($students as $student) {
			$driveLink = $student->drive_img;
			$studentId = $student->student_id;

			if ($driveLink && strpos($driveLink, 'drive.google.com') !== false) {
				echo "🔗 Trying to fetch image from: $driveLink<br>";

				$imageData = @file_get_contents($driveLink); // @ suppresses warnings, we’ll check manually

				if ($imageData === false) {
					echo "❌ Failed to download image data for Student ID $studentId from $driveLink<br>";
					$error = error_get_last();
					echo "⚠️ file_get_contents() error: " . ($error['message']) . "<br>";
					continue;
				}

				$fileName = 'student_' . $studentId . '.jpg';
				$folderPath = FCPATH . 'uploads/gcmhs/';
				$filePath = $folderPath . $fileName;

				// Make sure folder exists
				if (!is_dir($folderPath)) {
					echo "📁 Folder not found, creating: $folderPath<br>";
					if (!mkdir($folderPath, 0755, true)) {
						echo "❌ Failed to create folder: $folderPath<br>";
						continue;
					}
				}

				// Try saving the image
				if (file_put_contents($filePath, $imageData) === false) {
					echo "❌ Failed to write image to $filePath<br>";
				} else {
					// Optional: update DB
					$this->db->where('student_id', $studentId)
						->update('students', ['local_image' => $fileName]);

					echo "✅ Image saved and DB updated for Student ID $studentId<br>";
				}
			} else {
				echo "⚠️ Invalid or missing drive link for Student ID $studentId<br>";
			}
		}
	}


	private function extractDriveFileId($url)
	{
		preg_match("/\/d\/(.*?)\//", $url, $matches);
		if ($matches[1]) {
			return $matches[1];
		} else {
			return null;
		}
	}


	private function downloadFromGoogleDrive($fileId)
	{
		if (!$fileId) return false;

		$url = "https://drive.google.com/uc?export=download&id={$fileId}";

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$data = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return ($httpCode === 200) ? $data : false;
	}





	public function rename_student_images()
	{
		$this->load->helper('file');
		$class_id = 2;
		$section_id = 2;
		$path = FCPATH . "uploads/gcmhs/" . $class_id . "/" . $section_id . "/"; // Full system path
		$files = glob($path . "*");

		foreach ($files as $file) {
			$filename = basename($file); // e.g., "123 John Doe.jpg"

			// Extract number (roll number) from beginning of filename
			if (preg_match('/^(\d+)/', $filename, $matches)) {
				$roll_no = $matches[1];

				// Find the student by roll_no
				$student = $this->db->get_where('students', ['student_class_no' => $roll_no, 'class_id' => $class_id, 'section_id' => $section_id])->row();
				if ($student) {
					$ext = pathinfo($file, PATHINFO_EXTENSION);
					$new_file_name = $student->student_id . '.' . $ext;
					$new_file_path = $path . $new_file_name;

					if (rename($file, $new_file_path)) {
						$this->db->where('student_id', $student->student_id)->update('students', ['image' => $new_file_name]);
						echo "Renamed {$filename} ➜ {$new_file_name}<br>";
					} else {
						echo "Failed to rename {$filename}<br>";
					}
				} else {
					echo "No student found for roll no: {$roll_no}<br>";
				}
			} else {
				echo "Could not extract roll number from filename: {$filename}<br>";
			}
		}
	}
}
