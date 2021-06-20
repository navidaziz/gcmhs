<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/cloud-admin.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/themes/default.css"); ?>" id="skin-switcher" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/responsive.css"); ?>" />

<head>
</head>

<body style="background-color: white;">

  <!-- /PAGE HEADER -->

  <!-- PAGE MAIN CONTENT -->
  <div class="row" style="font-size:12px !important; font-family: Open Sans !important">
    <!-- MESSENGER -->
    <div class="col-md-12">
      <div class="container">
        <section contenteditable="true">

          <div class="col-md-12">

            <h6>

              <?php foreach ($teachers as $teacher) { ?>

                <table id="example" class="table table-border" cellspacing="0" width="45%" style="float:left; font-size:11px">
                  <thead>
                    <tr>
                      <th colspan="11">
                        <strong><?php echo $teacher->teacher_name; ?> - <?php echo $teacher->teacher_designation; ?></strong>
                        <span style="float: right;">
                          <?php $query = "SELECT Class_title, section_title, color 
                                          FROM `classes_time_tables`  
                                          WHERE `classes_time_tables`.`class_teacher`='1' 
                                          and teacher_id='" . $teacher->teacher_id . "'";
                          $class_teacher = $this->db->query($query)->result();
                          if ($class_teacher) {
                            echo '<span style="float:right">';
                            echo str_replace("th", "", $class_teacher[0]->Class_title) . "-" . substr($class_teacher[0]->section_title, 0, 1);
                            echo '</span>';
                          }
                          ?>
                        </span>
                      </th>
                    </tr>
                    <tr>
                      <th>Days</th>
                      <?php foreach ($periods as $period) { ?>
                        <th><?php echo $period->period_title;  ?></th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    error_reporting(14);
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
                        <td><?php echo strtoupper(substr($week, 0, 3)); ?></td>
                        <?php foreach ($periods as $period) { ?>

                          <?php $query = "SELECT * FROM `classes_time_tables` 
                      WHERE period_id='" . $period->period_id . "'
                      AND `" . $w_index . "` = '1'
                      AND `teacher_id` = '" . $teacher->teacher_id . "'";
                          $teacher_subjects = $this->db->query($query)->result();
                          if ($teacher_subjects) { ?>
                            <td>
                              <?php foreach ($teacher_subjects as $teacher_subject) { ?>
                                <div style="background-color:  <?php echo $teacher_subject->color ?>;">
                                  <?php echo $teacher_subject->short_title ?>-<?php echo str_replace("th", "", $teacher_subject->Class_title);  ?>-<?php echo substr($teacher_subject->section_title, 0, 1);  ?>
                                  <br />
                                </div>
                              <?php } ?>
                            </td>
                          <?php } else { ?>
                            <td>-</td>
                          <?php } ?>

                        <?php } ?>
                      </tr>
                    <?php } ?>

                  </tbody>
                </table>


              <?php } ?>

            </h6>
          </div>
        </section>
      </div>
    </div>
  </div>
  </div>
  <!-- /MESSENGER -->
  </div>
</body>

</html>