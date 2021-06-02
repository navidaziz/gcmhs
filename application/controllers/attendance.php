<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Attendance extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
		
		
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
		
	$query = "SELECT `session_id` FROM `session` WHERE  `session`.`active` = 1";
	$query_result = $this->db->query($query);
	$session = $query_result->result()[0];
	$this->data['current_session'] = $session->session_id;
		
		
		 $query ="SELECT
						DISTINCT `classes`.`Class_title`, `classes`.`class_id`
					FROM					`classes` 
					WHERE `classes`.`class_id` IN (2,3,4,5,6) ORDER BY `classes`.`class_id` DESC";
		
		$result = $this->db->query($query);
		$classes = $result->result();
		//var_dump($classes);
		
		foreach($classes as $classe){
			$query = "SELECT
							`sections`.`section_title`
							, `sections`.`color`
							, `sections`.`section_id`
						FROM
						`sections`,
						`class_sections` 
						WHERE `sections`.`section_id` = `class_sections`.`section_id`
						AND  `class_sections`.`status`=1
						AND `class_sections`.`class_id` =".$classe->class_id;
						
			$result = $this->db->query($query);
			$sections = $result->result();	
			$classe->sections = $sections;		
			}
			
			//var_dump($classes);
			
		$query='SELECT COUNT(*) AS `total` 
					FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()';
			$query_result = $this->db->query($query);
			$record = $query_result->result()[0];
			if($record->total==0){
				$this->data['classes'] = $classes;
		 		$this->data["view"] = PUBLIC_DIR."attendance/daily_attendance";
        		$this->load->view(PUBLIC_DIR."layout", $this->data);
			}else{
				$this->data['classes'] = $classes;
		 		$this->data["view"] = PUBLIC_DIR."attendance/daily_attendance_view";
        		$this->load->view(PUBLIC_DIR."layout", $this->data);
				}
		 
		
		
    }
	
public function save_today_attendance(){
	
	//get current session
	//error_reporting(14);
	$query = "SELECT `session_id` FROM `session` WHERE  `session`.`active` = 1";
	$query_result = $this->db->query($query);
	$session = $query_result->result()[0];
	$current_session = $session->session_id;

	
	$today_attendances = $this->input->post('daily_attendance');
	foreach($today_attendances as $class => $sections){
		foreach($sections as $section => $attendance ){
			
			/*$class
			$section
			$attendance['present']
			$attendance['absent']
			$attendance['leave']
			$attendance['sick']
			$attendance['total']*/
			
			
			$query='SELECT COUNT(*) AS `total` 
					FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session.'
					AND `class_id` ='.$class.'
					AND `section_id` ='.$section;
			$query_result = $this->db->query($query);
			$record = $query_result->result()[0];
			if($record->total==0){
				$query="INSERT INTO 
				`daily_attendances`(`session_id`, 
									`class_id`, 
									`section_id`, 
									`present`, 
									`absent`, 
									`leave`, 
									`sick`,
									`total`)
		         VALUES (".$current_session.",
				 		 ".$class.",
						 ".$section.",
						 ".$attendance['present'].",
						 ".$attendance['absent'].",
						 ".$attendance['leave'].",
						 ".$attendance['sick'].",
						 ".$attendance['total'].");";
						 $this->db->query($query);
				
				}
			
			}
		}
	
	
	
	 redirect("attendance/");
	
	}	
	
	public function update_attandance(){
		$daily_attendance_id =  $this->input->post('daily_attendance_id');
		$present =  $this->input->post('present');
		$absent =  $this->input->post('absent');
		$leave =  $this->input->post('leave');
		$sick =  $this->input->post('sick');
		$total =  $this->input->post('total');
		
		$query="UPDATE `daily_attendances` SET 
					`present`='".$present."',
					`absent`='".$absent."',
					`leave`='".$leave."',
					`sick`='".$sick."',
					`total`='".$total."'
					WHERE `daily_attendance_id` = '".$daily_attendance_id."'";
		$this->db->query($query);
		redirect("attendance/");
		
		}
		
	public function attendance_dashboard(){
		
		$query = "SELECT `session_id` FROM `session` WHERE  `session`.`active` = 1";
		$query_result = $this->db->query($query);
		$session = $query_result->result()[0];
		$current_session = $session->session_id;
		$this->data['current_session'] = $current_session;
		
			$query='SELECT SUM(`present`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			$this->data['today_present'] = $query_result->result()[0]->total;
			
			$query='SELECT SUM(`absent`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			$this->data['today_absent'] = $query_result->result()[0]->total;
			
			
			
			/*$query='SELECT SUM(`total`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			$this->data['total'] $query_result->result()[0]->total;*/
			
			
			//get over all daily attendance ...
			$query="SELECT 
			  `created_date` AS `date`,
			  SUM(`absent`) AS total_absents,
			  SUM(`present`) AS total_present,
			   SUM(`total`) AS total
			FROM
			  `daily_attendances` 
			WHERE `session_id` ='".$current_session."'
			GROUP BY DATE(`created_date`);";
			$query_result = $this->db->query($query);
			$this->data['over_all_daily_attendance'] = $query_result->result();
			
			
			
			
			$class_section_daily_attendance = array();
			$query ="SELECT
						DISTINCT `classes`.`Class_title`, `classes`.`class_id`
					FROM					`classes` 
					WHERE `classes`.`class_id` IN (2,3,4,5,6) ORDER BY `classes`.`class_id` DESC";
		
		$result = $this->db->query($query);
		$classes = $result->result();
		//var_dump($classes);
		
		foreach($classes as $classe){
			$query = "SELECT
							`sections`.`section_title`
							, `sections`.`color`
							, `sections`.`section_id`
						FROM
						`sections`,
						`class_sections` 
						WHERE `sections`.`section_id` = `class_sections`.`section_id`
						AND  `class_sections`.`status`=1
						AND `class_sections`.`class_id` =".$classe->class_id;
						
			$result = $this->db->query($query);
			$sections = $result->result();	
			foreach($sections as $section){
				$query="SELECT 
				  `created_date` AS `date`,
				  SUM(`absent`) AS total_absents,
				  SUM(`present`) AS total_present,
				   SUM(`total`) AS total
				FROM
				  `daily_attendances` 
				WHERE `session_id` ='".$current_session."'
				AND `class_id` ='".$classe->class_id."'
				AND `section_id` ='".$section->section_id."'
				GROUP BY DATE(`created_date`);";
				$query_result = $this->db->query($query);
				$class_section_daily_attendance[$classe->Class_title." ".$section->section_title]= $query_result->result();
				
				}
					
			}
			
			
			
			$query="SELECT
						ROUND(AVG(`daily_attendances`.`absent`), 1) AS absent_avg
						, `classes`.`Class_title`
						, `sections`.`section_title`
						, `classes`.`class_id`
						, `sections`.`section_id`
					FROM
					`classes`,
					`daily_attendances`,
					`sections` 
					WHERE `classes`.`class_id` = `daily_attendances`.`class_id`
					AND `session_id` ='".$current_session."'
					AND `sections`.`section_id` = `daily_attendances`.`section_id`
					GROUP BY `classes`.`Class_title`, `sections`.`section_title`
					ORDER BY absent_avg DESC";
			$result = $this->db->query($query);
			$avg_attendances = $result->result();		
			$this->data["avg_attendances"] = $avg_attendances;
			//var_dump($class_section_daily_attendance);
			$this->data["class_section_daily_attendance"] = $class_section_daily_attendance;
			$this->data["view"] = PUBLIC_DIR."attendance/attendance_dashboard";
			$this->load->view(PUBLIC_DIR."layout", $this->data);
		
		}	
    
	
}        
