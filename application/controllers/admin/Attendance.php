<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends CI_Controller
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
		$this->data['title'] = "Attendance";
		$this->data["view"] = ADMIN_DIR . "attendance/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
}
