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
	font-family: Verdana, Geneva, sans-serif !important;
	
}

thead {
  font-weight:bold;
}

table, th, td {
    border: 1px solid black;
	height:17px;
}
      </style>
        
        
        <?php 
		$count=0;
		
		foreach($class_sections as $class_section){
		  
		?>
        
        <table id="example" class="table table-border" cellspacing="0" width="23%" style="float:left; font-size:11px">
      
          <thead>
          <tr><td colspan="3"> Class <?php echo $class[0]->Class_title; ?> - Section <strong><?php echo $class_section->section_title; ?></strong></td>
          <td>T-M: (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
          </tr>
          <tr><td colspan="4">Subject</td></tr>
            <tr><td colspan="4">Teacher Name</td></tr>
            <tr>
              <th width="5">#</th>
               <th width="5">Ad. No</th>
              <!-- <th width="5">Roll No</th>-->
              <th width="150">Student Name</th>
              <th>Marks</th>
            </tr>
            
          </thead>
          <tbody>
          <?php 
          $roll_no =101;
          foreach($class_section->students as $student){ ?>
          <tr>
             
          <td><?php echo $student->student_class_no; ?></td>
           <td><?php echo $student->student_admission_no; ?></td>
          
          <!--<td><?php echo  $class[0]->roll_pre_code."".$roll_no++;  ?></td>-->
          <td><?php echo str_replace("Muhammad", "M.", $student->student_name); ?></td>
          <td></td>
          </tr>
          <?php } ?>

<tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>

<tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>

<tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>

<tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>


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