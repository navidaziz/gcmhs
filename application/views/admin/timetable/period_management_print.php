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
          <table id="example" class="table table-bordered" style="font-size:10px !important">
            <thead>
              <th>#</th>
              <th>Teacher</th>
              <th>inch</th>
              <th>Tol</th>
              <?php

              foreach ($periods as $period) { ?>
                <th><?php echo $period->period_title;  ?></th>
              <?php } ?>

            </thead>
            <tbody>
              <?php
              $count = 1;
              foreach ($teachers as $teacher) { ?>
                <tr <?php if ($teacher->total_class_assigned == $teacher->period_assinged) { ?> style="background-color: #EAEAEA;" <?php } ?>>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo $teacher->teacher_name;  ?>
                    <br />
                    <?php echo $teacher->teacher_designation; ?>
                  </td>

                  <?php $query = "SELECT Class_title, section_title, color 
                                          FROM `classes_time_tables`  
                                          WHERE `classes_time_tables`.`class_teacher`='1' 
                                          and teacher_id='" . $teacher->teacher_id . "'";
                  $class_teacher = $this->db->query($query)->result();
                  if ($class_teacher) {
                    echo '<td style="background-color:' . $class_teacher[0]->color . '">';
                    echo str_replace("th", "", $class_teacher[0]->Class_title) . "-" . substr($class_teacher[0]->section_title, 0, 1);
                    echo '</td>';
                  } else {
                    echo '<td></td>';
                  }
                  ?>

                  <td><?php echo $teacher->class_total;  ?></td>
                  <?php foreach ($periods as $period) { ?>


                    <td style="width:100px !important; white-space: nowrap;">




                      <?php
                      $query = "SELECT
                                  `classes`.`Class_title`
                                  , `sections`.`section_title`
                                  , `sections`.`color`
                                  , `subjects`.`subject_title`
                                  , `subjects`.`short_title`
                                  , `class_subjects`.`total_class_week`
                                , `period_subjects`.`period_subject_id`
                                , `subjects`.`short_title`
                              FROM
                              `class_section_subject_teachers`
                              , `period_subjects` 
                              , `classes`
                              , `sections`
                              , `class_subjects`
                              , `subjects`  
                              WHERE `class_section_subject_teachers`.`class_section_subject_teacher_id` = `period_subjects`.`class_section_subject_teacher_id`
                              AND `classes`.`class_id` = `class_section_subject_teachers`.`class_id`
                              AND `sections`.`section_id` = `class_section_subject_teachers`.`section_id`
                              AND `class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id`
                              AND `subjects`.`subject_id` = `class_subjects`.`subject_id`
                              AND  `period_subjects`.`period_id`= '$period->period_id'
                              AND `period_subjects`.`teacher_id`= '$teacher->teacher_id'";
                      $result = $this->db->query($query);
                      $period_subjects = $result->result();
                      if ($period_subjects) {
                        $subject_count = 0;
                        foreach ($period_subjects as $period_subject) {


                          $subject_count += $period_subject->total_class_week;



                      ?>
                          <span style="background-color:<?php echo $period_subject->color; ?>; 
                                margin-bottom: 4px; padding:3px; border-radius:6px; display: block; 
                              ">
                            <?php /* echo $period_subject->Class_title . " " . substr($period_subject->section_title, 0, 1) . " " . $period_subject->short_title . " 
                                    - " . $period_subject->total_class_week; */ ?>
                            <?php echo str_replace("th", "", $period_subject->Class_title) . " " . substr($period_subject->section_title, 0, 1) . " " . $period_subject->short_title . " 
                                  - " . $period_subject->total_class_week;  ?>
                            <?php //if ($period_subject->total_class_week != 6) { 
                            ?>
                            <i onClick="update_weeks('Update Weekly Classes', '<?php echo $period_subject->period_subject_id; ?>')" class="fa fa-calendar" aria-hidden="true"></i>
                            <a href="<?php echo site_url(ADMIN_DIR . "timetable/remove_teacher_subject_period/$period_subject->period_subject_id"); ?>">x</a>
                            <?php if ($period_subject->total_class_week < 6) {
                              echo '<br /><small>';
                              $query = "SELECT * FROM `period_subjects` WHERE period_subject_id='" . $period_subject->period_subject_id . "'";
                              $period_weeks = $this->db->query($query)->result();
                              foreach ($period_weeks as $weeks) {
                                if ($weeks->mon) {
                                  echo "Mon-";
                                }
                                if ($weeks->tue) {
                                  echo "Tue-";
                                }
                                if ($weeks->wed) {
                                  echo "Wed-";
                                }
                                if ($weeks->thu) {
                                  echo "Thu-";
                                }
                                if ($weeks->fri) {
                                  echo "Fri-";
                                }
                                if ($weeks->sat) {
                                  echo "Sat";
                                }
                              }
                              echo '</small>'
                            ?>

                            <?php } ?>

                          </span>
                          <?php //} 
                          ?>



                        <?php } ?>



                        <?php if ($subject_count < 6) { ?> <br />
                          <a style="margin-left:5px;" href="javascript:return false;" onClick="add_subject('<?php echo $teacher->teacher_name . " - " . $teacher->teacher_designation; ?>', '<?php echo $teacher->teacher_id; ?>', '<?php echo $period->period_id; ?>')">+</a>


                        <?php } ?>





                      <?php  } else { ?>
                        <?php if ($period->period_id != 7) { ?>

                        <?php } else { ?>
                          <p style="text-align:center">-</p>
                        <?php } ?>

                      <?php } ?>
                    <?php } ?>
                    </td>


                </tr>
              <?php } ?>
            </tbody>
          </table>

        </section>
      </div>
    </div>
  </div>
  </div>
  <!-- /MESSENGER -->
  </div>
</body>

</html>