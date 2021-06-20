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
        <section>
          <style>
            table {
              border-collapse: collapse;
              margin: 10px;
              margin-left: 10px;
              font-family: Verdana, Geneva, sans-serif !important;

            }

            thead {
              font-weight: bold;
            }

            table,
            th,
            td {
              border: 1px solid gray;
              height: 17px;
              margin: 5px;
            }
          </style>
          <h6>

            <?php foreach ($teachers as $teacher) { ?>
              <div style="width: 46%; float: left; margin: 5px; margin-left: 5px;">
                <table id="example" class="table table-bordered" cellspacing="0" width="100%" style="float:left; font-size:11px">
                  <thead>
                    <tr>
                      <th colspan="11" style="text-align: left !important;">
                        <strong><?php echo $teacher->teacher_name; ?> - <?php echo $teacher->teacher_designation; ?></strong>
                        <span style="float: right;">
                          <?php $query = "SELECT Class_title, section_title, color 
                              FROM `classes_time_tables`  
                              WHERE `classes_time_tables`.`class_teacher`='1' 
                              and teacher_id='" . $teacher->teacher_id . "'";
                          $class_teacher = $this->db->query($query)->result();
                          if ($class_teacher) {
                            echo '<span style="float:right"> Incharge Teacher: Class ';
                            echo $class_teacher[0]->Class_title . " - " . $class_teacher[0]->section_title;
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
                                  <?php if ($teacher_subject->short_title != 'Nazira') { ?>
                                    <?php echo substr($teacher_subject->short_title, 0, 4); ?>-
                                  <?php } ?>


                                  <?php echo str_replace("th", "", $teacher_subject->Class_title);  ?>-<?php echo substr($teacher_subject->section_title, 0, 1);  ?>
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
              </div>

            <?php } ?>

          </h6>
        </section>
      </div>
    </div>
  </div>
  </div>
  <!-- /MESSENGER -->
  </div>
</body>

</html>