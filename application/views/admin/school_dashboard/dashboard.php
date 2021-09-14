<!-- PAGE HEADER-->
<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 30px;">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
        </li>
        <li><?php echo $title; ?></li>
      </ul>


    </div>
  </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
        <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
      </div>
      <div class="box-body">

        <div class="table-responsive">
          <div class="row">
            <div class="col-md-12">

              <table class="table ">

                <tr>
                  <th>Class</th>
                  <?php for ($i = 1; $i <= 30; $i++) { ?>
                    <th><?php echo $i ?></th>
                  <?php } ?>
                  <th>Month</th>
                </tr>
                <?php foreach ($classes as $class) { ?>
                  <?php
                  $count = 1;
                  foreach ($class->sections as $section) { ?>

                    <?php

                    $query = "SELECT teacher_name FROM `classes_time_tables` 
                                WHERE `class_teacher` = 1 
                                AND class_id = '" . $class->class_id . "'
                                AND section_id = '" . $section->section_id . "'";
                    $teacher_name = $this->db->query($query)->result()[0]->teacher_name;


                    $query = "SELECT * FROM `daily_class_wise_attendance`
                    WHERE class_id = '" . $class->class_id . "'
                    AND section_id = '" . $section->section_id . "'
                    AND DATE(created_date) = DATE(NOW())";
                    $today_attendance_summary = $this->db->query($query)->result(); ?>
                    <tr>
                      <td> <span title=" <?php echo $teacher_name; ?>"><?php echo $class->Class_title; ?> - <?php echo $section->section_title; ?></span>
                      </td>

                      <?php for ($i = 1; $i <= 30; $i++) {
                        $query = "SELECT * FROM `daily_class_wise_attendance`
                        WHERE class_id = '" . $class->class_id . "'
                        AND section_id = '" . $section->section_id . "'
                        AND DATE(created_date) = DATE('" . date("Y-m-") . $i . "')";
                        $attendance_summary = $this->db->query($query)->result();

                      ?>
                        <td><?php
                            if ($attendance_summary[0]->total) {
                              //echo round(($attendance_summary[0]->absent * 100) / ($attendance_summary[0]->total - $today_attendance_summary[0]->corona_leave));
                              echo $attendance_summary[0]->absent;
                            } ?></td>
                      <?php } ?>

                      <?php $query = "SELECT AVG(absent) as absent  FROM `daily_class_wise_attendance`
                        WHERE class_id = '" . $class->class_id . "'
                        AND section_id = '" . $section->section_id . "'
                        AND MONTH(created_date) = MONTH(NOW())
                        AND YEAR(created_date)  = YEAR(NOW())";
                      $attendance_summary = $this->db->query($query)->result();

                      ?>
                      <td><?php
                          if ($attendance_summary[0]->absent) {
                            echo round($attendance_summary[0]->absent, 2);
                          } ?></td>
                    </tr>


                  <?php } ?>

                <?php } ?>


              </table>







            </div>
          </div>



        </div>


      </div>

    </div>
  </div>
  <!-- /MESSENGER -->
</div>