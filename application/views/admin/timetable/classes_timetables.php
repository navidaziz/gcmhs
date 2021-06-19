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
          <style>
            table {
              border-collapse: collapse;
              margin: 5px;
              margin-left: 10px;
              font-family: Verdana, Geneva, sans-serif !important;

            }

            thead {
              font-weight: bold;
            }

            table,
            th,
            td {
              border: 1px solid black;
              height: 17px;
            }
          </style>
          <?php foreach ($classes as $class) { ?>

            <div class="col-md-12">


              <div id="error"></div>

              <?php foreach ($class->sections as $section) { ?>
                <h3><?php echo $class->Class_title; ?> <?php echo $section->section_title; ?> </h3>

                <table id="example" class="table table-bordered" style="font-size:10px !important">
                  <thead>
                    <th>#</th>
                    <?php foreach ($periods as $period) { ?>
                      <th><?php echo $period->period_title;  ?></th>
                    <?php } ?>

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
                        <?php foreach ($periods as $period) { ?>
                          <td>
                            <?php $query = "SELECT * FROM `classes_time_tables` 
                                            WHERE period_id='" . $period->period_id . "'
                                            AND `" . $w_index . "` = '1'
                                            AND `class_id` = '" . $class->class_id . "' 
                                            AND `section_id` = '" . $section->section_id . "'";
                            $teacher_subjects = $this->db->query($query)->result();
                            if ($teacher_subjects) { ?>

                              <?php foreach ($teacher_subjects as $teacher_subject) { ?>

                                <?php echo $teacher_subject->teacher_name ?> <br />
                                <strong><?php echo $teacher_subject->subject_title ?>-<?php echo $teacher_subject->per_week_class ?><strong><br />

                                  <?php } ?>

                                <?php } else { ?>
                                  -
                                <?php } ?>
                          </td>
                        <?php } ?>
                      </tr>
                    <?php } ?>

                  </tbody>
                </table>


              <?php } ?>


            </div>
          <?php } ?>
        </section>
      </div>
    </div>
  </div>
  </div>
  <!-- /MESSENGER -->
  </div>
</body>

</html>