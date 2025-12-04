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


	public function missing_attendance_list()
	{
		$year = date('Y');
		$today = date('Y-m-d');

		// Load classes and sections
		$sql = "
        SELECT c.class_id, c.Class_title, s.section_id, s.section_title
        FROM classes AS c
        INNER JOIN class_sections AS cs ON cs.class_id = c.class_id
        INNER JOIN sections AS s ON s.section_id = cs.section_id
        WHERE s.status = 1 AND c.status = 1 AND c.class_id IN (2,3,4,5)
        GROUP BY c.class_id, s.section_id
    ";

		$classes = $this->db->query($sql)->result_array(); // PHP 4 compatible, returns array

		for ($i = 0; $i < count($classes); $i++) {
			$class_id   = $classes[$i]['class_id'];
			$section_id = $classes[$i]['section_id'];
			$class_title = $classes[$i]['Class_title'];
			$section_title = $classes[$i]['section_title'];

			// Get teacher name
			$sql_teacher = "
            SELECT teacher_name 
            FROM classes_time_tables 
            WHERE class_teacher = 1 
            AND class_id = '$class_id'
            AND section_id = '$section_id'
        ";
			$teacher_row = $this->db->query($sql_teacher)->row_array();
			$teacher_name = ($teacher_row) ? $teacher_row['teacher_name'] : "N/A";

			echo "<b>$class_title - $section_title - $teacher_name</b><br>";

			// Load all attendance for the class/section/year
			$sql_att = "
            SELECT DATE(`date`) AS att_date
            FROM students_attendance
            WHERE class_id = $class_id
            AND section_id = $section_id
            AND YEAR(`date`) = $year
        ";
			$att_rows = $this->db->query($sql_att)->result_array();

			// Create a lookup array for fast search
			$attendance_map = array();
			for ($j = 0; $j < count($att_rows); $j++) {
				$attendance_map[$att_rows[$j]['att_date']] = true;
			}

			// Loop through months April to December, skip July
			for ($month = 4; $month <= 12; $month++) {
				if ($month == 7) continue; // Skip July

				$missing_days = array();

				// Loop through days
				for ($day = 1; $day <= 31; $day++) {
					if (!checkdate($month, $day, $year)) continue;

					$date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

					// Stop at today
					if ($date > $today) break;

					// Skip Sundays
					$w = date('w', mktime(0, 0, 0, $month, $day, $year));
					if ($w == 0) continue;

					// Check if attendance exists
					if (!isset($attendance_map[$date])) {
						$missing_days[] = $day;
					}
				}

				$month_name = date('F', mktime(0, 0, 0, $month, 1, $year));

				if (count($missing_days) > 0) {
					echo $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . " ($month_name): " . implode(', ', $missing_days) . "<br>";
				} else {
					echo $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . " ($month_name): No Missing Days<br>";
				}
			}

			echo "<hr>";
		}
	}
}
