<!-- PAGE HEADER-->

<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
</head>
<body>

<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row" style='font-size:15px !important; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;'> 
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="container"> 
     
      <section>
        <style>
table {
    border-collapse: collapse;
}

thead {
  font-weight:bold;
}

table, th, td {
    border: 1px solid black;
}
      </style>
        <h1>Class <?php echo $students[0]->Class_title; ?>  (<?php echo $exam->year." ".$exam->term." "." Exam"; ?>) Results
       (GCMHS boys Chitral)  
        </h1>
		
        
            <?php 
			  $count=1;
			  $column_one="";
			  $column_two="";
			  foreach($students as $student):
			      
			      //var_dump($student);
			  
			  $column_one.='<tr><td>'.$count++.'</td>
              <td>'.$student->student_class_no.'</td>
              <td>'.str_ireplace("Muhammad", "M.", $student->student_name).'</td>
              <td style="background-color:'.$student->color.'">'.$student->section_title.'</td>
              <td>'.$student->obtain_marks.'</td>
              <td>'.$student->total_marks.'</td>
              <td>'.$student->percentage.'</td><td><em>';
			  
			  if($student->percentage>=33){
				  $passed++;
				  $column_one.="<strong>Passed</strong>";
	/*	$query="INSERT INTO `student_section_history`(`student_id`, `section_id`, `class_id`, `student_class_no`, `exam_id`) 
			   		   VALUES ('".$student->student_id."','".$student->section_id."', '".$student->class_id."', '".$student->student_class_no."', '6')";
			   $this->db->query($query);
			   
			$query="UPDATE `students` SET `class_id`='2' WHERE `student_id`='".$student->student_id."'";
			$this->db->query($query); */
				  
				  }else{
					 if($student->percentage>10){
						 $promoted++;
						 $column_one.="<strong>Promoted</strong>";
		/*	$query="INSERT INTO `student_section_history`(`student_id`, `section_id`, `class_id`, `student_class_no`, `exam_id`) 
			   		   VALUES ('".$student->student_id."','".$student->section_id."', '".$student->class_id."', '".$student->student_class_no."', '6')";
			   $this->db->query($query);
			   
			$query="UPDATE `students` SET `class_id`='2' WHERE `student_id`='".$student->student_id."'";
			$this->db->query($query); */
						 
						 }else{
							 $fail++;
							$column_one.="Failed"; 
							 } 
					  
					  }
			  
			  
              $column_one.='</em></td>';
			  
			  
			  ?>
              <?php endforeach; ?>
              <table id="example" class="table table-border" cellspacing="0" width="100%" >
          <thead>
            <tr>
              <th>S/No</th>
              <th>Class No</th>
              <th>Student Name</th>
              <th>Section</th>
              <th>Marks</th>
              <th>Total Marks</th>
              <th>%</th>
              <td>Remarks</td>
            </tr>
          </thead>
          <tbody>
              
            
             <?php echo $column_one; ?>
          
            
          </tbody>
        </table>
        
             
       <br />
       <table class="table table-border" cellspacing="0" width="48%" style="text-align:center !important; float:left">
       <tr>
       <th>Total Students</th>
       <th>Passed </th>
        <th>Promoted</th>
        <th>Failed</th>
       
       </tr>
       <tr>
      
       
       <td><?php echo count($students); ?></td>
        <td><?php echo $passed; ?></td>
        <td><?php echo $promoted; ?></td>
        <td><?php echo $fail; ?></td>
       
       
       </tr>
       </table>
       
        <table class="table table-border" cellspacing="0" width="48%" style="text-align:center !important; float:right;">
       <tr>
       <th>Total Students %</th>
       <th>Passed %</th>
        <th>Promoted %</th>
       <th>Failed %</th>
       
       </tr>
       <tr>
       
       <td>100%</td>
       <td><?php echo round(( $passed*100)/count($students),2); ?> %</td>
       <td><?php echo round(( $promoted*100)/count($students),2); ?> %</td>
       <td><?php echo round(( $fail*100)/count($students),2); ?> %</td>
       </tr>
       </table>
        
        <p style="text-align:center"><span style="font-size:9px !important; "><?php echo $exam->year." ".$exam->term; ?></span></p>
      </section>
    </div>

  </div>
</div>
</div>
<!-- /MESSENGER -->
</div>
</body>
</html>
