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

		// Step 1: Get all active classes
		$query = "SELECT * FROM `classes` WHERE status = 1 ORDER BY class_id DESC";
		$result = $this->db->query($query);
		$classes = $result->result();

		// Step 2: Get all relevant sections for these classes (excluding section_id = 15)
		$class_ids = array_column($classes, 'class_id');
		$class_ids_in = implode(',', array_map('intval', $class_ids));

		$section_query = "
	SELECT 
		students.class_id,
		sections.section_id,
		sections.section_title,
		sections.color
	FROM students
	JOIN sections ON students.section_id = sections.section_id
	WHERE students.status = 1
	AND students.class_id IN ($class_ids_in)
	AND sections.section_id != 15
	GROUP BY students.class_id, sections.section_id
";

		$result = $this->db->query($section_query);
		$section_rows = $result->result();

		// Step 3: Group sections under their respective classes
		$sections_by_class = [];
		foreach ($section_rows as $row) {
			$sections_by_class[$row->class_id][] = $row;
		}

		// Step 4: Attach sections to their respective class
		foreach ($classes as $class) {
			$class->sections = $sections_by_class[$class->class_id] ?? [];
		}


		//var_dump($classes);
		$this->data['classes'] = $classes;
		$this->data["view"] = ADMIN_DIR . "school_dashboard/dashboard";
		$this->load->view(ADMIN_DIR . "dashboard_layout", $this->data);
	}
}
