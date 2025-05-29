<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="utf-8">
  <title>Paper Collection Report</title>
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
  </style>
</head>

<body>
  <section id="page" class="container">
    <div class="row">
      <div class="col-12">
        <div class="card border-primary mb-4">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fa fa-bell"></i> Paper Collection Report</h4>
          </div>
          <div class="card-body">
            <?php foreach ($classes as $class) { ?>
              <div class="mb-4">
                <h3>Class <?php echo $class->Class_title; ?></h3>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
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
                          <th><?php echo $section->section_title; ?></th>
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
                          ?>
                            <td><?php echo isset($assigned_teacher->teacher_name) ? $assigned_teacher->teacher_name : '-'; ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap 4 JS (Optional) -->
  <script src="https: