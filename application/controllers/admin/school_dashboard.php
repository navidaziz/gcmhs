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

		$query = "SELECT c.class_id, c.Class_title, s.section_id, s.section_title FROM `classes` as c INNER JOIN class_sections as cs ON cs.class_id = c.class_id INNER JOIN `sections` as s ON s.section_id = cs.section_id WHERE s.status=1 AND c.status=1 AND c.class_id IN(2,3,4,5,6) GROUP BY c.class_id , s.section_id;";
		$classes = $this->db->query($query)->result();
		foreach ($classes as $class) {

			$class_id = $class->class_id;
			$section_id = $class->section_id;
			echo "<h4>" . $class->Class_title . " - " . $class->section_title . "";
			$query = "SELECT `teacher_name` FROM `classes_time_tables` 
                                      WHERE class_teacher=1 and class_id='" . $class->class_id . "' 
                                      AND section_id='" . $class->section_id . "';";
			$class_teacher = $this->db->query($query)->row();
			if ($class_teacher) {
				echo $class_teacher->teacher_name;
			}
			echo "</h4>";
			echo "<hr />";
			echo "<table border='1' cellpadding='5' cellspacing='0'>";

			// Header row
			echo "<tr><th>Month</th>";
			for ($day = 1; $day <= 31; $day++) {
				echo "<th>$day</th>";
			}
			echo "</tr>";

			$year = date('Y');

			for ($month = 4; $month <= 12; $month++) {

				echo "<tr>";
				echo "<td>" . date('F', mktime(0, 0, 0, $month, 1)) . "</td>";

				for ($day = 1; $day <= 31; $day++) {

					// Skip invalid days (e.g., Feb 30, April 31)
					if (!checkdate($month, $day, $year)) {
						echo "<td style='background-color:#eee;'>X</td>";
						continue;
					}

					$timestamp = strtotime("$year-$month-$day");

					// Check if Sunday
					if (date('w', $timestamp) == 0) {
						echo "<td style='background-color:#d9d9d9; color:red;'></td>";
						continue;
					}

					// Query attendance
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
						echo "<td style='background-color:green; color:white;'></td>";
					} else {
						echo "<td style='background-color:red; color:white;'><a href=''>Add</a></td>";
					}
				}

				echo "</tr>";
			}

			echo "</table>";
		}
	}
}
