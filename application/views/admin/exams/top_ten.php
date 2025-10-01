<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="UTF-8">
  <title>Examination Results Summary</title>
  <style>
    body {
      font-size: 12px;
      font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
      margin: 25mm;
      color: #000;
    }

    h1,
    h2,
    h3 {
      text-align: center;
      margin: 5px 0;
    }

    h1 {
      font-size: 20px;
      text-transform: uppercase;
    }

    h2 {
      font-size: 16px;
      font-weight: normal;
    }

    h3 {
      margin-top: 20px;
      font-size: 14px;
      text-align: left;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    thead th {
      background: #f2f2f2;
      text-align: center;
      font-weight: bold;
      font-size: 12px;
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
  </style>
</head>

<body>
  <!-- School + Exam Title -->
  <h1>Government Centennial Model High School Boys Chitral</h1>
  <h2><?php echo $exam->year . " - " . $exam->term; ?></h2>

  <!-- Overall Top Ten -->
  <h3>Overall Top Ten Students</h3>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Class No</th>
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
      $count = 1;
      foreach ($top_ten_students as $s) { ?>
        <tr>
          <td class="center"><?php echo $count++; ?></td>
          <td class="center"><?php echo $s->student_class_no; ?></td>
          <td class="center"><?php echo $s->student_admission_no; ?></td>
          <td><?php echo $s->student_name; ?></td>
          <td><?php echo $s->student_father_name; ?></td>
          <td><?php echo implode('<br/>', array_map('trim', explode(',', $s->contact_numbers))); ?></td>
          <td style="background-color:<?php echo $s->color; ?>; text-align:center;">
            <?php echo $s->Class_title . " (" . $s->section_title . ")"; ?>
          </td>
          <td class="right"><?php echo $s->obtain_marks; ?></td>
          <td class="right"><?php echo $s->total_marks; ?></td>
          <td class="center"><?php echo $s->percentage; ?>%</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Per Class / Section -->
  <?php
  $query = "SELECT `Class_title`, `class_id` FROM student_results WHERE exam_id=? GROUP BY class_id ORDER BY class_id ASC";
  $classes = $this->db->query($query, [$exam_id])->result();

  foreach ($classes as $class) {
    $query = "SELECT `section_title`, `section_id` FROM student_results WHERE exam_id=? AND class_id=? GROUP BY section_id ORDER BY section_id ASC";
    $sections = $this->db->query($query, [$exam_id, $class->class_id])->result();

    foreach ($sections as $section) {
      $query = "SELECT * FROM student_results WHERE exam_id=? AND class_id=? AND section_id=? ORDER BY percentage DESC LIMIT 3";
      $top_three = $this->db->query($query, [$exam_id, $class->class_id, $section->section_id])->result();
  ?>
      <h3>Class <?php echo $class->Class_title; ?> - Section <?php echo $section->section_title; ?> (Top 3)</h3>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Class No</th>
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
          <?php
          $count = 1;
          foreach ($top_three as $s) { ?>
            <tr>
              <td class="center"><?php echo $count++; ?></td>
              <td class="center"><?php echo $s->student_class_no; ?></td>
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
  <?php }
  } ?>
</body>

</html>