<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Detailed Marks Certificate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print">
  <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" id="skin-switcher" media="screen,print">
  <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print">
  <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print">
  <style>
    body {
      background: #ccc;
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
      min-width: 17px;
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
          <thead>
            <tr>
              <th colspan="2">Session: <strong><?php echo $this->db->query("SELECT session FROM session WHERE session_id = (SELECT session_id FROM exams WHERE exam_id = '$exam_id')")->row()->session; ?></strong></th>
              <?php
              $session_exams = $this->db->query("SELECT * FROM exams WHERE session_id = (SELECT session_id FROM exams WHERE exam_id = '$exam_id') AND exams.show = '1' ORDER BY exam_id ASC")->result();
              foreach ($session_exams as $exam): ?>
                <th colspan="2" style="text-align: center;"><?php echo $exam->term; ?></th>
              <?php endforeach; ?>
              <th rowspan="2">AVG.</th>
            </tr>
            <tr>
              <th>#</th>
              <th>Subjects</th>
              <?php foreach ($session_exams as $exam): ?>
                <th>Marks</th>
                <th>%</th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($subjects as $subject): ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $subject->subject_title; ?></td>
                <?php
                $total_percent = 0;
                $count = 0;
                foreach ($session_exams as $exam):
                  $result = $this->db->query("SELECT obtain_mark, percentage, total_marks FROM students_exams_subjects_marks WHERE student_id = '$student->student_id' AND exam_id = '$exam->exam_id' AND class_subjec_id = '$subject->class_subject_id'")->row();
                  if ($result) {
                    $total_percent += $result->percentage;
                    $count++;
                  }
                ?>
                  <td style="text-align:center;"><?php echo $result ? "<strong>{$result->obtain_mark}</strong> / {$result->total_marks}" : '-'; ?></td>
                  <td style="text-align:center;"><?php echo $result ? round($result->percentage, 2) . '%' : '-'; ?></td>
                <?php endforeach; ?>
                <td style="text-align:center;"><?php echo $count ? round($total_percent / $count, 2) . '%' : '-'; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </page>
  <?php endforeach; ?>

</body>

</html>