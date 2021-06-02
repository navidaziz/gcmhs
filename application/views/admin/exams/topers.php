<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
</head>
<body>

<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row" style='font-size:13px !important; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;'> 
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
        <h1> <?php echo $exam->year." ".$exam->term; ?>, Class and Section Wise Top Three Students List </h1>
        <table  style="width:100%">
          <?php foreach($classes as $class){ ?>
          
          <!-- <h5><?php echo $class->Class_title; ?></h5>-->
          
          <tr >
            <?php 
			$count =1;
			$top_student_table='<table style=" width:100%">
			 <h5>Class '.$class->Class_title.' ( Class Top Three Students)</h5>
                  <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <!--<th>Class</th>-->
                    <th>%</th>
                  </tr>';
			foreach($class->top_three as $top_three_student){ ?>
            
            <?php $top_student_table.='<tr >
              <td>'.$count++.'</td>
              <td>'.$top_three_student->student_name.'</td>
             <!-- <td style="background-color:'.$top_three_student->color.'">'.$top_three_student->Class_title.' ('.$top_three_student->section_title.')</td>-->
              <td>'.$top_three_student->percentage.'</td>
            </tr>';
			 } 
			 $top_student_table.='</table>'; ?>
            <td  style="padding:5px;" ><?php echo $top_student_table; ?></td>
            <?php foreach($class->sections as $section_name => $section_top_threes){ ?>
            <td style="padding:5px;" ><h5>Class <?php echo $class->Class_title; ?> ( <?php echo $section_name; ?> Top Three Students )</h5>
              <table class="table table-bordered" style=" width:100%">
                <tr>
                  <th>#</th>
                   <th>Add. No</th>
                  <th>Student Name</th>
                 <!-- <th>Class</th>-->
                  <th>Obtain Marks</th>
              <th>Total Marks</th>
                  <th>%</th>
                </tr>
                <?php 
			$count_2 =1;
			foreach($section_top_threes as $section_top_three){ ?>
                <tr >
                  <td><?php echo $count_2++; ?></td>
                  
                  <td>
                <?php
                $query="SELECT `student_admission_no` FROM `students` WHERE `student_id`='".$section_top_three->student_id."'";
                $query_result = $this->db->query($query);
                $student_admission_no = $query_result->result()[0]->student_admission_no;
                echo $student_admission_no;
                ?>
                
            </td>
                  
                  <td><?php echo $section_top_three->student_name; ?></td>
                 <!-- <td style="background-color:<?php echo $section_top_three->color; ?>"><?php echo $section_top_three->Class_title; ?> (<?php echo $section_top_three->section_title; ?>)</td>-->
                 
                 <td><?php echo $section_top_three->obtain_marks; ?></td>
                 <td><?php echo $section_top_three->total_marks; ?></td>
                  <td><?php echo $section_top_three->percentage; ?></td>
                </tr>
                <?php } ?>
              </table></td>
            <?php } ?>
          </tr>
          <?php } ?>
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