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
	padding:10px;
}
      </style>
        <h1>GCMHS Boys Chitral</h1>
		<h2><?php echo $exam->year." ".$exam->term; ?>, <br /> Top Ten Students List</h2>
        <div class="col-md-3">
          <h2>
            <table class="table table-bordered">
            <tr>
            <th>#</th>
            <th>Add. No</th>
            <th>Student Name</th>
            <th>Class</th>
             <th>Obtain Marks</th>
              <th>Total Marks</th>
            <th>%</th>
            </tr>
            <?php 
			$count =1;
			foreach($top_ten_students as $top_ten_student){ ?>
			<tr >
            <td><?php echo $count++; ?></td>
            <td>
                <?php
                $query="SELECT `student_admission_no` FROM `students` WHERE `student_id`='".$top_ten_student->student_id."'";
                $query_result = $this->db->query($query);
                $student_admission_no = $query_result->result()[0]->student_admission_no;
                echo $student_admission_no;
                ?>
                
            </td>
            <td><?php echo $top_ten_student->student_name; ?></td>
            <td style="background-color:<?php echo $top_ten_student->color; ?>"><?php echo $top_ten_student->Class_title; ?> (<?php echo $top_ten_student->section_title; ?>)</td>
            
             <td><?php echo $top_ten_student->obtain_marks; ?></td>
              <td><?php echo $top_ten_student->total_marks; ?></td>
            <td><?php echo $top_ten_student->percentage; ?></td>
            </tr>
			<?php } ?>
            </table>
            </h2>
            </div>
      </section>
    </div>
  </div>
</div>
</div>
<!-- /MESSENGER -->
</div>
</body>
</html>