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

		// Load class & section list
		$query = "
        SELECT c.class_id, c.Class_title, s.section_id, s.section_title 
        FROM classes AS c 
        INNER JOIN class_sections AS cs ON cs.class_id = c.class_id
        INNER JOIN sections AS s ON s.section_id = cs.section_id
        WHERE s.status = 1 
        AND c.status = 1 
        AND c.class_id IN (2)
        GROUP BY c.class_id, s.section_id
    ";

		$classes = $this->db->query($query)->result();

		foreach ($classes as $class) {

			$class_id    = $class->class_id;
			$section_id  = $class->section_id;

			// Get class teacher
			$teacher = $this->db->query("
            SELECT teacher_name FROM classes_time_tables
            WHERE class_teacher = 1
            AND class_id = '$class_id'
            AND section_id = '$section_id'
        ")->row();

			$teacher_name = ($teacher) ? $teacher->teacher_name : "N/A";

			echo "<b>{$class->Class_title} - {$class->section_title} - {$teacher_name}</b><br>";

			// Load ALL attendance for full year (1 query)
			$att_rows = $this->db->query("
            SELECT DATE(date) AS att_date
            FROM students_attendance
            WHERE class_id = $class_id
            AND section_id = $section_id
            AND YEAR(date) = $year
        ")->result();

			// Build a quick lookup map
			$attendance_map = [];
			foreach ($att_rows as $a) {
				$attendance_map[$a->att_date] = true;
			}

			// Loop months April–December
			for ($month = 4; $month <= 12; $month++) {

				$missing_days = [];

				// Find missing dates
				for ($day = 1; $day <= 31; $day++) {

					if (!checkdate($month, $day, $year)) continue;

					$date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
					$timestamp = strtotime($date);

					// Skip Sundays
					if (date('w', $timestamp) == 0) continue;

					// If not in attendance map → missing
					if (!isset($attendance_map[$date])) {
						$missing_days[] = $day;
					}
				}

				// Print only if missing exists
				$month_name = date('F', mktime(0, 0, 0, $month, 1));

				if (!empty($missing_days)) {
					echo "<span>{$year}-{$month} ({$month_name}): ";
					echo implode(", ", $missing_days);
					echo "</span><br>";
				} else {
					//echo "<span>{$year}-{$month} ({$month_name}): <i>No Missing Days</i></span><br>";
				}
			}

			echo "<hr>";
		}
	}
}
