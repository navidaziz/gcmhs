<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?php echo $system_global_settings[0]->system_title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">


<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."css/cloud-admin.css"); ?>" />
<link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR."css/themes/default.css"); ?>" id="skin-switcher" />
<link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR."css/responsive.css"); ?>" />

<!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->

<link href="<?php echo site_url("assets/".ADMIN_DIR."font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" />

<!-- ANIMATE -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."css/animatecss/animate.min.css"); ?>" />

<!-- date picker-->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/bootstrap-datepicker/css/bootstrap-datepicker.css"); ?>" />

<!-- JQUERY -->
<script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery/jquery-2.0.3.min.js"); ?>"></script>

<!-- BOOTSTRAP -->
<script  src="<?php echo site_url("assets/".ADMIN_DIR."bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

<!-- GRITTER -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/gritter/css/jquery.gritter.css"); ?>" />
<!-- FONTS -->
<link href='<?php echo site_url("assets/".ADMIN_DIR."css/fonts.css"); ?>' rel='stylesheet' type='text/css' />

<!-- jstree resources -->
<script src="<?php echo site_url("assets/".ADMIN_DIR."jstree-dist/jstree.min.js"); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."jstree-dist/themes/default/style.min.css"); ?>" />

<!-- HUBSPOT MESSENGER -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/css/messenger.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/css/messenger-theme-flat.min.css"); ?>" />
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/js/messenger.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/js/messenger-theme-flat.js"); ?>"></script>
<!-- HUBSPOT MESSENGER -->
<!-- SELECT2 -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/select2/select2.min.css" />
<!-- TYPEAHEAD -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/typeahead/typeahead.css" />
<!-- SELECT2 -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/select2/select2.min.css" />
<!-- UNIFORM -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/uniform/css/uniform.default.min.css" />

<!-- DATE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/datepicker/themes/default.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/datepicker/themes/default.date.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/datepicker/themes/default.time.min.css" />


<!-- custome styhles -->

<!--<script src="<?php echo site_url("assets/".ADMIN_DIR."js/script.js"); ?>"></script>-->
<?php if($this->lang->line('direction')=="rtl"){ ?>
<style>
.sidebar-menu > ul > li > ul.sub > li > a {
	color: #555555;
	font-size: 13px;
	font-weight: 400;
	margin-right: 15px !important;
	padding-right: 5px !important;
}


</style>
<?php } ?>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
 <script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/tinymce/js/tinymce/tinymce.min.js"></script>

<script>

function printData(table_id)
{
	var divToPrint=document.getElementById(table_id);
   
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
   
}



var stakeholder_or_activity ="";
function get_list(from, where_get, change_field_id){
	//alert(from);
		id=$('#'+where_get+'_f').val();
		
		//alert(where_get);
	
		
		
		
		
		url="<?php echo base_url()."".ADMIN_DIR; ?>";
		url=url+from;
		url=url+"/get_json/"+where_get+"/";
		url=url+id;
		console.log(url);
		$.ajax({ type: "POST",url: url,data:{ }}).done(function( data ) { 
				var obj = JSON.parse(data);
				var option="";
				for(var id in obj){
					option=option+"<option value='"+obj[id].id+"'>"+obj[id].value+"</option>";
				}
				$("#"+change_field_id+"_f").html(option);
			});
		
}
</script>

<!-- time line -->
		<link rel="stylesheet" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/horizontal_timeline/css/reset.css">
        <!-- CSS reset -->
        <link rel="stylesheet" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/horizontal_timeline/css/style.css">
        <!-- Resource style -->
        <script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/horizontal_timeline/js/modernizr.js"></script><!-- Modernizr -->
	<!-- end time line -->
<!-- Bootstrap core CSS -->
<link href="<?php echo site_url("assets/".ADMIN_DIR); ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
<body>
<section id="page" >

<div class="container">
<!--<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
     
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."exams/view/"); ?>"><?php echo $this->lang->line('Exams'); ?></a> </li>
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
          <div class="pull-right"> <a target="new" class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."exam_list/paper_collection_report/".$exams[0]->exam_id); ?>">Print</a> </div>
        </div>
      </div>
    </div>
  </div>
</div>-->
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row" style="margin-top:5px;"> 
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      
      <div class="box-body">
        <div class="table-responsive" style="font-size:11px !important;">
        <h1><?php echo $title; ?></h1>

          <table class="table">
            <thead>
            </thead>
            <tbody>
              <?php foreach($exams as $exam): ?>
              <tr>
                <th><?php echo $this->lang->line('year'); ?></th>
                <th><?php echo $this->lang->line('term'); ?></th>
                <th><?php echo $this->lang->line('passing_percentage'); ?></th>
                <th><?php echo $this->lang->line('promotion_percentage'); ?></th>
                <th><?php echo $this->lang->line('exam_data'); ?></th>
                <th><?php echo $this->lang->line('Status'); ?></th>
              </tr>
              <tr>
                <td><?php echo $exam->year; ?></td>
                <td><?php echo $exam->term; ?></td>
                <td><?php echo $exam->passing_percentage; ?></td>
                <td><?php echo $exam->promotion_percentage; ?></td>
                <td><?php echo $exam->exam_data; ?></td>
                <td><?php echo status($exam->status); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div class="row">
            <div class="col-md-4"> 
              <script type="text/javascript">
$(function () {
    $('#pass_fail').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Students Pass / Fail View'
        },
		
		subtitle: {
    text: 'Total: <?php echo $pass_fail_counts[0]->total+$pass_fail_counts[1]->total; ?> Pass: <?php echo $pass_fail_counts[1]->total;  ?> and Fail: <?php echo $pass_fail_counts[0]->total;  ?> '
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
            name: "Students",
            colorByPoint: true,
            data: [
			<?php foreach($pass_fail_counts as $pass_fail_count){ ?>
			{
                name: "<?php echo $pass_fail_count->pass_fail_status;  ?>",
                y: <?php echo $pass_fail_count->total;  ?>,
				<?php if($pass_fail_count->pass_fail_status=='Pass'){ ?> color:'#99ff99' <?php } ?>
				<?php if($pass_fail_count->pass_fail_status=='Fail'){ ?> color:'#F40202' <?php } ?>
            },
			<?php } ?>
			]
        }]
    });
});
		</script>
              <div id="pass_fail" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            </div>
            <div class="col-md-5"> 
              <script type="text/javascript">
$(function () {
    $('#per_wise_report').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Students Percentage Frequencies Distribution'
        },
        /*subtitle: {
            text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
        },*/
        xAxis: {
            type: 'category',
            labels: {
                rotation: -20,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Number Of Students'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Total: <b>{point.y} Students</b>'
        },
        series: [{
            name: 'Percentage Frequancies',
            data: [
			<?php foreach($percentage_counts as $percentage_index => $value){ ?>
			['<?php echo $percentage_index;  ?>%', <?php echo $value;  ?>],
			<?php } ?>
			   
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#00000',
                align: 'right',
                format: '{point.y:.0f}', // one decimal
                y: -30, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
});
		</script>
              <div id="per_wise_report" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
            </div>
            
            <div class="col-md-3">
            <h5>Top Ten Students of School</h5>
            <table class="table table-bordered">
            <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>%</th>
            </tr>
            <?php 
			$count =1;
			foreach($top_ten_students as $top_ten_student){ ?>
			<tr >
            <td><?php echo $count++; ?></td>
            <td><?php echo $top_ten_student->student_name; ?></td>
            <td style="background-color:<?php echo $top_ten_student->color; ?>"><?php echo $top_ten_student->Class_title; ?> (<?php echo $top_ten_student->section_title; ?>)</td>
            <td><?php echo $top_ten_student->percentage; ?></td>
            </tr>
			<?php } ?>
            </table>
            </div>
            
            <div class="col-md-6"> 
              <script type="text/javascript">

$(function () {
    // Create the chart
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grade Wise Students Distribution'
        },
       /* subtitle: {
            text: 'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
        },*/
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total Students'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Students<br/>'
        },

        series: [{
            name: "Grade",
            colorByPoint: true,
            data: [
			<?php foreach($grades_counts as $grades_count){ ?>
			{
                name: "<?php echo $grades_count->Grade; ?>",
                y: <?php echo $grades_count->total; ?>,
               
            }, 
			<?php } ?>
			]
        }],
       
    });
});
		</script>
              <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
            <div class="col-md-6"> 
              <script type="text/javascript">

$(function () {
    // Create the chart
    $('#division').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grade Wise Students Distribution'
        },
        /*subtitle: {
            text: 'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
        },*/
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total Students'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Students<br/>'
        },

        series: [{
            name: "Grade",
            colorByPoint: true,
            data: [
			<?php foreach($division_counts as $division_count){ ?>
			{
                name: "<?php echo $division_count->Division; ?>",
                y: <?php echo $division_count->total; ?>,
               
            }, 
			<?php } ?>
			]
        }],
       
    });
});
		</script>
              <div id="division" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
            <div class="col-md-4"> 
              <script type="text/javascript">
$(function () {
    $('#classe_wise_pass_fails').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Class Wise Pass / Fail'
        },
        /*subtitle: {
            text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        },*/
        xAxis: {
            categories: [<?php 
			$pass = "";
			$fail = "";
			$pass_fail_total="";
			foreach($classe_wise_pass_fails as $classe_wise_pass_fail){ 
			$pass.= $classe_wise_pass_fail->pass.", ";
			$fail.= $classe_wise_pass_fail->fail.", ";
			$pass_fail_total.=$classe_wise_pass_fail->pass+$classe_wise_pass_fail->fail.", ";
			
			?>'<?php echo $classe_wise_pass_fail->Class_title;  ?>', <?php } ?>], 
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Students (Total)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Total'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Pass',
            data: [<?php echo $pass; ?>],
			color:'#90ed7d'
        }, {
            name: 'Fail',
            data: [<?php echo $fail; ?>],
			color: '#f15c80'
        },
		{
			name: 'Total',
			data:[<?php echo $pass_fail_total; ?>],
			color: '#7cb5ec'
			}
		]
    });
});
		</script>
              <div id="classe_wise_pass_fails" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
            </div>
            <div class="col-md-8"> 
              <script type="text/javascript">
$(function () {
    $('#classe_section_pass_fails').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Class Sections Wise Pass / Fail'
        },
       /* subtitle: {
            text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        },*/
        xAxis: {
            categories: [<?php 
			$pass = "";
			$fail = "";
			$pass_fail_total="";
			foreach($classe_section_pass_fails as $classe_section_pass_fail){ 
			$pass.= $classe_section_pass_fail->pass.", ";
			$fail.= $classe_section_pass_fail->fail.", ";
			$pass_fail_total.=$classe_section_pass_fail->pass+$classe_section_pass_fail->fail.", ";
			?>'<?php echo $classe_section_pass_fail->Class_title;  ?> (<?php echo $classe_section_pass_fail->section_title;  ?>)', <?php } ?>], 
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Students (Total)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Total'
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Pass',
            data: [<?php echo $pass; ?>],
			color:'#90ed7d'
        }, {
            name: 'Fail',
            data: [<?php echo $fail; ?>],
			color: '#f15c80'
        },
		{
			name: 'Total',
			data:[<?php echo $pass_fail_total; ?>],
			color: '#7cb5ec'
			}]
    });
});
		</script>
              <div id="classe_section_pass_fails" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
            </div>
            <div class="col-md-11"> 
              <script type="text/javascript">
$(function () {
    $('#subject_pass_fails').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Subject Wise Pass / Fail'
        },
        /*subtitle: {
            text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        },*/
        xAxis: {
            categories: [<?php 
			$pass = "";
			$fail = "";
			$total = "";
			foreach($subject_pass_fails as $subject_pass_fail){ 
			$pass.= $subject_pass_fail->pass.", ";
			$fail.= $subject_pass_fail->fail.", ";
			$total.=$subject_pass_fail->fail+$subject_pass_fail->pass.", "
			
			?>'<?php echo $subject_pass_fail->subject_title;  ?>', <?php } ?>], 
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Students (Total)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Total'
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Pass',
            data: [<?php echo $pass; ?>]
        }
		
		, {
            name: 'Fail',
            data: [<?php echo $fail; ?>]
        }
		/*, {
            name: 'Total',
            data: [<?php echo $total; ?>]
        }*/]
    });
});
		</script>
              <div id="subject_pass_fails" style="min-width: 310px;  height: 400px; margin: 0 auto"></div>
            </div>
            <?php foreach($class_teacher_subject_pass_fails as $class_teacher_subject_pass_fail){ ?>
            <div class="col-md-11"> 
              <script type="text/javascript">
$(function () {
    $('#class_teacher_pass_fail_<?php echo $class_teacher_subject_pass_fail->Class_title; ?>').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Class <?php echo $class_teacher_subject_pass_fail->Class_title ?> - Teacher / Subject Wise Pass / Fail View'
        },
        /*subtitle: {
            text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        },*/
        xAxis: {
            categories: [<?php 
			$pass = "";
			$fail = "";
			$total = "";
			foreach($class_teacher_subject_pass_fail->class_teachers as $class_teacher){ 
		
			$pass.= $class_teacher->pass.", ";
			$fail.= $class_teacher->fail.", ";
			$total.=$class_teacher->fail+$class_teacher->pass.", "
			
			?>'<?php echo $class_teacher->class_teacher;  ?> (<?php echo $class_teacher->subject_title; ?>)', <?php } ?>], 
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Students (Total)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Total'
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Pass',
            data: [<?php echo $pass; ?>]
        }
		
		, {
            name: 'Fail',
            data: [<?php echo $fail; ?>]
        }
		/*, {
            name: 'Total',
            data: [<?php echo $total; ?>]
        }*/]
    });
});
		</script>
              <div id="class_teacher_pass_fail_<?php echo $class_teacher_subject_pass_fail->Class_title; ?>" style="min-width: 310px;  height: 400px; margin: 0 auto"></div>
            </div>
            <?php } ?>
            <script src="<?php echo site_url('assets/admin/Highcharts/js/highcharts.js'); ?>"></script> 
            <script src="<?php echo site_url('assets/admin/Highcharts/js/exporting.js'); ?>"></script> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
