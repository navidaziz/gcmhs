<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
</head>
<body>

<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row"  style='font-size:12px !important; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif; '> 
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
	height:17px;
}
      </style>
        
        
        <?php foreach($class_sections as $class_section){  ?>
        
        <table id="example" class="table table-border" cellspacing="0" width="98%" >
      
          <thead>
          <tr><td colspan="8" > Class <?php echo $class[0]->Class_title; ?> - Section <strong><?php echo $class_section->section_title; ?></strong></td>
          
          </tr>
           <tr>
              <th>#</th>
              <th>C/No</th>
              <th>Student Name</th>
              <th>Marks</th>
              <th>Total Marks</th>
              <th>%</th>
              <td>Remarks</td>
              <td width="200">Committee Remarks</td>
            </tr>
          </thead>
          <tbody>
          <?php 
		  $count = 1;
		  foreach($class_section->students as $student){ ?>
         
			  
			  <tr><td><?php echo $count++ ?></td>
              <td><?php echo $student->student_class_no ?></td>
              <td><?php echo $student->student_name ?></td>
              <td><?php echo $student->obtain_marks ?></td>
              <td><?php echo $student->total_marks ?></td>
              <td><?php echo $student->percentage ?></td>
              <td><?php echo $student->pass_fail_status ?></td>
			
         <td></td>
          <?php } ?>
          </tbody>
        </table>
        
        
        <?php } ?>
        
        
        
        
      </section>
    </div>
  </div>
</div>
</div>
<!-- /MESSENGER -->
</div>
</body>
</html>


<?php exit(); ?>



