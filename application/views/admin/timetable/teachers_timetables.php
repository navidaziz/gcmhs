<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title><?php echo $system_global_settings[0]->system_title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/cloud-admin.css"); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/themes/default.css"); ?>" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/responsive.css"); ?>" />

  <!-- STYLESHEETS -->
  <!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->

  <link href="<?php echo site_url("assets/" . ADMIN_DIR . "font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" />

  <!-- ANIMATE -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/animatecss/animate.min.css"); ?>" />

  <!-- date picker-->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "js/bootstrap-datepicker/css/bootstrap-datepicker.css"); ?>" />

  <!-- JQUERY -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>

  <!-- BOOTSTRAP -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

  <!-- GRITTER -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "js/gritter/css/jquery.gritter.css"); ?>" />
  <!-- FONTS -->
  <link href='<?php echo site_url("assets/" . ADMIN_DIR . "css/fonts.css"); ?>' rel='stylesheet' type='text/css' />

  <!-- jstree resources -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "jstree-dist/jstree.min.js"); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "jstree-dist/themes/default/style.min.css"); ?>" />

  <!-- HUBSPOT MESSENGER -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "js/hubspot-messenger/css/messenger.min.css"); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "js/hubspot-messenger/css/messenger-theme-flat.min.css"); ?>" />
  <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "js/hubspot-messenger/js/messenger.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "js/hubspot-messenger/js/messenger-theme-flat.js"); ?>"></script>
  <!-- HUBSPOT MESSENGER -->
  <!-- SELECT2 -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/select2/select2.min.css" />
  <!-- TYPEAHEAD -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/typeahead/typeahead.css" />
  <!-- SELECT2 -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/select2/select2.min.css" />
  <!-- UNIFORM -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/uniform/css/uniform.default.min.css" />

  <!-- DATE PICKER -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/datepicker/themes/default.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/datepicker/themes/default.date.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/datepicker/themes/default.time.min.css" />


  <!-- custome styhles -->

  <!--<script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/script.js"); ?>"></script>-->
  <?php if ($this->lang->line('direction') == "rtl") { ?>
    <style>
      .sidebar-menu>ul>li>ul.sub>li>a {
        color: #555555;
        font-size: 13px;
        font-weight: 400;
        margin-right: 15px !important;
        padding-right: 5px !important;
      }
    </style>
  <?php } ?>

  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/tinymce/js/tinymce/tinymce.min.js"></script>

  <script>
    function printData(table_id) {
      var divToPrint = document.getElementById(table_id);

      newWin = window.open("");
      newWin.document.write(divToPrint.outerHTML);
      newWin.print();
      newWin.close();

    }



    var stakeholder_or_activity = "";

    function get_list(from, where_get, change_field_id) {
      //alert(from);
      id = $('#' + where_get + '_f').val();

      //alert(where_get);





      url = "<?php echo base_url() . "" . ADMIN_DIR; ?>";
      url = url + from;
      url = url + "/get_json/" + where_get + "/";
      url = url + id;
      console.log(url);
      $.ajax({
        type: "POST",
        url: url,
        data: {}
      }).done(function(data) {
        var obj = JSON.parse(data);
        var option = "";
        for (var id in obj) {
          option = option + "<option value='" + obj[id].id + "'>" + obj[id].value + "</option>";
        }
        $("#" + change_field_id + "_f").html(option);
      });

    }
  </script>

  <!-- time line -->
  <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/horizontal_timeline/css/reset.css">
  <!-- CSS reset -->
  <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/horizontal_timeline/css/style.css">
  <!-- Resource style -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/horizontal_timeline/js/modernizr.js"></script><!-- Modernizr -->
  <!-- end time line -->
  <!-- Bootstrap core CSS -->
  <link href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
  <section id="page">

    <div class="container">
      <div class="col-md-12">


        <div id="error"></div>

        <?php foreach ($teachers as $teacher) { ?>

          <table id="example" class="table table-bordered" style="font-size:10px !important; width: 10% !important; float: left;">
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

                          <strong style="color:  <?php echo $teacher_subject->color ?>;">
                            <?php echo $teacher_subject->subject_title ?>-<?php echo $teacher_subject->Class_title;  ?>
                          </strong><br />

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


      </div>
    </div>
  </section>
</body>

</html>