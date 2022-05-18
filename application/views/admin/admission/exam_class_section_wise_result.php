<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<!-- JQUERY -->
<script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>

<!-- BOOTSTRAP -->
<script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

<head>
  <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

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

          <style>
            .table_small>tbody>tr>td,
            .table_small>tbody>tr>th,
            .table_small>tfoot>tr>td,
            .table_small>tfoot>tr>th,
            .table_small>thead>tr>td,
            .table_small>thead>tr>th {
              padding: 2px;
              line-height: 1.42857143;
              vertical-align: top;
              border-top: 1px solid #ddd;
            }
          </style>

          <table id="example" class="tab le table -border table_small" cellspacing="0" width="100%" style="font-size:12px !important">

            <thead>
              <tr>
                <td colspan="<?php echo count($class_subjects) + 13; ?>">
                  <h1 style="text-align:center;">
                    Government Centennial Model High Schools Boys Chitral <br />
                    Class <?php echo $class_name; ?>
                    <span style="margin-left: 10px; margin-right:10px">--</span> <?php echo $exam->term . " " . $exam->year  ?> Award List
                    <span style="margin-left: 10px; margin-right:10px">--</span> Date: <?php echo date('d M, Y', strtotime($exam->exam_data));  ?>

                  </h1>
                </td>
              </tr>
              <tr>
                <th>#</th>
                <th>Cla.#</th>
                <th>Add.#</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>DOB</th>
                <th>Age</th>
                <th>Section</th>
                <th>Status</th>
                <?php
                $promoted = 0;
                $passed = 0;
                $fail = 0;
                $total_subject_marks = 0;
                foreach ($class_subjects as $class_subject) { ?>
                  <th style="width: 50px;"><?php

                                            echo substr($class_subject->short_title, 0, 10); ?> </th>
                <?php } ?>
                <th>Obtain M.</th>
                <th>Total M.</th>
                <th>Per%</th>
                <th style="width:100px">Remarks</th>
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
                  <td><?php echo $student->student_father_name; ?></td>
                  <td><?php echo date("d M, Y", strtotime($student->student_data_of_birth)); ?></td>
                  <td><?php

                      $date = new DateTime($student->student_data_of_birth);
                      $now = new DateTime();
                      $interval = $now->diff($date);
                      echo  $interval->y;
                      ?></td>
                  <td>
                    <?php echo $student->section_title; ?>
                  </td>
                  <td><?php if ($student->status == 2) { ?> Struck Off <?php } ?>
                    <?php if ($student->status == 0) { ?> Deleted <?php } ?>
                    <?php if ($student->status == 3) { ?> Withdraw <?php } ?>
                  </td>
                  <?php
                  $total_obtain_marks = 0;
                  $subject_total = 0;
                  foreach ($class_subjects as $class_subject) {
                    $subject_total = $subject_total + 100;
                  ?>
                    <td style="text-align:center; <?php if (
                                                    $student->subjects[$class_subject->class_subject_id]['passing_mark'] == 'M' ||
                                                    $student->subjects[$class_subject->class_subject_id]['passing_mark'] == 'A'
                                                  ) {
                                                  ?> ; font-style:oblique; font-weight:bold; 
                        <?php } ?>">



                      <span <?php
                            if ($student->subjects[$class_subject->class_subject_id]['marks']->percentage <= 32) {
                            ?> style="color:red;" <?php } ?>>

                        <?php
                        $total_obtain_marks += $student->subjects[$class_subject->class_subject_id]['marks']->percentage;
                        if ($student->subjects[$class_subject->class_subject_id]['marks']->obtain_mark > 0) {

                          echo round($student->subjects[$class_subject->class_subject_id]['marks']->percentage, 1);
                        } else {
                          if ($student->subjects[$class_subject->class_subject_id]['marks']->obtain_mark == 'A') {
                            echo
                            '<span style="  color: red; display: inline-block;
                          width: 12px;
                          min-height: 10px;
                          padding: 2px;
                          color: red;
                          line-height: 1;
                          vertical-align: baseline;
                          white-space: nowrap;
                          text-align: center;
                          border:1px solid red;
                          border-radius: 10px;" >' . $student->subjects[$class_subject->class_subject_id]['marks']->obtain_mark . '</span>';
                          }
                        } ?>


                      </span>

                    </td>

                  <?php } ?>

                  <td style="text-align: center;"><strong><?php echo round($total_obtain_marks, 1); ?><strong></td>
                  <td style="text-align: center;"> <?php echo $subject_total; ?></td>
                  <td style="text-align: center;"><strong><?php echo $percentage = round((($total_obtain_marks * 100) / $subject_total), 2) . "%"; ?><strong></td>
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