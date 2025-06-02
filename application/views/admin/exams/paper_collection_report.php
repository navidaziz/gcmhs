<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="utf-8">
  <title>Result Submission Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Optional: Font Awesome (for icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    body {
      font-size: 13px;
    }

    h3 {
      margin-top: 30px;
    }

    table th,
    table td {
      vertical-align: middle !important;
      font-size: 12px;
    }

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
      font-size: 9px;
      border: 0.1px solid gray !important;
      font-weight: bold !important;
      color: black !important;
    }
  </style>
</head>

<body>

  <div class="row">
    <div class="col-12">
      <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0"><i class="fa fa-paper-plane" aria-hidden="true"></i>Result Submission Report</h4>
        </div>
        <div class="card-body">
          <?php foreach ($classes as $class) { ?>
            <div class="mb-1">
              <h5><strong>Class <?php echo $class->Class_title; ?></strong></h5>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table_small">
                  <thead class="thead-light">
                    <tr>
                      <th>Sections</th>
                      <?php foreach ($class->subjects as $subject) : ?>
                        <th><?php echo substr($subject->subject_title, 0, 15); ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($class->sections as $section) { ?>
                      <tr>
                        <th>
                          <a target="_blank" href="<?php echo site_url(ADMIN_DIR . 'class_result/' . $exam_id . '/' . $class->class_id . '/' . $section->section_id) ?>">
                            <?php echo $section->section_title; ?>
                          </a>
                        </th>
                        <?php foreach ($class->subjects as $subject) {
                          $query = "SELECT
                                        `teachers`.`teacher_name`
                                        FROM `teachers`, `class_section_subject_teachers`
                                        WHERE `teachers`.`teacher_id` = `class_section_subject_teachers`.`teacher_id`
                                        AND `class_id` = '" . $class->class_id . "'
                                        AND `section_id` = '" . $section->section_id . "'
                                        AND `class_subject_id` = '" . $subject->class_subject_id . "'";
                          $result = $this->db->query($query);
                          $assigned_teacher = $result->row();
                          if ($assigned_teacher->teacher_name) {

                            // $query = "SELECT COUNT(*) as total
                            //         FROM `students_exams_subjects_marks` 
                            //         WHERE class_id = ? AND class_id = ? AND exam_id = ? AND subject_id = ?";
                            // $result = $this->db->query($query, [$class->class_id, $section->section_id, $exam_id, $subject->subject_id]);
                            $query = "SELECT COUNT(*) as total
                                    FROM `students_exams_subjects_marks` 
                                    WHERE class_id = '" . $class->class_id . "' 
                                    AND section_id = '" . $section->section_id . "' 
                                    AND exam_id = '" . $exam_id . "' 
                                    AND subject_id = '" . $subject->subject_id . "'";
                            $result = $this->db->query($query);

                            if ($result->num_rows() > 0) {
                              $total = $result->row()->total;
                              if ($total > 0) {
                                $color = '#8BE78A; text-decoration: line-through;';
                              } else {
                                $color = '#F86F72; font-weight: bold; font-size: 15px;';
                                $not_submitted_teachers[$assigned_teacher->teacher_name][] = $subject->subject_title . " - " . $section->section_title . " - " . $class->Class_title;
                              }
                            }
                          } else {
                            $color = '#E9ECEF;';
                          }
                        ?>
                          <td style="background-color: <?php echo $color; ?>"><?php echo isset($assigned_teacher->teacher_name) ? $assigned_teacher->teacher_name : '-'; ?></td>
                        <?php } ?>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } ?>
          <table class="table table-bordered table-striped mt-4">
            <thead>
              <tr>
                <th colspan="3">Teachers Not Submitted Test / Exam Result</th>
              </tr>
              <tr>
                <th>#</th>
                <th>Teacher Name</th>
                <th>Remaining Subjects / Section / Class</th>
              </tr>
            </thead>
            <?php
            $count = 1;
            foreach ($not_submitted_teachers as $teacher_name => $subjects) { ?>
              <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $teacher_name; ?></td>
                <td>
                  <ul>
                    <?php foreach ($subjects as $subject) { ?>
                      <li><?php echo $subject; ?></li>
                    <?php } ?>
                  </ul>
                </td>

              </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
  </div>