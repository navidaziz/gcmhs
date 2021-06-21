<!-- PAGE HEADER-->
<!DOCTYPE html>

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
              border: 1px solid gray;
              height: 17px;
            }
          </style>

          <div style="margin-top: 20px !important; text-align: center;">
            <h3>Government Centennial Model High School, Boys Chitral</h2>
              <h4>Teacher Wise General Time Table for Session 2021-2022</h2>
          </div>
          <table class="table table-bordered" style="font-size:10px !important; width: 95%; margin: 5px;">
            <thead>
              <th>#</th>
              <th>Teacher</th>
              <th>inch</th>
              <th>Tot</th>
              <?php

              foreach ($periods as $period) { ?>
                <th><?php echo $period->period_title;  ?></th>
              <?php } ?>

            </thead>
            <tbody>
              <?php
              $count = 1;
              foreach ($teachers as $teacher) { ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo $teacher->teacher_name;  ?>-<?php echo $teacher->teacher_designation; ?>
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
                              ";  ?>
                            <?php //if ($period_subject->total_class_week != 6) { 
                            ?>
                            <?php if ($period_subject->total_class_week < 6) {
                              echo '<small> ';
                              $query = "SELECT * FROM `period_subjects` WHERE period_subject_id='" . $period_subject->period_subject_id . "'";
                              $period_weeks = $this->db->query($query)->result();
                              foreach ($period_weeks as $weeks) {
                                if ($weeks->mon) {
                                  echo "M-";
                                }
                                if ($weeks->tue) {
                                  echo "T-";
                                }
                                if ($weeks->wed) {
                                  echo "W-";
                                }
                                if ($weeks->thu) {
                                  echo "T-";
                                }
                                if ($weeks->fri) {
                                  echo "F-";
                                }
                                if ($weeks->sat) {
                                  echo "S";
                                }
                              }
                              echo '</small>'
                            ?>

                            <?php } ?>

                          </span>
                          <?php //} 
                          ?>



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