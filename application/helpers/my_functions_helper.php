<?php


function update_q($post, $table, $id)
{
	foreach ($post as $variable => $value) {
		echo '$input["' . $variable . '"] = $this->input->post("' . $variable . '");<br />';
	}
	echo '$this->db->where("' . $id . '", $' . $id . ');<br />';
	echo 'if ($this->db->update("' . $table . '", $input)) {<br />
		$this->session->set_flashdata("msg_success", $this->lang->line("success"));<br />
		redirect(ADMIN_DIR . "admission/student_profile/$' . $id . '");<br />
	} else {<br />
		$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));<br />
		redirect(ADMIN_DIR . "admission/student_profile/$' . $id . '");<br />
	}<br />';
}



// pass fail check 


function remarks($percentage, $promote)
{
	$fail = 33;
	if ($percentage >= 32.5) {
		return 'pass';
	}
	if ($percentage >= $promote and $percentage < 32.5) {
		return 'promote';
	}

	if ($percentage < $promote) {
		return 'fail';
	}
}





function pass_fail($number)
{
	$fail = 33;
	if ($number < $fail) {
		return 'Fail';
	} else {
		return 'Pass';
	}
}

function paper_pass_fail($number)
{


	$fail = 33;
	if ($number < $fail) {
		if ($number == 'A') {
			return '<div class="blackcircle">' . $number . '</div>';
		} else {
			return '<div class="redcircle">' . $number . '</div>';
		}
	} else {
		return $number;
	}
}

function get_subject_total_marks($subject)
{
	$subject_marks = array(
		"islamiyat" => 100,
		"urdu" => 100,
		"english" => 100,
		"math" => 100,
		"arabi" => 100,
		"drawing" => 100,
		"computer" => 100,
		"general_studies" => 100,
		"history_geography" => 100
	);
	return $subject_marks[$subject];
}
function get_total_marks()
{
	return get_subject_total_marks("islamiyat") + get_subject_total_marks("urdu") + get_subject_total_marks("english") + get_subject_total_marks("math") + get_subject_total_marks("arabi") + get_subject_total_marks("drawing") + get_subject_total_marks("computer") + get_subject_total_marks("general_studies") + get_subject_total_marks("history_geography");
}

function get_grade($percentage)
{
	$percentage =  (int) $percentage;
	if ($percentage >= 0 and $percentage <= 39) {
		return "F";
	}
	if ($percentage >= 40 and $percentage <= 49) {
		return "D";
	}
	if ($percentage >= 50 and $percentage <= 54) {
		return "C";
	}
	if ($percentage >= 55 and $percentage <= 59) {
		return "C+";
	}
	if ($percentage >= 60 and $percentage <= 64) {
		return "B-";
	}
	if ($percentage >= 65 and $percentage <= 69) {
		return "B";
	}
	if ($percentage >= 70 and $percentage <= 74) {
		return "B+";
	}
	if ($percentage >= 75 and $percentage <= 79) {
		return "A-";
	}
	if ($percentage >= 80 and $percentage <= 100) {
		return "A+";
	}


	/*if($percentage>=0 and $percentage<=39){ return "F (FAIL)"; }
	if($percentage>=40 and $percentage<=49){ return "D (PASSING)"; }
	if($percentage>=50 and $percentage<=54){ return "C (PASS)"; }
	if($percentage>=55 and $percentage<=59){ return "C+ (SATISFACTORY)"; }
	if($percentage>=60 and $percentage<=64){ return "B- (GOOD)"; }
	if($percentage>=65 and $percentage<=69){ return "B (GOOD)"; }
	if($percentage>=70 and $percentage<=74){ return "B+ (VERY GOOD)"; }
	if($percentage>=75 and $percentage<=79){ return "A- (EXCELLENT)"; }
	if($percentage>=80 and $percentage<=100){ return "A+ (EXCELLENT)"; }*/
}

/**
 * function to check module menu status and 
 * display the corresponding status
 * @param $menu_status integer
 * @return string
 */
if (!function_exists('menu_status')) {

	function menu_status($menu_status)
	{


		if ($menu_status == 1) {
			return "<span class='label label-success'>Enabled</span>";
		} else {
			return "<span class='label label-danger'>Disabled</span>";
		}
	}
}




/**
 * function to check status and 
 * display the corresponding status
 * @param $status integer
 * @return string
 */
if (!function_exists('status')) {

	function status($status, $lang_obj = NULL)
	{


		if (!is_null($lang_obj)) {
			if ($status == 0) {
				return "<span class='label label-default'>" . $lang_obj->line('Draft') . "</span>";
			} elseif ($status == 1) {
				return "<span class='label label-success'>" . $lang_obj->line('Active') . "</span>";
			} elseif ($status == 2) {
				return "<span class='label label-danger'>" . $lang_obj->line('Trash') . "</span>";
			} else {
				return "<span class='label label-info'>" . $lang_obj->line('Unkown') . "</span>";
			}
		} else {

			if ($status == 0) {
				return "<span class='label label-default'>Draft</span>";
			} elseif ($status == 1) {
				return "<span class='label label-success'>Active</span>";
			} elseif ($status == 2) {
				return "<span class='label label-danger'>Trash</span>";
			} else {
				return "<span class='label label-info'>Unkown</span>";
			}
		}
	}
}



/**
 * function to check the database value of a radio and
 * conpare it against the the value of that radio and 
 * return checked="checked" if both are same
 * @param $db_value mixed database value of the radio
 * @param $current_value html value of radio
 * @return string checked="checked"
 */
if (!function_exists('radio_checked')) {

	function radio_checked($db_value, $current_value)
	{

		if ($db_value == $current_value) {

			return "checked='checked'";
		} else {

			return "";
		}
	}
}


/**
 * function to compare current value with object's value and return
 * selected="selected" attribute for option list
 * @param $this_value mixed current value of iteration
 * @param $object_value mixed the value of the object
 * @return $attr string selected="selected"
 */
if (!function_exists('sel_attr')) {

	function sel_attr($this_value, $object_value)
	{

		if ($this_value == $object_value) {
			return " selected='selected' ";
		} else {
			return "";
		}
	}
}




/**
 * function to check if a string is a file or not
 */
if (!function_exists('file_type')) {



	function file_type($filename, $original = false, $width = 50, $height = 50)
	{



		if ($width) {
			$image_width = $width;
		} else {
			$image_width = "100%";
		}

		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if (isset($ext) and strlen($ext) > 1) {

			$images = array('jpg', 'jpeg', 'bmp', 'gif', 'png');

			if (in_array($ext, $images)) {

				$path_parts = pathinfo($filename);


				if ($original == false) {

					return "<a href='" . $path_parts['dirname'] . "/" . $path_parts['filename'] . "." . $ext . "' target='_blank'>
									<img src='" . $path_parts['dirname'] . "/" . $path_parts['filename'] . "_thumb." . $ext . "' height=" . $height . " width='" . $image_width . "' class='img-circle' />
									</a>";
				} else {


					return "<img src='" . $path_parts['dirname'] . "/" . $path_parts['filename'] . "." . $ext . "' />";
				}
			} else {

				return anchor($filename, "Download", array("target" => "new"));
			}
		}
	}
}





function seconds_in_redable($seconds)
{
	$then = new DateTime(date('Y-m-d H:i:s', 0));
	$now  = new DateTime(date('Y-m-d H:i:s', $seconds));
	$diff = $then->diff($now);
	return  $diff->y . " Years, " . $diff->m . " Months, " . $diff->d . " Days, " . $diff->h . " Hours, " . $diff->i . " Minutes, " . $diff->s . " Second";
}
function average($array)
{
	@$total = count($array);
	@$sum   = array_sum($array);
	return round($sum / $total, 0);
}

function minimum($array)
{
	@sort($array);
	@$minimum = array_shift($array);
	return $minimum;
}

function maximum($array)
{
	@sort($array);
	@$maximum = array_pop($array);
	return $maximum;
}


function get_timeago($ptime)
{
	$ptime = strtotime($ptime);
	$estimate_time = time() - $ptime;

	if ($estimate_time < 1) {
		return 'less than 1 second ago';
	}

	$condition = array(
		12 * 30 * 24 * 60 * 60  =>  'YY',
		30 * 24 * 60 * 60       =>  'Mon',
		24 * 60 * 60            =>  'Day',
		60 * 60                 =>  'Hr',
		60                      =>  'Min',
		1                       =>  'Sec'
	);

	foreach ($condition as $secs => $str) {
		$d = $estimate_time / $secs;

		if ($d >= 1) {
			$r = round($d);
			return 'about ' . $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
		}
	}
}

function date_formate($date, $formate = false)
{
	if ($formate) {
		return date($formate, strtotime($date));
	} else {
		return date('D d M, Y H:m:s A', strtotime($date));
	}
}


function trim_all($str, $what = NULL, $with = ' ')
{
	if ($what === NULL) {
		//  Character      Decimal      Use
		//  "\0"            0           Null Character
		//  "\t"            9           Tab
		//  "\n"           10           New line
		//  "\x0B"         11           Vertical Tab
		//  "\r"           13           New Line in Mac
		//  " "            32           Space

		$what   = "\\x00-\\x20";    //all white-spaces and control chars
	}

	return trim(preg_replace("/[" . $what . "]+/", $with, $str), $what);
}

function captcha()
{
	session_start();
	$ranStr = md5(microtime());
	$ranStr = substr($ranStr, 0, 6);
	$_SESSION['cap_code'] = $ranStr;
	$newImage = imagecreatefromjpeg("images/cap_bg.jpg");
	$txtColor = imagecolorallocate($newImage, 0, 0, 0);
	imagestring($newImage, 5, 5, 5, $ranStr, $txtColor);
	header("Content-type: image/jpeg");
	return imagejpeg($newImage);
}
