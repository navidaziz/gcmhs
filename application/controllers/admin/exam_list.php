<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exam_list extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();

		$this->load->model("admin/exam_model");
		$this->load->model("admin/student_model");
		$this->lang->load("students", 'english');
		$this->lang->load("exams", 'english');
		$this->lang->load("system", 'english');
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{
		$main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view";
		redirect($main_page);
	}
	//---------------------------------------------------------------



	public function award_list($exam_id, $class_id)
	{
		$this->data["class_id"] = $class_id = (int) $class_id;
		//$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "select * from classes where class_id = " . $class_id;
		$result = $this->db->query($query);
		$class = $result->result();

		$this->data['class'] = $class;
		//$query="select * from sections WHERE section_id<=4";
		$query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title`, 
						  `sections`.`color` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`status` = 1
						AND `students`.`class_id` =" . $class_id . " Order By `sections`.`section_title` ASC";
		$result = $this->db->query($query);
		$class_sections = $result->result();

		//var_dump($class_sections);

		foreach ($class_sections as $class_section) {
			$query = "SELECT * FROM students where status=1 and class_id = $class_id and section_id = $class_section->section_id ORDER BY student_class_no ASC";
			$result = $this->db->query($query);
			$class_section->students = $result->result();
		}


		$this->data['class_sections'] = $class_sections;
		//$this->data["view"] = ADMIN_DIR."exams/view_class_result";
		$this->load->view(ADMIN_DIR . "exams/award_list", $this->data);
	}

	/**
	 * get a list of all items that are not trashed
	 */
	public function view()
	{

		$where = "`exams`.`status` IN (0, 1) ORDER BY `exams`.`order`";
		$data = $this->exam_model->get_exam_list($where);
		$this->data["exams"] = $data->exams;
		$this->data["pagination"] = $data->pagination;
		$this->data["title"] = $this->lang->line('Exams');
		$this->data["view"] = ADMIN_DIR . "exams/exams_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	//-----------------------------------------------------

	/**
	 * get single record by id
	 */

	function top_ten($exam_id)
	{
		$exam_id = (int) $exam_id;
		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		//get top ten students 
		$query = "SELECT * FROM student_results WHERE exam_id=$exam_id ORDER BY percentage DESC LIMIT 10";
		$result = $this->db->query($query);
		$top_ten_students = $result->result();


		$this->data['top_ten_students'] = $top_ten_students;


		$this->load->view(ADMIN_DIR . "exams/top_ten", $this->data);
	}




	function toppers($exam_id)
	{
		$exam_id = (int) $exam_id;
		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
					  DISTINCT  `classes`.`Class_title`,
					  `classes`.`class_id`
					FROM
					  `students_exams_subjects_marks`,
					  `classes` 
					WHERE `students_exams_subjects_marks`.`class_id` = `classes`.`class_id`
					AND `classes`.`class_id` IN (1,2,3,4,5,6) Order By `classes`.`class_id` ASC ";

		$result = $this->db->query($query);
		$classes = $result->result();

		foreach ($classes as $classe) {
			//SELECT * FROM student_results WHERE class_id=2 LIMIT 3

			$query = "SELECT * FROM student_results WHERE class_id=" . $classe->class_id . " AND exam_id=$exam_id  ORDER BY `percentage` DESC LIMIT 3";
			$result = $this->db->query($query);
			$top_three_students = $result->result();
			$classe->top_three = $top_three_students;

			$query = "SELECT 
						DISTINCT section_title, 
						section_id
						FROM student_results 
					WHERE class_id=" . $classe->class_id . "  
					ORDER BY section_title ASC";
			$result = $this->db->query($query);
			$class_sections = $result->result();
			foreach ($class_sections as $class_section) {

				$query = "SELECT * FROM student_results 
						WHERE 
						class_id=" . $classe->class_id . "  
						AND section_id=" . $class_section->section_id . "
						AND exam_id=$exam_id
						ORDER BY `percentage` DESC LIMIT 3";
				$result = $this->db->query($query);
				$top_three_students = $result->result();
				$classe->sections[$class_section->section_title] =  $top_three_students;
			}
		}

		//var_dump($classes);
		$this->data['classes'] = $classes;
		$this->load->view(ADMIN_DIR . "exams/topers", $this->data);
	}



	public function section_dashboard($exam_id, $class_id, $section_id)
	{


		$exam_id = (int) $exam_id;
		$class_id = (int) $class_id;
		$section_id = (int) $section_id;


		/*	$query="SELECT * FROM `exams` WHERE `exams`.`exam_id` = $exam_id";
		$query_result = $this->db->query($query);
		$exam_information =  $query_result ->result()[0];*/

		$query = "SELECT * FROM `classes` WHERE `classes`.`class_id` = $class_id";
		$query_result = $this->db->query($query);
		$class_information =  $query_result->result()[0];

		$query = "SELECT * FROM `sections` WHERE `sections`.`section_id` = $section_id";
		$query_result = $this->db->query($query);
		$section_information =  $query_result->result()[0];

		$this->data["title"] = $section_information->section_title . " Class " . $class_information->Class_title;

		//get top ten students 
		$query = "SELECT * FROM student_results 
				WHERE `exam_id` = $exam_id
				AND `class_id` = $class_id
				AND `section_id` = $section_id 
				ORDER BY percentage DESC LIMIT 10";
		$result = $this->db->query($query);
		$top_ten_students = $result->result();
		$this->data['top_ten_students'] = $top_ten_students;




		$query = "Select Class_title, class_id from classes WHERE  `class_id` = $class_id ";
		$result = $this->db->query($query);
		$classes = $all_classes =  $result->result();

		$class_techer_subject = array();
		foreach ($all_classes as $all_class) {
			$query = "SELECT 
					  class_teacher,
					  subject_title,
					  class_id 
					FROM
					  `teachers_subjects_marks`
					  WHERE `class_id` =" . $all_class->class_id . "
					  AND `section_id` =" . $section_id . "
					  GROUP BY subject_title, class_teacher  
					ORDER BY class_id,subject_title,class_teacher ASC ";



			$result = $this->db->query($query);
			$class_teachers = $result->result();

			foreach ($class_teachers as $class_teacher) {


				//var_dump($class_teacher);
				$query = "SELECT 
						  pass_fail_status,
						  COUNT(pass_fail_status) AS total 
						FROM `teachers_subjects_marks`
						WHERE class_teacher = '" . $class_teacher->class_teacher . "' 
						  AND subject_title = '" . $class_teacher->subject_title . "' 
						  AND `class_id` ='" . $class_teacher->class_id . "' 
						  AND `section_id` ='" . $section_id . "' 
						  AND `exam_id` = $exam_id 
						GROUP BY pass_fail_status,class_teacher ";
				$result = $this->db->query($query);
				$subject_pass_fail = $result->result();


				if ($subject_pass_fail) {
					//var_dump($class_pass_fail);
					if (isset($subject_pass_fail[1]->total)) {
						$class_teacher->pass =  $subject_pass_fail[1]->total;
					} else {
						$class_teacher->pass = 0;
					}

					if (isset($subject_pass_fail[0]->total)) {
						$class_teacher->fail =  $subject_pass_fail[0]->total;
					} else {
						$class_teacher->fail = 0;
					}
				} else {
					$class_teacher->pass =  0;
					$class_teacher->fail =  0;
				}
			}

			$all_class->class_teachers = $class_teachers;
		}

		$this->data['class_teacher_subject_pass_fails'] = $all_classes;

		foreach ($classes as $index => $classe) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total FROM student_results 
			WHERE class_id ='" . $classe->class_id . "'
			AND `section_id` ='" . $section_id . "'
			AND `exam_id` = $exam_id GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
			$result = $this->db->query($query);
			$class_pass_fail = $result->result();

			if ($class_pass_fail) {
				//var_dump($class_pass_fail);
				$classe->pass =  $class_pass_fail[1]->total;
				$classe->fail =  $class_pass_fail[0]->total;
			} else {
				$classe->pass =  0;
				$classe->fail =  0;
			}
		}
		$this->data['classe_wise_pass_fails'] = $classes;


		$query = "SELECT DISTINCT section_title, section_id, Class_title, class_id FROM student_results 
		WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id 
		AND `section_id` ='" . $section_id . "'
		ORDER BY class_id ASC";
		$result = $this->db->query($query);
		$classe_sections = $result->result();

		foreach ($classe_sections as $index => $classe_section) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total FROM student_results 
			WHERE class_id ='" . $classe_section->class_id . "' 
			AND section_id ='" . $classe_section->section_id . "' 
			AND `exam_id` = $exam_id
			GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
			$result = $this->db->query($query);
			$class_pass_fail = $result->result();

			if ($class_pass_fail) {
				//var_dump($class_pass_fail);
				if (isset($class_pass_fail[1]->total)) {
					$classe_section->pass =  $class_pass_fail[1]->total;
				} else {
					$classe_section->pass = 0;
				}

				if (isset($class_pass_fail[0]->total)) {
					$classe_section->fail =  $class_pass_fail[0]->total;
				} else {
					$classe_section->fail = 0;
				}
			} else {
				$classe_section->pass =  0;
				$classe_section->fail =  0;
			}
		}

		$this->data['classe_section_pass_fails'] = $classe_sections;


		$query = "SELECT subject_title, subject_id FROM subject_marks WHERE  `class_id` = $class_id AND `section_id` ='" . $section_id . "'  GROUP BY subject_title";
		$result = $this->db->query($query);
		$subjects = $result->result();
		foreach ($subjects as $subject) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) AS total 
					  FROM subject_marks 
					  WHERE
					  subject_id = '" . $subject->subject_id . "' 
					  AND `exam_id` = $exam_id 
					  AND `class_id` = $class_id 
					  AND `section_id` ='" . $section_id . "'
					  GROUP BY pass_fail_status ORDER BY pass_fail_status";
			$result = $this->db->query($query);
			$subject_pass_fail = $result->result();

			if ($subject_pass_fail) {
				//var_dump($class_pass_fail);
				if (isset($subject_pass_fail[1]->total)) {
					$subject->pass =  $subject_pass_fail[1]->total;
				} else {
					$subject->pass = 0;
				}

				if (isset($subject_pass_fail[0]->total)) {
					$subject->fail =  $subject_pass_fail[0]->total;
				} else {
					$subject->fail = 0;
				}
			} else {
				$subject->pass =  0;
				$subject->fail =  0;
			}
		}


		$this->data['subject_pass_fails'] = $subjects;

		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id  
		AND `section_id` ='" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();
		$this->data['pass_fail_counts'] = $pass_fail_counts;
		//var_dump($pass_fail_counts);
		$query = "SELECT Grade, COUNT(Grade) as total FROM student_results
		WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id 
		AND `section_id` ='" . $section_id . "'
		 GROUP BY Grade ORDER BY Grade ASC";
		$results = $this->db->query($query);
		$grades_counts = $results->result();
		$this->data['grades_counts'] = $grades_counts;
		//var_dump($grades_counts);
		//var_dump($grades_counts);
		$query = "SELECT Division, COUNT(Division) as total FROM student_results 
		WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id 
		AND `section_id` ='" . $section_id . "'
		GROUP BY Division ORDER BY Division ASC";
		$results = $this->db->query($query);
		$division_counts = $results->result();

		$this->data['division_counts'] = $division_counts;
		//var_dump($division_counts);
		//exit();
		$percentage_count = array(
			"0-10" => 0,
			"11-20" => 0,
			"21-30" => 0,
			"31-40" => 0,
			"41-50" => 0,
			"51-60" => 0,
			"61-70" => 0,
			"71-80" => 0,
			"81-90" => 0,
			"91-100" => 0
		);

		$query = "SELECT percentage FROM student_results WHERE `exam_id` = $exam_id AND `class_id` = $class_id AND `section_id` ='" . $section_id . "' ";
		$results = $this->db->query($query);
		$result_percentages = $results->result();
		foreach ($result_percentages as $result_percentage) {
			if ($result_percentage->percentage >= 0 and $result_percentage->percentage <= 10) {
				$percentage_count["0-10"] += 1;
			}
			if ($result_percentage->percentage >= 11 and $result_percentage->percentage <= 20) {
				$percentage_count["11-20"] += 1;
			}
			if ($result_percentage->percentage >= 21 and $result_percentage->percentage <= 30) {
				$percentage_count["21-30"] += 1;
			}
			if ($result_percentage->percentage >= 30 and $result_percentage->percentage <= 40) {
				$percentage_count["31-40"] += 1;
			}
			if ($result_percentage->percentage >= 41 and $result_percentage->percentage <= 50) {
				$percentage_count["41-50"] += 1;
			}
			if ($result_percentage->percentage >= 51 and $result_percentage->percentage <= 60) {
				$percentage_count["51-60"] += 1;
			}
			if ($result_percentage->percentage >= 61 and $result_percentage->percentage <= 70) {
				$percentage_count["61-70"] += 1;
			}
			if ($result_percentage->percentage >= 71 and $result_percentage->percentage <= 80) {
				$percentage_count["71-80"] += 1;
			}
			if ($result_percentage->percentage >= 81 and $result_percentage->percentage <= 90) {
				$percentage_count["81-90"] += 1;
			}
			if ($result_percentage->percentage >= 91 and $result_percentage->percentage <= 100) {
				$percentage_count["91-100"] += 1;
			}
		}

		$this->data['percentage_counts'] = $percentage_count;
		$this->data["exams"] = $this->exam_model->get_exam($exam_id);

		$this->data["view"] = ADMIN_DIR . "exams/dashboard";
		$this->load->view(ADMIN_DIR . "exams/dashboard", $this->data);
	}




	public function class_dashboard($exam_id, $class_id)
	{


		$exam_id = (int) $exam_id;
		$class_id = (int) $class_id;


		/*	$query="SELECT * FROM `exams` WHERE `exams`.`exam_id` = $exam_id";
		$query_result = $this->db->query($query);
		$exam_information =  $query_result ->result()[0];*/

		$query = "SELECT * FROM `classes` WHERE `classes`.`class_id` = $class_id";
		$query_result = $this->db->query($query);
		$class_information =  $query_result->result()[0];

		$this->data["title"] = "Class " . $class_information->Class_title;

		//get top ten students 
		$query = "SELECT * FROM student_results 
				WHERE `exam_id` = $exam_id
				AND `class_id` = $class_id 
				ORDER BY percentage DESC LIMIT 10";
		$result = $this->db->query($query);
		$top_ten_students = $result->result();
		$this->data['top_ten_students'] = $top_ten_students;




		$query = "Select Class_title, class_id from classes WHERE  `class_id` = $class_id ";
		$result = $this->db->query($query);
		$classes = $all_classes =  $result->result();

		$class_techer_subject = array();
		foreach ($all_classes as $all_class) {
			$query = "SELECT 
					  class_teacher,
					  subject_title,
					  class_id 
					FROM
					  `teachers_subjects_marks`
					  WHERE `class_id` =" . $all_class->class_id . "
					  GROUP BY subject_title, class_teacher  
					ORDER BY class_id,subject_title,class_teacher ASC ";



			$result = $this->db->query($query);
			$class_teachers = $result->result();

			foreach ($class_teachers as $class_teacher) {


				//var_dump($class_teacher);
				$query = "SELECT 
						  pass_fail_status,
						  COUNT(pass_fail_status) AS total 
						FROM `teachers_subjects_marks`
						WHERE class_teacher = '" . $class_teacher->class_teacher . "' 
						  AND subject_title = '" . $class_teacher->subject_title . "' 
						  AND `class_id` ='" . $class_teacher->class_id . "' 
						  AND `exam_id` = $exam_id 
						GROUP BY pass_fail_status,class_teacher ";
				$result = $this->db->query($query);
				$subject_pass_fail = $result->result();


				if ($subject_pass_fail) {
					//var_dump($class_pass_fail);
					if (isset($subject_pass_fail[1]->total)) {
						$class_teacher->pass =  $subject_pass_fail[1]->total;
					} else {
						$class_teacher->pass = 0;
					}

					if (isset($subject_pass_fail[0]->total)) {
						$class_teacher->fail =  $subject_pass_fail[0]->total;
					} else {
						$class_teacher->fail = 0;
					}
				} else {
					$class_teacher->pass =  0;
					$class_teacher->fail =  0;
				}
			}

			$all_class->class_teachers = $class_teachers;
		}

		$this->data['class_teacher_subject_pass_fails'] = $all_classes;

		foreach ($classes as $index => $classe) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total FROM student_results 
			WHERE class_id ='" . $classe->class_id . "'
			AND `exam_id` = $exam_id GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
			$result = $this->db->query($query);
			$class_pass_fail = $result->result();

			if ($class_pass_fail) {
				//var_dump($class_pass_fail);
				$classe->pass =  $class_pass_fail[1]->total;
				$classe->fail =  $class_pass_fail[0]->total;
			} else {
				$classe->pass =  0;
				$classe->fail =  0;
			}
		}
		$this->data['classe_wise_pass_fails'] = $classes;


		$query = "SELECT DISTINCT section_title, section_id, Class_title, class_id FROM student_results 
		WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id 
		ORDER BY class_id ASC";
		$result = $this->db->query($query);
		$classe_sections = $result->result();

		foreach ($classe_sections as $index => $classe_section) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total FROM student_results 
			WHERE class_id ='" . $classe_section->class_id . "' 
			AND section_id ='" . $classe_section->section_id . "' 
			AND `exam_id` = $exam_id
			GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
			$result = $this->db->query($query);
			$class_pass_fail = $result->result();

			if ($class_pass_fail) {
				//var_dump($class_pass_fail);
				if (isset($class_pass_fail[1]->total)) {
					$classe_section->pass =  $class_pass_fail[1]->total;
				} else {
					$classe_section->pass = 0;
				}

				if (isset($class_pass_fail[0]->total)) {
					$classe_section->fail =  $class_pass_fail[0]->total;
				} else {
					$classe_section->fail = 0;
				}
			} else {
				$classe_section->pass =  0;
				$classe_section->fail =  0;
			}
		}

		$this->data['classe_section_pass_fails'] = $classe_sections;


		$query = "SELECT subject_title, subject_id FROM subject_marks WHERE  `class_id` = $class_id  GROUP BY subject_title";
		$result = $this->db->query($query);
		$subjects = $result->result();
		foreach ($subjects as $subject) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) AS total 
					  FROM subject_marks 
					  WHERE
					  subject_id = '" . $subject->subject_id . "' 
					  AND `exam_id` = $exam_id 
					  AND `class_id` = $class_id 
					  GROUP BY pass_fail_status ORDER BY pass_fail_status";
			$result = $this->db->query($query);
			$subject_pass_fail = $result->result();

			if ($subject_pass_fail) {
				//var_dump($class_pass_fail);
				if (isset($subject_pass_fail[1]->total)) {
					$subject->pass =  $subject_pass_fail[1]->total;
				} else {
					$subject->pass = 0;
				}

				if (isset($subject_pass_fail[0]->total)) {
					$subject->fail =  $subject_pass_fail[0]->total;
				} else {
					$subject->fail = 0;
				}
			} else {
				$subject->pass =  0;
				$subject->fail =  0;
			}
		}


		$this->data['subject_pass_fails'] = $subjects;

		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id  
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();
		$this->data['pass_fail_counts'] = $pass_fail_counts;
		//var_dump($pass_fail_counts);
		$query = "SELECT Grade, COUNT(Grade) as total FROM student_results
		WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id 
		 GROUP BY Grade ORDER BY Grade ASC";
		$results = $this->db->query($query);
		$grades_counts = $results->result();
		$this->data['grades_counts'] = $grades_counts;
		//var_dump($grades_counts);
		//var_dump($grades_counts);
		$query = "SELECT Division, COUNT(Division) as total FROM student_results 
		WHERE `exam_id` = $exam_id
		AND `class_id` = $class_id 
		GROUP BY Division ORDER BY Division ASC";
		$results = $this->db->query($query);
		$division_counts = $results->result();

		$this->data['division_counts'] = $division_counts;
		//var_dump($division_counts);
		//exit();
		$percentage_count = array(
			"0-10" => 0,
			"11-20" => 0,
			"21-30" => 0,
			"31-40" => 0,
			"41-50" => 0,
			"51-60" => 0,
			"61-70" => 0,
			"71-80" => 0,
			"81-90" => 0,
			"91-100" => 0
		);

		$query = "SELECT percentage FROM student_results WHERE `exam_id` = $exam_id AND `class_id` = $class_id ";
		$results = $this->db->query($query);
		$result_percentages = $results->result();
		foreach ($result_percentages as $result_percentage) {
			if ($result_percentage->percentage >= 0 and $result_percentage->percentage <= 10) {
				$percentage_count["0-10"] += 1;
			}
			if ($result_percentage->percentage >= 11 and $result_percentage->percentage <= 20) {
				$percentage_count["11-20"] += 1;
			}
			if ($result_percentage->percentage >= 21 and $result_percentage->percentage <= 30) {
				$percentage_count["21-30"] += 1;
			}
			if ($result_percentage->percentage >= 30 and $result_percentage->percentage <= 40) {
				$percentage_count["31-40"] += 1;
			}
			if ($result_percentage->percentage >= 41 and $result_percentage->percentage <= 50) {
				$percentage_count["41-50"] += 1;
			}
			if ($result_percentage->percentage >= 51 and $result_percentage->percentage <= 60) {
				$percentage_count["51-60"] += 1;
			}
			if ($result_percentage->percentage >= 61 and $result_percentage->percentage <= 70) {
				$percentage_count["61-70"] += 1;
			}
			if ($result_percentage->percentage >= 71 and $result_percentage->percentage <= 80) {
				$percentage_count["71-80"] += 1;
			}
			if ($result_percentage->percentage >= 81 and $result_percentage->percentage <= 90) {
				$percentage_count["81-90"] += 1;
			}
			if ($result_percentage->percentage >= 91 and $result_percentage->percentage <= 100) {
				$percentage_count["91-100"] += 1;
			}
		}

		$this->data['percentage_counts'] = $percentage_count;
		$this->data["exams"] = $this->exam_model->get_exam($exam_id);

		$this->data["view"] = ADMIN_DIR . "exams/dashboard";
		$this->load->view(ADMIN_DIR . "exams/dashboard", $this->data);
	}




	function trends()
	{

		//get all exam 
		$query = "SELECT `term`, `year`, `exam_id` FROM `exams` WHERE `status`=1";
		$results = $this->db->query($query);
		$exams = $results->result();
		foreach ($exams as $exam) {

			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam->exam_id 
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
			$results = $this->db->query($query);
			$pass_fail_counts = $results->result();
			$exam->fail = $pass_fail_counts[0]->total;
			$exam->pass = $pass_fail_counts[1]->total;
		}
		$this->data["exams"] = $exams;


		$query = "SELECT
                ROUND(`percentage`) AS `percentage`,
                COUNT(ROUND(`percentage`)) AS total
                FROM
                  student_results 
                GROUP BY ROUND(`percentage`)";
		$results = $this->db->query($query);
		$percentage_densities = $results->result();
		$this->data["percentage_densities"] = $percentage_densities;

		//$this->data["exams"] = $this->exam_model->get_exam($exam_id);
		$this->data["title"] = "Trends Analysis";
		$this->data["view"] = ADMIN_DIR . "exams/trands";
		$this->load->view(ADMIN_DIR . "exams/trends", $this->data);
	}


	function dashboard($exam_id = 1)
	{
		$exam_id = (int) $exam_id;




		//get top ten students 
		$query = "SELECT * FROM student_results WHERE `exam_id` = $exam_id ORDER BY percentage DESC LIMIT 10";
		$result = $this->db->query($query);
		$top_ten_students = $result->result();
		$this->data['top_ten_students'] = $top_ten_students;




		$query = "Select Class_title, class_id from classes";
		$result = $this->db->query($query);
		$classes = $all_classes =  $result->result();

		$class_techer_subject = array();
		foreach ($all_classes as $all_class) {
			$query = "SELECT 
					  class_teacher,
					  subject_title,
					  class_id 
					FROM
					  `teachers_subjects_marks`
					  WHERE `class_id` =" . $all_class->class_id . "
					  GROUP BY subject_title, class_teacher  
					ORDER BY class_id,subject_title,class_teacher ASC ";



			$result = $this->db->query($query);
			$class_teachers = $result->result();

			foreach ($class_teachers as $class_teacher) {


				//var_dump($class_teacher);
				$query = "SELECT 
						  pass_fail_status,
						  COUNT(pass_fail_status) AS total 
						FROM `teachers_subjects_marks`
						WHERE class_teacher = '" . $class_teacher->class_teacher . "' 
						  AND subject_title = '" . $class_teacher->subject_title . "' 
						  AND `class_id` ='" . $class_teacher->class_id . "' 
						  AND `exam_id` = $exam_id 
						GROUP BY pass_fail_status,class_teacher ";
				$result = $this->db->query($query);
				$subject_pass_fail = $result->result();


				if ($subject_pass_fail) {
					//var_dump($class_pass_fail);
					if (isset($subject_pass_fail[1]->total)) {
						$class_teacher->pass =  $subject_pass_fail[1]->total;
					} else {
						$class_teacher->pass = 0;
					}

					if (isset($subject_pass_fail[0]->total)) {
						$class_teacher->fail =  $subject_pass_fail[0]->total;
					} else {
						$class_teacher->fail = 0;
					}
				} else {
					$class_teacher->pass =  0;
					$class_teacher->fail =  0;
				}
			}

			$all_class->class_teachers = $class_teachers;
		}

		$this->data['class_teacher_subject_pass_fails'] = $all_classes;

		foreach ($classes as $index => $classe) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total FROM student_results 
			WHERE class_id ='" . $classe->class_id . "'
			AND `exam_id` = $exam_id GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
			$result = $this->db->query($query);
			$class_pass_fail = $result->result();

			if ($class_pass_fail) {
				//var_dump($class_pass_fail);
				$classe->pass =  $class_pass_fail[1]->total;
				$classe->fail =  $class_pass_fail[0]->total;
			} else {
				$classe->pass =  0;
				$classe->fail =  0;
			}
		}
		$this->data['classe_wise_pass_fails'] = $classes;


		$query = "SELECT DISTINCT section_title, section_id, Class_title, class_id FROM student_results 
		WHERE `exam_id` = $exam_id
		ORDER BY class_id ASC";
		$result = $this->db->query($query);
		$classe_sections = $result->result();

		foreach ($classe_sections as $index => $classe_section) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total FROM student_results 
			WHERE class_id ='" . $classe_section->class_id . "' 
			AND section_id ='" . $classe_section->section_id . "' 
			AND `exam_id` = $exam_id
			GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
			$result = $this->db->query($query);
			$class_pass_fail = $result->result();

			if ($class_pass_fail) {
				//var_dump($class_pass_fail);
				if (isset($class_pass_fail[1]->total)) {
					$classe_section->pass =  $class_pass_fail[1]->total;
				} else {
					$classe_section->pass = 0;
				}

				if (isset($class_pass_fail[0]->total)) {
					$classe_section->fail =  $class_pass_fail[0]->total;
				} else {
					$classe_section->fail = 0;
				}
			} else {
				$classe_section->pass =  0;
				$classe_section->fail =  0;
			}
		}

		$this->data['classe_section_pass_fails'] = $classe_sections;


		$query = "SELECT subject_title, subject_id FROM subject_marks GROUP BY subject_title";
		$result = $this->db->query($query);
		$subjects = $result->result();
		foreach ($subjects as $subject) {
			$query = "SELECT pass_fail_status, COUNT(pass_fail_status) AS total 
					  FROM subject_marks 
					  WHERE
					  subject_id = '" . $subject->subject_id . "' 
					  AND `exam_id` = $exam_id 
					  GROUP BY pass_fail_status ORDER BY pass_fail_status";
			$result = $this->db->query($query);
			$subject_pass_fail = $result->result();

			if ($subject_pass_fail) {
				//var_dump($class_pass_fail);
				if (isset($subject_pass_fail[1]->total)) {
					$subject->pass =  $subject_pass_fail[1]->total;
				} else {
					$subject->pass = 0;
				}

				if (isset($subject_pass_fail[0]->total)) {
					$subject->fail =  $subject_pass_fail[0]->total;
				} else {
					$subject->fail = 0;
				}
			} else {
				$subject->pass =  0;
				$subject->fail =  0;
			}
		}


		$this->data['subject_pass_fails'] = $subjects;

		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();
		$this->data['pass_fail_counts'] = $pass_fail_counts;
		//var_dump($pass_fail_counts);
		$query = "SELECT Grade, COUNT(Grade) as total FROM student_results
		WHERE `exam_id` = $exam_id
		 GROUP BY Grade ORDER BY Grade ASC";
		$results = $this->db->query($query);
		$grades_counts = $results->result();
		$this->data['grades_counts'] = $grades_counts;
		//var_dump($grades_counts);
		//var_dump($grades_counts);
		$query = "SELECT Division, COUNT(Division) as total FROM student_results 
		WHERE `exam_id` = $exam_id
		GROUP BY Division ORDER BY Division ASC";
		$results = $this->db->query($query);
		$division_counts = $results->result();

		$this->data['division_counts'] = $division_counts;
		//var_dump($division_counts);
		//exit();
		$percentage_count = array(
			"0-10" => 0,
			"11-20" => 0,
			"21-30" => 0,
			"31-40" => 0,
			"41-50" => 0,
			"51-60" => 0,
			"61-70" => 0,
			"71-80" => 0,
			"81-90" => 0,
			"91-100" => 0
		);

		$query = "SELECT percentage FROM student_results WHERE `exam_id` = $exam_id";
		$results = $this->db->query($query);
		$result_percentages = $results->result();
		foreach ($result_percentages as $result_percentage) {
			if ($result_percentage->percentage >= 0 and $result_percentage->percentage <= 10) {
				$percentage_count["0-10"] += 1;
			}
			if ($result_percentage->percentage >= 11 and $result_percentage->percentage <= 20) {
				$percentage_count["11-20"] += 1;
			}
			if ($result_percentage->percentage >= 21 and $result_percentage->percentage <= 30) {
				$percentage_count["21-30"] += 1;
			}
			if ($result_percentage->percentage >= 30 and $result_percentage->percentage <= 40) {
				$percentage_count["31-40"] += 1;
			}
			if ($result_percentage->percentage >= 41 and $result_percentage->percentage <= 50) {
				$percentage_count["41-50"] += 1;
			}
			if ($result_percentage->percentage >= 51 and $result_percentage->percentage <= 60) {
				$percentage_count["51-60"] += 1;
			}
			if ($result_percentage->percentage >= 61 and $result_percentage->percentage <= 70) {
				$percentage_count["61-70"] += 1;
			}
			if ($result_percentage->percentage >= 71 and $result_percentage->percentage <= 80) {
				$percentage_count["71-80"] += 1;
			}
			if ($result_percentage->percentage >= 81 and $result_percentage->percentage <= 90) {
				$percentage_count["81-90"] += 1;
			}
			if ($result_percentage->percentage >= 91 and $result_percentage->percentage <= 100) {
				$percentage_count["91-100"] += 1;
			}
		}

		$this->data['percentage_counts'] = $percentage_count;
		$this->data["exams"] = $this->exam_model->get_exam($exam_id);
		$this->data["title"] = "Dashboard";
		$this->data["view"] = ADMIN_DIR . "exams/dashboard";
		$this->load->view(ADMIN_DIR . "exams/dashboard", $this->data);
	}



	function paper_collection_report($exam_id)
	{





		$exam_id = (int) $exam_id;

		$this->data['exam_id'] = $exam_id;
		$query = "SELECT
						DISTINCT `classes`.`Class_title`, `classes`.`class_id`
					FROM
					`students`,
					`classes` 
					WHERE `students`.`class_id` = `classes`.`class_id`";

		$result = $this->db->query($query);
		$classes = $result->result();
		//var_dump($classes);

		foreach ($classes as $classe) {
			$query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`class_id` =" . $classe->class_id;

			$result = $this->db->query($query);
			$sections = $result->result();
			$classe->sections = $sections;


			$query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `subjects`.`subject_id`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $classe->class_id . " ORDER BY `subjects`.`subject_title` ASC ";
			$result = $this->db->query($query);
			$subjects = $result->result();
			$classe->subjects = $subjects;

			//var_dump($subjects);
			//var_dump($subjects);
			/*foreach($sections as $section)
			$query="SELECT 
					  COUNT(`student_exam_subject_mark_id`) AS total,
					  ,
					  ,
					  `subject_id`,
					  `exam_id` 
					FROM `students_exams_subjects_marks`
					WHERE `class_id` = '".$classe->class_id."'
					AND `section_id` = '".$section->section_id."';
					";
		}*/
		}

		//var_dump($classes);
		$this->data['classes'] = $classes;
		$this->data["exams"] = $this->exam_model->get_exam($exam_id);
		$this->data["title"] = $this->lang->line('Exam Details');
		$this->data["view"] = ADMIN_DIR . "exams/paper_collection_report";
		$this->load->view(ADMIN_DIR . "exams/paper_collection_report", $this->data);
	}


	public function class_subjects_update($exam_id = 1)
	{
		$this->data['exam_id'] = $exam_id = (int) $exam_id;



		$query = "SELECT
						DISTINCT `classes`.`Class_title`, `classes`.`class_id`
					FROM
					`students`,
					`classes` 
					WHERE `students`.`class_id` = `classes`.`class_id`";

		$result = $this->db->query($query);
		$classes = $result->result();
		//var_dump($classes);



		foreach ($classes as $classe) {


			$query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`class_id` =" . $classe->class_id;

			$result = $this->db->query($query);
			$sections = $result->result();
			$classe->sections = $sections;


			$query = "SELECT 
				  `class_subjects`.*,
				  `subjects`.`subject_title`,
				  `subjects`.`subject_id`
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $classe->class_id . " ORDER BY `subjects`.`subject_title` ASC ";



			$result = $this->db->query($query);
			$subjects = $result->result();
			$classe->subjects = $subjects;
		}

		//var_dump($classes);
		$this->data['classes'] = $classes;
		$this->data["title"] = $this->lang->line('Update Class Subjects Data');
		$this->data["view"] = ADMIN_DIR . "exams/class_subjects_update";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}


	public function class_subjects_view($exam_id)
	{


		$exam_id = (int) $exam_id;
		$this->data['exam_id'] = $exam_id;


		$query = "SELECT
						DISTINCT `classes`.`Class_title`, `classes`.`class_id`
					FROM
					`students`,
					`classes` 
					WHERE `students`.`class_id` = `classes`.`class_id` AND `classes`.`status`=1";

		$result = $this->db->query($query);
		$classes = $result->result();

		foreach ($classes as $classe) {
			$query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title`, 
						  `sections`.`color` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`class_id` =" . $classe->class_id . " 
						AND `sections`.`status`=1
						AND `students`.`status` =1
						Order By `sections`.`section_title` ASC";

			$result = $this->db->query($query);
			$sections = $result->result();
			$classe->sections = $sections;


			$query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `subjects`.`subject_id`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $classe->class_id . " ORDER BY `subjects`.`subject_title` ASC ";
			$result = $this->db->query($query);
			$subjects = $result->result();
			$classe->subjects = $subjects;

			//var_dump($subjects);
			//var_dump($subjects);
			/*foreach($sections as $section)
			$query="SELECT 
					  COUNT(`student_exam_subject_mark_id`) AS total,
					  ,
					  ,
					  `subject_id`,
					  `exam_id` 
					FROM `students_exams_subjects_marks`
					WHERE `class_id` = '".$classe->class_id."'
					AND `section_id` = '".$section->section_id."';
					";
		}*/
		}


		$this->data['classes'] = $classes;
		$this->data["exams"] = $this->exam_model->get_exam($exam_id);
		$this->data["title"] = $this->lang->line('Exam Details');
		$this->data["view"] = ADMIN_DIR . "exams/class_subject_view";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}




	public function promote_students($exam_id, $class_id, $section_id = NULL)
	{

		$this->data["class_id"] = $class_id = (int) $class_id;
		//$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];



		$query = "SELECT * FROM student_results WHERE `exam_id` = '" . $exam_id . "' and  class_id='" . $class_id . "' ORDER BY percentage DESC";
		$result = $this->db->query($query);
		$this->data['students'] = $result->result();


		/*$where = "`students`.`status` IN (1) and `students`.`class_id`='".$class_id."' 
				   AND `students`.`section_id` ='".$section_id."' ORDER by `students`.`student_class_no` ASC ";
		$this->data["students"] = $this->student_model->get_student_list($where,FALSE);*/

		$this->load->view(ADMIN_DIR . "exams/promote_students", $this->data);
	}








	public function view_class_result($exam_id, $class_id, $section_id = NULL)
	{
		$this->data["class_id"] = $class_id = (int) $class_id;
		//$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];



		$query = "SELECT * FROM student_results WHERE `exam_id` = '" . $exam_id . "' and  class_id='" . $class_id . "' ORDER BY percentage DESC";
		$result = $this->db->query($query);
		$this->data['students'] = $result->result();


		/*$where = "`students`.`status` IN (1) and `students`.`class_id`='".$class_id."' 
				   AND `students`.`section_id` ='".$section_id."' ORDER by `students`.`student_class_no` ASC ";
		$this->data["students"] = $this->student_model->get_student_list($where,FALSE);*/

		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_class_result";
		$this->load->view(ADMIN_DIR . "exams/view_class_result", $this->data);
	}

	public function secction_wise_result($exam_id, $class_id, $section_id)
	{
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "select * from classes where class_id = " . $class_id;
		$result = $this->db->query($query);
		$class = $result->result();

		$this->data['class'] = $class;
		$query = "SELECT DISTINCT 
						 `sections`.`section_id`,
						  `sections`.`section_title`, 
						  `sections`.`color` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`class_id` =" . $class[0]->class_id;
		$result = $this->db->query($query);
		$class_sections = $result->result();

		foreach ($class_sections as $class_section) {
			$query = "SELECT * FROM students where class_id = $class_id and section_id = $class_section->section_id ORDER BY student_class_no ASC";
			$result = $this->db->query($query);
			$class_section->students = $result->result();

			$query = "SELECT * FROM student_results WHERE `exam_id` = '" . $exam_id . "' and  class_id='" . $class_id . "' and section_id ='" . $class_section->section_id . "' ORDER BY percentage DESC";
			$result = $this->db->query($query);
			$class_section->students = $result->result();
		}





		$this->data['class_sections'] = $class_sections;

		/*$where = "`students`.`status` IN (1) and `students`.`class_id`='".$class_id."' 
				   AND `students`.`section_id` ='".$section_id."' ORDER by `students`.`student_class_no` ASC ";
		$this->data["students"] = $this->student_model->get_student_list($where,FALSE);*/

		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_class_result";
		$this->load->view(ADMIN_DIR . "exams/view_class_section_result", $this->data);
	}





	public function view_subject_result($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
	{
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;
		$this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
		$this->data["subject_id"] = $subject_id = (int) $subject_id;


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subjects`.`subject_id` =" . $subject_id;
		$result = $this->db->query($query);
		$this->data['class_subject'] = $result->result()[0]->subject_title;


		$query = "SELECT
					`students`.*
					, `students_exams_subjects_marks`.`student_exam_subject_mark_id`
					, `students_exams_subjects_marks`.`exam_id`
					, `students_exams_subjects_marks`.`class_subjec_id`
					, `students_exams_subjects_marks`.`obtain_mark`
					, `classes`.`Class_title`
					, `sections`.`section_title`
				FROM
					`students`,
				`students_exams_subjects_marks`,
				`classes`,
				`sections`
				WHERE 
				`students`.`student_id` = `students_exams_subjects_marks`.`student_id`
				AND  `classes`.`class_id` = `students`.`class_id`
				AND `sections`.`section_id` = `students`.`section_id`
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['students'] = $result->result();


		/*$where = "`students`.`status` IN (1) and `students`.`class_id`='".$class_id."' 
				   AND `students`.`section_id` ='".$section_id."' ORDER by `students`.`student_class_no` ASC ";
		$this->data["students"] = $this->student_model->get_student_list($where,FALSE);*/

		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "exams/view_subject_result", $this->data);
	}



	public function attendance_sheet($exam_id, $class_id, $section_id, $order = NULL)
	{
		/*$query = "SELECT * FROM `students_exams_subjects_marks`";
		$result = $this->db->query($query);
		$students = $result->result();
		//var_dump($students);
		foreach($students as $student){
			$query="SELECT `student_class_no`
					, `class_id`
				FROM
					`students`
					WHERE `students`.`student_id` = ".$student->student_id;
			$result = $this->db->query($query);
			$student_info = $result->result()[0];
			
			//update record 
			$query="UPDATE 
			       `student_section_history` SET`student_class_no`='".$student_info->student_class_no."',
				   `class_id`='".$student_info->class_id."' WHERE `student_id`= ".$student->student_id;
			$this->db->query($query);
			//var_dump($student_info);	
			}
		
		exit();*/
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "'";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....

		//check the exam id is in section history .....

		$query = "SELECT COUNT(*) as total FROM `student_section_history` WHERE `exam_id`='" . $exam_id . "'
		AND `student_section_history`.`class_id` = '" . $class_id . "'";
		$result = $this->db->query($query);
		$exam_count = $result->result()[0]->total;

		if ($order) {
		} else {
		}

		if ($exam_count == 0) {
			$query = "SELECT
					`student_id`
					, `student_name`
					, `student_class_no`
					, `class_id`
					, `section_id`
				FROM
					`students`
					WHERE `students`.`class_id` = $class_id
					AND `students`.`section_id` = $section_id ORDER BY `student_class_no` ASC  ";
		} else {
			$query = "SELECT 
					  `students`.`student_id`,
					  `students`.`student_name`,
					  `student_section_history`.`student_class_no` as `student_class_no` ,
					  `student_section_history`.`class_id` AS `class_id`,
					  `student_section_history`.`section_id`  AS `section_id`
					FROM
					  `students`,
					  `student_section_history` 
					WHERE `students`.`student_id` = `student_section_history`.`student_id` 
					AND `student_section_history`.`class_id` = $class_id
					AND `student_section_history`.`section_id` = $section_id ORDER BY `student_class_no` ASC  ";
		}
		$result = $this->db->query($query);
		$students = $result->result();


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
  `subjects`.`subject_title`,
  `class_subject_teacher`.`section_id`,
  `class_subjects`.`subject_id`,
  `class_subjects`.`class_subject_id`,
  `subjects`.`subject_title`,
  `subjects`.`short_title`,
  `class_subjects`.`class_id`,
  `class_subjects`.`marks`,
  `class_subjects`.`passing_mark` 
FROM
`class_subjects` ,
`class_subject_teacher`,
`subjects`  
WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`exam_id` =" . $exam_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id;
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();



		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = $result->result()[0]->obtain_mark;
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = " ";
				}
			}
		}
		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "exams/attendancesheet", $this->data);
	}




	public function view_subjects_result($exam_id, $class_id, $section_id, $order = NULL)
	{


		/*$query = "SELECT * FROM `students_exams_subjects_marks`";
		$result = $this->db->query($query);
		$students = $result->result();
		//var_dump($students);
		foreach($students as $student){
			$query="SELECT `student_class_no`
					, `class_id`
				FROM
					`students`
					WHERE `students`.`student_id` = ".$student->student_id;
			$result = $this->db->query($query);
			$student_info = $result->result()[0];
			
			//update record 
			$query="UPDATE 
			       `student_section_history` SET`student_class_no`='".$student_info->student_class_no."',
				   `class_id`='".$student_info->class_id."' WHERE `student_id`= ".$student->student_id;
			$this->db->query($query);
			//var_dump($student_info);	
			}
		
		exit();*/
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "' Order By `classes`.`Class_title` ASC";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....

		//check the exam id is in section history .....

		$query = "SELECT COUNT(*) as total FROM `student_section_history` WHERE `exam_id`='" . $exam_id . "'
		AND `student_section_history`.`class_id` = '" . $class_id . "'";
		$result = $this->db->query($query);
		$exam_count = $result->result()[0]->total;



		if ($order) {
		} else {
		}

		/*	if($exam_count==0){
		$query="SELECT
					`student_id`
					, `student_name`
					, `student_class_no`
					, `class_id`
					, `section_id`
					, `student_admission_no`
				FROM
					`students`
					WHERE `students`.`class_id` = $class_id
					AND `students`.`section_id` = $section_id 
					AND `students`.`status` =1
					ORDER BY `student_class_no` ASC  ";
		}else{
			echo $query="SELECT 
					  `students`.`student_id`,
					  `students`.`student_name`,
					  `student_section_history`.`student_class_no` as `student_class_no` ,
					  `student_section_history`.`class_id` AS `class_id`,
					  `student_section_history`.`section_id`  AS `section_id`
					FROM
					  `students`,
					  `student_section_history` 
					WHERE `students`.`student_id` = `student_section_history`.`student_id` 
					AND `student_section_history`.`class_id` = $class_id
					AND `student_section_history`.`section_id` = $section_id
					AND `students`.`status` =1  ORDER BY `student_class_no` ASC  ";
					
				
			
			}*/

		$query = "SELECT
             `students`.`student_id`
                , `students`.`student_class_no`
                , `students`.`student_name`
                , `students`.`student_father_name`
                , `students`.`student_data_of_birth`
                , `students`.`student_admission_no`
                , `students_exams_subjects_marks`.`section_id`
                , `students_exams_subjects_marks`.`class_id`
                , `students_exams_subjects_marks`.`subject_id`
            FROM
            `students_exams_subjects_marks`
            , `students`
            WHERE `students_exams_subjects_marks`.`student_id` = `students`.`student_id`
            
            AND `students_exams_subjects_marks`.`class_id` =" . $class_id . "
		    AND `students_exams_subjects_marks`.`exam_id` =" . $exam_id . "
	    	AND `students_exams_subjects_marks`.`section_id` =" . $section_id . "
	    	GROUP BY `students`.`student_id` 
            ORDER BY `student_class_no` ASC";



		$result = $this->db->query($query);
		$students = $result->result();


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
  `subjects`.`subject_title`,
  `class_subject_teacher`.`section_id`,
  `class_subjects`.`subject_id`,
  `class_subjects`.`class_subject_id`,
  `subjects`.`subject_title`,
  `subjects`.`short_title`,
  `class_subjects`.`class_id`,
  `class_subjects`.`marks`,
  `class_subjects`.`passing_mark` 
FROM
`class_subjects` ,
`class_subject_teacher`,
`subjects`  
WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`exam_id` =" . $exam_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id . ' Order By `subjects`.`subject_title` ASC';
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();


		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = $result->result()[0]->obtain_mark;
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = "-";
				}
			}
		}

		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "exams/view_subjects_results", $this->data);
	}


	public function update_students_subject_result($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
	{
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;
		$this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
		$this->data["subject_id"] = $subject_id = (int) $subject_id;


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subjects`.`subject_id` =" . $subject_id;
		$result = $this->db->query($query);
		$this->data['class_subject'] = $result->result()[0]->subject_title;


		$query = "SELECT
    `students`.*
	, `students_exams_subjects_marks`.`student_exam_subject_mark_id`
    , `students_exams_subjects_marks`.`exam_id`
    , `students_exams_subjects_marks`.`class_subjec_id`
	, `students_exams_subjects_marks`.`obtain_mark`
    , `classes`.`Class_title`
    , `sections`.`section_title`
FROM
    `students`,
   `students_exams_subjects_marks`,
   `classes`,
   `sections`
   WHERE 
   `students`.`student_id` = `students_exams_subjects_marks`.`student_id`
  AND  `classes`.`class_id` = `students`.`class_id`
   AND `sections`.`section_id` = `students`.`section_id`
			AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
			AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject_id . "'
			AND  `students`.`status`=1
			and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "' ORDER BY `students`.`student_class_no`";
		$result = $this->db->query($query);
		$this->data['students'] = $students = $result->result();

		$missing_student_id = '';
		//var_dump($students);
		foreach ($students as $student) {
			$missing_student_id .= $student->student_id . ", ";
		}

		$where = "`students`.`status` IN (1) and `students`.`class_id`='" . $class_id . "' 
				   AND `students`.`section_id` ='" . $section_id . "'
				   AND student_id NOT IN(" . rtrim($missing_student_id, ', ') . ") ORDER by `students`.`student_class_no` ASC ";
		$this->data["missing_students"] = $this->student_model->get_student_list($where, FALSE);

		/*$where = "`students`.`status` IN (1) and `students`.`class_id`='".$class_id."' 
				   AND `students`.`section_id` ='".$section_id."' ORDER by `students`.`student_class_no` ASC ";
		$this->data["students"] = $this->student_model->get_student_list($where,FALSE);*/

		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/update_students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function add_students_subject_result($exam_id, $class_id, $section_id, $class_subject_id, $subject_id)
	{
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;
		$this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
		$this->data["subject_id"] = $subject_id = (int) $subject_id;



		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];
		$query = "SELECT 
				  `class_subjects`.`class_subject_id`,
				  `subjects`.`subject_title`,
				  `class_subjects`.`class_id` 
				FROM
				  `subjects`,
				  `class_subjects` 
				WHERE `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subjects`.`subject_id` =" . $subject_id;
		$result = $this->db->query($query);
		$this->data['class_subject'] = $result->result()[0]->subject_title;



		$where = "`students`.`status` IN (1) and `students`.`class_id`='" . $class_id . "' 
				   AND `students`.`section_id` ='" . $section_id . "' ORDER by `students`.`student_class_no` ASC ";
		$this->data["students"] = $this->student_model->get_student_list($where, FALSE);

		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function view_exam($exam_id)
	{

		$exam_id = (int) $exam_id;

		$this->data["exams"] = $this->exam_model->get_exam($exam_id);
		$this->data["title"] = $this->lang->line('Exam Details');
		$this->data["view"] = ADMIN_DIR . "exams/view_exam";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	//-----------------------------------------------------

	/**
	 * get a list of all trashed items
	 */
	public function trashed()
	{

		$where = "`exams`.`status` IN (2) ORDER BY `exams`.`order`";
		$data = $this->exam_model->get_exam_list($where);
		$this->data["exams"] = $data->exams;
		$this->data["pagination"] = $data->pagination;
		$this->data["title"] = $this->lang->line('Trashed Exams');
		$this->data["view"] = ADMIN_DIR . "exams/trashed_exams";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	//-----------------------------------------------------

	/**
	 * function to send a user to trash
	 */
	public function trash($exam_id, $page_id = NULL)
	{

		$exam_id = (int) $exam_id;


		$this->exam_model->changeStatus($exam_id, "2");
		$this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
		redirect(ADMIN_DIR . "exams/view/" . $page_id);
	}

	/**
	 * function to restor exam from trash
	 * @param $exam_id integer
	 */
	public function restore($exam_id, $page_id = NULL)
	{

		$exam_id = (int) $exam_id;


		$this->exam_model->changeStatus($exam_id, "1");
		$this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
		redirect(ADMIN_DIR . "exams/trashed/" . $page_id);
	}
	//---------------------------------------------------------------------------

	/**
	 * function to draft exam from trash
	 * @param $exam_id integer
	 */
	public function draft($exam_id, $page_id = NULL)
	{

		$exam_id = (int) $exam_id;


		$this->exam_model->changeStatus($exam_id, "0");
		$this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
		redirect(ADMIN_DIR . "exams/view/" . $page_id);
	}
	//---------------------------------------------------------------------------

	/**
	 * function to publish exam from trash
	 * @param $exam_id integer
	 */
	public function publish($exam_id, $page_id = NULL)
	{

		$exam_id = (int) $exam_id;


		$this->exam_model->changeStatus($exam_id, "1");
		$this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
		redirect(ADMIN_DIR . "exams/view/" . $page_id);
	}
	//---------------------------------------------------------------------------

	/**
	 * function to permanently delete a Exam
	 * @param $exam_id integer
	 */
	public function delete($exam_id, $page_id = NULL)
	{

		$exam_id = (int) $exam_id;
		//$this->exam_model->changeStatus($exam_id, "3");

		$this->exam_model->delete(array('exam_id' => $exam_id));
		$this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
		redirect(ADMIN_DIR . "exams/trashed/" . $page_id);
	}
	//----------------------------------------------------



	/**
	 * function to add new Exam
	 */
	public function add()
	{

		$this->data["title"] = $this->lang->line('Add New Exam');
		$this->data["view"] = ADMIN_DIR . "exams/add_exam";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	//--------------------------------------------------------------------
	public function save_data()
	{
		if ($this->exam_model->validate_form_data() === TRUE) {

			$exam_id = $this->exam_model->save_data();
			if ($exam_id) {
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
				redirect(ADMIN_DIR . "exams/edit/$exam_id");
			} else {

				$this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
				redirect(ADMIN_DIR . "exams/add");
			}
		} else {
			$this->add();
		}
	}


	/**
	 * function to edit a Exam
	 */
	public function edit($exam_id)
	{
		$exam_id = (int) $exam_id;
		$this->data["exam"] = $this->exam_model->get($exam_id);

		$this->data["title"] = $this->lang->line('Edit Exam');
		$this->data["view"] = ADMIN_DIR . "exams/edit_exam";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	//--------------------------------------------------------------------

	public function update_data($exam_id)
	{

		$exam_id = (int) $exam_id;

		if ($this->exam_model->validate_form_data() === TRUE) {

			$exam_id = $this->exam_model->update_data($exam_id);
			if ($exam_id) {

				$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
				redirect(ADMIN_DIR . "exams/edit/$exam_id");
			} else {

				$this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
				redirect(ADMIN_DIR . "exams/edit/$exam_id");
			}
		} else {
			$this->edit($exam_id);
		}
	}


	/**
	 * function to move a record up in list
	 * @param $exam_id id of the record
	 * @param $page_id id of the page to be redirected to
	 */
	public function up($exam_id, $page_id = NULL)
	{

		$exam_id = (int) $exam_id;

		//get order number of this record
		$this_exam_where = "exam_id = $exam_id";
		$this_exam = $this->exam_model->getBy($this_exam_where, true);
		$this_exam_id = $exam_id;
		$this_exam_order = $this_exam->order;


		//get order number of previous record
		$previous_exam_where = "order <= $this_exam_order AND exam_id != $exam_id ORDER BY `order` DESC";
		$previous_exam = $this->exam_model->getBy($previous_exam_where, true);
		$previous_exam_id = $previous_exam->exam_id;
		$previous_exam_order = $previous_exam->order;

		//if this is the first element
		if (!$previous_exam_id) {
			redirect(ADMIN_DIR . "exams/view/" . $page_id);
			exit;
		}


		//now swap the order
		$this_exam_inputs = array(
			"order" => $previous_exam_order
		);
		$this->exam_model->save($this_exam_inputs, $this_exam_id);

		$previous_exam_inputs = array(
			"order" => $this_exam_order
		);
		$this->exam_model->save($previous_exam_inputs, $previous_exam_id);



		redirect(ADMIN_DIR . "exams/view/" . $page_id);
	}
	//-------------------------------------------------------------------------------------

	/**
	 * function to move a record up in list
	 * @param $exam_id id of the record
	 * @param $page_id id of the page to be redirected to
	 */
	public function down($exam_id, $page_id = NULL)
	{

		$exam_id = (int) $exam_id;



		//get order number of this record
		$this_exam_where = "exam_id = $exam_id";
		$this_exam = $this->exam_model->getBy($this_exam_where, true);
		$this_exam_id = $exam_id;
		$this_exam_order = $this_exam->order;


		//get order number of next record

		$next_exam_where = "order >= $this_exam_order and exam_id != $exam_id ORDER BY `order` ASC";
		$next_exam = $this->exam_model->getBy($next_exam_where, true);
		$next_exam_id = $next_exam->exam_id;
		$next_exam_order = $next_exam->order;

		//if this is the first element
		if (!$next_exam_id) {
			redirect(ADMIN_DIR . "exams/view/" . $page_id);
			exit;
		}


		//now swap the order
		$this_exam_inputs = array(
			"order" => $next_exam_order
		);
		$this->exam_model->save($this_exam_inputs, $this_exam_id);

		$next_exam_inputs = array(
			"order" => $this_exam_order
		);
		$this->exam_model->save($next_exam_inputs, $next_exam_id);



		redirect(ADMIN_DIR . "exams/view/" . $page_id);
	}

	/**
	 * get data as a json array 
	 */
	public function get_json()
	{
		$where = array("status" => 1);
		$where[$this->uri->segment(3)] = $this->uri->segment(4);
		$data["exams"] = $this->exam_model->getBy($where, false, "exam_id");
		$j_array[] = array("id" => "", "value" => "exam");
		foreach ($data["exams"] as $exam) {
			$j_array[] = array("id" => $exam->exam_id, "value" => "");
		}
		echo json_encode($j_array);
	}
	//-----------------------------------------------------
	public function add_class_teacher()
	{
		$exam_id = (int) $this->input->post('exam_id');
		$class_subject_id = (int) $this->input->post('class_subject_id');
		$section_id = (int)$this->input->post('section_id');
		$techer_name = $this->input->post('techer_name');
		$total_marks = (int) $this->input->post('total_marks');
		$passing_marks = (int) $this->input->post('passing_marks');


		$query = "INSERT INTO `class_subject_teacher`( `exam_id`, `class_subject_id`, `section_id`, `class_teacher`, `paper_checked_by`, `total_marks`, `passing_marks` ) VALUES ('" . $exam_id . "', '" . $class_subject_id . "', '" . $section_id . "', '" . $techer_name . "', '" . $techer_name . "', '" . $total_marks . "', '" . $passing_marks . "')";
		if ($this->db->query($query)) {
			redirect(ADMIN_DIR . "exam_list/class_subjects_view/" . $exam_id);
		}
	}


	public function remove_duplicate_record($exam_id, $class_id, $section_id, $class_subject_id, $subject_id,  $student_exam_subject_mark_id)
	{
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;
		$this->data["class_subject_id"] = $class_subject_id = (int) $class_subject_id;
		$this->data["subject_id"] = $subject_id = (int) $subject_id;

		$student_exam_subject_mark_id = (int) $student_exam_subject_mark_id;
		$query = "DELETE FROM `students_exams_subjects_marks` WHERE `student_exam_subject_mark_id` ='" . $student_exam_subject_mark_id . "'";


		if ($this->db->query($query)) {
			redirect(ADMIN_DIR . "exam_list/update_students_subject_result/" . $exam_id . "/" . $class_id . "/" . $section_id . "/" . $class_subject_id . "/" . $subject_id);
		}
	}



	public function class_dmcs($exam_id, $class_id, $section_id, $order = NULL)
	{


		/*$query = "SELECT * FROM `students_exams_subjects_marks`";
		$result = $this->db->query($query);
		$students = $result->result();
		//var_dump($students);
		foreach($students as $student){
			$query="SELECT `student_class_no`
					, `class_id`
				FROM
					`students`
					WHERE `students`.`student_id` = ".$student->student_id;
			$result = $this->db->query($query);
			$student_info = $result->result()[0];
			
			//update record 
			$query="UPDATE 
			       `student_section_history` SET`student_class_no`='".$student_info->student_class_no."',
				   `class_id`='".$student_info->class_id."' WHERE `student_id`= ".$student->student_id;
			$this->db->query($query);
			//var_dump($student_info);	
			}
		
		exit();*/
		$this->data["class_id"] = $class_id = (int) $class_id;
		$this->data["section_id"] = $section_id = (int) $section_id;
		$this->data["exam_id"] = $exam_id = (int) $exam_id;

		//get class name 

		$query = "SELECT  `Class_title` FROM `classes` WHERE `classes`.`class_id` ='" . $class_id . "'";
		$result = $this->db->query($query);
		$this->data['class_name'] = $result->result()[0]->Class_title;
		//$this->data['class_name'] $result->result()[0]->Class_title;	


		//get section name 

		$query = "SELECT `section_title` FROM `sections` WHERE  `sections`.`section_id` ='" . $section_id . "'";
		$result = $this->db->query($query);
		$this->data['section_title'] = $result->result()[0]->section_title;
		//get all students here....

		//check the exam id is in section history .....

		$query = "SELECT COUNT(*) as total FROM `student_section_history` WHERE `exam_id`='" . $exam_id . "'
		AND `student_section_history`.`class_id` = '" . $class_id . "'";
		$result = $this->db->query($query);
		$exam_count = $result->result()[0]->total;

		if ($order) {
		} else {
		}

		if ($exam_count == 0) {
			$query = "SELECT
					`student_id`
					, `student_name`
					, `student_class_no`
					, `class_id`
					, `section_id`
				FROM
					`students`
					WHERE `students`.`class_id` = $class_id
					AND `students`.`section_id` = $section_id 
					AND `students`.`status` =1
					ORDER BY `student_class_no` ASC  ";
		} else {
			$query = "SELECT 
					  `students`.`student_id`,
					  `students`.`student_name`,
					  `student_section_history`.`student_class_no` as `student_class_no` ,
					  `student_section_history`.`class_id` AS `class_id`,
					  `student_section_history`.`section_id`  AS `section_id`
					FROM
					  `students`,
					  `student_section_history` 
					WHERE `students`.`student_id` = `student_section_history`.`student_id` 
					AND `student_section_history`.`class_id` = $class_id
					AND `student_section_history`.`section_id` = $section_id
					AND `students`.`status` =1  ORDER BY `student_class_no` ASC  ";
		}
		$result = $this->db->query($query);
		$students = $result->result();


		$where = "`exams`.`status` IN (0, 1) and `exams`.`exam_id` =" . $exam_id;
		$exam = $this->exam_model->get_exam_list($where, false, false);
		$this->data["exam"] = $exam[0];

		$query = "SELECT 
  `subjects`.`subject_title`,
  `class_subject_teacher`.`section_id`,
  `class_subjects`.`subject_id`,
  `class_subjects`.`class_subject_id`,
  `subjects`.`subject_title`,
  `subjects`.`short_title`,
  `class_subjects`.`class_id`,
  `class_subjects`.`marks`,
  `class_subjects`.`passing_mark` 
FROM
`class_subjects` ,
`class_subject_teacher`,
`subjects`  
WHERE `class_subjects`.`class_subject_id` = `class_subject_teacher`.`class_subject_id`
AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_subjects`.`class_id` =" . $class_id . "
				AND `class_subject_teacher`.`exam_id` =" . $exam_id . "
				AND `class_subject_teacher`.`section_id` =" . $section_id;
		$result = $this->db->query($query);
		$this->data['class_subjects'] = $class_subjects = $result->result();



		foreach ($students as $student_index => $student) {
			foreach ($class_subjects as $class_subject) {
				$students[$student_index]->subjects[$class_subject->class_subject_id]['total_marks'] = $class_subject->marks;
				$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->marks;
				$query = "SELECT 
					`obtain_mark`
							FROM
							`students_exams_subjects_marks`
							WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
							AND `students_exams_subjects_marks`.`exam_id` = '" . $exam_id . "'
							AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
							and `students_exams_subjects_marks`.`section_id` = '" . $section_id . "'";
				$result = $this->db->query($query);
				if ($result->num_rows) {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = $result->result()[0]->obtain_mark;
				} else {
					$students[$student_index]->subjects[$class_subject->class_subject_id]['passing_mark'] = $class_subject->obtain_marks = "-";
				}
			}
		}

		$query = "SELECT pass_fail_status, COUNT(pass_fail_status) as total 
		FROM student_results WHERE `exam_id` = $exam_id 
		AND `class_id` =" . $class_id . "
		AND `section_id` = '" . $section_id . "'
		 GROUP BY pass_fail_status ORDER BY  pass_fail_status ASC";
		$results = $this->db->query($query);
		$pass_fail_counts = $results->result();

		$this->data['pass_fail_counts'] = $pass_fail_counts;



		$this->data['students'] = $students;
		$this->data["title"] = "Subject Marks";
		$this->data["view"] = ADMIN_DIR . "exams/view_subject_result";
		$this->load->view(ADMIN_DIR . "exams/class_dmcs", $this->data);
	}
}
