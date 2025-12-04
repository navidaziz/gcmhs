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
		$this->data["view"] = ADMIN_DIR . "school_dashboard/dashboard";
		$this->load->view(ADMIN_DIR . "dashboard_layout", $this->data);
	}

	public function students_attendance_list()
	{
		$this->data["view"] = ADMIN_DIR . "school_dashboard/students_attendance_list";
		$this->load->view(ADMIN_DIR . "dashboard_layout", $this->data);
	}

	public function missing_attendance()
	{
		// $this->load->library('calendar');
		// echo $this->calendar->generate();
		echo "<table border='1' cellpadding='5' cellspacing='0'>";
		echo "<tr><th>Month</th>";
		for ($day = 1; $day <= 31; $day++) {

			echo "<td>" . $day . "</td>";
		}
		echo "</tr>";

		for ($month = 1; $month <= 1; $month++) {
			echo "<tr><td>" . date('F', mktime(0, 0, 0, $month, 10)) . "</td>";
			for ($day = 1; $day <= 31; $day++) {
				$query = $this->db->query("SELECT * FROM `student_attendances` 
				WHERE DAY(`attendance_date`) = $day AND MONTH(`attendance_date`) = $month 
				AND YEAR(`attendance_date`) = " . date('Y'));
				$attendance = $query->result();
				if (!empty($attendance)) {
					echo "<td style='background-color: red; color: white;'>" . count($attendance) . "</td>";
				} else {
					echo "<td> - </td>";
				}
				echo "</td>";
			}
		}
	}
}
