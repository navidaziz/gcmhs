<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="UTF-8">
  <title>Award List</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/css/bootstrap.min.css"); ?>">

  <!-- jQuery -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>

  <!-- Bootstrap JS -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

  <!-- DataTables -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  <style>
    body {
      font-size: 12px;
      font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
    }
  </style>

  <script>
    document.title = "Award List Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>) <?php echo $exam->term . ' ' . $exam->year ?>";
  </script>
</head>

<body>

  <div class="container-fluid">
    <section class="mt-4">
      < class="table-responsive">

        <?php $count = 1; ?>
        <?php foreach ($students as $student): ?>
          <div style="width:22% !important; float:left;  margin-right:20px !important;  margin-bottom:15px !important; border:1px dashed #999999; padding:5px">
            <div style="text-align:center !important; margin-bottom:10px !important">



              <img src="<?php echo site_url("assets/admin/images/kpese.png"); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:30px !important; float:right;">


              <img src="<?php echo site_url("assets/uploads/" . $system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:30px !important; float:left;">

              <h4 style="margin:5px !important;">GCMHS For Boys Chitral</h4>
              <h5 style="margin:1px !important;"> DMC <?php echo $class_name; ?> (<?php echo $section_title; ?>) <?php echo $exam->term . " " . $exam->year  ?> </h5>



            </div>
            <div style="margin:3px !important">
              Class No: <strong><?php echo $student->student_class_no; ?></strong> <br />
              Student Name: <strong><?php echo $student->student_name; ?></strong>
            </div>
            <table id="transposed" class="table table-bordered table-striped table_small">
              <thead>
                <tr>
                  <th colspan="2" class="text-center">
                    <h1>Award List - Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>) - <?php echo $exam->term . " " . $exam->year ?></h1>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>#</th>
                  <td>1</td>
                </tr>
                <tr>
                  <th>Class No.</th>
                  <td><?php echo $student->class_no; ?></td>
                </tr>
                <tr>
                  <th>Admission No.</th>
                  <td><?php echo $student->adminssion_no; ?></td>
                </tr>
                <tr>
                  <th>Student Name</th>
                  <td><?php echo $student->student_name . ' S/O ' . $student->father_name; ?></td>
                </tr>

                <?php
                $obtained_marked = 0;
                $total_marked = 0;

                foreach ($subjects as $subject):
                  $query = "SELECT obtain_mark, total_marks, passing_marks, `percentage` 
                FROM `students_exams_subjects_marks` 
                WHERE student_id = ? AND exam_id = ? AND subject_id = ?";
                  $result = $this->db->query($query, [$student->student_id, $exam->exam_id, $subject->subject_id]);

                  $value = '-';
                  if ($result->num_rows() > 0) {
                    $marks = $result->row();
                    if ($marks->obtain_mark !== 'A') {
                      $value = $marks->percentage;
                      $obtained_marked += $marks->percentage;
                    } else {
                      $value = 'A';
                      $obtained_marked += 100; // Assuming full marks for 'A'
                    }
                    $total_marked += 100;
                  }
                ?>
                  <tr>
                    <th><?php echo substr($subject->short_title, 0, 7); ?></th>
                    <td style="text-align: center;"><?php echo $value; ?></td>
                  </tr>
                <?php endforeach; ?>

                <tr>
                  <th>Total Marks</th>
                  <td style="text-align: center;"><?php echo $total_marked; ?></td>
                </tr>
                <tr>
                  <th>Marks Obtained</th>
                  <td style="text-align: center;"><?php echo $obtained_marked; ?></td>
                </tr>
                <tr>
                  <th>Percentage</th>
                  <td style="text-align: center;"><?php echo $total_marked > 0 ? round(($obtained_marked / $total_marked) * 100, 2) : 0; ?>%</td>
                </tr>
                <tr>
                  <th>Remarks</th>
                  <td></td>
                </tr>
              </tbody>
            </table>

          </div>

        <?php endforeach; ?>

  </div>

  <div class="row mt-5">
    <div class="col-md-6">
      <strong>GCMHS Boys Chitral<br>Exam Committee</strong>
    </div>
    <div class="col-md-6 text-end" style="text-align: right;">
      <strong>GCMHS Boys Chitral<br>Principal</strong>
    </div>
  </div>
  </section>
  </div>


</html>