<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Class Timetable - GCMHS Boys Chitral</title>

  <link rel="stylesheet" media="all" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/cloud-ad min.css"); ?>" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/themes/def ault.css"); ?>" id="skin-switcher" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/respons ive.css"); ?>" />

  <style>
    @media print {
      .timetable-page {
        page-break-after: always;
      }

      .timetable-page:last-child {
        page-break-after: auto;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
      }

      th {
        background-color: #3498db;
        color: white;
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
      }

      td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2;
      }

      .section-highlight {
        color: inherit;
        font-weight: bold;
      }



      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
      }

      th {
        background-color: #3498db;
        color: white;
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
      }

      td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2;
      }

      .section-highlight {
        color: inherit;
        font-weight: bold;
      }

    }
  </style>
</head>

<body>
  <div class="container">
    <?php foreach ($classes as $class) { ?>
      <?php foreach ($class->sections as $section) {
        $query = "SELECT teacher_name,
                                  teacher_id
                                    FROM `classes_time_tables`
                                    WHERE `classes_time_tables`.`class_teacher`='1' 
                                    AND `classes_time_tables`.`class_id`='" . $class->class_id . "'
                                    AND  `classes_time_tables`.`section_id`='" . $section->section_id . "'";
        $class_teacher = $this->db->query($query)->row();
      ?>
        <div class="timetable-page">
          <div class="timetable-container">
            <div class="header-section" style="color: <?php echo $section->color;  ?> !important;">
              <div class="row">

                <div class="col-md-12">

                  <h2 style="padding: 0px;"><strong> Class <?php echo $class->Class_title; ?> <span style="co lor: <?php echo $section->color;  ?>;">
                        <?php echo $section->section_title; ?>
                      </span> Timetable for Session

                      <?php
                      $query = "SELECT `session` as a_session FROM `session` WHERE session.active=1 ORDER BY session_id DESC LIMIT 1;";
                      $a_session = $this->db->query($query)->row();
                      echo $a_session->a_session;
                      ?>

                    </strong></h2>
                  <hr />
                  <h4><strong>Incharge Teacher:
                      <?php
                      //var_dump($class_teacher);
                      if ($class_teacher) {
                        echo $class_teacher->teacher_name;
                      }
                      ?>
                    </strong><br />
                    <small><strong>Government Centennial Model High School (Boys) Chitral</strong></small>
                  </h4>
                  </strong>

                </div>


                <div style="display: none;" class="col-md-1">
                  <?php
                  if ($class_teacher and $class_teacher->teacher_id > 0) {
                    $user = "";
                    $user = $this->db->get_where('users', array('teacher_id' => $class_teacher->teacher_id))->row();
                    if ($user->user_image) { ?>
                      <img src="<?php echo base_url("assets/uploads/" . $user->user_image) ?>" width="100%">
                    <?php  } else { ?>
                      <div width="100%"></div>
                  <?php }
                  }

                  ?>
                </div>

              </div>

            </div>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Days</th>
                  <?php foreach ($periods as $period) { ?>
                    <?php if ($period->period_id != 7) { ?>
                      <th><?php echo $period->period_title; ?></th>
                    <?php } else { ?>
                      <th><?php echo $period->period_title; ?></th>
                    <?php } ?>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
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
                    <th><strong><?php echo $week; ?></strong></th>
                    <?php foreach ($periods as $period) {
                      if ($period->period_id != 7) { ?>
                        <td>
                          <?php
                          $query = "SELECT * FROM `classes_time_tables` 
                                                        WHERE period_id='" . $period->period_id . "'
                                                        AND `" . $w_index . "` = '1'
                                                        AND `class_id` = '" . $class->class_id . "' 
                                                        AND `section_id` = '" . $section->section_id . "'";
                          $teacher_subjects = $this->db->query($query)->result();

                          if ($teacher_subjects) { ?>
                            <?php foreach ($teacher_subjects as $teacher_subject) { ?>
                              <div style="margin-bottom: 5px; text-align: center;">
                                <?php echo $teacher_subject->teacher_name ?><br>
                                <strong><?php echo $teacher_subject->short_title ?></strong>
                              </div>
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
              <tfoot></tfoot>
              <tr>
                <td colspan="11" style="text-align: center;">
                  <small>Generated on <?php echo date('d/m/Y H:i'); ?> | GCMHS Boys Chitral</small>
                </td>
              </tr>
            </table>

          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
</body>

</html>