<div class="row" style="background-color: white; padding-top: 10px;">
  <div class="col-md-12">
    <div class="row">

      <?php

      $query = "SELECT * FROM `classes` WHERE status=1 ORDER BY class_id DESC";

      $result = $this->db->query($query);
      $classes = $result->result();
      //var_dump($classes);

      foreach ($classes as $classe) {
        $query = "SELECT DISTINCT 
						  `sections`.`section_id`,
						  `sections`.`section_title`,
						  `sections`.`color` 
						FROM
						  `students`,
						  `sections` 
						WHERE `students`.`section_id` = `sections`.`section_id`
						AND `students`.`status` =1
						AND `students`.`class_id` ='" . $classe->class_id . "'
				        AND  `sections` . `section_id` != '15'";

        $result = $this->db->query($query);
        $sections = $result->result();
        $classe->sections = $sections;
      }



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
                  <div class="title" style="color: #91e8e1;"><strong><?php echo $today_attendance_summary->strucked_off; ?></strong> - Struck-Off </div>
                  <!-- <span class="label label-success">
                    26% <i class="fa fa-arrow-up"></i>
                  </span> -->
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="dash box pa nel pa nel-de fault">
              <div class="pa nel-b ody" style="padding: 3px;">

                <h5>Today Attendance Summary - <?php echo $today_attendance_summary->total_attendance_percentage; ?> %</h5>
                <table class="table">
                  <tr>
                    <th style="background-color: #7cb5ec;">Present-<?php echo $today_attendance_summary->present; ?></th>
                    <th style="background-color: #f15c80;">Absent-<?php echo $today_attendance_summary->absent; ?></th>
                    <th style="background-color: #90ed7d;">On leave-<?php echo $today_attendance_summary->leave; ?></th>
                  </tr>

                </table>

              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="quick-pie panel panel-default" style="margin-top: -15px;">
              <div class="panel-body">
                <div id="today_attendance_summary_colum_chart" style="height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>







      <div class="col-md-6">
        <div class="quick-pie panel panel-default">
          <div class="panel-body">
            <div id="daily_attendance"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
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
<?php
// 1. Fetch daily attendance summary for the current month
$dailyQuery = "
    SELECT DATE(created_date) as day, 
           SUM(absent) as absent, 
           SUM(total) as total, 
           SUM(present) as present 
    FROM daily_class_wise_attendance
    WHERE YEAR(created_date) = YEAR(CURDATE())
      AND MONTH(created_date) = MONTH(CURDATE())
    GROUP BY DATE(created_date)
";
$dailyData = $this->db->query($dailyQuery)->result();

// 2. Format for chart
$dayWise = [];
foreach ($dailyData as $row) {
  $day = (int)date('j', strtotime($row->day));
  $dayWise[$day] = $row;
}

$categories = $daily_absent = $daily_total = $daily_present = [];
for ($i = 1; $i <= 30; $i++) {
  $categories[] = (string)$i;
  if (isset($dayWise[$i])) {
    $daily_absent[] = (int)$dayWise[$i]->absent;
    $daily_total[]  = (int)$dayWise[$i]->total;
    $daily_present[] = (int)$dayWise[$i]->present;
  } else {
    $daily_absent[] = null;
    $daily_total[] = null;
    $daily_present[] = null;
  }
}

// 3. Get monthly absent average
$avgAbsentQuery = "
    SELECT AVG(absent) as absent 
    FROM daily_total_attendance 
    WHERE YEAR(created_date) = YEAR(CURDATE())
      AND MONTH(created_date) = MONTH(CURDATE())
";
$dailyabseentaverage = $this->db->query($avgAbsentQuery)->row()->absent;

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
  if ($t->present) {
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

// 5. Monthly avg by class (top 10)
$monthlyAvg = $this->db->query("
    SELECT class_title, section_title AVG(absent) as avg_absent 
    FROM daily_class_wise_attendance
    WHERE YEAR(created_date) = YEAR(CURDATE()) 
      AND MONTH(created_date) = MONTH(CURDATE()) 
    GROUP BY section_title
    ORDER BY avg_absent DESC 
    LIMIT 10
")->result();

$monthly_absent_avg = [];
foreach ($monthlyAvg as $row) {
  $monthly_absent_avg[] = [$row->class_title . '-' . $row->class_title, round($row->avg_absent)];
}

?>
<script>
  Highcharts.chart('daily_attendance', {
    chart: {
      type: 'line'
    },
    title: {
      text: '<?php echo date("F, Y") ?> Day Wise Attendance '
    },
    subtitle: {
      text: 'Total-Present-Absent-AVG Absent Per Day.'
    },
    xAxis: {
      categories: <?php echo json_encode($categories); ?>
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
        visible: false
      }
    ]
  });

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
        visible: false,
        data: <?php echo json_encode($present); ?>
      },
      {
        name: 'leave',
        color: '#90ed7d',
        visible: false,
        data: <?php echo json_encode($leave); ?>
      },
      {
        name: 'Struck Off',
        color: '#91e8e1',
        visible: false,
        data: <?php echo json_encode($struck_off); ?>
      }
    ]
  });

  Highcharts.chart('monthly_absent_avg', {
    chart: {
      type: 'bar'
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
      text: 'Top 10 Classes by Avg Absentees'
    },
    tooltip: {
      shared: true
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      title: {
        text: 'Average Absentees'
      }
    },
    series: [{
      name: 'Avg Absentees',
      data: <?php echo json_encode($monthly_absent_avg); ?>
    }]
  });
</script>