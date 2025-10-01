<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="UTF-8">
  <title>Top Students Report</title>
  <style>
    body {
      font-size: 15px;
      font-family: "Segoe UI", Arial, sans-serif;
      color: #000;
    }

    h1,
    h2,
    h3 {
      text-align: center;
      margin: 5px 0;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 20px;
    }

    th,
    td {
      border: 1px solid black;
      padding: 6px;
      font-size: 11px;
    }

    th {
      background: #f0f0f0;
      font-weight: bold;
    }

    td.center {
      text-align: center;
    }

    td.right {
      text-align: right;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>

  <!-- Page 1: Overall Top 10 -->
  <h1>GCMHS Boys Chitral</h1>
  <h2><?php echo $exam->year . " " . $exam->term; ?></h2>
  <h2>Overall Top 10 Students</h2>

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
      $rank = 1;
      foreach ($top_ten_students as $s) { ?>
        <tr>
          <td class="center"><?php echo $rank++; ?></td>
          <td class="center"><?php echo $s->student_class_no; ?></td>
          <td class="center"><?php echo $s->student_admission_no; ?></td>
          <td><?php echo $s->student_name; ?></td>
          <td><?php echo $s->student_father_name; ?></td>
          <td>
            <?php
            $numbers = explode(',', $s->contact_numbers);
            echo implode('<br>', array_map('trim', $numbers));
            ?>
          </td>
          <td class="center"><?php echo $s->Class_title . " (" . $s->section_title . ")"; ?></td>
          <td class="right"><?php echo $s->obtain_marks; ?></td>
          <td class="right"><?php echo $s->total_marks; ?></td>
          <td class="center"><?php echo $s->percentage; ?>%</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <div class="page-break"></div>

  <!-- Pages for Each Class -->
  <?php
  // get distinct classes
  $query = "SELECT class_id, Class_title 
            FROM student_results 
            WHERE exam_id=? 
            GROUP BY class_id 
            ORDER BY class_id ASC";
  $classes = $this->db->query($query, [$exam_id])->result();

  foreach ($classes as $class) {
  ?>
    <h1>GCMHS Boys Chitral</h1>
    <h2><?php echo $exam->year . " " . $exam->term; ?></h2>
    <h2>Top Students - Class <?php echo $class->Class_title; ?></h2>

    <?php
    // get sections of class
    $sections = $this->db->query(
      "SELECT section_id, section_title 
                                  FROM student_results 
                                  WHERE exam_id=? AND class_id=? 
                                  GROUP BY section_id 
                                  ORDER BY section_id ASC",
      [$exam_id, $class->class_id]
    )->result();

    foreach ($sections as $section) {
      // get top 3 students per section
      $top_three = $this->db->query(
        "SELECT * FROM student_results 
                                     WHERE exam_id=? AND class_id=? AND section_id=? 
                                     ORDER BY percentage DESC 
                                     LIMIT 3",
        [$exam_id, $class->class_id, $section->section_id]
      )->result();
    ?>

      <h3>Section <?php echo $section->section_title; ?> - Top 3 Students</h3>
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
          <?php $rank = 1;
          foreach ($top_three as $s) { ?>
            <tr>
              <td class="center"><?php echo $rank++; ?></td>
              <td class="center"><?php echo $s->student_class_no; ?></td>
              <td class="center"><?php echo $s->student_admission_no; ?></td>
              <td><?php echo $s->student_name; ?></td>
              <td><?php echo $s->student_father_name; ?></td>
              <td>
                <?php
                $numbers = explode(',', $s->contact_numbers);
                echo implode('<br>', array_map('trim', $numbers));
                ?>
              </td>
              <td class="right"><?php echo $s->obtain_marks; ?></td>
              <td class="right"><?php echo $s->total_marks; ?></td>
              <td class="center"><?php echo $s->percentage; ?>%</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    <?php } // end sections 
    ?>

    <div class="page-break"></div>
  <?php } // end classes 
  ?>

</body>

</html>