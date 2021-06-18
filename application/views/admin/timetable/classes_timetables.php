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
      <!--<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
     
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR . "exams/view/"); ?>"><?php echo $this->lang->line('Exams'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
     
      <div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
        <div class="col-md-6">
          <div class="pull-right"> <a target="new" class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "exam_list/paper_collection_report/" . $exams[0]->exam_id); ?>">Print</a> </div>
        </div>
      </div>
    </div>
  </div>
</div>-->
      <!-- /PAGE HEADER -->


      <div class="row">
        <div class="col-sm-12">

        </div>
      </div>
      <!-- /PAGE HEADER -->

      <!-- PAGE MAIN CONTENT -->
      <div class="row">
        <!-- MESSENGER -->
        <div class="col-md-12">
          <div class="box border blue" id="messenger" style="margin-top:5px !important">
            <div class="box-title">
              <h4><i class="fa fa-bell"></i>Class Time Tables</h4>

            </div>
            <div class="box-body">
              <div class="table-responsive" style="font-size:11px !important;">
                <div class="row">



                  <?php foreach ($classes as $class) { ?>

                    <div class="col-md-12">


                      <div id="error"></div>

                      <?php foreach ($class->sections as $section) { ?>
                        <h3><?php echo $class->Class_title; ?> <?php echo $class->class_id; ?> <?php echo $section->section_title; ?> <?php echo $section->section_id; ?></h3>

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
                              <td><?php echo $week; ?></td>
                              <?php echo $query = "SELECT * FROM `classes_time_tables` 
                                            WHERE period_id='" . $period->id . "'
                                            AND `" . $w_index . "` = '1'
                                            AND `class_id` = '" . $class->id . "' 
                                            AND `section_id` = '" . $section->id . "'";
                              $teacher_subjects = $this->db->query()->result();
                              if ($teacher_subjects) { ?>
                                <?php foreach ($teacher_subjects as $teacher_subject) { ?>
                                  <?php echo $teacher_subject->teacher_name ?> <br />
                                  <?php echo $teacher_subject->subject_title ?>
                                <?php } ?>
                              <?php } ?>
                            <?php } ?>

                          </tbody>
                        </table>


                      <?php } ?>


                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /MESSENGER -->
      </div>
</body>

</html>