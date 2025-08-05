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
                  <h4>Free Teachers</h2>
              </div>
              <table id="example" class="table table-bordered" style="margin-bottom: 15px !important; font-size: 10px !important;">
                <thead>

                  <tr>
                    <?php foreach ($periods as $period) { ?>
                      <?php if ($period->period_id != 7) { ?>
                        <th><?php echo $period->period_title;  ?></th>
                      <?php }  ?>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($periods as $period) {
                    if ($period->period_id != 7) {  ?>

                      <td>
                        <ol style="padding: 10px;">
                          <?php $query = "SELECT *, (SELECT SUM(`class_subjects`.`total_class_week`)  
                                                            FROM `class_section_subject_teachers`, `class_subjects`
                                                             WHERE `class_subjects`.`class_subject_id` = `class_section_subject_teachers`.`class_subject_id` 
                                                             AND `class_section_subject_teachers`.`teacher_id`=teachers.teacher_id) as total_classes 
                                                             FROM teachers WHERE teacher_id NOT IN (SELECT teacher_id FROM `period_subjects` WHERE period_id='" . $period->period_id . "') 
                                                             AND teachers.status=1
                                                             ORDER BY total_classes ASC";
                          $free_teachers = $this->db->query($query)->result();
                          if ($free_teachers) { ?>

                            <?php
                            $teacher_count = 1;
                            foreach ($free_teachers as $free_teacher) { ?>
                              <strong style="color:black">
                                <li><?php echo str_ireplace("Muhammad", "M.", $free_teacher->teacher_name) ?> (
                                  <?php
                                  if ($free_teacher->total_classes) {
                                    echo $free_teacher->total_classes;
                                  } else {
                                    echo 0;
                                  }
                                  ?>
                                  )
                                  <?php $query = "SELECT COUNT(*) as total FROM `classes_time_tables` 
                                                  WHERE teacher_id = $free_teacher->teacher_id
                                                  AND period_id='" . ($period->period_id - 1) . "'";
                                  if ($this->db->query($query)->result()[0]->total > 0) {
                                    echo "<";
                                  }

                                  ?>

                                  <?php $query = "SELECT COUNT(*) as total FROM `classes_time_tables` 
                                                  WHERE teacher_id = $free_teacher->teacher_id
                                                  AND period_id='" . ($period->period_id + 1) . "'";
                                  if ($this->db->query($query)->result()[0]->total > 0) {
                                    echo ">";
                                  }

                                  ?>
                                </li>
                              </strong>

                            <?php } ?>

                          <?php } else { ?>
                            -
                          <?php } ?>
                        </ol>
                      </td>
                    <?php } ?>
                  <?php } ?>
                  </tr>

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