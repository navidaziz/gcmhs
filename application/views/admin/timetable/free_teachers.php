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
                      <?php } else { ?>
                        <th rowspan="6"><?php echo $period->period_title;  ?></th>
                      <?php } ?>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($periods as $period) {
                    if ($period->period_id != 7) {  ?>
                      <td style="text-align: center;">
                        <?php $query = "SELECT * FROM teachers 
                                        WHERE teacher_id NOT IN (SELECT teacher_id FROM `period_subjects` 
                                        WHERE period_id='" . $period->period_id . "')";
                        $free_teachers = $this->db->query($query)->result();
                        if ($free_teachers) { ?>

                          <?php foreach ($free_teachers as $free_teacher) { ?>

                            <?php echo $free_teacher->teacher_name ?> <br />

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