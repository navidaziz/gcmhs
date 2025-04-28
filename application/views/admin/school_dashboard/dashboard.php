<div class="row" style="background-color: white; padding-top: 10px;">
  <div class="col-md-12">
    <div class="row">

      <?php

      $query = "SELECT * FROM `classes` WHERE status=1 ORDER BY class_id DESC";

      $result = $this->db->query($query);
      $classes = $result->result();
      //var_dump($classes);

      foreach ($classes as $classe) {
        $query = "SELECT `sections`.`section_id`,
						  `sections`.`section_title`,
						  `sections`.`color` 
						FROM
						  `sections` 
						WHERE  `sections`.`status` =1";

        $result = $this->db->query($query);
        $sections = $result->result();
        $classe->sections = $sections;
      }



      $query = "SELECT sum(present) as present, 
                                   sum(`leave`) as `leave`, 
                                   sum(absent) as absent, 
                                   sum(total) as total, 
                                   sum(total_students) as total_students, 
                                   sum(struck_off) as struck_off, 
                                   (sum(total)*100) / sum(total) as total_attendance_percentage 
                            FROM `today_attendance_summery`";
      $today_attendance_summary = $this->db->query($query)->result()[0];


      ?>


      <div class="row">
        <div class="col-lg-5">
          <div class="dashbox panel panel-default">
            <div class="panel-body">
              <div class="panel-left red">
                <i class="fa fa-user fa-3x"></i>
              </div>
              <div class="panel-right">
                <div class="number"><strong>Total Students: <?php echo $today_attendance_summary->total_students; ?></strong></div>
                <div class="title" style="color: #91e8e1;"><strong><?php echo $today_attendance_summary->struck_off_over_all; ?> - Struck-Off </strong></div>

                <div>
                  <?php
                  $query = "SELECT c.class_id, c.Class_title AS class, 
                        (SELECT COUNT(*) FROM students WHERE students.class_id = c.class_id and students.status=1) as total_students, 
                        (SELECT COUNT(*) FROM students WHERE students.class_id = c.class_id and students.status=2) as struck_off, 
                        COUNT(*) AS new_admission, 
                        SUM(IF(s.private_public_school = 'P', 1, 0)) AS private_schools, 
                        SUM(IF(s.private_public_school = 'G', 1, 0)) AS government_schools, 
                        SUM(IF(s.orphan = 'yes', 1, 0)) AS orphans, SUM(IF(s.nationality = 'Afghani', 1, 0)) AS afghanis, 
                        SUM(IF(s.hafiz = 'Yes', 1, 0)) AS hafiz_e_quran FROM students AS s 
                        INNER JOIN classes AS c ON c.class_id = s.class_id 
                        WHERE DATE(s.admission_date) >= '" . date('Y') . "-03-01' 
                        AND c.class_id IN (2, 3, 4, 5, 6) 
                        GROUP BY c.class_id, c.Class_title;";
                  $student_addmission_summary = $this->db->query($query)->result();

                  // Initialize sum variables
                  $sum_total_students = 0;
                  $sum_struck_off = 0;
                  $sum_new_admission = 0;
                  $sum_private_schools = 0;
                  $sum_government_schools = 0;
                  $sum_orphans = 0;
                  $sum_afghanis = 0;
                  $sum_hafiz_e_quran = 0;
                  ?>

                  <table class="table table-bordered table-striped table_small">
                    <thead>
                      <tr style="background-color: #f2f2f2;">

                        <th>Class</th>
                        <th>Total Students</th>
                        <th>Struck Off</th>
                        <th>New Admission</th>
                        <th>Private Schools</th>
                        <th>Government Schools</th>
                        <th>Orphans</th>
                        <th>Afghanis</th>
                        <th>Hafiz-e-Quran</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($student_addmission_summary as $row): ?>
                        <tr>

                          <td><?php echo $row->class; ?></td>
                          <td><?php echo $row->total_students;
                              $sum_total_students += $row->total_students; ?></td>
                          <td><?php echo $row->struck_off;
                              $sum_struck_off += $row->struck_off; ?></td>
                          <td><?php echo $row->new_admission;
                              $sum_new_admission += $row->new_admission; ?></td>
                          <td><?php echo $row->private_schools;
                              $sum_private_schools += $row->private_schools; ?></td>
                          <td><?php echo $row->government_schools;
                              $sum_government_schools += $row->government_schools; ?></td>
                          <td><?php echo $row->orphans;
                              $sum_orphans += $row->orphans; ?></td>
                          <td><?php echo $row->afghanis;
                              $sum_afghanis += $row->afghanis; ?></td>
                          <td><?php echo $row->hafiz_e_quran;
                              $sum_hafiz_e_quran += $row->hafiz_e_quran; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr style="background-color: #e6e6e6; font-weight: bold;">
                        <td colspan="2">Total</td>
                        <td><?php echo $sum_total_students; ?></td>
                        <td><?php echo $sum_struck_off; ?></td>
                        <td><?php echo $sum_new_admission; ?></td>
                        <td><?php echo $sum_private_schools; ?></td>
                        <td><?php echo $sum_government_schools; ?></td>
                        <td><?php echo $sum_orphans; ?></td>
                        <td><?php echo $sum_afghanis; ?></td>
                        <td><?php echo $sum_hafiz_e_quran; ?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="dash box pa nel pa nel-de fault">
            <div class="pa nel-b ody" style="padding: 3px;">

              <h5>Today Attendance Summary - <?php echo round($today_attendance_summary->total_attendance_percentage); ?> %</h5>
              <table class="table">
                <tr>
                  <th style="background-color: #7cb5ec;">Present - <?php echo $today_attendance_summary->present; ?></th>
                  <th style="background-color: #f15c80;">Absent - <?php echo $today_attendance_summary->absent; ?></th>
                  <th style="background-color: #90ed7d;">On leave - <?php echo $today_attendance_summary->leave; ?></th>
                  <th style="background-color: #91E8E0;">Struck Off - <?php echo $today_attendance_summary->struck_off; ?></th>
                  <th style="background-color:rgb(255, 255, 255);">Total - <?php echo $today_attendance_summary->total; ?></th>
                </tr>

              </table>

            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row">

      <div class="col-md-3">
        <div class="quick-pie panel panel-default">
          <div class="panel-body">
            <div id="attendance-chart" style="height: 300px;"></div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="quick-pie panel panel-default">
          <div class="panel-body">
            <div id="today_attendance_summary_colum_chart_class" style="height: 300px;"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="quick-pie panel panel-default">
          <div class="panel-body">
            <div id="today_attendance_summary_colum_chart" style="height: 300px;"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="quick-pie panel panel-default">
          <div class="panel-body">
            <div id="daily_attendance"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="quick-pie panel panel-default">
          <div class="panel-body">
            <div id="monthly_absent_avg"></div>
          </div>
        </div>
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
    Highcharts.chart('attendance-chart', {
      chart: {
        type: 'pie'
      },
      title: {
        text: 'Today\'s Attendance Summary'
      },
      subtitle: {
        text: 'Total Attendance - <?php echo $today_attendance_summary->total_students . ' / ' . $today_attendance_summary->total; ?>'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          colors: ['#7cb5ec', '#f15c80', '#90ed7d', '#91E8E0'],
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.y} %'
          }
        }
      },
      series: [{
        name: 'Count',
        colorByPoint: true,
        data: [{
          name: 'Present',
          y: <?php if ($today_attendance_summary->present) {
                echo round($today_attendance_summary->present * 100 / $today_attendance_summary->total_students, 2);
              } else {
                echo 0;
              } ?>
        }, {
          name: 'Absent',
          y: <?php if ($today_attendance_summary->absent) {
                echo round($today_attendance_summary->absent * 100 / $today_attendance_summary->total_students, 2);
              } else {
                echo 0;
              } ?>

        }, {
          name: 'On Leave',
          y: <?php if ($today_attendance_summary->leave) {
                echo round($today_attendance_summary->leave * 100 / $today_attendance_summary->total_students, 2);
              } else {
                echo 0;
              } ?>
        }, {
          name: 'Struck Off',
          y: <?php if ($today_attendance_summary->struck_off) {
                echo round($today_attendance_summary->struck_off * 100 / $today_attendance_summary->total_students, 2);
              } else {
                echo 0;
              } ?>
        }]
      }]
    });
  </script>

  <?php





  // 4. Today's class-wise summary
  $todaySummary = $this->db->query("SELECT class_title,
  sum(`absent`) as `absent`,
  sum(`present`) as `present`,
  sum(`leave`) as `leave`,
   sum(`struck_off`) as `struck_off`
   FROM today_attendance_summery GROUP BY class_title ORDER BY class_id")->result();
  $c_cat = $absent = $present = $leave = $struck_off = [];
  foreach ($todaySummary as $t) {
    $c_cat[] = $t->class_title;
    if ($t->absent) {
      $absent[] = (int) $t->absent;
    } else {
      $absent[] = 0;
    }
    if ($t->present) {
      $present[] = (int) $t->present;
    } else {
      $present[] = 0;
    }
    if ($t->leave) {
      $leave[] = (int) $t->leave;
    } else {
      $leave[] = 0;
    }
    if ($t->struck_off) {
      $struck_off[] = (int) $t->struck_off;
    } else {
      $struck_off[] = 0;
    }
  }



  ?>
  <script>
    Highcharts.chart('today_attendance_summary_colum_chart_class', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Today Class Wise Attendance Summary'
      },
      xAxis: {
        categories: <?php echo json_encode($c_cat); ?>
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Total Students'
        },
        stackLabels: {
          enabled: true,
          style: {
            color: (Highcharts.defaultOptions.title.style &&
              Highcharts.defaultOptions.title.style.color) || 'gray'
          }
        }
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
          name: 'Absent',
          color: '#f15c80',
          data: <?php echo json_encode($absent); ?>
        },
        {
          name: 'Present',
          color: '#7cb5ec',
          //visible: false,
          data: <?php echo json_encode($present); ?>
        },
        {
          name: 'leave',
          color: '#90ed7d',
          //visible: false,
          data: <?php echo json_encode($leave); ?>
        },
        {
          name: 'Struck Off',
          color: '#91e8e1',
          //visible: false,
          data: <?php echo json_encode($struck_off); ?>
        }
      ]
    });





    <?php





    // 4. Today's class-wise summary
    $todaySummary = $this->db->query("SELECT * FROM today_attendance_summery")->result();
    $cat = $absent = $present = $leave = $struck_off = [];
    foreach ($todaySummary as $t) {
      $cat[] = $t->Class_title . '-' . substr($t->section_title, 0, 1);
      if ($t->absent) {
        $absent[] = (int) $t->absent;
      } else {
        $absent[] = 0;
      }
      if ($t->present) {
        $present[] = (int) $t->present;
      } else {
        $present[] = 0;
      }
      if ($t->leave) {
        $leave[] = (int) $t->leave;
      } else {
        $leave[] = 0;
      }
      if ($t->struck_off) {
        $struck_off[] = (int) $t->struck_off;
      } else {
        $struck_off[] = 0;
      }
    }



    ?>


    Highcharts.chart('today_attendance_summary_colum_chart', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Today Class and Section Wise Attendance Summary'
      },
      xAxis: {
        categories: <?php echo json_encode($cat); ?>
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Total Students'
        },
        stackLabels: {
          enabled: true,
          style: {
            color: (Highcharts.defaultOptions.title.style &&
              Highcharts.defaultOptions.title.style.color) || 'gray'
          }
        }
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
          name: 'Absent',
          color: '#f15c80',
          data: <?php echo json_encode($absent); ?>
        },
        {
          name: 'Present',
          color: '#7cb5ec',
          //visible: false,
          data: <?php echo json_encode($present); ?>
        },
        {
          name: 'leave',
          color: '#90ed7d',
          //visible: false,
          data: <?php echo json_encode($leave); ?>
        },
        {
          name: 'Struck Off',
          color: '#91e8e1',
          //visible: false,
          data: <?php echo json_encode($struck_off); ?>
        }
      ]
    });


    <?php
    // 1. Fetch daily attendance summary for the last 30 days
    $dailyQuery = "
    SELECT DATE(created_date) as day, 
           SUM(absent) as absent, 
           SUM(total) as total, 
           SUM(present) as present 
    FROM daily_class_wise_attendance
    WHERE created_date >= CURDATE() - INTERVAL 30 DAY
    GROUP BY DATE(created_date)
";
    $dailyData = $this->db->query($dailyQuery)->result();

    // 2. Format for chart
    $dayWise = [];
    foreach ($dailyData as $row) {
      $day = date('Y-m-d', strtotime($row->day)); // Use full date for more precise matching
      $dayWise[$day] = $row;
    }

    $categories = $daily_absent = $daily_total = $daily_present = [];
    for ($i = 30; $i >= 0; $i--) {
      $date = date('Y-m-d', strtotime("-$i days"));
      $categories[] = date('j M', strtotime($date)); // e.g., "12 Apr"
      if (isset($dayWise[$date])) {
        $daily_absent[] = (int)$dayWise[$date]->absent;
        $daily_total[]  = (int)$dayWise[$date]->total;
        $daily_present[] = (int)$dayWise[$date]->present;
      } else {
        $daily_absent[] = null;
        $daily_total[] = null;
        $daily_present[] = null;
      }
    }
    ?>





    Highcharts.chart('daily_attendance', {
      chart: {
        type: 'spline'
      },
      title: {
        text: 'Last 30 Day Attendance Trend Analysis'
      },
      subtitle: {
        text: 'Total - Present - Absent - AVG Absent Per Day.'
      },
      xAxis: {
        categories: <?php echo json_encode($categories); ?>
      },
      yAxis: {
        title: {
          text: 'Total Students'
        },

        <?php
        // 3. Get monthly absent average
        $avgAbsentQuery = "
    SELECT AVG(absent) as absent 
    FROM daily_total_attendance 
    WHERE YEAR(created_date) = YEAR(CURDATE())
      AND MONTH(created_date) = MONTH(CURDATE())";
        $dailyabseentaverage = $this->db->query($avgAbsentQuery)->row()->absent;
        ?>

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
              color: '#f15c80'
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
          data: <?php echo json_encode($daily_absent); ?>,
          color: '#f15c80'
        },
        {
          name: 'Total',
          data: <?php echo json_encode($daily_total); ?>,
          visible: false
        },
        {
          name: 'Present',
          data: <?php echo json_encode($daily_present); ?>,
          // visible: false
        }
      ]
    });

    <?php

    // 5. Monthly avg by class (top 10)
    $monthlyAvg = $this->db->query("
    SELECT class_title, section_title, AVG(absent) as avg_absent 
    FROM daily_class_wise_attendance
    WHERE created_date >= CURDATE() - INTERVAL 30 DAY
    GROUP BY class_title, section_title
    ORDER BY avg_absent DESC
")->result();

    $monthly_absent_avg = [];
    foreach ($monthlyAvg as $row) {
      $monthly_absent_avg[] = [$row->class_title . '-' . $row->section_title, round($row->avg_absent)];
    }

    ?>
    Highcharts.chart('monthly_absent_avg', {
      chart: {
        type: 'column'
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
        text: '<?php echo date("Y") ?>'
      },
      title: {
        text: 'Last 30 Days Class-Section Wise AVG Absenteeism'
      },
      tooltip: {
        shared: true
      },
      xAxis: {
        type: 'category'
      },
      yAxis: {
        title: {
          text: 'Average Absenteeism'
        }
      },
      series: [{
        name: 'Avg Absenteeism',
        data: <?php echo json_encode($monthly_absent_avg); ?>
      }]
    });
  </script>