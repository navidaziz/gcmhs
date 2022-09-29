<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>DMC's</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


  <style>
    body {
      background: rgb(204, 204, 204);
    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 50%;
      /* height: 29.7cm;  */
      height: auto;
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {
      page[size="A4"] {
        width: 100%;
        /* height: 29.7cm;  */
        height: auto;
        page-break-before: always;
      }

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }



    }


    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
      border: 1px solid black;
      text-align: center;
    }
  </style>

  <style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
      /* vertical-align: middle;
      border-top: 1px solid #ddd;
      background-color: transparent !important; */
      padding: 7px !important;
      margin: 0px !important;
      font-size: 12px !important;

    }
  </style>
</head>

<body>





  <script>
    document.title = "Award List Class <?php echo $class_name; ?> (<?php echo $section_title; ?>)   <?php echo $exam->term . " " . $exam->year  ?>";
  </script>




  <?php
  $count = 1;
  foreach ($students as $student) :

  ?>

    <page size='A4' style="color: black;">
      <div class="col-md-12">
        <div class="container">
          <section>

            <h3 style="font-weight: bold; text-align:center; color:black;"> Government Centennial Model High Schools Boys Chitral </h3>
            <div style=" font-weight: bold; text-align: center; color:black"><img src="<?php echo site_url("assets/log_outline.png"); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" style="width:70px; height:70px !important;">
            </div>
            <h4 style=" font-weight: bold;text-align:center; color:black"> Class <?php echo $class_name; ?>, Section <?php echo $section_title; ?> </h4>
            <h5 style=" font-weight: bold;text-align:center; color:black"> <?php echo $exam->term . " " . $exam->year  ?>
              <span style="margin-left: 10px; margin-right:10px; color:black">--</span> Date: <?php echo date('d M, Y', strtotime($exam->exam_data));  ?>

            </h5>


            <table class="table table-bordered">
              <tr>

                <th>Class No</th>
                <th>Admission No</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Form-B</th>
                <th>Status</th>

              </tr>
              <tr>
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
                <td><?php echo $student->form_b; ?></td>
                <td><?php if ($student->status == 2) { ?> Struck Off <?php } ?>
                  <?php if ($student->status == 0) { ?> Deleted <?php } ?>
                  <?php if ($student->status == 3) { ?> Withdraw <?php } ?>
                </td>
              </tr>
            </table>

            <table style="width: 100%;">
              <tr>
                <td>
                  <h5 style="color:black"> Detailed Marks Certificate</h5>
                  <table class="table table-bordered">
                    <tr>
                      <th>#</th>
                      <th>Subjects</th>
                      <th>Total Marks</th>
                      <th>Obtained Marks</th>
                      <th>Percentage</th>

                    </tr>
                    <?php
                    $total_obtain_marks = 0;
                    $subject_total_marks = 0;
                    $subject_obtain_marks = 0;
                    //$subject_total = 0;
                    $subject_count = 1;
                    foreach ($class_subjects as $class_subject) {
                      //  $subject_total = $subject_total + 100;
                    ?>
                      <tr>
                        <th style="width: 30px;"><?php echo $subject_count++; ?></th>
                        <th><?php echo $class_subject->subject_title; ?> </th>

                        <th style="text-align: center;">
                          <?php
                          echo $student->subjects[$class_subject->class_subject_id]['marks']->total_marks;
                          $subject_total_marks += $student->subjects[$class_subject->class_subject_id]['marks']->total_marks;
                          ?>

                        </th>

                        <th style="text-align: center;">
                          <?php
                          echo $student->subjects[$class_subject->class_subject_id]['marks']->obtain_mark;
                          $subject_obtain_marks += $student->subjects[$class_subject->class_subject_id]['marks']->obtain_mark;
                          ?>

                        </th>



                        <th style="text-align:center; <?php if (
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
                                '<span style=" ">' . $student->subjects[$class_subject->class_subject_id]['marks']->obtain_mark . '</span>';
                              }
                            } ?>


                          </span>

                </td>

              </tr>

            <?php } ?>
            <tr>
              <th colspan="2" style="text-align: right;">Total Marks</th>
              <th style="text-align: center;"> <?php echo $subject_total_marks; ?></th>
              <th style="text-align: center;"> <?php echo $subject_obtain_marks; ?></th>
              <td style="text-align: center;"><strong><?php //echo round($total_obtain_marks, 1); 
                                                      ?><strong></td>

            </tr>

            <tr>
              <th colspan="2" style="text-align: right;">Percentage</th>

              <td colspan="3" style="text-align: center;"><strong><?php echo $percentage = round((($total_obtain_marks * 100) / $subject_total), 2); ?> %</strong>
                <small style="margin-left: 20px;"><i>
                    <?php
                    if ($percentage >= 70) { ?> Excellent<? } ?>
                      <?php if ($percentage >= 60 and $percentage <= 69) { ?> Very Good<? } ?>
                        <?php if ($percentage >= 50 and $percentage <= 59) { ?> Good<? } ?>
                          <?php if ($percentage >= 40 and $percentage <= 49) { ?> Fair<? } ?>
                            <?php if ($percentage >= 33 and $percentage <= 39) { ?> Satisfactory<? } ?>
                              <?php if ($percentage < 33) { ?> Poor & required special attention<? } ?>

                  </i> </small>


              </td>

            </tr>
            </table>
            </td>
            <td style="vertical-align: top;">
              <h5 style="margin-left: 10px; color:black"> Observartions</h5>
              <div style="border: 1px solid gray; padding-left:10px; margin-left:10px; width:100%; border-radius: 9px; padding-top:10px">
                <table style="width: 100%;">
                  <tr>
                    <td>

                      <strong>Behavier In Class</strong>
                      <table style="width: 100%;">
                        <tr>
                          <td>Excellent </td>
                          <td>A. ____________</td>
                        </tr>
                        <tr>
                          <td>Good </td>
                          <td>B. ____________</td>
                        </tr>
                        <tr>
                          <td>Poor </td>
                          <td>C. ____________</td>
                        </tr>
                      </table>
                      <br />

                      <strong>Attandance and Position</strong>
                      <table style="width: 100%;">
                        <tr>
                          <td>Possible Attendance: </td>
                          <td>____________</td>
                        </tr>
                        <tr>
                          <td>Student Attendance</td>
                          <td>____________</td>
                        </tr>
                        <tr>
                          <td>Position in Class:</td>
                          <td>____________</td>
                        </tr>
                      </table>
                      <br />
                      <p>
                        <strong>Grading</strong><br />
                        <small>

                          70 % and Above<span style="margin-left: 20px;"></span> Excellent<br />
                          60-69 % <span style="margin-left: 23px;"></span> V.Good <br />
                          50-59 % <span style="margin-left: 23px;"></span> Good <br />
                          40-49 % <span style="margin-left: 23px;"></span> Fair <br />
                          33-39 % <span style="margin-left: 23px;"></span> Satisfactory <br />
                          Below 33 % <span style="margin-left: 7px;"></span> Poor & required
                          special attention

                        </small>
                      </p>


                    </td>
                  </tr>
                </table>
              </div>

            </td>
            </tr>
            </table>


            <div>
              <br />
              <table style="width: 100%;">
                <tr>
                  <td>Teacher Remarks: ..............................................................................................................
                    ..............................................................................................................
                    ..............................................................................................................
                    ..............................................................................................................
                    <br />
                    <br />
                    Guardian Remarks: ..............................................................................................................
                    ..............................................................................................................
                    ..............................................................................................................
                    ..............................................................................................................
                  </td>
                  <td style="text-align: center; width:150px">
                    <img style="width: 100px;" src="<?php echo site_url("assets/signature.png") ?>" />
                    <strong>Principal </strong><br /><small>GCMHS Boys Chitral</small>
                  </td>
                </tr>
              </table>
              <p style="text-align: center; color:light-gray; margin-top:50px; margin-bottom:5px; font-size:8px">
                <small><i>Note: it's computer generated result. Errors and omissions excepted not used for legal purpose. </i></small>
              </p>
            </div>
          </section>
        </div>
      </div>
    </page>

  <?php endforeach; ?>


</body>

</html>