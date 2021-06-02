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
		foreach($class_sections as $class_section){  ?>
        <table id="example" class="table table-border" cellspacing="0" width="98%" style="float:left; font-size:11px">
          <thead>
            <tr>
              <td colspan="7"><h3> Class <?php echo $class[0]->Class_title; ?> - Section <strong><?php echo $class_section->section_title; ?></strong></h3></td>
             
            </tr>
            <tr>
              <th width="5">S/No.</th>
              <th width="150">Student Name</th>
              <th>Father Name</th>
              <th>Gardian</th>
              <th>Contact No.</th>
              <th>Village</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($class_section->students as $student){ ?>
            <tr>
              <td><?php echo $student->student_class_no; ?></td>
              <td><?php echo str_replace("Muhammad", "M.", $student->student_name); ?></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php } ?>
            <?php for($i=1; $i<=4; $i++){ ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php 
			$count++;
			} ?>
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