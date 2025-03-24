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
            <?php foreach ($classes as $class) { ?>





              <?php foreach ($class->sections as $section) { ?>


                <h5>
                  <table id="example" class="table table-bordered" style="margin-bottom: 15px !important;">
                    <thead>
                      <tr>
                        <th colspan="11" style="text-align: center;">
                          <div class="row">
                            <div class="col-md-6">
                              <h2><strong>Government Centennial Model High School, Boys Chitral</strong></h2>
                            </div>
                            <div class="col-md-6">

                              <h2>Time Table For Class: <strong><?php echo $class->Class_title; ?> <?php echo $section->section_title; ?> </strong></h2>
                              <h4>Class Teacher:
                                <?php $query = "SELECT teacher_name
                                    FROM `classes_time_tables`
                                    WHERE `classes_time_tables`.`class_teacher`='1' 
                                    AND `classes_time_tables`.`class_id`='" . $class->class_id . "'
                                    AND  `classes_time_tables`.`section_id`='" . $section->section_id . "'";
                                $class_teacher = $this->db->query($query)->result();
                                if ($class_teacher) {
                                  echo $class_teacher[0]->teacher_name;
                                }
                                ?>
                              </h4>
                              </strong>

                            </div>
                          </div>

                        </th>
                      </tr>
                      <tr>
                        <th>Days</th>
                        <?php foreach ($periods as $period) { ?>
                          <?php if ($period->period_id != 7) { ?>
                            <th><?php echo $period->period_title;  ?></th>
                          <?php } else { ?>
                            <th rowspan="6"><?php echo $period->period_title;  ?></th>
                          <?php } ?>
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
                          <td><?php echo $week; ?></td>
                          <?php foreach ($periods as $period) {
                            if ($period->period_id != 7) {
                          ?>
                              <td style="text-align: center;">
                                <?php $query = "SELECT * FROM `classes_time_tables` 
                                            WHERE period_id='" . $period->period_id . "'
                                            AND `" . $w_index . "` = '1'
                                            AND `class_id` = '" . $class->class_id . "' 
                                            AND `section_id` = '" . $section->section_id . "'";
                                $teacher_subjects = $this->db->query($query)->result();
                                if ($teacher_subjects) { ?>

                                  <?php foreach ($teacher_subjects as $teacher_subject) { ?>

                                    <?php echo $teacher_subject->teacher_name ?> <br />
                                    <strong><?php echo $teacher_subject->short_title ?></strong><br />

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
                  </table>
                </h5>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
              <?php } ?>



            <?php } ?>
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