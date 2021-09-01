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
              <!-- MESSENGER -->
              <div class="row">
                <?php foreach ($classes as $class) { ?>
                  <div class="col-md-4" style="min-height: 800px;">
                    <?php
                    $count = 1;
                    foreach ($class->sections as $section) { ?>

                      <?php $query = "SELECT * FROM `daily_class_wise_attendance`
                    WHERE class_id = '" . $class->class_id . "'
                    AND section_id = '" . $section->section_id . "'
                    AND DATE(created_date) = DATE(NOW())";
                      $today_attendance_summary = $this->db->query($query)->result(); ?>
                      <?php echo $class->Class_title; ?> - <?php echo $section->section_title; ?> Today Attendance Summary
                      <table class="table" style="background-color: <?php echo $section->color; ?>;">
                        <tr>
                          <th style="text-align: center;">Total</th>
                          <th style="text-align: center;">Morning P</th>
                          <th style="text-align: center;">A</th>
                          <th style="text-align: center;">L</th>
                          <th style="text-align: center;">CL</th>
                          <th style="text-align: center;">Evening A</th>
                        </tr>
                        <?php if ($today_attendance_summary) { ?>
                          <tr>
                            <th style="text-align: center;"><?php echo $today_attendance_summary[0]->total; ?></th>
                            <th style="text-align: center;"><?php echo $today_attendance_summary[0]->present; ?></th>
                            <th style="text-align: center;"><?php echo $today_attendance_summary[0]->absent; ?></th>
                            <th style="text-align: center;"><?php echo $today_attendance_summary[0]->leave; ?></th>
                            <th style="text-align: center;"><?php echo $today_attendance_summary[0]->corona_leave; ?></th>
                            <th style="text-align: center;"><?php echo $today_attendance_summary[0]->evening_absent; ?></th>
                          </tr>
                        <?php } else { ?>
                          <tr>
                            <td colspan="6">Morning Attendance Pending..</td>
                          </tr>
                        <?php } ?>
                      </table>

                    <?php } ?>
                  </div>

                <?php } ?>
              </div>
            </div>
          </div>



        </div>


      </div>

    </div>
  </div>
  <!-- /MESSENGER -->
</div>