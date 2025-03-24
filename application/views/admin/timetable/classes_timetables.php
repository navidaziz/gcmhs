<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Class Timetable - GCMHS Boys Chitral</title>

  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/cloud-admin.css"); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/themes/default.css"); ?>" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/responsive.css"); ?>" />

</head>

<body>
  <div class="container">
    <?php foreach ($classes as $class) { ?>
      <?php foreach ($class->sections as $section) { ?>
        <div class="timetable-page">
          <div class="timetable-container">
            <div class="header-section">
              <div class="row">
                <div class="col-md-5">
                  <h2><strong>GCMHS Boys Chitral</strong></h2>
                </div>
                <div class="col-md-5">

                  <h2>Time Table For Class: <strong><?php echo $class->Class_title; ?>
                      <span style="color: <?php echo $section->color;  ?>;">
                        <?php echo $section->section_title; ?>
                      </span>
                    </strong></h2>
                  <h4><strong>Incharge Teacher:
                      <?php $query = "SELECT teacher_name,
                                  teacher_id
                                    FROM `classes_time_tables`
                                    WHERE `classes_time_tables`.`class_teacher`='1' 
                                    AND `classes_time_tables`.`class_id`='" . $class->class_id . "'
                                    AND  `classes_time_tables`.`section_id`='" . $section->section_id . "'";
                      $class_teacher = $this->db->query($query)->row();
                      //var_dump($class_teacher);
                      if ($class_teacher) {
                        echo $class_teacher->teacher_name;
                      }
                      ?>
                    </strong>
                  </h4>
                  </strong>

                </div>
                <div class="col-md-2">
                  <?php
                  if ($class_teacher and $class_teacher->teacher_id > 0) {
                    $user = "";
                    $user = $this->db->get_where('users', array('teacher_id' => $class_teacher->teacher_id))->row();
                    if ($user->user_image) { ?>
                      <img src="<?php echo base_url("assets/uploads/" . $user->user_image) ?>" height="80" width="80" class="img-circle">
                    <?php  } else { ?>
                      <div height="80" width="80" class="img-circle"></div>
                  <?php }
                  }

                  ?>
                </div>
              </div>

            </div>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 12%;">Days</th>
                  <?php foreach ($periods as $period) { ?>
                    <?php if ($period->period_id != 7) { ?>
                      <th><?php echo $period->period_title; ?></th>
                    <?php } else { ?>
                      <th><?php echo $period->period_title; ?></th>
                    <?php } ?>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $weeks = array(
                  "mon" => "Monday",
                  "tue" => "Tuesday",
                  "wed" => "Wednesday",
                  "thu" => "Thursday",
                  "fri" => "Friday",
                  "sat" => "Saturday",
                );

                foreach ($weeks as $w_index => $week) { ?>
                  <tr>
                    <td><strong><?php echo $week; ?></strong></td>
                    <?php foreach ($periods as $period) {
                      if ($period->period_id != 7) { ?>
                        <td>
                          <?php
                          $query = "SELECT * FROM `classes_time_tables` 
                                                        WHERE period_id='" . $period->period_id . "'
                                                        AND `" . $w_index . "` = '1'
                                                        AND `class_id` = '" . $class->class_id . "' 
                                                        AND `section_id` = '" . $section->section_id . "'";
                          $teacher_subjects = $this->db->query($query)->result();

                          if ($teacher_subjects) { ?>
                            <?php foreach ($teacher_subjects as $teacher_subject) { ?>
                              <div style="margin-bottom: 5px; text-align: center;">
                                <?php echo $teacher_subject->teacher_name ?><br>
                                <strong><?php echo $teacher_subject->short_title ?></strong>
                              </div>
                            <?php } ?>
                          <?php } else { ?>
                            -
                          <?php } ?>
                        </td>
                      <?php } else { ?>
                        <td></td>
                      <?php } ?>
                    <?php } ?>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot></tfoot>
              <tr>
                <td colspan="11" style="text-align: center;">
                  <small>Generated on <?php echo date('d/m/Y H:i'); ?> | GCMHS Boys Chitral</small>
                </td>
              </tr>
            </table>

          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
</body>

</html>