<div class="row" style="background-color: white; padding-top: 10px;">
  <div class="col-md-12">
    <div class="row">
      <?php
      // Optimized query to fetch classes
      $query = "SELECT * FROM `classes` WHERE status=1 ORDER BY class_id DESC";
      $result = $this->db->query($query);
      $classes = $result->result();

      // Pre-fetch all sections data in one query
      $class_ids = array();
      foreach ($classes as $classe) {
        $class_ids[] = $classe->class_id;
      }

      if (!empty($class_ids)) {
        $class_ids_str = implode(",", $class_ids);
        $sections_query = "SELECT DISTINCT 
                            s.section_id,
                            s.section_title,
                            s.color,
                            st.class_id
                          FROM
                            `students` st,
                            `sections` s
                          WHERE st.section_id = s.section_id
                          AND st.status = 1
                          AND st.class_id IN ($class_ids_str)
                          AND s.section_id != 15";

        $sections_result = $this->db->query($sections_query);
        $all_sections = $sections_result->result();

        // Organize sections by class_id
        $sections_by_class = array();
        foreach ($all_sections as $section) {
          if (!isset($sections_by_class[$section->class_id])) {
            $sections_by_class[$section->class_id] = array();
          }
          $sections_by_class[$section->class_id][] = $section;
        }

        // Assign sections to classes
        foreach ($classes as $classe) {
          $classe->sections = isset($sections_by_class[$classe->class_id]) ? $sections_by_class[$classe->class_id] : array();
        }
      }

      // Get today's attendance summary
      $today_summary_query = "SELECT sum(present) as present, 
                             sum(`leave`) as `leave`, 
                             sum(absent) as absent, 
                             sum(total) as total, 
                             sum(total_students) as total_students, 
                             sum(strucked_off) as strucked_off, 
                             (sum(total)*100) / sum(total_students) as total_attendance_percentage 
                             FROM `today_attendance_summery`";
      $today_summary_result = $this->db->query($today_summary_query);
      $today_attendance_summary = $today_summary_result->row();

      // Pre-fetch all class teachers
      $teachers_query = "SELECT class_id, section_id, teacher_name 
                         FROM `classes_time_tables` 
                         WHERE `class_teacher` = 1";
      $teachers_result = $this->db->query($teachers_query);
      $teachers = array();
      while ($teacher = $teachers_result->row()) {
        if (!isset($teachers[$teacher->class_id])) {
          $teachers[$teacher->class_id] = array();
        }
        $teachers[$teacher->class_id][$teacher->section_id] = $teacher->teacher_name;
      }

      // Pre-fetch all daily attendance data for the month
      $monthly_attendance_query = "SELECT class_id, section_id, 
                                  DAY(created_date) as day,
                                  absent, present, `leave`, corona_leave, struck_off, ea, evening_absent
                                  FROM `daily_class_wise_attendance`
                                  WHERE MONTH(created_date) = MONTH(NOW())
                                  AND YEAR(created_date) = YEAR(NOW())";
      $monthly_attendance_result = $this->db->query($monthly_attendance_query);
      $attendance_data = array();
      while ($att = $monthly_attendance_result->row()) {
        if (!isset($attendance_data[$att->class_id])) {
          $attendance_data[$att->class_id] = array();
        }
        if (!isset($attendance_data[$att->class_id][$att->section_id])) {
          $attendance_data[$att->class_id][$att->section_id] = array();
        }
        $attendance_data[$att->class_id][$att->section_id][$att->day] = $att;
      }

      // Pre-fetch daily totals for the chart
      $daily_totals_query = "SELECT DAY(created_date) as day,
                            SUM(absent) as absent, 
                            SUM(total) as total,
                            SUM(present) as present
                            FROM `daily_class_wise_attendance`
                            WHERE MONTH(created_date) = MONTH(NOW())
                            AND YEAR(created_date) = YEAR(NOW())
                            GROUP BY DAY(created_date)";
      $daily_totals_result = $this->db->query($daily_totals_query);
      $daily_totals = array();
      while ($total = $daily_totals_result->row()) {
        $daily_totals[$total->day] = $total;
      }

      // Prepare daily data arrays
      $daily_absent = $daily_total = $daily_present = array();
      for ($day = 1; $day <= 30; $day++) {
        if (isset($daily_totals[$day])) {
          $daily_absent[] = $daily_totals[$day]->absent;
          $daily_total[] = $daily_totals[$day]->total;
          $daily_present[] = $daily_totals[$day]->present;
        } else {
          $daily_absent[] = 'null';
          $daily_total[] = 'null';
          $daily_present[] = 'null';
        }
      }

      // Get average absent for the month
      $avg_query = "SELECT AVG(`absent`) as absent 
                   FROM `daily_total_attendance` 
                   WHERE YEAR(created_date) = YEAR(NOW()) 
                   AND MONTH(created_date) = MONTH(NOW())";
      $avg_result = $this->db->query($avg_query);
      $dailyabseentaverage = $avg_result->row()->absent;

      // Initialize chart data variables
      $monthly_absent_avg = $class_sections = $absent_avg = $present_avg = $leave_avg = $staggered_avg = '';
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
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="dash box pa nel pa nel-de fault">
              <div class="pa nel-b ody" style="padding: 3px;">
                <h5>Today Attendance Summary - <?php echo round($today_attendance_summary->total_attendance_percentage, 2); ?> %</h5>
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
          <div id="monthly_absent_avg2"></div>
        </div>
      </div>
    </div>

    <table class="table">
      <tr>
        <th>Class</th>
        <th>Class Teacher</th>
        <?php for ($i = 1; $i <= 30; $i++) { ?>
          <th><?php echo $i; ?></th>
        <?php } ?>
        <th>Month</th>
      </tr>
      <?php foreach ($classes as $class) { ?>
        <?php foreach ($class->sections as $section) { ?>
          <?php
          $teacher_name = isset($teachers[$class->class_id][$section->section_id]) ? $teachers[$class->class_id][$section->section_id] : '';

          // Color mapping
          $color = 'white';
          if ($section->section_title == 'Yellow') {
            $color = '#ffff00';
          } elseif ($section->section_title == 'Red') {
            $color = '#ff0000';
          } elseif ($section->section_title == 'Green') {
            $color = '#00ff00';
          } elseif ($section->section_title == 'Blue') {
            $color = '#0000ff';
          }

          // Calculate monthly averages
          $monthly_avg_query = "SELECT AVG(absent) as absent, 
                               AVG(present) as present, 
                               AVG(corona_leave) as staggered, 
                               AVG(`leave`) as `leave`,
                               AVG(`struck_off`) as `struck_off`  
                               FROM `daily_class_wise_attendance`
                               WHERE class_id = '" . $class->class_id . "'
                               AND section_id = '" . $section->section_id . "'
                               AND MONTH(created_date) = MONTH(NOW())
                               AND YEAR(created_date) = YEAR(NOW())";
          $attendance_summary = $this->db->query($monthly_avg_query)->row();

          if ($attendance_summary->absent) {
            $monthly_absent_avg .= "{
                  name: '" . $class->Class_title . "-" . $section->section_title . "-" . $teacher_name . "',
                  low: " . round($attendance_summary->absent, 2) . ",
                  color: '" . $section->color . "',
              },";
            $class_sections .= "'" . $class->Class_title . "-" . $section->section_title . "-" . $teacher_name . "', ";
            $absent_avg .= round($attendance_summary->absent, 2) . ', ';
            $present_avg .= round($attendance_summary->present, 2) . ', ';
            $leave_avg .= round($attendance_summary->leave, 2) . ', ';
            $staggered_avg .= round($attendance_summary->staggered, 2) . ', ';
          }
          ?>
          <tr style="background-image: linear-gradient(<?php echo $color; ?>,white);">
            <td><?php echo $class->Class_title . "-" . $section->section_title; ?></td>
            <td><?php echo $teacher_name; ?></td>
            <?php for ($day = 1; $day <= 30; $day++) { ?>
              <td>
                <?php
                if (isset($attendance_data[$class->class_id][$section->section_id][$day])) {
                  $att = $attendance_data[$class->class_id][$section->section_id][$day];
                  echo $att->absent;
                  if ($att->ea == 'y') {
                    echo "<small style=\"color:red\">-" . $att->evening_absent . "</small>";
                  }
                }
                ?>
              </td>
            <?php } ?>
            <td><?php echo $attendance_summary->absent ? round($attendance_summary->absent, 2) : ''; ?></td>
          </tr>
        <?php } ?>
      <?php } ?>
    </table>
  </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
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
      text: '<?php echo date("F, Y"); ?> Day Wise Attendance '
    },
    subtitle: {
      text: 'Total-Present-Absent-AVG Absent Per Day.'
    },
    xAxis: {
      categories: [
        <?php for ($i = 1; $i <= 30; $i++) { ?> '<?php echo $i; ?>',
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
        data: [<?php echo implode(",", $daily_absent); ?>],
        color: '#f15c80'
      }, {
        name: 'Total',
        data: [<?php echo implode(",", $daily_total); ?>],
        visible: false
      },
      {
        name: 'Present',
        data: [<?php echo implode(",", $daily_present); ?>],
        visible: false
      }
    ]
  });

  // Get today's attendance data for the chart
  <?php
  $today_attendances = $this->db->query("SELECT * FROM `today_attendance_summery`")->result();
  $absent = $present = $leave = $struck_off = array();
  $categories = array();
  foreach ($today_attendances as $todayattendance) {
    $categories[] = $todayattendance->Class_title . "-" . $todayattendance->section_title . substr(0, 1);
    $absent[] = $todayattendance->absent ? $todayattendance->absent : 0;
    $present[] = $todayattendance->present ? $todayattendance->present : 0;
    $leave[] = $todayattendance->leave ? $todayattendance->leave : 0;
    $struck_off[] = $todayattendance->strucked_off ? $todayattendance->strucked_off : 0;
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
      categories: [<?php echo "'" . implode("','", $categories) . "'"; ?>]
    },
    yAxis: {
      min: 0,
      title: {
        text: 'Total Students'
      },
      stackLabels: {
        enabled: true,
        style: {
          color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions.title.style.color) || 'gray'
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
        data: [<?php echo implode(",", $absent); ?>]
      }, {
        name: 'Present',
        color: '#7cb5ec',
        visible: false,
        data: [<?php echo implode(",", $present); ?>]
      }, {
        name: 'leave',
        color: '#90ed7d',
        visible: false,
        data: [<?php echo implode(",", $leave); ?>]
      },
      {
        name: 'Struck Off',
        color: '#91e8e1',
        visible: false,
        data: [<?php echo implode(",", $struck_off); ?>]
      }
    ]
  });

  Highcharts.chart('monthly_absent_avg2', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Current Month Average Data'
    },
    xAxis: {
      categories: [<?php echo $class_sections; ?>],
      crosshair: true
    },
    yAxis: {
      min: 0,
      title: {
        text: 'Total Students'
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