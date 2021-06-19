<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Timetable extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->load->model("admin/evaluation_model");
		$this->lang->load("evaluations", 'english');
		$this->lang->load("system", 'english');

		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------


	public function teachers_timetables()
	{




		$query = "SELECT
					`teachers`.`teacher_name`
					, `teachers`.`teacher_id`
					, `teachers`.`teacher_designation`
					, SUM(`class_subjects`.`total_class_week`) AS `class_total`
					, COUNT(`class_subjects`.`total_class_week`) AS `total_class_assigned`
					, (SELECT COUNT(*) FROM `period_subjects` WHERE `period_subjects`.`teacher_id` = `teachers`.`teacher_id`) AS period_assinged
				FROM
					`class_section_subject_teachers`
					RIGHT JOIN `teachers` 
						ON (`class_section_subject_teachers`.`teacher_id` = `teachers`.`teacher_id`)
					LEFT JOIN `class_subjects` 
						ON (`class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`)
				GROUP BY `teachers`.`teacher_id`
				ORDER BY `teachers`.`order` ASC;";
		$result = $this->db->query($query);
		$teachers = $result->result();

		$query = "SELECT * FROM `periods`";
		$result = $this->db->query($query);
		$periods = $result->result();



		$this->data['teachers'] = $teachers;
		$this->data['periods'] = $periods;
		$this->data["title"] = $this->lang->line('Teachers Time Tables');
		//$this->data["view"] = ADMIN_DIR."timetable/timetable";
		//$this->load->view(ADMIN_DIR."layout", $this->data);
		$this->load->view(ADMIN_DIR . "timetable/teachers_timetables", $this->data);
	}




	public function classes_timetables()
	{




		$query = "SELECT * FROM `periods`";
		$result = $this->db->query($query);
		$periods = $result->result();
		$query = "SELECT  `Class_title`, `class_id`
					FROM
					`classes` 
					WHERE `class_id` IN(2,3,4,5,6)";

		$result = $this->db->query($query);
		$classes = $result->result();
		foreach ($classes as $class) {
			$query = "SELECT
				`sections`.`section_title`
				, `sections`.`section_id`
			FROM
			`class_sections`,
			`sections`
			WHERE `class_sections`.`section_id` = `sections`.`section_id` 
				AND `class_sections`.`class_id` = '" . $class->class_id . "'";

			$result = $this->db->query($query);
			$class->sections = $result->result();

			$query = "SELECT
				`subjects`.`subject_title`
				, `subjects`.`short_title`
				, `subjects`.`subject_id`
				, `class_subjects`.`total_class_week`
				, `class_subjects`.`class_subject_id`
			FROM
			`class_subjects`,
			`subjects` 
			WHERE `class_subjects`.`subject_id` = `subjects`.`subject_id`
			AND `class_subjects`.`class_id` = '" . $class->class_id . "'
			AND `subjects`.`subject_id` NOT IN (2)
			Order By `class_subjects`.`total_class_week`, `subjects`.`order`, `subjects`.`subject_title`  ASC
			";

			$result = $this->db->query($query);
			$class->subjects = $result->result();
		}


		$this->data['classes'] = $classes;
		$this->data['periods'] = $periods;
		$this->data["title"] = $this->lang->line('Classes Time Tables');
		//$this->data["view"] = ADMIN_DIR."timetable/timetable";
		//$this->load->view(ADMIN_DIR."layout", $this->data);
		$this->load->view(ADMIN_DIR . "timetable/classes_timetables", $this->data);
	}




	/**
	 * Default action to be called
	 */
	public function index()
	{


		$query = "SELECT  `Class_title`, `class_id`
					FROM
					`classes` 
					WHERE `class_id` IN(2,3,4,5,6)";

		$result = $this->db->query($query);
		$classes = $result->result();
		foreach ($classes as $class) {
			$query = "SELECT
				`sections`.`section_title`
				, `sections`.`section_id`
			FROM
			`class_sections`,
			`sections`
			WHERE `class_sections`.`section_id` = `sections`.`section_id` 
				AND `class_sections`.`class_id` = '" . $class->class_id . "'";

						$result = $this->db->query($query);
						$class->sections = $result->result();

						$query = "SELECT
				`subjects`.`subject_title`
				, `subjects`.`short_title`
				, `subjects`.`subject_id`
				, `class_subjects`.`total_class_week`
				, `class_subjects`.`class_subject_id`
			FROM
			`class_subjects`,
			`subjects` 
			WHERE `class_subjects`.`subject_id` = `subjects`.`subject_id`
			AND `class_subjects`.`class_id` = '" . $class->class_id . "'
			Order By `class_subjects`.`total_class_week`, `subjects`.`order`, `subjects`.`subject_title`  ASC
			";

			$result = $this->db->query($query);
			$class->subjects = $result->result();
		}


		$this->data['classes'] = $classes;
		$this->data["title"] = $this->lang->line('Time Table');
		//$this->data["view"] = ADMIN_DIR."timetable/timetable";
		//$this->load->view(ADMIN_DIR."layout", $this->data);
		$this->load->view(ADMIN_DIR . "timetable/timetable", $this->data);
	}


	public function update_total_class_week($class_subject_id)
	{
		$class_subject_id = (int) $class_subject_id;
		$total_class_week =  $this->input->post('total_class_week');

		$query = "UPDATE `class_subjects` SET 
	        `total_class_week`='" . $total_class_week . "' 
			WHERE `class_subject_id` = '" . $class_subject_id . "'";
		$result = $this->db->query($query);
		if ($result) {
			echo "Update successfuly";
		} else {
			echo "error..";
		}
	}

	public function add_teacher()
	{
		$class_id =  $this->input->post('class_id');
		$section_id =  $this->input->post('section_id');
		$class_subject_id =  $this->input->post('class_subject_id');
		$teacher_id =  $this->input->post('teacher_id');





		$query = "SELECT COUNT(*) as total FROM `class_section_subject_teachers` 
		WHERE `class_id` = '" . $class_id . "'
		AND `section_id` = '" . $section_id . "' 
		AND `class_subject_id` = '" . $class_subject_id . "'
		AND `teacher_id` = '" . $teacher_id . "'";
		$result = $this->db->query($query);
		$total = $result->result()[0]->total;
		if ($total == 0) {


			$query = "SELECT 
					  `id` 
					FROM
					  `class_sections` 
					WHERE `class_id` = '" . $class_id . "' 
					  AND `section_id` = '" . $section_id . "' ";

			$result = $this->db->query($query);
			$class_section_id = $result->result()[0]->id;

			$query = "INSERT INTO `class_section_subject_teachers`(`class_id`, `section_id`, `class_subject_id`, `teacher_id`, `class_section_id`) 
		        VALUES ('" . $class_id . "', '" . $section_id . "', '" . $class_subject_id . "', '" . $teacher_id . "', '" . $class_section_id . "')";
			$result = $this->db->query($query);


			if ($result) {
				$this->session->set_flashdata('msg_success', 'Teacher Assign Successfully.');
				redirect(ADMIN_DIR . "timetable");
			} else {
				$this->session->set_flashdata('msg_success', 'Error Try Again.');
				redirect(ADMIN_DIR . "timetable");
			}
		} else {
			$this->session->set_flashdata('msg_success', 'Teacher Already Assigned.');
			redirect(ADMIN_DIR . "timetable");
		}
	}

	public function remove_teacher($class_section_subject_teacher_id)
	{
		$class_section_subject_teacher_id = (int) $class_section_subject_teacher_id;
		$result = $this->db->query("DELETE FROM `class_section_subject_teachers` 
										WHERE `class_section_subject_teacher_id` = '" . $class_section_subject_teacher_id . "'");
		if ($result) {
			$this->session->set_flashdata('msg_success', 'Record Delete Successfully.');
			redirect(ADMIN_DIR . "timetable");
		}
	}

	public function period_management()
	{


		$query = "SELECT
					`teachers`.`teacher_name`
					, `teachers`.`teacher_id`
					, `teachers`.`teacher_designation`
					, SUM(`class_subjects`.`total_class_week`) AS `class_total`
					, COUNT(`class_subjects`.`total_class_week`) AS `total_class_assigned`
					, (SELECT COUNT(*) FROM `period_subjects` WHERE `period_subjects`.`teacher_id` = `teachers`.`teacher_id`) AS period_assinged
				FROM
					`class_section_subject_teachers`
					RIGHT JOIN `teachers` 
						ON (`class_section_subject_teachers`.`teacher_id` = `teachers`.`teacher_id`)
					LEFT JOIN `class_subjects` 
						ON (`class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`)
				GROUP BY `teachers`.`teacher_id`
				ORDER BY `teachers`.`order` ASC;";
		$result = $this->db->query($query);
		$teachers = $result->result();

		$query = "SELECT * FROM `periods`";
		$result = $this->db->query($query);
		$periods = $result->result();



		$this->data['teachers'] = $teachers;
		$this->data['periods'] = $periods;
		$this->data["title"] = $this->lang->line('Time Table');
		//$this->data["view"] = ADMIN_DIR."timetable/timetable";
		//$this->load->view(ADMIN_DIR."layout", $this->data);
		$this->load->view(ADMIN_DIR . "timetable/period_management", $this->data);
	}

	public function period_management_print()
	{


		$query = "SELECT
					`teachers`.`teacher_name`
					, `teachers`.`teacher_id`
					, `teachers`.`teacher_designation`
					, SUM(`class_subjects`.`total_class_week`) AS `class_total`
					, COUNT(`class_subjects`.`total_class_week`) AS `total_class_assigned`
					, (SELECT COUNT(*) FROM `period_subjects` WHERE `period_subjects`.`teacher_id` = `teachers`.`teacher_id`) AS period_assinged
				FROM
					`class_section_subject_teachers`
					RIGHT JOIN `teachers` 
						ON (`class_section_subject_teachers`.`teacher_id` = `teachers`.`teacher_id`)
					LEFT JOIN `class_subjects` 
						ON (`class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`)
				GROUP BY `teachers`.`teacher_id`
				ORDER BY `teachers`.`order` ASC;";
		$result = $this->db->query($query);
		$teachers = $result->result();

		$query = "SELECT * FROM `periods`";
		$result = $this->db->query($query);
		$periods = $result->result();



		$this->data['teachers'] = $teachers;
		$this->data['periods'] = $periods;
		$this->data["title"] = $this->lang->line('Time Table');
		//$this->data["view"] = ADMIN_DIR."timetable/timetable";
		//$this->load->view(ADMIN_DIR."layout", $this->data);
		$this->load->view(ADMIN_DIR . "timetable/period_management_print", $this->data);
	}



	public function get_teacher_classes()
	{
		$teacher_id = (int) $this->input->post('teacher_id');
		$period_id  = (int) $this->input->post('period_id');


		$query = "SELECT * FROM `periods` WHERE `period_id`='$period_id'";

		$result = $this->db->query($query);
		$period = $result->result()[0];
		echo '<h4>' . $period->period_title . '</h4>';

		$query = "SELECT
					DISTINCT `class_section_subject_teachers`.`class_section_id`
				FROM
				`class_section_subject_teachers`
				, `period_subjects`
				WHERE `class_section_subject_teachers`.`class_section_subject_teacher_id` = `period_subjects`.`class_section_subject_teacher_id`
				AND `period_subjects`.`period_id`='$period_id'";

		$result = $this->db->query($query);
		$assigned_sections_subjects = $result->result_array();
		$assigned_sections_subjects = array_column($assigned_sections_subjects, 'class_section_id');

		//var_dump($assigned_sections_subjects);



		$query = "SELECT 
				  `subjects`.`subject_title`,
				  `subjects`.`short_title`,
				  `classes`.`Class_title`,
				  `sections`.`section_title`,
				  `sections`.`color`,
				  `class_subjects`.`total_class_week`,
				  `class_section_subject_teachers`.`class_section_subject_teacher_id`,
				  `sections`.`section_id`,
				  `class_subjects`.`subject_id`,
				  `classes`.`class_id`,
				  `class_section_subject_teachers`.`class_section_id`,
				  (SELECT COUNT(*) AS total FROM period_subjects 
				  WHERE class_section_subject_teacher_id=`class_section_subject_teachers`.`class_section_subject_teacher_id` 
				  AND teacher_id=$teacher_id ) as assinged
				FROM
				  `class_subjects`,
				  `class_section_subject_teachers`,
				  `subjects`,
				  `classes`,
				  `sections` 
				WHERE `class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id` 
				  AND `subjects`.`subject_id` = `class_subjects`.`subject_id` 
				  AND `classes`.`class_id` = `class_section_subject_teachers`.`class_id` 
				  AND `sections`.`section_id` = `class_section_subject_teachers`.`section_id` 
				  AND `class_section_subject_teachers`.`teacher_id` = $teacher_id;";
		$result = $this->db->query($query);
		$teacher_classes = $result->result();


		echo '<ul class="list-group">';
		//and !in_array($teacher_class->section_id, $assigned_sections_ids)

		foreach ($teacher_classes as $teacher_class) {


			echo '<li class="list-group-item" 
					style="background-color:' . $teacher_class->color . '">
					' . $teacher_class->Class_title . '-' . $teacher_class->section_title . ' ' . $teacher_class->subject_title . ' ' . $teacher_class->total_class_week;

			if ($teacher_class->assinged == 0) {
				if (!in_array($teacher_class->class_section_id, $assigned_sections_subjects)) {
					echo '<form action="' . site_url(ADMIN_DIR . 'timetable/assign_teacher_subject_period') . '" method="post">
							<input type="hidden" name="teacher_id" value="' . $teacher_id . '" />
							<input type="hidden" name="period_id" value="' . $period_id . '" />
							<input type="hidden" name="class_section_subject_teacher_id" value="' . $teacher_class->class_section_subject_teacher_id . '" /> 
							<input onclick="this.form.submit()" type="radio"  /></form>';
				} else {
					//get teacher and subject name that assinged in this period
					$query = "SELECT
										`teachers`.`teacher_name`
										, `class_subjects`.`total_class_week`
										, `subjects`.`subject_title`
										, `subjects`.`short_title`,
										`class_section_subject_teachers`.`class_section_subject_teacher_id`
									FROM
									`period_subjects`,
									`class_section_subject_teachers`,
									`teachers`,  
									`class_subjects`,
									`subjects`
									WHERE `period_subjects`.`class_section_subject_teacher_id` = `class_section_subject_teachers`.`class_section_subject_teacher_id`
									AND `teachers`.`teacher_id` = `period_subjects`.`teacher_id`
									AND `class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`
									AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
									AND `class_section_subject_teachers`.`class_section_id`= $teacher_class->class_section_id
									AND `period_subjects`.`period_id`=$period_id";
					$result = $this->db->query($query);
					$already_assinged_classes = $result->result();
					$count_assigned_class_days = 0;
					foreach ($already_assinged_classes as $already_assinged_class) {
						$count_assigned_class_days += $already_assinged_class->total_class_week;
					}


					if ($teacher_class->total_class_week + $count_assigned_class_days == 6) {
						echo '<form action="' . site_url(ADMIN_DIR . 'timetable/assign_teacher_subject_period') . '" method="post" style="display:inline">
												<input type="hidden" name="teacher_id" value="' . $teacher_id . '" />
												<input type="hidden" name="period_id" value="' . $period_id . '" />
												<input type="hidden" name="class_section_subject_teacher_id" value="' . $teacher_class->class_section_subject_teacher_id . '" /> 
												<input onclick="this.form.submit()" type="radio"  /></form>';
					}



					foreach ($already_assinged_classes as $already_assinged_class) {

						if (($teacher_class->class_section_subject_teacher_id == 199 and $already_assinged_class->class_section_subject_teacher_id == 20) or ($teacher_class->class_section_subject_teacher_id == 201 and $already_assinged_class->class_section_subject_teacher_id == 29)) {
							echo '<form action="' . site_url(ADMIN_DIR . 'timetable/assign_teacher_subject_period') . '" method="post">
									<input type="hidden" name="teacher_id" value="' . $teacher_id . '" />
									<input type="hidden" name="period_id" value="' . $period_id . '" />
									<input type="hidden" name="class_section_subject_teacher_id" value="' . $teacher_class->class_section_subject_teacher_id . '" /> 
									<input onclick="this.form.submit()" type="radio"  /></form>';
						}

						echo '<strong><span class="pull-right" style="color:Black !important">Assinged (

											' . $already_assinged_class->teacher_name . ' - ' . $already_assinged_class->subject_title . ' ' . $already_assinged_class->total_class_week . '

										)</span></strong><br />';
					}
				}
			} else {

				echo '   <i class="fa fa-check-circle" style="color: red !important;
							text-shadow: 1px 1px 1px #ccc;
							font-size: 1.5em;"></i>';

				//get teacher and subject name that assinged in this period
				$query = "SELECT
					`teachers`.`teacher_name`
					, `class_subjects`.`total_class_week`
					, `subjects`.`subject_title`
					, `subjects`.`short_title`,
					`class_section_subject_teachers`.`class_section_subject_teacher_id`
				FROM
				`period_subjects`,
				`class_section_subject_teachers`,
				`teachers`,  
				`class_subjects`,
				`subjects`
				WHERE `period_subjects`.`class_section_subject_teacher_id` = `class_section_subject_teachers`.`class_section_subject_teacher_id`
				AND `teachers`.`teacher_id` = `period_subjects`.`teacher_id`
				AND `class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`
				AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `class_section_subject_teachers`.`class_section_id`= $teacher_class->class_section_id
				AND `period_subjects`.`period_id`=$period_id";
				$result = $this->db->query($query);
				$already_assinged_classes = $result->result();
				$count_assigned_class_days = 0;
				foreach ($already_assinged_classes as $already_assinged_class) {
					$count_assigned_class_days += $already_assinged_class->total_class_week;
				}



				foreach ($already_assinged_classes as $already_assinged_class) {
					echo '<strong><span class="pull-right" style="color:Black !important">Assinged (

						' . $already_assinged_class->teacher_name . ' - ' . $already_assinged_class->subject_title . ' ' . $already_assinged_class->total_class_week . '

					)</span></strong><br />';
				}
			}


			echo '</li>';
		}
		echo '</ul>';
	}




	public function assign_teacher_subject_period()
	{
		$teacher_id = (int) $this->input->post('teacher_id');
		$period_id  = (int) $this->input->post('period_id');
		$class_section_subject_teacher_id  = (int) $this->input->post('class_section_subject_teacher_id');
		$query = "INSERT INTO `period_subjects`(`period_id`, `teacher_id`, `class_section_subject_teacher_id` ) 
				VALUES ('" . $period_id . "', '" . $teacher_id . "', '" . $class_section_subject_teacher_id . "')";
		$result = $this->db->query($query);
		redirect(ADMIN_DIR . "timetable/period_management");
	}

	public function remove_teacher_subject_period($period_subject_id)
	{
		$period_subject_id = (int) $period_subject_id;

		$query = "DELETE FROM `period_subjects` WHERE `period_subject_id` = '$period_subject_id'";
		$result = $this->db->query($query);
		redirect(ADMIN_DIR . "timetable/period_management");
	}

	public function class_time_table()
	{



		$query = "SELECT  `Class_title`, `class_id` FROM
			`classes` 
			WHERE `class_id` IN(2,3,4,5,6)";

		$result = $this->db->query($query);
		$classes = $result->result();



		foreach ($classes as $class) {
			$query = "SELECT
			`sections`.`section_title`
			, `sections`.`section_id`
			FROM
			`class_sections`,
			`sections`
			WHERE `class_sections`.`section_id` = `sections`.`section_id` 
			AND `class_sections`.`class_id` = '" . $class->class_id . "'";

			$result = $this->db->query($query);
			$class->sections = $result->result();

			$query = "SELECT  * FROM `periods`";

			$result = $this->db->query($query);
			$class->periods = $result->result();
		}


		$this->data['classes'] = $classes;
		$this->data["title"] = $this->lang->line('Time Table');
		//$this->data["view"] = ADMIN_DIR."timetable/timetable";
		//$this->load->view(ADMIN_DIR."layout", $this->data);
		$this->load->view(ADMIN_DIR . "timetable/class_time_table", $this->data);
	}

	public function update_weeks()
	{

		$period_subject_id = (int) $this->input->post('period_subject_id');

		$query = "SELECT
				`teachers`.`teacher_name`
				, `class_subjects`.`total_class_week`
				, `subjects`.`subject_title`
				, `subjects`.`short_title`
				, `classes`.`Class_title`
				, `sections`.`section_title`
				, `sections`.`color`
				, `period_subjects`.*
				FROM
				`period_subjects`,
				`class_section_subject_teachers`,
				`teachers`,  
				`class_subjects`,
				`subjects`,
				`classes`,
				`sections`
				WHERE `period_subjects`.`class_section_subject_teacher_id` = `class_section_subject_teachers`.`class_section_subject_teacher_id`
				AND `teachers`.`teacher_id` = `period_subjects`.`teacher_id`
				AND `class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`
				AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
				AND `classes`.`class_id` = `class_section_subject_teachers`.`class_id`
				AND `sections`.`section_id` = `class_section_subject_teachers`.`section_id`
				AND `period_subjects`.`period_subject_id` = $period_subject_id";
		$result = $this->db->query($query);
		$period_subject = $result->result()[0];

		echo "<h4>Class: $period_subject->Class_title - Section: $period_subject->section_title</h4>";
		echo "<h5>Subject: $period_subject->subject_title (Days Classes: $period_subject->total_class_week)</h5>";
		echo "<h5>Subject Teacher: $period_subject->teacher_name</h5>";
		echo "<table class='table table-bordared'>
						<tr>
							<th>Monday</th>
							<th>Tuesday</th>
							<th>Wednesday</th>
							<th>Thrusday</th>
							<th>Friday</th>
							<th>Satureday</th>
						</tr>
						<tr>";
		echo "<td><input type='checkbox' name='mon' id='mon' onclick=\"updateWeeks('mon','" . $period_subject->period_subject_id . "')\" ";
		if ($period_subject->mon == 1) {
			echo "value='1' checked";
		} else {
			echo "value='0'";
		}
		echo "/> </td>";
		echo "<td><input type='checkbox' name='tue' id='tue' onclick=\"updateWeeks('tue','" . $period_subject->period_subject_id . "')\" ";
		if ($period_subject->tue == 1) {
			echo "value='1' checked";
		} else {
			echo "value='0'";
		}
		echo "/> </td>";
		echo "<td><input type='checkbox' name='wed' id='wed' onclick=\"updateWeeks('wed','" . $period_subject->period_subject_id . "')\" ";
		if ($period_subject->wed == 1) {
			echo "value='1' checked";
		} else {
			echo "value='0'";
		}
		echo "/> </td>";
		echo "<td><input type='checkbox' name='thr' id='thu' onclick=\"updateWeeks('thu','" . $period_subject->period_subject_id . "')\" ";
		if ($period_subject->thu == 1) {
			echo "value='1' checked";
		} else {
			echo "value='0'";
		}
		echo "/> </td>";
		echo "<td><input type='checkbox' name='fri' id='fri' onclick=\"updateWeeks('fri','" . $period_subject->period_subject_id . "')\" ";
		if ($period_subject->fri == 1) {
			echo "value='1' checked";
		} else {
			echo "value='0'";
		}
		echo "/> </td>";
		echo "<td><input type='checkbox' name='sat' id='sat' onclick=\"updateWeeks('sat','" . $period_subject->period_subject_id . "')\" ";
		if ($period_subject->sat == 1) {
			echo "value='1' checked";
		} else {
			echo "value='0'";
		}
		echo "/> </td>";


		echo "</tr>
				</table>";
	}

	public function update_week_value()
	{
		$period_subject_id = (int) $this->input->post('period_subject_id');
		$week_value  = (int) $this->input->post('week_value');
		$week_id  = $this->input->post('week_id');
		$query_week = NULL;
		if ($week_id == 'mon') {
			$query_week = '`mon`';
		}
		if ($week_id == 'tue') {
			$query_week = '`tue`';
		}
		if ($week_id == 'wed') {
			$query_week = '`wed`';
		}
		if ($week_id == 'thu') {
			$query_week = '`thu`';
		}
		if ($week_id == 'fri') {
			$query_week = '`fri`';
		}
		if ($week_id == 'sat') {
			$query_week = '`sat`';
		}
		if ($query_week) {
			$query = "UPDATE `period_subjects` SET $query_week = '" . $week_value . "' WHERE `period_subject_id`='" . $period_subject_id . "'";
			$result = $this->db->query($query);
		}
	}

	public function test()
	{

		/* $query="SELECT
						`class_id`
						, `section_id`
						, `class_section_subject_teacher_id`
					FROM
						`class_section_subject_teachers`;";
						
		$result = $this->db->query($query);	
		$class_section_subject_teachers = $result->result(); 
		foreach($class_section_subject_teachers as $class_section_subject_teacher){				
		 $query="SELECT 
					  `id` 
					FROM
					  `class_sections` 
					WHERE `class_id` = '".$class_section_subject_teacher->class_id."' 
					  AND `section_id` = '".$class_section_subject_teacher->section_id."' ";
						
		$result = $this->db->query($query);	
		$class_section_id = $result->result()[0]->id;
		
		$this->db->query("UPDATE `class_section_subject_teachers` 
						  SET `class_section_id`= '".$class_section_id."' 
						  WHERE `class_section_subject_teacher_id`= '".$class_section_subject_teacher->class_section_subject_teacher_id."'");
		 
		}*/
	}
}
