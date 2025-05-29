<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<!-- JQUERY -->
<script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>

<!-- BOOTSTRAP -->
<script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

<head>
</head>

<body>

  <!-- /PAGE HEADER -->

  <!-- PAGE MAIN CONTENT -->
  <div class="row" style='font-size:12px !important; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif; '>
    <!-- MESSENGER -->
    <div class="col-md-12">
      <div class="container">

        <section>
          <style>
            table {
              border-collapse: collapse;
            }

            thead {
              font-weight: bold;
            }

            table,
            th,
            td {
              border: 1px solid black;
            }

            @media print {
              * {
                color: black;
                background: white;
                !important;
                font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
              }

              table {
                font-size: 80%;
              }

              table {
                border-collapse: collapse;
              }

              thead {
                font-weight: bold;
              }

              table,
              th,
              td {
                border: 1px solid black;
              }

            }
          </style>





          <script>
            document.title = "Award List Class <?php echo $class_name; ?> (<?php echo $section_title; ?>)   <?php echo $exam->term . " " . $exam->year  ?>";
          </script>



          <table id="example" class="table table-border" cellspacing="0" width="100%" style="font-size:12 !important">

            <thead>
              <tr>
                <td colspan="17">
                  <h1 style="text-align:center;">

                    Award List Class <?php echo $class_name; ?> (<?php echo $section_title; ?>) <?php echo $exam->term . " " . $exam->year  ?>
                  </h1>
                </td>
              </tr>
              <tr>
                <th>#</th>
                <th>C/No</th>
                <th>Add. #</th>
                <th>Student Name</th>
                <?php
                $promoted = 0;
                $passed = 0;
                $fail = 0;
                $total_subject_marks = 0;
                foreach ($class_subjects as $class_subject) { ?>
                  <th><?php echo substr($class_subject->short_title, 0, 7); ?></th>
                <?php } ?>
                <th>Obtain Marks</th>
                <th>%</th>
                <td>Remarks</td>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              foreach ($students as $student) :

              ?>
                <tr>
                  <td><?php //echo $count++; 
                      ?></td>
                  <td><?php echo $student->student_class_no; ?></td>
                  <td><?php echo $student->student_admission_no; ?></td>
                  <td><?php echo $student->student_name; ?></td>
                  <?php
                  $grant_total = 0;
                  foreach ($class_subjects as $class_subject) { ?>
                    <td <?php if ($student->subjects[$class_subject->class_subject_id]['passing_mark'] == 'M' || $student->subjects[$class_subject->class_subject_id]['passing_mark'] == 'A') { ?> style="text-align:center; font-style:oblique; font-weight:bold;
             
             
             
             " <?php } ?>>



                      <span <?php


                            if ($student->subjects[$class_subject->class_subject_id]['passing_mark'] > $student->subjects[$class_subject->class_subject_id]['total_marks']) { ?> style="color:red;" <?php } ?>>

                        <?php
                        $grant_total += $student->subjects[$class_subject->class_subject_id]['passing_mark'];
                        echo $student->subjects[$class_subject->class_subject_id]['percentage']; ?>


                      </span>

                    </td>

                  <?php } ?>
                  <td><?php echo $grant_total; ?></td>
                  <td><?php echo $percentage = round((($grant_total * 100) / $total_subject_marks), 2); ?></td>
                  <td>
                    <em> <?php
                          if ($percentage >= 33) {
                            $passed++;
                            // echo "<strong>Passed</strong>";
                          } else {
                            if ($percentage > 10) {
                              $promoted++;
                              //	echo "<strong>Promoted</strong>";
                            } else {
                              $fail++;
                              //	echo "Failed"; 
                            }
                          }
                          ?></em>

                  </td>
                </tr>
              <?php endforeach; ?>




            </tbody>

          </table>
          <br />

          <!--<table class="table table-border" cellspacing="0" width="48%" style="text-align:center !important; float:left">
       <tr>
       <th>Total Students</th>
       <th>Passed (33%) </th>
        <th>Promoted</th>
        <th>Failed</th>
       
       </tr>
       <tr>
      
       
       <td><?php echo count($students); ?></td>
        <td><?php echo $passed; ?></td>
        <td><?php echo $promoted; ?></td>
        <td><?php echo $fail; ?></td>
       
       
       </tr>
       </table> -->





          <!--<table class="table table-border" cellspacing="0" width="48%" style="text-align:center !important; float:right;">
       <tr>
       <th>Total Students %</th>
       <th>Passed % (33%)</th>
        <th>Promoted %</th>
       <th>Failed %</th>
       
       </tr>
       <tr>
       
       <td>100%</td>
       <td><?php echo round(($passed * 100) / count($students), 2); ?> %</td>
       <td><?php echo round(($promoted * 100) / count($students), 2); ?> </td>
       <td><?php echo round(($fail * 100) / count($students), 2); ?> </td>
       </tr>
       </table>-->
          <div style="clear:both"></div>
          <br />
          <br />
          <br />
          <table width="100%" style="border:0px !important">
            <tr>
              <td style="border:0px !important">
                <strong>GCMHS Boys Chitral <br />Exam Committee</strong>
              </td>
              <td style="text-align:right; border:0px !important"><strong style="margin:5px"> GCMHS Boys Chitral <br />Principal</strong></td>
            </tr>
          </table>
        </section>
      </div>

    </div>
  </div>
  </div>



  <script>
    /*$(document).ready(function(){
  $('#example').DataTable({
	   
                "bPaginate": false,
				 dom: 'Bfrtip',
        buttons: [
            'print'
        ],
		"order": [[ 0, 'asc' ]]
		
            });
});*/


    $(document).ready(function() {
      var table = $('#example').DataTable({
        "bPaginate": false,
        dom: 'Bfrtip',
        /* buttons: [
             'print'
             
             
         ],*/

        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          "targets": 0
        }],
        "order": [
          [1, 'asc']
        ]
      });


      table.on('order.dt search.dt', function() {
        table.column(0, {
          search: 'applied',
          order: 'applied'
        }).nodes().each(function(cell, i) {
          cell.innerHTML = i + 1;
          table.cell(cell).invalidate('dom');
        });
      }).draw();

    });
  </script>
  <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  <!-- /MESSENGER -->

  <style>
    .dataTables_filter,
    .dataTables_info {
      display: none;
    }

    .dt-button,
    .buttons-print {
      display: none;
    }
  </style>
  </div>
</body>

</html>