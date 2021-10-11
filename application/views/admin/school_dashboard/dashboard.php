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

      </div>
      <div class="box-body">

        <div class="table-responsive">
          <div class="row">
            <div class="col-md-12">
              <div class="row">

                <?php
                $query = "SELECT sum(present) as present, 
                                   sum(`leave`) as `leave`, 
                                   sum(absent) as absent, 
                                   sum(total) as total, 
                                   sum(total_students) as total_students, 
                                   sum(strucked_off) as strucked_off, 
                                   (sum(total)*100) / sum(total_students) as total_attendance_percentage 
                            FROM `today_attendance_summery`";
                $today_attendance_summary = $this->db->query($query)->result()[0];


                ?>

                <div class="col-md-6">
                  <div class="row">
                    <div class="col-lg-5">
                      <div class="dashbox panel panel-default">
                        <div class="panel-body">
                          <div class="panel-left red">
                            <i class="fa fa-user fa-3x"></i>
                          </div>
                          <div class="panel-right">
                            <div class="number"><?php echo $today_attendance_summary->total_students; ?></div>
                            <div class="title"><?php echo $today_attendance_summary->strucked_off; ?> - Struck-Off </div>
                            <span class="label label-success">
                              26% <i class="fa fa-arrow-up"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-7">
                      <div class="dashbox panel panel-default">
                        <div class="panel-body" style="padding: 3px;">

                          <h5>Today Attendance Summary - <?php echo $today_attendance_summary->total_attendance_percentage; ?> %</h5>
                          <table class="table table-bordered">
                            <tr>
                              <th>Present</th>
                              <th>Absent</th>
                              <th>leave</th>
                            </tr>
                            <tr>
                              <td><?php echo $today_attendance_summary->present; ?></td>
                              <td><?php echo $today_attendance_summary->absent; ?></td>
                              <td><?php echo $today_attendance_summary->leave; ?></td>
                            </tr>
                          </table>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="quick-pie panel panel-default">
                        <div class="panel-body">
                          <div id="today_attendance_summary_colum_chart"></div>
                          <script>
                            Highcharts.chart('today_attendance_summary_colum_chart', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: 'Stacked column chart'
                              },
                              xAxis: {
                                categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'Total fruit consumption'
                                },
                                stackLabels: {
                                  enabled: true,
                                  style: {
                                    fontWeight: 'bold',
                                    color: ( // theme
                                      Highcharts.defaultOptions.title.style &&
                                      Highcharts.defaultOptions.title.style.color
                                    ) || 'gray'
                                  }
                                }
                              },
                              legend: {
                                align: 'right',
                                x: -30,
                                verticalAlign: 'top',
                                y: 25,
                                floating: true,
                                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                                borderColor: '#CCC',
                                borderWidth: 1,
                                shadow: false
                              },
                              tooltip: {
                                headerFormat: '<b>{point.x}</b><br/>',
                                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                              },
                              plotOptions: {
                                column: {
                                  stacking: 'normal',
                                  dataLabels: {
                                    enabled: true
                                  }
                                }
                              },
                              series: [{
                                name: 'John',
                                data: [5, 3, 4, 7, 2]
                              }, {
                                name: 'Jane',
                                data: [2, 2, 3, 2, 1]
                              }, {
                                name: 'Joe',
                                data: [3, 4, 4, 2, 5]
                              }]
                            });
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>







                <div class="col-md-6">
                  <div id="daily_attendance"></div>
                </div>
              </div>

              <table class="table ">

                <tr>
                  <th>Class</th>
                  <th>Class Teacher</th>
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
                    $today_attendance_summary = $this->db->query($query)->result();
                    $color = '';
                    if ($section->section_title == 'Yellow') {
                      $color = ' ';
                    }
                    if ($section->section_title == 'Red') {
                      $color = ' ';
                    }
                    if ($section->section_title == 'Green') {
                      $color = ' ';
                    }
                    if ($section->section_title == 'Blue') {
                      $color = ' ';
                    }
                    ?>
                    <tr style="background-image: linear-gradient(<?php echo $color; ?>,white); ">
                      <td><?php echo $class->Class_title; ?>-<?php echo $section->section_title; ?></td>
                      <td><?php echo $teacher_name; ?></td>

                      <?php for ($i = 1; $i <= 30; $i++) {
                        $query = "SELECT * FROM `daily_class_wise_attendance`
                        WHERE class_id = '" . $class->class_id . "'
                        AND section_id = '" . $section->section_id . "'
                        AND DATE(created_date) = DATE('" . date("Y-m-") . $i . "')";
                        $attendance_summary = $this->db->query($query)->result();

                      ?>
                        <td>
                          <?php
                          if ($attendance_summary[0]->total) {
                            //echo round(($attendance_summary[0]->absent * 100) / ($attendance_summary[0]->total - $today_attendance_summary[0]->corona_leave));
                            echo $attendance_summary[0]->absent;

                            if ($attendance_summary[0]->ea == 'y') {
                              echo "<small style=\"color:red\">-" . $attendance_summary[0]->evening_absent . "</small>";
                            }
                          } ?>



                        </td>
                      <?php } ?>

                      <?php $query = "SELECT AVG(absent) as absent, 
                                             AVG(present) as present, 
                                             AVG(corona_leave) as staggered, 
                                             AVG(`leave`) as `leave`,
                                             AVG(`struck_off`) as `struck_off`  
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


        <script src=" https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-more.js"></script>
        <script src="https://code.highcharts.com/modules/dumbbell.js"></script>
        <script src="https://code.highcharts.com/modules/lollipop.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>


        <script>
          Highcharts.chart('daily_attendance', {
            chart: {
              type: 'line'
            },
            title: {
              text: '<?php echo date("F, Y") ?> Day Wise Atendance '
            },
            subtitle: {
              text: 'Total-Present-Absent-AVG Absent Per Day.'
            },
            xAxis: {
              categories: [
                <?php
                $query = "SELECT AVG(`absent`) as absent FROM `daily_total_attendance` 
                            WHERE YEAR(created_date) = YEAR(NOW()) 
                            AND MONTH(created_date) = MONTH(NOW())";
                $dailyabseentaverage = $this->db->query($query)->result()[0]->absent;
                $daily_absent = '';
                $daily_total = '';
                $daily_present = '';
                for ($i = 1; $i <= 30; $i++) {


                  $query = "SELECT SUM(absent) as absent, 
                                     SUM(total) as total,
                                     SUM(present) as present
                                       FROM `daily_class_wise_attendance`
                        WHERE  DATE(created_date) = DATE('" . date("Y-m-") . $i . "')";
                  $attendance_summary = $this->db->query($query)->result();
                  if ($attendance_summary[0]->total) {
                    echo  "'" . $i . "', ";
                    $daily_absent .= $attendance_summary[0]->absent . ", ";
                    $absent_sum += $attendance_summary[0]->absent;
                    $daily_total .= $attendance_summary[0]->total . ", ";
                    $daily_present .= $attendance_summary[0]->present . ", ";
                  } else {
                    echo  "'" . $i . "', ";
                    $daily_absent .= "null, ";
                    $daily_total .= "null, ";
                    $daily_present .= "null, ";
                  } ?>
                <?php } ?>
              ],

            },
            yAxis: {
              title: {
                text: 'Total Students'
              },
              plotLines: [{
                id: 'avg',
                value: <?php echo $dailyabseentaverage; ?>,
                color: '#f15c80',
                dashStyle: 'dash',
                width: 1,

                label: {
                  text: 'AVG-Absentees - <?php echo round($dailyabseentaverage); ?> Per Day',
                  align: 'right',
                  style: {
                    color: '#f15c80',
                  }
                },
                zIndex: 4
              }]
            },
            plotOptions: {
              line: {
                dataLabels: {
                  enabled: true
                },
                enableMouseTracking: false

              },
              series: {
                connectNulls: true
              }
            },
            series: [{
                name: 'Absent',
                data: [<?php echo $daily_absent; ?>],
                color: '#f15c80'
              }, {
                name: 'Total',
                data: [<?php echo $daily_total; ?>],
                visible: false
              },
              {
                name: 'Present',
                data: [<?php echo $daily_present; ?>],
                visible: false
              }
            ]
          });
        </script>




        <figure class="highcharts-figure">
          <div id="monthly_absent_avg2"></div>

          <script>
            Highcharts.chart('monthly_absent_avg2', {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Class Wise Absent-Present-Leave and Staggered AVG Data'
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
                  borderWidth: 0,
                  stacking: 'normal'
                }
              },
              series: [{
                name: 'Absent Avg',
                type: '',
                color: '#f15c80',
                data: [<?php echo $absent_avg; ?>],
                zIndex: 4

              }, {
                name: 'Present Avg',
                color: '#7cb5ec',
                type: '',
                data: [<?php echo $present_avg; ?>]


              }, {
                name: 'Leave Avg',
                color: '#90ed7d',
                type: '',
                data: [<?php echo $leave_avg; ?>]

              }, {
                name: 'staggered Avg',
                color: '#91e8e1',
                type: '',
                data: [<?php echo $staggered_avg; ?>]

              }]
            });
          </script>
        </figure>

        <figure class="highcharts-figure">
          <div id="monthly_abse nt_avg"></div>
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