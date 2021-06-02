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
       <h1>Class Wise Topers </h1>
		
        <?php foreach($classes as $class){ ?>
        <div class="col-md-3">
        <h1><?php echo $class->Class_title; ?></h1>
            <h5>Top Three Student</h5>
            <table class="table table-bordered">
            <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>%</th>
            </tr>
            <?php 
			$count =1;
			foreach($class->top_three as $top_three_student){ ?>
			<tr >
            <td><?php echo $count++; ?></td>
            <td><?php echo $top_three_student->student_name; ?></td>
            <td style="background-color:<?php echo $top_three_student->color; ?>"><?php echo $top_three_student->Class_title; ?> (<?php echo $top_three_student->section_title; ?>)</td>
            <td><?php echo $top_three_student->percentage; ?></td>
            </tr>
            <tr>
            <td>
            <?php foreach($class->sections as $section_name => $section_top_threes){ ?>7
 <h1><?php echo $section_name; ?></h1>
            <h5>Top Three Student</h5>
            <table class="table table-bordered">
            <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>%</th>
            </tr>
            <?php 
			$count_2 =1;
			foreach($section_top_threes as $section_top_three){ ?>
			<tr >
            <td><?php echo $count_2++; ?></td>
            <td><?php echo $section_top_three->student_name; ?></td>
            <td style="background-color:<?php echo $section_top_three->color; ?>"><?php echo $section_top_three->Class_title; ?> (<?php echo $section_top_three->section_title; ?>)</td>
            <td><?php echo $section_top_three->percentage; ?></td>
            </tr>
            
            
			<?php } ?>
            </table>
          
<?php } ?>
            
            
            
            </td>
            </tr>
            
            
            
            
			<?php } ?>
            </table>
            </div>
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
