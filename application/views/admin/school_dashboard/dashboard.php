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
                  <?php
                  $monthly_absent_avg = '';
                  $class_sections = '';
                  $absent_avg = '';
                  $present_avg = '';
                  $leave_avg = '';
                  $staggered_avg = '';
                  for ($i = 1; $i <= 30; $i++) { ?>
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

                      <?php $query = "SELECT AVG(absent) as absent, AVG(present) as present, AVG(corona_leave) as staggered, AVG(`leave`) as `leave` 
                        FROM `daily_class_wise_attendance`
                        WHERE class_id = '" . $class->class_id . "'
                        AND section_id = '" . $section->section_id . "'
                        AND MONTH(created_date) = MONTH(NOW())
                        AND YEAR(created_date)  = YEAR(NOW())";
                      $attendance_summary = $this->db->query($query)->result();



                      ?>
                      <td><?php
                          if ($attendance_summary[0]->absent) {
                            echo round($attendance_summary[0]->absent, 2);
                            $monthly_absent_avg .= "{
                              name: '" . $class->Class_title . "-" . $section->section_title . "-" . $teacher_name . "',
                              low: " . round($attendance_summary[0]->absent, 2) . ",
                              color: '" . $section->section_title . "',
                            },";
                            $class_sections .= "'" . $class->Class_title . "-" . $section->section_title . "-" . $teacher_name . "', ";
                            $absent_avg .= round($attendance_summary[0]->absent, 2) . ', ';
                            $present_avg .= round($attendance_summary[0]->present, 2) . ', ';
                            $leave_avg .= round($attendance_summary[0]->leave, 2) . ', ';
                            $staggered_avg .= round($attendance_summary[0]->staggered, 2) . ', ';
                          } ?></td>
                    </tr>


                  <?php } ?>

                <?php } ?>


              </table>







            </div>
          </div>



        </div>


        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-more.js"></script>
        <script src="https://code.highcharts.com/modules/dumbbell.js"></script>
        <script src="https://code.highcharts.com/modules/lollipop.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>


        <figure class="highcharts-figure">
          <div id="monthly_absent_avg2"></div>
          <p class="highcharts-description">
            A basic column chart compares rainfall values between four cities.
            Tokyo has the overall highest amount of rainfall, followed by New York.
            The chart is making use of the axis crosshair feature, to highlight
            months as they are hovered over.
          </p>
          <script>
            Highcharts.chart('monthly_absent_avg2', {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Monthly Average Rainfall'
              },
              subtitle: {
                text: 'Source: WorldClimate.com'
              },
              xAxis: {
                categories: [<?php echo $class_sections; ?>],
                crosshair: true
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Rainfall (mm)'
                }
              },
              tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },
              plotOptions: {
                column: {
                  pointPadding: 0.2,
                  borderWidth: 0
                }
              },
              series: [{
                name: 'Absent Avg',
                type: 'spline',
                color: 'red',
                data: [<?php echo $absent_avg; ?>]

              }, {
                name: 'Present Avg',
                color: 'green',
                data: [<?php echo $present_avg; ?>]

              }, {
                name: 'Leave Avg',
                color: 'blue',
                data: [<?php echo $leave_avg; ?>]

              }, {
                name: 'staggered Avg',
                color: 'orange',
                data: [<?php echo $staggered_avg; ?>]

              }]
            });
          </script>
        </figure>

        <figure class="highcharts-figure">
          <div id="monthly_absent_avg"></div>
          <p class="highcharts-description">
            Lollipop charts are variants of column charts, with a circle
            marker for the data value and a line extending to the axis.
          </p>
          <script>
            Highcharts.chart('monthly_absent_avg', {

              chart: {
                type: 'lollipop'
              },

              accessibility: {
                point: {
                  valueDescriptionFormat: '{index}. {xDescription}, {point.y}.'
                }
              },

              legend: {
                enabled: false
              },

              subtitle: {
                text: '2018'
              },

              title: {
                text: 'Top 10 Countries by Population'
              },

              tooltip: {
                shared: true
              },

              xAxis: {
                type: 'category'
              },

              yAxis: {
                title: {
                  text: 'Population'
                }
              },

              series: [{
                name: 'Population',
                data: [<?php echo $monthly_absent_avg; ?>]
              }]

            });
          </script>
        </figure>



      </div>

    </div>
  </div>
  <!-- /MESSENGER -->
</div>