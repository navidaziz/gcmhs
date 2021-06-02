
        <?php 
	
			 $table="";
			 $class_no_one=1;
			  foreach($students as $student): 
      /* if($student->percentage>18.5){
		    $query="INSERT INTO `student_section_history`(`student_id`, `section_id`, `exam_id`) 
			   		   VALUES ('".$student->student_id."','".$student->section_id."','".$exam_id."')";
			   $this->db->query($query);
			   
			   
			   $query="UPDATE `students` SET 
			   `students`.`class_id` = '2', 
			  `student_class_no` = '".$class_no_one."', `section_id` = '1' WHERE `student_id` = ".$student->student_id;
			  $this->db->query($query);
		}*/
			   
		
		
		
		
			  $table.='<tr><td>'.$class_no_one++.'</td>
              <td>'.$student->student_class_no.'</td>
              <th></th>
              <td>'.str_ireplace("Muhammad", "M.", $student->student_name).'</td>
			  <td>'.$student->section_title.' '.$student->section_id.'</td>
			  <td style="background-color:'.$student->color.'">'.$student->section_title.'</td>
              <td>'.$student->obtain_marks.'</td>
              <td>'.$student->total_marks.'</td>
              <td>'.$student->percentage.'</td>
              <td>'.$student->pass_fail_status.'</td></tr>';
			  
			  ?>
        <?php 
		$count++;
		endforeach; 
		
		echo "<table>";
		echo $table ;
		echo "</table>";
		?>
    