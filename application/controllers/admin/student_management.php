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

		$query = $this->db->query("
        SELECT s.*, c.Class_title, sec.section_title 
        FROM students s
        JOIN classes c ON s.class_id = c.class_id
        JOIN sections sec ON s.section_id = sec.section_id
        WHERE s.class_id = ? AND s.section_id = ?
    	", array($class_id, $section_id));

		$class_section = $query->row();

		if ($class_section) {
			$this->data['title'] = $class_section->Class_title . " - " . $class_section->section_title . " Students List";
		} else {
			$this->data['title'] = "Students List";
		}

		$this->data["view"] = ADMIN_DIR . "student_management/class_section_students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
}
