<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="utf-8">
  <title><?php echo $system_global_settings[0]->system_title ?> - Paper Collection Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap core CSS -->
  <link href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-size: 12px;
    }

    h3 {
      margin-top: 20px;
      font-weight: bold;
    }

    .table {
      font-size: 11px;
    }

    .box {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <section id="page">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="box border blue">
            <div class="box-title">
              <h4><i class="fa fa-bell"></i> Paper Collection Report</h4>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <div class="row">
                  <?php foreach ($classes as $class) { ?>
                    <div class="col-md-12">
                      <h3><?php echo $class->Class_title; ?> </h3>
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Sections</th>
                            <?php foreach ($class->subjects as $subject) : ?>
                              <th><?php echo substr($subject->subject_title, 0, 15); ?> </th>
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
                                    FROM
                                    `teachers`,
                                    `class_section_subject_teachers` 
                                    WHERE `teachers`.`teacher_id` = `class_section_subject_teachers`.`teacher_id`
                                    AND `class_id` = '" . $class->class_id . "'
                                    AND `section_id` = '" . $section->section_id . "' 
                                    AND `class_subject_id` = '" . $subject->class_subject_id . "'";
                                $result = $this->db->query($query);
                                $assigned_teacher = $result->row();
                              ?>
                                <td><?php echo $assigned_teacher->teacher_name; ?></td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS (optional if needed) -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>
</body>

</html>