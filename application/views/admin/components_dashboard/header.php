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



  <!--<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/my_fucking_style.css"); ?>" />-->
  <header class="navbar clearfix" id="header">
    <div class="container">
      <table style="width: 100%;">
        <tr>
          <td><a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>">
              <img style="margin-right: 5px;
    border-radius: 99px;
    height: 35px;
    width: 35px;" src="<?php echo site_url("assets/uploads/" . $system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>"></a>
          </td>
          <td>
            <ul class="nav navba r-nav pull-right">


              <li style="float:right;" class="dropdown user" id="header-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img alt="" src="<?php echo site_url("assets/uploads/" . $this->session->userdata("user_image")); ?>" />
                  <span class="username"><?php echo $this->session->userdata("user_title"); ?></span>
                  <i class="fa fa-angle-down"></i> </a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo site_url(ADMIN_DIR . "users/update_profile"); ?>"><i class="fa fa-user"></i> Update Profile</a></li>
                  <li><a href="<?php echo site_url(ADMIN_DIR . "users/logout"); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>

                </ul>
              </li>



              <!-- END USER LOGIN DROPDOWN -->
            </ul>
          </td>
        </tr>
      </table>


      <!-- BEGIN TOP NAVIGATION MENU -->

      <!-- END TOP NAVIGATION MENU -->
    </div>
  </header>
  <!--/HEADER -->

  <!-- PAGE -->
  <section id="page">

    <div>
      <div class="container">
        <div class="row">
          <div id="content" class="col-lg-12">