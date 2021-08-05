<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admission extends Public_Controller
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

		/*echo '<pre>'; print_r($this->session->all_userdata());
		 echo '</pre>';*/
		$query = $this->db->select('user_data, ip_address')->get('ci_sessions');
		$online_users = array(); /* array to store the user data we fetch */

		$uip[$this->session->userdata('student_id')] = $this->input->ip_address();
		foreach ($query->result() as $row) {
			$loginCheck = True;
			$udata = unserialize($row->user_data);
			@$uip[$udata['student_id']] = $row->ip_address;
			/* put data in array using username as key */
			//$online_users[$udata['student_id']] = $udata['student_name']; 
			@$online_users[] = $udata['student_id'];
		}
		$this->data['online_users'] = $online_users;
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */

	public function index()
	{

		/*var_dump($this->session->userdata('student_name'));
		exit();
		*/
		$query = "SELECT
						DISTINCT `classes`.`Class_title`, `classes`.`class_id`
					FROM
					`students`,
					`classes` 
					WHERE `students`.`class_id` = `classes`.`class_id`";

		$result = $this->db->query($query);
		$classes = $result->result();
		//var_dump($classes);

		foreach ($classes as $classe) {
			$query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`class_id` =" . $classe->class_id;

			$result = $this->db->query($query);
			$sections = $result->result();
			$classe->sections = $sections;
		}

		//var_dump($classes);
		$this->data['classes'] = $classes;
		$this->data["view"] = ADMIN_DIR . "admission/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function students_list($class_id, $section_id)
	{
		/*$class_and_section = $this->input->post('class_and_section');
		$temp_var = explode("_", $class_and_section);
		$class_id = $temp_var[0];
		$section_id = $temp_var[1];*/

		//var_dump($this->session->userdata);



		/*if($this->session->userdata('logged_in')){
		$main_page=base_url().$this->router->fetch_class()."/view_student/".$this->session->userdata('student_id');
  		redirect($main_page); 
		exit();
		}*/


		$class_id = (int) $class_id;
		$section_id = (int) $section_id;
		$where = "`students`.`status` IN (1) and `students`.`class_id`='" . $class_id . "' and `students`.`section_id` ='" . $section_id . "'
		ORDER BY `student_class_no` ASC";
		$this->data["students"] = $this->student_model->get_student_list($where, FALSE);

		$this->data["pagination"] = "";
		$this->data["title"] = "Students";

		$this->data["view"] = PUBLIC_DIR . "student/students";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
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
	public function view_student($student_id)
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
		$this->data["view"] = PUBLIC_DIR . "student/view_student";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
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
				  AND `students`.`status`='1' 
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
		var_dump($_REQUEST);
		$section_id = $this->input->post("section_id");
		$class_id = $this->input->post("class_id");
		$student_id = $this->input->post("student_id");
		$student_section_id = $this->input->post("student_section_id");

		//update student section

		$this->db->query("UPDATE `students` SET `section_id`='" . $student_section_id . "' WHERE `student_id`='" . $student_id . "'");

		$main_page = base_url() . $this->router->fetch_class() . "/edit_students/" . $class_id . "/" . $section_id;
		redirect($main_page);
	}

	function view_students($class_id, $section_id)
	{



		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,0) and `students`.`class_id`='" . $class_id . "' AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
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
}
