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
        <h1><?php echo $students[0]->Class_title." (".$students[0]->section_title.")"; ?> <span style="font-size:12px !important"> <?php echo "Subject ".$class_subject." Marks"; ?></span>
         
        </h1>
		
        
       
        <table id="example" class="table table-border" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>S/No</th>
              <th>Class No</th>
              <th>Student Name</th>
              <th>Marks</th>
            </tr>
          </thead>
          <tbody>
            <?php 
			  $count=1;
			  foreach($students as $student): ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $student->student_class_no; ?></td>
              <td><?php echo $student->student_name; ?></td>
              <td><?php echo $student->obtain_mark; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p style="text-align:center"><span style="font-size:9px !important; "><?php echo $exam->year." ".$exam->term." Term "." Exam"; ?></span></p>
      </section>
    </div>

  </div>
</div>
</div>
<!-- /MESSENGER -->
</div>
</body>
</html>
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> 
<script>
$(document).ready(function(){
  $('#example').DataTable({
                "bPaginate": false,
				 dom: 'Bfrtip',
        buttons: [
            'print'
        ]
            });
});
</script>