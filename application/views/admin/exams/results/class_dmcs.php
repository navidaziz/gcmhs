<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Detailed Marks Certificate</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      background: #ccc;
    }


    @media print {
      * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      body,
      page {
        margin: 0;
        box-shadow: none;
      }

      page {
        page-break-before: always;
      }
    }

    page {
      background: #fff;
      display: block;
      margin: 0 auto 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
      color: black;
    }

    page[size="A4"] {
      width: 100%;
      height: auto;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: none;
      }

      page {
        page-break-before: always;
      }
    }

    .table,
    .table th,
    .table td {
      border: 1px solid black;
      border-collapse: collapse;
      padding: 2px;
      font-size: 12px;
    }

    .table_small th,
    .table_small td {
      font-size: 9px;
      padding: 2px;
      border: 0.1px solid gray;
      font-weight: bold;
    }

    .fail {
      display: inline-block;
      min-width: 19px;
      padding: 2px;
      border: 1px solid black;
      border-radius: 10px;
      font-weight: bold;
      text-align: center;
    }
  </style>
</head>

<body>

  <?php foreach ($students as $student): ?>
    <page size="A4">
      <div class="container">
        <table style="width: 100%;">
          <tr>
            <td style="width: 80px;"><img src="<?php echo site_url("assets/log_outline.png"); ?>" alt="Logo" style="width:70px; height:70px;"></td>
            <td style="text-align: center;">
              <h4><strong>Government Centennial Model High School Boys Chitral</strong></h4>
              <h5><strong>Class <?php echo $class->Class_title; ?>, Section <?php echo $section->section_title; ?></strong></h5>
            </td>
          </tr>
        </table>

        <table class="table" style="width: 100%; margin-top: 10px;">
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
            <td><?php echo (new DateTime())->diff(new DateTime($student->student_data_of_birth))->y; ?></td>
            <td><?php echo $student->form_b; ?></td>
            <td>
              <?php
              switch ($student->status) {
                case 0:
                  echo "Deleted";
                  break;
                case 1:
                  echo "Admit";
                  break;
                case 2:
                  echo "Struck Off";
                  break;
                case 3:
                  echo "Withdraw";
                  break;
              }
              ?>
            </td>
          </tr>
        </table>

        <h5 style="margin-top: 15px;">Detailed Marks Certificate</h5>
        <table class="table_small" style="width: 100%;">
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
            $query = "SELECT * FROM exams 
                WHERE exams.session_id = (SELECT session_id FROM exams WHERE exam_id = '" . $exam_id . "') 
                AND exams.show = '1'
                ORDER BY exam_id ASC";
            $session_exams = $this->db->query($query)->result();
            $exams_ids = array();
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
            <th style="width: 155px;">Subjects</th>
            <?php foreach ($session_exams as $session_exam) { ?>
              <th style="text-align: center;">Marks</th>
              <th style="text-align: center;">Percentage</th>
            <?php } ?>

          </tr>

          <?php
          $subject_count = 1;
          foreach ($subjects as $class_subject) {
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
                    if ($student_result->percentage < 32.9) {
                      echo '<span class="fail">' . round($student_result->percentage) . '</span>';
                    } else {
                      echo round($student_result->percentage);
                    }
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
              <th style="text-align: center;"><?php
                                              $subject_avg = round(($subject_percentage / $exam_count));
                                              if ($subject_avg < 32.9) {
                                                echo '<span class="fail">' . $subject_avg . '</span>';
                                              } else {
                                                echo $subject_avg;
                                              }

                                              ?></th>
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
                <?php $percentage = (($session_exam->subject_obtain_marks * 100) / $session_exam->subject_total_marks);
                if ($percentage) {
                  $total_percentage += $percentage;
                  if ($percentage < 32.9) {
                    echo '<span class="fail">' . round($percentage) . '</span> %';
                  } else {
                    echo round($percentage) . " %";
                  }
                }
                ?>
              </th>
            <?php } ?>
            <th style="text-align:center"><?php
                                          $avg_percentage = round(($total_percentage / $exam_count), 1);

                                          if ($avg_percentage < 32.9) {
                                            echo '<span class="fail">' . round($avg_percentage) . '</span>';
                                          } else {
                                            echo round($avg_percentage) . "";
                                          }
                                          ?></th>

          </tr>


        </table>

        <h4>Attendance History</h4>
        <table class="table_small" style="width:100%; font-size: 8px;">
          <thead>
            <tr>
              <th>Month / Days</th>
              <?php for ($day = 1; $day <= 31; $day++) { ?>
                <th><?php echo $day; ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $monthNames = [
              '01' => 'January',
              '02' => 'February',
              '03' => 'March',
              '04' => 'April',
              '05' => 'May',
              '06' => 'June',
              '07' => 'July',
              '08' => 'August',
              '09' => 'September',
              '10' => 'October',
              '11' => 'November',
              '12' => 'December'
            ];

            $currentYear = date('Y'); // This will be 2025

            foreach ($monthNames as $monthNum => $monthName) {
              $daysInMonth = date('t', mktime(0, 0, 0, $monthNum, 1, $currentYear));
            ?>
              <tr>
                <th><?php echo $monthName; ?></th>
                <?php
                for ($day = 1; $day <= 31; $day++) {
                  if ($day > $daysInMonth) {
                    echo '<td></td>';
                    continue;
                  }

                  $query = "SELECT * FROM `students_attendance` WHERE `student_id` = ? 
                              AND YEAR(`date`) = ? 
                              AND MONTH(`date`) = ? 
                              AND DAY(`date`) = ?";
                  $students_attendance = $this->db->query($query, [
                    $student->student_id,
                    $currentYear,
                    $monthNum,
                    $day
                  ])->row();
                ?>
                  <td style="text-align:center; 
                                <?php
                                if (!empty($students_attendance)) {
                                  // Set background color based on attendance status
                                  if ($students_attendance->attendance == 'A') {
                                    echo 'background-color: #D8534E;';  // Red for absent
                                  } elseif ($students_attendance->attendance == 'P') {
                                    if (empty($students_attendance->attendance2) || $students_attendance->attendance2 == 'P') {
                                      echo 'background-color: #96AE5F;';  // Green for present
                                    } elseif ($students_attendance->attendance2 == 'A') {
                                      echo 'background-color: #F0AD4E;';  // Orange for partial absence
                                    }
                                  }
                                }
                                ?>">
                    <small>
                      <?php
                      if (!empty($students_attendance)) {
                        echo $students_attendance->attendance;
                        if (!empty($students_attendance->attendance2)) {
                          echo "-" . htmlspecialchars($students_attendance->attendance2);
                        }
                      }
                      ?>
                    </small>
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <h5 style="margin-left: 10px; color:black"> Observartions</h5>
        <div style="border: 1px solid gray;  width:100%; border-radius: 9px;">

          <table class="table_small" style="width: 100%;">
            <tr>
              <td>
                <strong>Behavier In Class</strong>
                <table class="table_small" style="width: 100%;">
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
                    <?php if ($avg_percentage >= 32.9 and $avg_percentage <= 39.9) { ?>
                      <strong style="font-size: 12px;">
                        32.9-39 % <span style="margin-left: 23px;"></span> Satisfactory <br />
                      </strong>
                    <?php } else { ?>
                      32.9-39 % <span style="margin-left: 23px;"></span> Satisfactory <br />
                    <?php } ?>

                    <?php if ($avg_percentage < 32.9) { ?>
                      <strong style="font-size: 11px;">
                        Below 32.9 % <span style="margin-left: 7px;"></span> Poor & required special attention
                      </strong>
                    <? } else { ?>
                      Below 32.9 % <span style="margin-left: 7px;"></span> Poor & required special attention
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



      </div>
    </page>
  <?php endforeach; ?>

</body>

</html>