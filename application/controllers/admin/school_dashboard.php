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

		$class_id = 5;
		$section_id = 1;
		echo "<table border='1' cellpadding='5' cellspacing='0'>";

		// Header row
		echo "<tr><th>Month</th>";
		for ($day = 1; $day <= 31; $day++) {
			echo "<th>$day</th>";
		}
		echo "</tr>";

		$year = date('Y');

		for ($month = 4; $month <= 12; $month++) {   // change to any range you want
			echo "<tr>";
			echo "<td>" . date('F', mktime(0, 0, 0, $month, 1)) . "</td>";

			for ($day = 1; $day <= 31; $day++) {

				// Query attendance for a particular day
				$query = $this->db->query("
                SELECT * FROM students_attendance
                WHERE DAY(`date`) = $day 
                AND MONTH(`date`) = $month
                AND YEAR(`date`) = $year
				AND class_id = $class_id
				AND section_id = $section_id
				");

				$count = $query->num_rows();

				if ($count > 0) {
					// Attendance exists → show count with red background
					echo "<td style='background-color:red; color:white;'>$count</td>";
				} else {
					// No attendance → show dash
					echo "<td>-</td>";
				}
			}

			echo "</tr>";  // close row for this month
		}

		echo "</table>";
	}
}
