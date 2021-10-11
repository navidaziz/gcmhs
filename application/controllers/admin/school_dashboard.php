<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class School_dashboard extends Admin_Controller
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
						AND `students`.`class_id` ='" . $classe->class_id . "'
				        AND  `sections` . `section_id` != '15'";

			$result = $this->db->query($query);
			$sections = $result->result();
			$classe->sections = $sections;
		}

		//var_dump($classes);
		$this->data['classes'] = $classes;
		$this->data["view"] = ADMIN_DIR . "school_dashboard/dashboard";
		$this->load->view(ADMIN_DIR . "dashboard_layout", $this->data);
	}
}
