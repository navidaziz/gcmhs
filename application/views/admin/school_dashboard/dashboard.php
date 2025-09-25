<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
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
                <div class="number"><strong>Total Students: <?php

                                                            $query = "SELECT * FROM students WHERE status IN ()";

                                                            echo $today_attendance_summary->total_students; ?></strong></div>
                <div class="title" style="color: #91e8e1;"><strong><?php echo $today_attendance_summary->struck_off; ?> - Struck-Off </strong></div>


              </div>
              <div style="padding: 4px;">
                <?php


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
                <h5><strong>Total and New Admissions From March <?php echo date('Y'); ?> So Far</strong></h5>
                <table border="1" cellpadding="5" cellspacing="0" style="width:100%; margin-bottom:20px;">
                  <thead>
                    <tr style="background-color: #f2f2f2;">
                      <th>Class</th>
                      <th>Section</th>

                      <th>Total Students</th>
                      <th>Struck Off</th>
                      <th>New Admission</th>
                      <th>Private</th>
                      <th>Govt.</th>
                      <th>Orphans</th>
                      <th>Afghanis</th>
                      <th>Hafiz</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT c.class_id, c.Class_title, s.section_id, s.section_title FROM `classes` as c INNER JOIN class_sections as cs ON cs.class_id = c.class_id INNER JOIN `sections` as s ON s.section_id = cs.section_id WHERE s.status=1 AND c.status=1 AND c.class_id IN(2,3,4,5,6) GROUP BY c.class_id , s.section_id;";
                    $classes = $this->db->query($query)->result();
                    foreach ($classes as $class):
                      $query = "SELECT 
                        (SELECT COUNT(*) FROM students WHERE students.class_id = '" . $class->class_id . "' and students.section_id = '" . $class->section_id . "' and students.status IN (1,2)) as total_students, 
                        (SELECT COUNT(*) FROM students WHERE students.class_id = '" . $class->class_id . "' and students.section_id = '" . $class->section_id . "' and students.status=2) as struck_off, 
                        COUNT(*) AS new_admission, 
                        SUM(IF(s.private_public_school = 'P', 1, 0)) AS private_schools, 
                        SUM(IF(s.private_public_school = 'G', 1, 0)) AS government_schools, 
                        SUM(IF(s.orphan = 'yes', 1, 0)) AS orphans, SUM(IF(s.nationality = 'Afghani', 1, 0)) AS afghanis, 
                        SUM(IF(s.hafiz = 'Yes', 1, 0)) AS hafiz_e_quran 
                       FROM students AS s 
                        WHERE DATE(s.admission_date) >= '" . date('Y') . "-03-01' 
                        AND s.class_id = '" . $class->class_id . "'
                        AND s.section_id = '" . $class->section_id . "'
                        AND s.status IN (1,2)";
                      $row = $this->db->query($query)->row();


                    ?>
                      <tr>

                        <th><?php echo $class->Class_title; ?></th>
                        <th><?php echo $class->section_title; ?></th>

                        <th><?php echo $row->total_students;
                            $sum_total_students += $row->total_students; ?></th>
                        <th><?php echo $row->struck_off;
                            $sum_struck_off += $row->struck_off; ?></th>
                        <th><?php echo $row->new_admission;
                            $sum_new_admission += $row->new_admission; ?></th>
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
        <div class="col-lg-7">
          <div class="well" style="margin-top:20px; padding:15px;">
            <h5>Today <strong>(<?php echo date("d M, Y") ?>)</strong> Attendance Summary (Percentage)</h5>
            <div class="row">
              <div class="col-xs-2 text-center border-right">
                <div class="text-success" style="font-size:18px; font-weight:bold;"><?php echo  round(($today_attendance_summary->present / $today_attendance_summary->total) * 100, 2) ?>%</div>
                <small class="text-muted">Present</small>
              </div>
              <div class="col-xs-2 text-center border-right">
                <div class="text-danger" style="font-size:18px; font-weight:bold;"><?php echo  round(($today_attendance_summary->absent / $today_attendance_summary->total) * 100, 2) ?>%</div>
                <small class="text-muted">Absent</small>
              </div>
              <div class="col-xs-2 text-center border-right">
                <div class="text-primary" style="font-size:18px; font-weight:bold;"><?php echo  round(($today_attendance_summary->leave / $today_attendance_summary->total) * 100, 2) ?>%</div>
                <small class="text-muted">Leave</small>
              </div>
              <div class="col-xs-2 text-center">
                <div class="text-warning" style="font-size:18px; font-weight:bold;"><?php echo  round(($today_attendance_summary->struck_off / $today_attendance_summary->total) * 100, 2) ?>%</div>
                <small class="text-muted">Struck Off</small>
              </div>
              <div class="col-xs-2 text-center">
                <div class="text-warning" style="font-size:18px; font-weight:bold;"><?php echo  $today_attendance_summary->total ?></div>
                <small class="text-muted">Total Student</small>
              </div>
            </div>

          </div>
          <?php
          // Initialize totals
          $totalAbsent = $totalPresent = $totalLeave = $totalStruckOff = 0;
          $todaySummary = $this->db->query("SELECT class_id, section_id, class_title, section_title,
                sum(`absent`) as `absent`,
                sum(`present`) as `present`,
                sum(`leave`) as `leave`,
                sum(`struck_off`) as `struck_off`,
                SUM(evening_absent) as evening_absent,
                ea as evening_attendance
                FROM today_attendance_summery GROUP BY section_title, class_title ORDER BY class_id")->result();
          $totalStudents = $totalAbsent + $totalPresent + $totalLeave + $totalStruckOff;
          ?>

          <table border="1" id="today_attendance" cellpadding="5" cellspacing="0" style="width:100%; margin-bottom:20px;">
            <thead>
              <tr>
                <th>#</th>
                <th>Class</th>
                <th>Section</th>
                <th>Class Teacher</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Leave</th>
                <th>Struck Off</th>
                <th>Total</th>
                <th>Last Class</th>
                <th>Evening Absent</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              foreach ($todaySummary as $t):
                $totalAbsent += $t->absent;
                $totalPresent += $t->present;
                $totalLeave += $t->leave;
                $totalStruckOff += $t->struck_off;
                $evening_absent += $t->evening_absent;

              ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo htmlspecialchars($t->class_title) ?></td>
                  <td><?php echo htmlspecialchars($t->section_title) ?></td>
                  <th><?php
                      $query = "SELECT `teacher_name` FROM `classes_time_tables` 
                                      WHERE class_teacher=1 and class_id='" . $t->class_id . "' 
                                      AND section_id='" . $t->section_id . "';";
                      $class_teacher = $this->db->query($query)->row();
                      if ($class_teacher) {
                        echo $class_teacher->teacher_name;
                      }
                      ?></th>
                  <td><?php echo $t->present ?></td>
                  <td><?php echo $t->absent ?></td>
                  <td><?php echo $t->leave ?></td>
                  <td><?php echo $t->struck_off ?></td>
                  <td><?php echo ($t->present + $t->absent + $t->leave + $t->struck_off); ?></td>
                  <th>
                    <?php
                    $query = "SELECT `teacher_name` FROM `classes_time_tables` 
                                      WHERE period_id=10 and class_id='" . $t->class_id . "' 
                                      AND section_id='" . $t->section_id . "';";
                    $class_teachers = $this->db->query($query)->result();
                    if ($class_teachers) {
                      foreach ($class_teachers as $class_teacher) {
                        echo $class_teacher->teacher_name . ', <br />';
                      }
                    }
                    ?>
                  </th>
                  <td><?php
                      if ($t->evening_attendance == 'n') {
                        echo '<small style="color:red">Pending</small>';
                      } else {
                        echo $t->evening_absent;
                      } ?></td>
                </tr>
              <?php endforeach;
              $totalStudents = $totalAbsent + $totalPresent + $totalLeave + $totalStruckOff;
              ?>
            </tbody>
            <tfoot>
              <tr style="font-weight:bold;">
                <td colspan="4">Total</td>
                <td><?php echo $totalPresent ?></td>
                <td><?php echo $totalAbsent ?></td>

                <td><?php echo $totalLeave ?></td>
                <td><?php echo $totalStruckOff ?></td>
                <td><?php echo ($totalPresent + $totalAbsent + $totalLeave + $totalStruckOff) ?></td>
                <td></td>
                <td><?php echo $evening_absent; ?></td>
              </tr>
            </tfoot>
          </table>
          <table border="1" id="today_eve_attendance" cellpadding="5" cellspacing="0" style="width:100%; margin-bottom:20px;">
            <thead>
              <tr>
                <h4><strong>Evening Absent Students List - Date: <?php echo date('d F, Y'); ?></strong></h4>

              </tr>
              <tr>
                <th></th>
                <th colspan="3" style="text-align:center;">Students</th>
                <th></th>
                <th colspan="2" style="text-align:center;">Class</th>
                <th colspan="2" style="text-align:center;">Attendance</th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <th>S/No</th>
                <th>Class No</th>
                <th>Name</th>
                <th>Father Name</th>
                <th>Contact No.</th>
                <th>Class</th>
                <th>Section</th>
                <th>Morning</th>
                <th>Evening</th>
                <th>Skipping Last 7 Days</th>
                <th>Skipping Frequency</th>
                <th>Attendance Rate</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $count = 1;
              $query = "SELECT * FROM `today_evening_absent_students`";
              $today_evening_absent_students = $this->db->query($query)->result();
              foreach ($today_evening_absent_students as $today_evening_absent_student) { ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo $today_evening_absent_student->student_class_no; ?></td>
                  <td><?php echo $today_evening_absent_student->student_name; ?></td>
                  <td><?php echo $today_evening_absent_student->father_name; ?></td>
                  <td>
                    <?php echo $today_evening_absent_student->father_mobile_number; ?>
                    <?php
                    if ($today_evening_absent_student->guardian_contact_no != $today_evening_absent_student->father_mobile_number) {
                      echo "<br />" . $today_evening_absent_student->guardian_contact_no;
                    } ?>

                  </td>
                  <td><?php echo $today_evening_absent_student->class; ?></td>
                  <td><?php echo $today_evening_absent_student->section; ?></td>
                  <td style="text-align: center;"><?php echo $today_evening_absent_student->morning_attendance; ?></td>
                  <td style="text-align: center;"><?php echo $today_evening_absent_student->evening_attendance; ?></td>
                  <th style="text-align: center; color:red;">
                    <?php
                    $query = "SELECT COUNT(*) as total FROM `students_attendance`
                    WHERE student_id = ? AND attendance2='A' AND date >= CURDATE() - INTERVAL 7 DAY;";
                    echo $this->db->query($query, [$today_evening_absent_student->student_id])->row()->total;
                    ?>
                  </th>
                  <td style="text-align: center;"><?php
                                                  $query = "SELECT e_a, m_p, m_a, m_l, (m_p + m_a + m_l) AS total
                                                  FROM `students_attendance_list` WHERE student_id= ? ;";
                                                  $ea = $this->db->query($query, [$today_evening_absent_student->student_id])->row();
                                                  echo $ea->e_a;
                                                  ?></td>
                  <th><?php echo round(($ea->m_p * 100) / $ea->total, 2) . " %";  ?></th>
                <?php } ?>
            </tbody>
          </table>
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
    <div class="col-md-12">
      <div class="quick-pie panel panel-default">
        <div class="panel-body">
          <div id="daily_attendance_percentage"></div>
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
    SELECT 
  DATE(created_date) AS day, 
  SUM(absent) AS absent, 
  SUM(total) AS total, 
  SUM(present) AS present,
  SUM(`leave`) AS leave_count,
  SUM(`evening_absent`) as e_absent,
  SUM(`evening_leave`) as e_leave
FROM daily_class_wise_attendance
WHERE created_date >= CURDATE() - INTERVAL 30 DAY
GROUP BY DATE(created_date)
ORDER BY day ASC;
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
    $absent = (int)$dayWise[$date]->absent;
    $total = (int)$dayWise[$date]->total;
    $present = (int)$dayWise[$date]->present;
    $leave = (int)$dayWise[$date]->leave_count;
    $e_absent = (int)$dayWise[$date]->e_absent;
    $e_leave = (int)$dayWise[$date]->e_leave;
    // Avoid division by zero
    if ($total > 0) {
      $absent_percent[] = round(($absent / $total) * 100, 2);
      $present_percent[] = round(($present / $total) * 100, 2);
      $leave_percent[] = round(($leave / $total) * 100, 2);
      $e_absent_percent[] = round(($e_absent / $total) * 100, 2);
      $e_leave_percent[] = round(($e_leave / $total) * 100, 2);
    } else {
      $absent_percent[] = NULL;
      $present_percent[] = NULL;
      $leave_percent[] = NULL;
      $e_absent_percent[] = NULL;
      $e_leave_percent[] = NULL;
    }
  }
  ?>



  <?php
  // Get average daily absent
  $avgAbsentQuery = "
    SELECT AVG(absent) AS absent 
    FROM daily_total_attendance 
    WHERE YEAR(created_date) = YEAR(CURDATE())
    AND MONTH(created_date) = MONTH(CURDATE())";
  if ($this->db->query($avgAbsentQuery)->row()->absent) {
    $dailyabseentaverage = $this->db->query($avgAbsentQuery)->row()->absent;
  } else {
    $dailyabseentaverage = 0;
  }
  $absent_average = !empty($absent_percent) ? array_sum($absent_percent) / count($absent_percent) : 0;
  ?>
  Highcharts.chart('daily_attendance_percentage', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Last 30 Day Attendance Trend Analysis'
    },
    subtitle: {
      text: 'Total - Present - Absent - AVG Absent Per Day.'
    },
    xAxis: {
      categories: <?php echo json_encode($categories); ?>,
      crosshair: true
    },
    yAxis: {
      title: {
        text: 'Attendance Percentage (%)'
      },
      plotLines: [{
        id: 'avg_absent',
        value: <?php echo round($absent_average, 2); ?>,
        color: '#f15c80',
        dashStyle: 'ShortDash',
        width: 1,
        label: {
          text: 'Avg Absent % - <?php echo round($absent_average, 2); ?>',
          align: 'right',
          style: {
            color: '#f15c80'
          }
        },
        zIndex: 10
      }]
    },
    tooltip: {
      shared: true,
      valueSuffix: '%'
    },
    plotOptions: {
      column: {
        dataLabels: {
          enabled: true,
          format: '{point.y:.2f}%'
        },
        enableMouseTracking: true
      },
      spline: {
        dataLabels: {
          enabled: true,
          format: '{point.y:.2f}%'
        }
      },
      series: {
        connectNulls: true
      }
    },
    series: [{
        name: 'Present %',
        data: <?php echo json_encode($present_percent); ?>,
        color: '#7cb5ec'
      }, {
        name: 'Absent %',
        type: 'spline',
        data: <?php echo json_encode($absent_percent); ?>,
        color: '#f15c80'
      },
      {
        name: 'Leave %',
        type: 'spline',
        data: <?php echo json_encode($leave_percent); ?>,
        color: '#A3F791'
      },
      {
        name: 'Evening Absent %',
        type: 'spline',
        data: <?php echo json_encode($e_absent_percent); ?>,
        color: '#EE6C21'
      },
      {
        name: 'Evening Leave %',
        type: 'spline',
        data: <?php echo json_encode($e_leave_percent); ?>,
        color: '#A3F701'
      }


    ]

  });


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

  ?> Highcharts.chart('monthly_absent_avg', {
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

<?php
$monthlyAvg = $this->db->query("
    SELECT 
        class_title, section_title, 
        MONTH(created_date) as month, 
        AVG(absent) as avg_absent
    FROM daily_class_wise_attendance
    WHERE YEAR(created_date) = YEAR(CURDATE()) 
      AND MONTH(created_date) IN (5, 6, 8)
    GROUP BY class_title, section_title, MONTH(created_date)
")->result();

$data = array();
foreach ($monthlyAvg as $row) {
  $key = $row->class_title . '-' . $row->section_title;
  $month = ($row->month == 5) ? 'May' : 'June';
  if (!isset($data[$key])) {
    $data[$key] = array();
  }
  $data[$key][$month] = round($row->avg_absent, 2);
}

$categories = array();
$mayData = array();
$juneData = array();
$improvementData = array();

foreach ($data as $classSection => $months) {
  $may = isset($months['May']) ? $months['May'] : 0;
  $june = isset($months['June']) ? $months['June'] : 0;
  $categories[] = $classSection;
  $mayData[] = $may;
  $juneData[] = $june;

  if ($may > 0) {
    $improvement = (($may - $june) / $may) * 100;
  } else {
    $improvement = 0;
  }

  $improvementData[] = round($improvement, 1); // can be negative
}
?>





<script>
  today_attendance
  $(document).ready(function() {
        var table = $('#today_eve_attendance').DataTable({
          bPaginate: false,
          dom: 'Bfrtip',
          searching: false, // Disable search box
          buttons: ['excel', 'pdf'], // Add Excel and PDF buttons
          columnDefs: [{
            searchable: false,
            orderable: false,
            targets: 0 // First column (Serial No.) not sortable/searchable
          }],
          order: [] // Optional: avoid initial sorting
        });

        $(document).ready(function() {
          var table = $('#today_attendance').DataTable({
            bPaginate: false,
            dom: 'Bfrtip',
            searching: false, // Disable search box
            buttons: ['excel', 'pdf'], // Add Excel and PDF buttons
            columnDefs: [{
              searchable: false,
              orderable: false,
              targets: 0 // First column (Serial No.) not sortable/searchable
            }],
            order: [] // Optional: avoid initial sorting
          });

          // Auto-indexing the first column (Serial No.)
          table.on('order.dt search.dt draw.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
              })
              .nodes()
              .each(function(cell, i) {
                cell.innerHTML = i + 1;
              });
          }).draw();
        });
</script>
<h2 style='text-align:center; margin-bottom:15px;'>
  Class & Section Wise Monthly Average Absentees with Improvement
</h2>
<?php
// Step 1: Run Query
$monthlyAvg = $this->db->query("
    SELECT 
        class_title, section_title, 
        MONTH(created_date) as month, 
        AVG(absent) as avg_absent
    FROM daily_class_wise_attendance
    WHERE YEAR(created_date) = YEAR(CURDATE()) 
      AND MONTH(created_date) IN (5, 6, 8)
    GROUP BY class_title, section_title, MONTH(created_date)
")->result();

// Step 2: Restructure Results
$data = array();
foreach ($monthlyAvg as $row) {
  $key = $row->class_title . '-' . $row->section_title;

  if (!isset($data[$key])) {
    $data[$key] = array(
      'class'   => $row->class_title,
      'section' => $row->section_title,
      'months'  => array()
    );
  }

  $data[$key]['months'][$row->month] = round($row->avg_absent, 2);
}

// Step 3: Function to format improvement
function formatImprovement($value)
{
  if ($value < 0) {
    return "<span style='color:green;font-weight:bold;'>&#9660; " . round($value, 2) . "</span>"; // ▲
  } elseif ($value > 0) {
    return "<span style='color:red;font-weight:bold;'>&#9650; " . round($value, 2) . "</span>"; // ▼
  } else {
    return "<span style='color:gray;'>–</span>";
  }
}

// Step 4: Generate Table
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr style='background:#f2f2f2;'>
        <th>Class</th>
        <th>Section</th>
        <th>May</th>
        <th>June</th>
        <th>Improvement (Jun - May)</th>
        <th>August</th>
        <th>Improvement (Aug - Jun)</th>
      </tr>";

foreach ($data as $row) {
  $may    = isset($row['months'][5]) ? $row['months'][5] : 0;
  $june   = isset($row['months'][6]) ? $row['months'][6] : 0;
  $august = isset($row['months'][8]) ? $row['months'][8] : 0;

  $improveJune = $june - $may;
  $improveAug  = $august - $june;

  echo "<tr>
            <td>" . $row['class'] . "</td>
            <td>" . $row['section'] . "</td>
            <td>" . $may . "</td>
            <td>" . $june . "</td>
            <td>" . formatImprovement($improveJune) . "</td>
            <td>" . $august . "</td>
            <td>" . formatImprovement($improveAug) . "</td>
          </tr>";
}

echo "</table>";
?>