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
            <h5>Detailed Marks Certificate</h5>
            <table class="table table-bordered">
              <tr>
                <th colspan="2">
                  Session:
                  <strong><?php
                          $query = "SELECT * FROM session 
                            WHERE session_id = (SELECT session_id FROM exams WHERE exam_id = '" . $exam_id . "')";
                          $session = $this->db->query($query)->row();
                          echo $session->session;
                          ?>
                  </strong>
                </th>
                <?php
                echo $query = "SELECT * FROM exams 
                WHERE exams.session_id = (SELECT session_id FROM exams WHERE exam_id = '" . $exam_id . "') 
                AND exams.show = '1'
                ORDER BY exam_id ASC";
                $session_exams = $this->db->query($query)->result();
                $exams_ids = "";
                foreach ($session_exams as $session_exam) {
                  $exams_ids[] = $session_exam->exam_id;
                ?>
                  <th style="text-align: center;" colspan="2">
                    <?php
                    echo $session_exam->term; ?>
                  </th>

                <? } ?>
                <th rowspan="2" style="vertical-align: middle;">AVG.</th>
              </tr>
              <tr>
                <th>#</th>
                <th>Subjects</th>
                <?php foreach ($session_exams as $session_exam) { ?>
                  <th style="text-align: center;">Marks</th>
                  <th style="text-align: center;">Percentage</th>
                <?php } ?>

              </tr>

              <?php
              $subject_count = 1;
              foreach ($class_subjects as $class_subject) {
              ?>
                <tr>
                  <th style="width: 30px;"><?php echo $subject_count++; ?></th>
                  <th><?php echo $class_subject->subject_title; ?> </th>
                  <?php
                  $subject_percentage = 0;
                  $exam_count = 0;
                  foreach ($session_exams as $session_exam) {  ?>
                    <?php
                    $query = "SELECT
                  `obtain_mark`, `percentage`, `total_marks`
                  FROM
                  `students_exams_subjects_marks`
                  WHERE `students_exams_subjects_marks`.`student_id` = '" . $student->student_id . "'
                  AND `students_exams_subjects_marks`.`exam_id` = '" . $session_exam->exam_id . "'
                  AND `students_exams_subjects_marks`.`class_subjec_id` = '" . $class_subject->class_subject_id . "'
                  ORDER BY exam_id ASC
                  ";

                    $student_result = $this->db->query($query)->row();
                    if ($student_result) {
                      $exam_count++;
                    ?>
                      <td style="text-align: center; width:80px">
                        <?php echo "<strong>" . $student_result->obtain_mark . "</strong>"; ?>
                        / <?php echo $student_result->total_marks; ?>
                      </td>
                      <td style="text-align: center; width:80px">
                        <?php
                        echo $student_result->percentage;
                        $subject_percentage += $student_result->percentage;

                        $session_exam->subject_total_marks += $student_result->total_marks;
                        $session_exam->subject_obtain_marks += $student_result->obtain_mark;
                        ?> %
                      </td>
                    <?php } else { ?>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;"></td>
                    <?php } ?>
                  <?php } ?>
                  <th style="text-align: center;"><?php echo round(($subject_percentage / $exam_count), 1); ?></th>
                </tr>
              <?php }  ?>
              <tr>
                <th style="text-align: right;" colspan="2">Total</th>
                <?php
                $total_percentage = 0;
                foreach ($session_exams as $session_exam) { ?>
                  <th style="text-align: center;">
                    <?php echo $session_exam->subject_obtain_marks; ?>
                    <?php
                    if ($session_exam->subject_total_marks) {
                      echo " / " . $session_exam->subject_total_marks;
                    }
                    ?>
                  </th>
                  <th style="text-align: center;">
                    <?php $percentage = round((($session_exam->subject_obtain_marks * 100) / $session_exam->subject_total_marks), 1);
                    if ($percentage) {
                      $total_percentage += $percentage;
                      echo $percentage . " %";
                    }
                    ?>
                  </th>
                <?php } ?>
                <th style="font-size: 15px !important;"><?php
                                                        $avg_percentage = round(($total_percentage / $exam_count), 1);
                                                        echo round(($avg_percentage), 1); ?></th>

              </tr>


            </table>
            <h5 style="margin-left: 10px; color:black"> Observartions</h5>
            <div style="border: 1px solid gray;  width:100%; border-radius: 9px;">

              <table class="table">
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
                  </td>
                  <td>
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
                  </td>
                  <td rowspan="2" style="width: 200px;">
                    <p>
                      <strong>Grading</strong><br />
                      <small style="font-size: 8px;">

                        <?php if ($avg_percentage >= 70) { ?>
                          <strong style="font-size: 12px;">
                            70 % and Above<span style="margin-left: 20px;"></span> Excellent<br />
                          </strong>
                        <? } else { ?>
                          70 % and Above<span style="margin-left: 20px;"></span> Excellent<br />
                        <?php } ?>
                        <?php if ($avg_percentage >= 60 and $avg_percentage <= 69.9) { ?>
                          <strong style="font-size: 12px;">
                            60-69 % <span style="margin-left: 23px;"></span> V.Good <br />
                          </strong>
                        <?php } else { ?>
                          60-69 % <span style="margin-left: 23px;"></span> V.Good <br />
                        <?php } ?>
                        <?php if ($avg_percentage >= 50 and $avg_percentage <= 59.9) { ?>
                          <strong style="font-size: 12px;">
                            50-59 % <span style="margin-left: 23px;"></span> Good <br />
                          </strong>
                        <?php } else { ?>
                          50-59 % <span style="margin-left: 23px;"></span> Good <br />
                        <?php } ?>
                        <?php if ($avg_percentage >= 40 and $avg_percentage <= 49.9) { ?>
                          <strong style="font-size: 12px;">
                            40-49 % <span style="margin-left: 23px;"></span> Fair <br />
                          </strong>
                        <?php } else { ?>
                          40-49 % <span style="margin-left: 23px;"></span> Fair <br />
                        <?php } ?>
                        <?php if ($avg_percentage >= 33 and $avg_percentage <= 39.9) { ?>
                          <strong style="font-size: 12px;">
                            33-39 % <span style="margin-left: 23px;"></span> Satisfactory <br />
                          </strong>
                        <?php } else { ?>
                          33-39 % <span style="margin-left: 23px;"></span> Satisfactory <br />
                        <?php } ?>

                        <?php if ($avg_percentage < 33) { ?>
                          <strong style="font-size: 11px;">
                            Below 33 % <span style="margin-left: 7px;"></span> Poor & required special attention
                          </strong>
                        <? } else { ?>
                          Below 33 % <span style="margin-left: 7px;"></span> Poor & required special attention
                        <?php } ?>

                      </small>
                    </p>
                    <div style="text-align: center;">
                      <br />
                      <br />
                      <img style="width: 100px;" src="<?php echo site_url("assets/signature.png") ?>" />
                      <br />
                      <strong>Principal </strong><br /><small>GCMHS Boys Chitral</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="">
                    Teacher Remarks:
                    ..................................................................................................................................
                    ..................................................................................................................................
                    ..................................................................................................................................
                    ..................................................................................................................................
                    <br />
                    <br />
                    Guardian Remarks:
                    ..................................................................................................................................
                    ..................................................................................................................................
                    ..................................................................................................................................
                    ..................................................................................................................................

                  </td>


                </tr>
              </table>

            </div>





            <div>
              <br />

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