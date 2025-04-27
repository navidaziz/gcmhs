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
              <h4><i class="fa fa-bell"></i> School Time Table</h4>

            </div>
            <div class="box-body">
              <div class="table-responsive">

                <!-- MESSENGER -->
                <script>
                  function update_per_week_classes(class_subject_id) {
                    var total_class_week = $('#total_class_week' + class_subject_id).val();

                    $.ajax({
                      type: "POST",
                      url: "<?php echo site_url(ADMIN_DIR . "timetable/update_total_class_week"); ?>/" + class_subject_id,
                      data: {
                        total_class_week: total_class_week
                      }
                    }).done(function(msg) {
                      //$("#status-"+id).html(msg) 
                      //alert(msg);
                    });

                  }
                </script>





                <table id="example" class="table table-bordered table_small" style="font-size:10px !important">
                  <thead>
                    <th>#</th>
                    <th>Teacher Name</th>
                    <th>Designation</th>
                    <th>inch</th>
                    <th>Total Classes</th>
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
                        <td>
                          <?php
                          $user = "";
                          $user = $this->db->get_where('users', array('teacher_id' => $teacher->teacher_id))->row();
                          if ($user->user_image) {
                            echo file_type(base_url("assets/uploads/" . $user->user_image), false, 30, 30);
                          }
                          ?>
                          <?php echo $teacher->teacher_name;  ?>
                        </td>
                        <td> <?php echo $teacher->teacher_designation; ?>
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
    `classes`.`Class_title`,
    `classes`.`class_id`,
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
                                  <a href="<?php echo site_url(ADMIN_DIR . "timetable/period_management/" . $period_subject->class_id); ?>" style="color:#fff; text-decoration:none">
                                    <?php echo str_replace("th", "", $period_subject->Class_title) . " " . substr($period_subject->section_title, 0, 1) . " " . $period_subject->short_title . " 
        - " . $period_subject->total_class_week;  ?>
                                  </a>
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


                                <a style="margin-left:5px;" href="javascript:return false;" onClick="add_subject('<?php echo $teacher->teacher_name . " - " . $teacher->teacher_designation; ?>', '<?php echo $teacher->teacher_id; ?>', '<?php echo $period->period_id; ?>')">+</a>
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



              </div>
            </div>
          </div>
        </div>
        <!-- /MESSENGER -->
      </div>
      <!-- Modal -->

      <script type="text/javascript">
        function add_subject(teacher_name, teacher_id, period_id) {
          $('#myModalBody').html('Wait ..... ');
          $('#myModalTitle').html(teacher_name);
          $.ajax({
            type: "POST",
            url: '<?php echo site_url(ADMIN_DIR . "timetable/get_teacher_classes"); ?>',
            data: {
              teacher_id: teacher_id,
              period_id: period_id
            }
          }).done(function(data) {
            $('#myModalBody').html(data);
          });




          $('#myModal').modal('show');
          $("#myModal").draggable({
            handle: ".modal-header"
          })
        }

        function update_weeks(heading, period_subject_id) {
          $('#myModalBody').html('Wait ..... ');
          $('#myModalTitle').html(heading);
          $.ajax({
            type: "POST",
            url: '<?php echo site_url(ADMIN_DIR . "timetable/update_weeks"); ?>',
            data: {
              period_subject_id: period_subject_id
            }
          }).done(function(data) {
            $('#myModalBody').html(data);
          });




          $('#myModal').modal('show');
          //    $("#myModal").draggable({
          //     handle: ".modal-header"
          // })
        }


        function updateWeeks(week_id, period_subject_id) {
          if ($('#' + week_id).is(":checked")) {
            $.ajax({
              type: "POST",
              url: '<?php echo site_url(ADMIN_DIR . "timetable/update_week_value"); ?>',
              data: {
                period_subject_id: period_subject_id,
                week_value: 1,
                week_id: week_id
              }
            }).done(function(data) {

              //alert(data);

            });
          } else {
            $.ajax({
              type: "POST",
              url: '<?php echo site_url(ADMIN_DIR . "timetable/update_week_value"); ?>',
              data: {
                period_subject_id: period_subject_id,
                week_value: 0,
                week_id: week_id
              }
            }).done(function(data) {

              //alert(data);

            });
          }



        }
      </script>


      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width:60%">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="myModalTitle">Modal Header</h4>
            </div>
            <div class="modal-body" id="myModalBody">
              <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

      <script>
        $("#myModal").draggable({
          handle: ".modal-header"
        });


        //         $(document).ready(function(){
        //   $('#example').DataTable({

        //                 "bPaginate": false,
        // 				 dom: 'Bfrtip',
        //         buttons: [
        //             'print'
        //         ],
        // 		"order": [[ 0, 'asc' ]]

        //             });
        // });


        $(document).ready(function() {
          var table = $('#example').DataTable({
            "bPaginate": false,
            dom: 'Bfrtip',
            /* buttons: [
                 'print'
                 
                 
             ],*/

            "columnDefs": [{
              "searchable": false,
              "orderable": false,
              "targets": 0
            }],
            //"order": [[ 1, 'asc' ]]
          });


          table.on('order.dt search.dt', function() {
            table.column(0, {
              search: 'applied',
              order: 'applied'
            }).nodes().each(function(cell, i) {
              cell.innerHTML = i + 1;
              table.cell(cell).invalidate('dom');
            });
          }).draw();

        });
      </script>


      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

      <style>
        .table_small>tbody>tr>td,
        .table_small>tbody>tr>th,
        .table_small>tfoot>tr>td,
        .table_small>tfoot>tr>th,
        .table_small>thead>tr>td,
        .table_small>thead>tr>th {
          padding: 3px;
          line-height: 1.42857143;
          vertical-align: top;
          font-size: 10px;
          text-align: center;
        }
      </style>


</body>

</html>