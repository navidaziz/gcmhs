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
            <h5>
              <table id="example" class="table table-bordered" style="margin-bottom: 15px !important;">
                <thead>
                  <tr>
                    <th colspan="11" style="text-align: center;">
                      <div style="margin-top: 20px !important;">
                        Classes and section timetable
                      </div>
                    </th>
                  </tr>
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
                  <?php } ?>
                </tbody>
              </table>


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