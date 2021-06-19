<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />

<head>
</head>

<body>

  <!-- /PAGE HEADER -->

  <!-- PAGE MAIN CONTENT -->
  <div class="row" style="font-size:12px !important; font-family: Open Sans !important">
    <!-- MESSENGER -->
    <div class="col-md-12">
      <div class="container">
        <section contenteditable="true">

          <div class="col-md-12">
            <?php foreach ($classes as $class) { ?>



              <table id="example" class="table table-bordered">

                <?php foreach ($class->sections as $section) { ?>



                  <thead>
                    <tr>
                      <th colspan="11">
                        <h3><?php echo $class->Class_title; ?> <?php echo $section->section_title; ?> </h3>
                      </th>
                    </tr>
                    <tr>
                      <th>#</th>
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



                <?php } ?>

              </table>

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