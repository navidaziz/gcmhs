<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_management extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();

		$this->load->library('form_validation');
	}


	public function index()
	{
		$this->data['title'] = "Student Management";
		$this->data["view"] = ADMIN_DIR . "student_management/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}


	public function view_student_list($class_id, $section_id)
	{
		// Cast IDs to integers for security
		$class_id   = (int) $class_id;
		$section_id = (int) $section_id;

		$this->data['class_id']   = $class_id;
		$this->data['section_id'] = $section_id;
		$query = $this->db->query("SELECT * FROM classes WHERE class_id = ? ", array($class_id));
		$class = $query->row();
		$query = $this->db->query("SELECT * FROM sections WHERE section_id = ? ", array($section_id));
		$section = $query->row();
		$this->data['title'] = $class->Class_title . " - " . $section->section_title . " Students List";


		$this->data["view"] = ADMIN_DIR . "student_management/class_section_students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function get_student_information()
	{
		$student_id = $this->input->post("student_id");

		// Get student data
		$query = "SELECT * FROM students WHERE student_id = ?";
		$student = $this->db->query($query, [$student_id])->row();

		if (!$student) {
			return json_encode(['error' => 'Student not found']);
		} else {
			$this->data['student'] = $student;
			$this->load->view(ADMIN_DIR . "student_management/update_student_information", $this->data);
		}
	}

	public function update_student_attribure_record()
	{
		$student_id = $this->input->post("student_id");
		foreach ($_POST as $key => $value) {
			echo $key . " : " . $value . "<br>";
		}
	}
}
