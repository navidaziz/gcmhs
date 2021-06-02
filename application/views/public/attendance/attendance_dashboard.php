
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


<div class="row" style="font-size:10px !important">



<div class="col-md-6">
<table class="table table-sm" id="data_table">
<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Class Section</th>
      <th scope="col">AVG</th>
      <th>C.Month AVG</th>
      <th>C.Week AVG</th>
      <th>Today %</th>
    </tr>
  </thead>
  <tbody>
<?php 
$count=1;
foreach($avg_attendances as $avg_attendance){ ?>
<tr>
<td><?php echo $count; $count++;?></td>
<td><?php echo $avg_attendance->Class_title ?> <?php echo $avg_attendance->section_title ?></td>
<td><?php echo $avg_attendance->absent_avg ?></td>
<td>
<?php 
$query="SELECT ROUND(AVG(`daily_attendances`.`absent`), 1) AS month_avg
					FROM
					`daily_attendances` 
					WHERE `session_id` ='".$current_session."'
					AND `section_id` ='".$avg_attendance->section_id."'
					AND `class_id` ='".$avg_attendance->class_id."'
					AND MONTH(`created_date`) ='".date("m", time())."'";
			$result = $this->db->query($query);
			$avg_attendances = $result->result()[0];		
			echo $avg_attendances->month_avg;

?>
</td>
<td>
<?php 
$query="SELECT ROUND(AVG(`daily_attendances`.`absent`), 1) AS current_week_avg
					FROM
					`daily_attendances` 
					WHERE `session_id` ='".$current_session."'
					AND `section_id` ='".$avg_attendance->section_id."'
					AND `class_id` ='".$avg_attendance->class_id."'
					AND YEARWEEK(`created_date`) =YEARWEEK(NOW())";
			$result = $this->db->query($query);
			$current_week_avg = $result->result()[0];		
			echo $current_week_avg->current_week_avg;

?>
</td>
<td>
<?php 
$query="SELECT ROUND(((`absent`/`total`)*100), 1) AS today_pre
					FROM
					`daily_attendances` 
					WHERE `session_id` ='".$current_session."'
					AND `section_id` ='".$avg_attendance->section_id."'
					AND `class_id` ='".$avg_attendance->class_id."'
					AND DATE(`created_date`) =CURDATE()";
			@$result = $this->db->query($query);
			@$per_attendances = $result->result()[0];		
			echo @$per_attendances->today_pre;

?>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>






<div class="col-md-6">
<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
</div>
<div class="col-md-12">
<div id="over_all_daily_attendance" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
<div class="col-md-12">
<div id="class_section_over_all_daily_attendance" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>




</div>


<script>

Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Today Attendance'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Present',
            y: <?php echo $today_present; ?>
        }, {
            name: 'Absent',
            y: <?php echo $today_absent; ?>
        }]
    }]
});
</script>

<script>
Highcharts.chart('over_all_daily_attendance', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Daily Attendance'
    },
    
    xAxis: {
        categories: [
		<?php 
		$daily_present = "";
		$daily_absent = "";
		$daily_total = ""; 
		foreach($over_all_daily_attendance as $daily_attendance ){ 
		$daily_present=$daily_present."".$daily_attendance->total_present.",";
		$daily_absent=$daily_absent."".$daily_attendance->total_absents.",";
		$daily_total=$daily_total."".$daily_attendance->total.",";
		?> '<?php echo date("d M, y", strtotime($daily_attendance->date)); ?>',<?php } ?>
		 ]
    },
    yAxis: {
        title: {
            text: 'Total Student'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Present',
        data: [<?php echo $daily_present; ?>]
    }, {
        name: 'Absent',
        data: [<?php echo $daily_absent; ?>]
    }, {
        name: 'Total',
        data: [<?php echo $daily_total; ?>]
    }]
});
</script>
<script>
Highcharts.chart('class_section_over_all_daily_attendance', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Daily Attendance'
    },
    
    xAxis: {
        categories: [
		<?php 
		$daily_present = "";
		$daily_absent = "";
		$daily_total = ""; 
		foreach($class_section_daily_attendance['10th Green'] as $dates ){ 
		?> '<?php echo date("d M, y", strtotime($dates->date)); ?>',<?php } ?>
		 ]
    },
    yAxis: {
        title: {
            text: 'Total Student'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [
	<?php foreach($class_section_daily_attendance as $class_section => $attendances){ ?>
	{
        name: '<?php echo $class_section; ?>',
        data: [
		<?php foreach($attendances as $attendance){ ?> <?php echo $attendance->total_absents; ?>, <?php } ?>]
    },
	
	<?php } ?>
	 ]
});


$(document).ready(function() {
    $('#data_table').DataTable({
		"paging": false,
		searching: false,
		});
} );


</script>