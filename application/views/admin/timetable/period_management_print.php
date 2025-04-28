<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Teacher Wise General Time Table</title>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      font-size: 12px;
    }

    table {
      border-collapse: collapse;
      margin: 5px 10px;
      width: 95%;
      font-family: Verdana, Geneva, sans-serif;
      font-size: 10px;
    }

    thead {
      font-weight: bold;
    }

    table,
    th,
    td {
      border: 1px solid gray;
      height: 17px;
      text-align: center;
    }

    .heading {
      margin-top: 20px;
      text-align: center;
    }

    .period-cell {
      width: 100px;
      white-space: nowrap;
    }
  </style>
</head>

<body>

  <div class="container">
    <section>
      <div class="heading">
        <h3>Government Centennial Model High School, Boys Chitral</h3>
        <h4>Teacher Wise General Time Table for Session 2021-2022</h4>
      </div>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Teacher</th>
            <th>Incharge</th>
            <th>Total</th>
            <?php foreach ($periods as $period) { ?>
              <th><?php echo $period->period_title; ?></th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          foreach ($teachers as $teacher) {
          ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $teacher->teacher_name . '-' . $teacher->teacher_designation; ?></td>

              <?php
              $query = "SELECT Class_title, section_title, color 
                                  FROM classes_time_tables 
                                  WHERE class_teacher = '1' 
                                  AND teacher_id = '" . $teacher->teacher_id . "'";
              $class_teacher = $this->db->query($query)->result();

              if (!empty($class_teacher)) {
                echo '<td style="background-color:' . $class_teacher[0]->color . '">';
                echo str_replace("th", "", $class_teacher[0]->Class_title) . '-' . substr($class_teacher[0]->section_title, 0, 1);
                echo '</td>';
              } else {
                echo '<td></td>';
              }
              ?>

              <td><?php echo $teacher->class_total; ?></td>

              <?php
              foreach ($periods as $period) {
                $query = "SELECT 
                                        classes.Class_title, sections.section_title, sections.color, 
                                        subjects.subject_title, subjects.short_title, 
                                        class_subjects.total_class_week, period_subjects.period_subject_id
                                      FROM 
                                        class_section_subject_teachers,
                                        period_subjects,
                                        classes,
                                        sections,
                                        class_subjects,
                                        subjects
                                      WHERE 
                                        class_section_subject_teachers.class_section_subject_teacher_id = period_subjects.class_section_subject_teacher_id
                                        AND classes.class_id = class_section_subject_teachers.class_id
                                        AND sections.section_id = class_section_subject_teachers.section_id
                                        AND class_subjects.class_subject_id = class_section_subject_teachers.class_subject_id
                                        AND subjects.subject_id = class_subjects.subject_id
                                        AND period_subjects.period_id = '" . $period->period_id . "'
                                        AND period_subjects.teacher_id = '" . $teacher->teacher_id . "'";
                $period_subjects = $this->db->query($query)->result();
              ?>

                <td style="text-align: center;">
                  <?php
                  if (!empty($period_subjects)) {
                    foreach ($period_subjects as $period_subject) {
                  ?>
                      <div class="period-cell" style="width:100%; padding:3px; margin-bottom:2px; background-color:<?php echo $period_subject->color; ?>;">
                        <?php
                        echo $period_subject->Class_title . " : " . $period_subject->section_title . "<br />";
                        echo substr($period_subject->subject_title, 0, 10) . "<br />";

                        if ($period_subject->total_class_week < 6 && $period_subject->total_class_week > 0) {
                          $week_query = "SELECT * FROM period_subjects 
                                        WHERE period_subject_id = '" . $period_subject->period_subject_id . "'";
                          $weeks = $this->db->query($week_query)->result();

                          if (!empty($weeks)) {
                            echo '<strong>';
                            foreach ($weeks as $week) {
                              if ($week->mon) echo "M-";
                              if ($week->tue) echo "T-";
                              if ($week->wed) echo "W-";
                              if ($week->thu) echo "T-";
                              if ($week->fri) echo "F-";
                              if ($week->sat) echo "S";
                            }
                            echo '</strong>';
                          }
                        }
                        ?>
                      </div>

                  <?php
                    }
                  } else {
                    if ($period->period_id == 7) {
                      echo '<p style="text-align:center">-</p>';
                    }
                  }
                  ?>
                </td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </section>
  </div>

</body>

</html>