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



          <?php foreach ($teachers as $teacher) { ?>

            <table id="example" class="table table-border" cellspacing="0" width="45%" style="float:left; font-size:11px">
              <thead>
                <tr>
                  <th colspan="11"><?php echo $teacher->teacher_name; ?></th>
                </tr>
                <tr>
                  <th>#</th>
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
                    <td><?php echo $week; ?></td>
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
                              <?php echo $teacher_subject->short_title ?>-<?php echo $teacher_subject->Class_title;  ?>
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