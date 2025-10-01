<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="UTF-8">
  <title>Examination Results Report</title>
  <style>
    body {
      font-size: 12px;
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 20mm;
      color: #000;
    }

    header {
      text-align: center;
      margin-bottom: 15px;
    }

    header h1 {
      font-size: 20px;
      margin: 0;
      text-transform: uppercase;
    }

    header h2 {
      font-size: 14px;
      margin: 5px 0;
      font-weight: normal;
    }

    h3 {
      margin: 10px 0 5px 0;
      font-size: 14px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    thead th {
      background: #f2f2f2;
      text-align: center;
      font-weight: bold;
      font-size: 11px;
    }

    table,
    th,
    td {
      border: 1px solid #000;
      padding: 6px 8px;
    }

    td {
      font-size: 11px;
    }

    td.center {
      text-align: center;
    }

    td.right {
      text-align: right;
    }

    /* Page breaks */
    .page-break {
      page-break-before: always;
    }

    /* Print setup */
    @page {
      size: A4;
      margin: 20mm;
    }

    @media print {
      body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
    }

    footer {
      margin-top: 30px;
      font-size: 11px;
    }

    footer .sign {
      width: 33%;
      display: inline-block;
      text-align: center;
    }
  </style>
</head>

<body>
  <!-- First Page: Overall Top 10 -->
  <header>
    <h1>Government Centennial Model High School Boys Chitral</h1>
    <h2><?php echo $exam->year . " - " . $exam->term; ?></h2>
    <h3>Overall Top Ten Students</h3>
  </header>

  <table>
    <thead>
      <tr>
        <th>Rank</th>
        <th>Admission No.</th>
        <th>Student Name</th>
        <th>Father Name</th>
        <th>Contact No.</th>
        <th>Class</th>
        <th>Obtained Marks</th>
        <th>Total Marks</th>
        <th>%</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $rank = 1;
      foreach ($top_ten_students as $s) { ?>
        <tr>
          <td class="center"><b><?php echo $rank++; ?></b></td>
          <td class="center"><?php echo $s->student_admission_no; ?></td>
          <td><?php echo $s->student_name; ?></td>
          <td><?php echo $s->student_father_name; ?></td>
          <td><?php echo implode('<br/>', array_map('trim', explode(',', $s->contact_numbers))); ?></td>
          <td class="center" style="background-color:<?php echo $s->color; ?>">
            <?php echo $s->Class_title . " (" . $s->section_title . ")"; ?>
          </td>
          <td class="right"><?php echo $s->obtain_marks; ?></td>
          <td class="right"><?php echo $s->total_marks; ?></td>
          <td class="center"><?php echo $s->percentage; ?>%</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <footer>
    <div class="sign">Prepared by: ____________</div>
    <div class="sign">Verified by: ____________</div>
    <div class="sign">Date: ____________</div>
  </footer>

  <!-- Next Pages: Each Class -->
  <?php
  $classes = $this->db->query("SELECT `Class_title`, `class_id` FROM student_results WHERE exam_id=? GROUP BY class_id ORDER BY class_id ASC", [$exam_id])->result();

  foreach ($classes as $class) {
    $sections = $this->db->query("SELECT `section_title`, `section_id` FROM student_results WHERE exam_id=? AND class_id=? GROUP BY section_id ORDER BY section_id ASC", [$exam_id, $class->class_id])->result();

    foreach ($sections as $section) {
      $top_students = $this->db->query("SELECT * FROM student_results WHERE exam_id=? AND class_id=? AND section_id=? ORDER BY percentage DESC LIMIT 10", [$exam_id, $class->class_id, $section->section_id])->result();
  ?>
      <div class="page-break"></div>
      <header>
        <h1>Government Centennial Model High School Boys Chitral</h1>
        <h2><?php echo $exam->year . " - " . $exam->term; ?></h2>
        <h3>Class <?php echo $class->Class_title; ?> - Section <?php echo $section->section_title; ?><br>Top 10 Students</h3>
      </header>

      <table>
        <thead>
          <tr>
            <th>Rank</th>
            <th>Admission No.</th>
            <th>Student Name</th>
            <th>Father Name</th>
            <th>Contact No.</th>
            <th>Obtained Marks</th>
            <th>Total Marks</th>
            <th>%</th>
          </tr>
        </thead>
        <tbody>
          <?php $rank = 1;
          foreach ($top_students as $s) { ?>
            <tr>
              <td class="center"><b><?php echo $rank++; ?></b></td>
              <td class="center"><?php echo $s->student_admission_no; ?></td>
              <td><?php echo $s->student_name; ?></td>
              <td><?php echo $s->student_father_name; ?></td>
              <td><?php echo implode('<br/>', array_map('trim', explode(',', $s->contact_numbers))); ?></td>
              <td class="right"><?php echo $s->obtain_marks; ?></td>
              <td class="right"><?php echo $s->total_marks; ?></td>
              <td class="center"><?php echo $s->percentage; ?>%</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <footer>
        <div class="sign">Prepared by: ____________</div>
        <div class="sign">Verified by: ____________</div>
        <div class="sign">Date: ____________</div>
      </footer>
  <?php }
  } ?>
</body>

</html>