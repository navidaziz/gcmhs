<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="UTF-8">
  <title>Top Ten Students List</title>
  <style>
    body {
      font-size: 12px;
      font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
      margin: 30px;
      color: #000;
    }

    h1,
    h2 {
      text-align: center;
      margin: 5px 0;
    }

    h1 {
      font-size: 22px;
      text-transform: uppercase;
    }

    h2 {
      font-size: 16px;
      font-weight: normal;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
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

    /* Print-friendly setup */
    @page {
      size: A4;
      margin: 20mm;
    }

    @media print {
      body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      table {
        page-break-inside: auto;
      }

      tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }
    }
  </style>
</head>

<body>
  <h1>GCMHS Boys Chitral</h1>
  <h2><?php echo $exam->year . " " . $exam->term; ?> <br> Top Ten Students List</h2>

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
      foreach ($top_ten_students as $top_ten_student) { ?>
        <tr>
          <td class="center"><?php echo $count++; ?></td>
          <td class="center"><?php echo $top_ten_student->student_class_no; ?></td>
          <td class="center"><?php echo $top_ten_student->student_admission_no; ?></td>
          <td><?php echo $top_ten_student->student_name; ?></td>
          <td><?php echo $top_ten_student->student_father_name; ?></td>
          <td>
            <?php
            $numbers = explode(',', $top_ten_student->contact_numbers);
            echo implode('<br />', array_map('trim', $numbers));
            ?>
          </td>
          <td style="background-color:<?php echo $top_ten_student->color; ?>; text-align:center;">
            <?php echo $top_ten_student->Class_title; ?>
            (<?php echo $top_ten_student->section_title; ?>)
          </td>
          <td class="right"><?php echo $top_ten_student->obtain_marks; ?></td>
          <td class="right"><?php echo $top_ten_student->total_marks; ?></td>
          <td class="center"><?php echo $top_ten_student->percentage; ?>%</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>