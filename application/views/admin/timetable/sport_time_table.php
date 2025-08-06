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
              <div style="margin-top: 20px !important; text-align: center;">
                <h3>Government Centennial Model High School, Boys Chitral</h2>
                  <h4>General Time Table for Session 2021-2022</h2>
              </div>
              <table id="example" class="table table-bordered" style="margin-bottom: 15px !important;">
                <thead>

                  <tr>
                    <th>Classes</th>
                    <th>Sections</th>
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
                  <?php foreach ($classes as $class) { ?>
                    <?php foreach ($class->sections as $section) { ?>
                      <tr>
                        <td><?php echo $class->Class_title; ?></td>
                        <td> <?php echo $section->section_title; ?></td>
                        <?php foreach ($periods as $period) {
                          if ($period->period_id != 7) {
                        ?>
                            <td style="text-align: center;">
                              <?php $query = "SELECT * FROM `classes_time_tables` 
                                            WHERE period_id='" . $period->period_id . "'
                                            AND `class_id` = '" . $class->class_id . "' 
                                            AND `section_id` = '" . $section->section_id . "'
                                            AND short_title IN('PT', 'Sport')";
                              $teacher_subjects = $this->db->query($query)->result();
                              if ($teacher_subjects) { ?>

                                <?php foreach ($teacher_subjects as $teacher_subject) { ?>

                                  <?php echo $teacher_subject->teacher_name ?> <br />
                                  <strong><?php echo $teacher_subject->short_title ?></strong><br />
                                  <small>
                                    <?php
                                    $days = array();
                                    if ($teacher_subject->mon) {
                                      $days[] = 'Mon';
                                    } ?>
                                    <?php if ($teacher_subject->tue) {
                                      $days[] = 'Tue';
                                    } ?>
                                    <?php if ($teacher_subject->wed) {
                                      $days[] = 'Wed';
                                    } ?>
                                    <?php if ($teacher_subject->thu) {
                                      $days[] = 'Thu';
                                    } ?>
                                    <?php if ($teacher_subject->fri) {
                                      $days[] = 'Fri';
                                    } ?>
                                    <?php if ($teacher_subject->sat) {
                                      $days[] = 'Sat';
                                    }
                                    echo implode(", ", $days);
                                    $days = array(); // Reset the days array for the next iteration
                                    ?></small>

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
                  <?php } ?>
                </tbody>
              </table>
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