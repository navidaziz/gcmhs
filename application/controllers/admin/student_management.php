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
		// $student_id = $this->input->post("student_id");
		// foreach ($_POST as $key => $value) {
		// 	echo $key . " : " . $value . "<br>";
		// }

		// Validation rules
		$this->form_validation->set_rules('nationality', 'Nationality', 'required|alpha');
		$this->form_validation->set_rules('religion', 'Religion', 'required|alpha');
		$this->form_validation->set_rules('private_public_school', 'School Type', 'required|in_list[G,P]');
		$this->form_validation->set_rules('school_name', 'School Name', 'required|trim');
		$this->form_validation->set_rules('hafiz', 'Hafiz', 'required|in_list[Yes,No]');
		$this->form_validation->set_rules('orphan', 'Orphan', 'required|in_list[Yes,No]');
		$this->form_validation->set_rules('is_disable', 'Disability', 'required|in_list[Yes,No]');
		$this->form_validation->set_rules('works_after_school', 'Works After School', 'required|in_list[Yes,No]');
		$this->form_validation->set_rules('criminal_history', 'Criminal History', 'required|in_list[Yes,No]');
		$this->form_validation->set_rules('family_situation', 'Family Situation', 'required');
		$this->form_validation->set_rules('ehsaas', 'Ehsaas', 'required|in_list[Yes,No]');
		$this->form_validation->set_rules('guardian_occupation', 'Guardian Occupation', 'required|alpha_numeric_spaces');
		$this->form_validation->set_rules('guardian_contact_no', 'Contact No', 'required|regex_match[/^[0-9]{11}$/]');
		$this->form_validation->set_rules('mother_mobile_no', 'Mother Mobile No', 'regex_match[/^[0-9]{11}$/]');
		$this->form_validation->set_rules('father_mobile_number', 'Father Mobile No', 'regex_match[/^[0-9]{11}$/]');


		if ($this->form_validation->run() == FALSE) {
			// Validation failed
			// $response = array(
			// 	'status' => 'error',
			// 	//'errors' => $this->form_validation->error_array()
			// 	'errors' => validation_errors()
			// );
			echo validation_errors();
		} else {
			// Clean inputs
			$data = array(
				'nationality' => $this->input->post('nationality'),
				'religion' => $this->input->post('religion'),
				'private_public_school' => $this->input->post('private_public_school'),
				'school_name' => $this->input->post('school_name'),
				'hafiz' => $this->input->post('hafiz'),
				'orphan' => $this->input->post('orphan'),
				'is_disable' => $this->input->post('is_disable'),
				'works_after_school' => $this->input->post('works_after_school'),
				'criminal_history' => $this->input->post('criminal_history'),
				'family_situation' => $this->input->post('family_situation'),
				'ehsaas' => $this->input->post('ehsaas'),
				'guardian_occupation' => $this->input->post('guardian_occupation'),
				'guardian_contact_no' => preg_replace('/\D/', '', $this->input->post('guardian_contact_no')), // remove non-digits
				'mother_mobile_no' => preg_replace('/\D/', '', $this->input->post('mother_mobile_no')),
				'verified' => 1
			);

			$student_id = $this->input->post("student_id");
			$this->db->where('student_id', $student_id);
			$this->db->update('students', $data);

			// $response = array(
			// 	'status' => 'success',
			// 	'message' => 'Student updated successfully.'
			// );
			echo "success";
		}
	}

	public function get_change_class_no_form()
	{

		echo "we are here";
		exit();
		$student_id = $this->input->post("student_id");

		// Get student data
		$query = "SELECT * FROM students WHERE student_id = ?";
		$student = $this->db->query($query, [$student_id])->row();

		if (!$student) {
			return json_encode(['error' => 'Student not found']);
		} else {
			$this->data['student'] = $student;
			$this->load->view(ADMIN_DIR . "student_management/get_change_class_no_form", $this->data);
		}
	}
}
