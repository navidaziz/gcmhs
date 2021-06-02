<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
</head>
<body>

<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row" style="font-size:12px !important; font-family: Open Sans !important"> 
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
      
      
      <table width="95%" style="font-size:15px; padding 5px; margin:5px;">
          
          <th>Class 8th</th>
           <th>School Name:________________ </th>
            <th>School Type:_______________ </th>
             <th>School EMIS:______________ </th>
              <th>Tehisl/District: CHITRAL </th>
              </H4>
       </table>
      
		
        
       
        <table id="example" class="table table-border" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Roll No</th>
              <th>Student Name</th>
              <th>Father Name</th>
              <th>DateoBirth</th>
              <?php  
			  
			  $total_subject_marks =0;
			  foreach($class_subjects as $class_subject){?>
              <th><?php 
			  
			  echo substr($class_subject->subject_title,0, 7); ?> (<?php 
			  $total_subject_marks+=$class_subject->marks;
			  echo "&nbsp;&nbsp;&nbsp;";
			  //echo $class_subject->marks; ?>)</th>
              <?php } ?>
             <th>Total (&nbsp;&nbsp;&nbsp;)</th>
              <th>%tage</th>
            </tr>
          </thead>
          <tbody>
            <?php 
			  $count=1;
			  foreach($students as $student): ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $student->student_class_no; ?></td>
              <td><?php //echo $student->student_name; ?></td>
              <td></td>
              <td></td>
               <td></td>
              <td></td>
             <?php  
			 $grant_total = 0;
			 foreach($class_subjects as $class_subject){?>
             <td><?php  
			 $grant_total+=$student->subjects[$class_subject->class_subject_id]['passing_mark'];
			 //echo $student->subjects[$class_subject->class_subject_id]['passing_mark']; ?></td>
             
              <?php } ?>
             <!-- <td><?php echo $grant_total; ?></td>
              <td><?php echo round((($grant_total*100)/$total_subject_marks),2); ?></td>-->
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
       
      </section>
    </div>

  </div>
</div>
</div>
<!-- /MESSENGER -->
</div>
</body>
</html>
