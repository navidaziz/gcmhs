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
	margin:5px;
	margin-left:10px;
}

thead {
  font-weight:bold;
}

table, th, td {
    border: 1px solid black;
}
      </style>
        
        <?php 
			  $count=1;
			  $column_one="";
			  $column_two="";
			  $class_no_one=1;
			   $class_no_two=1;
			    $class_no_three=1;
			  	  $column_three="";
			  foreach($students as $student): ?>
        <?php if($count<=30){ 
			  $column_one.='<td>'.$class_no_one++.'</td>
              <!--<td>'.$student->student_class_no.'</td>-->
              <th></th>
              <td>'.str_ireplace("Muhammad", "M.", $student->student_name).'</td>
			  <td></td>
			  
              <!--<td style="background-color:'.$student->color.'">'.$student->section_title.'</td>
              <td>'.$student->obtain_marks.'</td>
              <td>'.$student->total_marks.'</td>
              <td>'.$student->percentage.'</td>
              <td>'.$student->pass_fail_status.'</td>--></tr>';
			  }
			  if($count>30 and $count<=60){ 
			  $column_two.='<td>'.$class_no_two++.'</td>
              <!--<td>'.$student->student_class_no.'</td>-->
              <th></th>
              <td>'.str_ireplace("Muhammad", "M.", $student->student_name).'</td>
			  <td></td>
              <!--<td style="background-color:'.$student->color.'">'.$student->section_title.'</td>
              <td>'.$student->obtain_marks.'</td>
              <td>'.$student->total_marks.'</td>
              <td>'.$student->percentage.'</td>
              <td>'.$student->pass_fail_status.'</td>--></tr>';
			  }
			  
			  
			   if($count>60){ 
			  $column_three.='<td>'.$class_no_three++.'</td>
              <!--<td>'.$student->student_class_no.'</td>-->
			  <th></th>
              <td>'.str_ireplace("Muhammad", "M.", $student->student_name).'</td>
			  <td></td>
              <!--<td style="background-color:'.$student->color.'">'.$student->section_title.'</td>
              <td>'.$student->obtain_marks.'</td>
              <td>'.$student->total_marks.'</td>
              <td>'.$student->percentage.'</td>
              <td>'.$student->pass_fail_status.'</td>--></tr>';
			  }
			  
			  ?>
        <?php 
		$count++;
		endforeach; ?>
        <table id="example" class="table table-border" cellspacing="0" width="32%" style="float:left;">
      
          <thead>
          <tr><td colspan="4"> Class <?php echo $students[0]->Class_title; ?> - Section <strong>Green</strong></td></tr>
            <tr>
              <th width="5">S/No</th>
              <th width="50">Adm No</th>
              <th width="150">Student Name</th>
              <th>Father Name</th>
            </tr>
          </thead>
          <tbody>
            <?php echo $column_one; ?>
          </tbody>
        </table>
        <table id="example" class="table table-border" cellspacing="0" width="32%" style="float:left;">
       
          <thead>
          <tr><td colspan="4"> Class <?php echo $students[0]->Class_title; ?> - Section <strong>Blue</strong></td></tr>
            <tr>
              <th width="5">S/No</th>
              <th width="50">Adm No</th>
              <th width="150">Student Name</th>
              <th>Father Name</th>
            </tr>
          </thead>
          <tbody>
            <?php echo $column_two; ?>
          </tbody>
        </table>
        <table id="example" class="table table-border" cellspacing="0" width="32%" style="float:left;">
        
          <thead>
          <tr><td colspan="4"> Class <?php echo $students[0]->Class_title; ?> - Section <strong>Blue</strong></td></tr>
            <tr>
              <th width="5">S/No</th>
              <th width="50">Adm No</th>
              <th width="150">Student Name</th>
              <th>Father Name</th>
            </tr>
          </thead>
          <tbody>
            <?php echo $column_three; ?>
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