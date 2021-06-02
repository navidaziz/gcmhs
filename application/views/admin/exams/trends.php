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

          <script type="text/javascript">
$(function () {
    $('#exam_pass_fail_trend').highcharts({
        title: {
            text: 'Exam Wise  Trend Analysis ',
            x: -20 //center
        },
        subtitle: {
            text: 'Pass/Fail',
            x: -20
        },
        xAxis: {
            categories: [
                <?php foreach($exams as $exam){ ?>
                '<?php echo $exam->term; ?>',
                <?php } ?>
                ]
        },
        yAxis: {
            title: {
                text: 'Total'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: 'Total'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Pass',
            data: [
                
                <?php foreach($exams as $exam){ ?>
                <?php echo $exam->pass; ?>,
                <?php } ?>
                ]
        }, {
            name: 'Fail',
            data: [
                 <?php foreach($exams as $exam){ ?>
                <?php echo $exam->fail; ?>,
                <?php } ?>
                ]
        }]
    });
});
		</script>
		
		<div id="exam_pass_fail_trend" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

          
   <script type="text/javascript">
$(function () {
    $('#percentage_density').highcharts({
        chart: {
            type: 'area',
            inverted: false
        },
        title: {
            text: 'Percentage Density'
        },
        subtitle: {
            style: {
                position: 'absolute',
                right: '0px',
                bottom: '10px'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        xAxis: {
            categories: [
                <?php foreach($percentage_densities as $percentage_density){ ?>
                '<?php echo $percentage_density->percentage; ?> %',
                <?php } ?>
            ]
        },
        yAxis: {
            title: {
                text: 'Total Number of Students'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            },
            min: 0
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Percentage',
            data: [
                <?php foreach($percentage_densities as $percentage_density){ ?>
                <?php echo $percentage_density->total; ?>,
                <?php } ?>
                ]
        }]
    });
});
	
		</script>
		
		<div id="percentage_density" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
          
          
          
          
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>



<script src="<?php echo site_url('assets/admin/Highcharts/js/highcharts.js'); ?>"></script> 
            <script src="<?php echo site_url('assets/admin/Highcharts/js/exporting.js'); ?>"></script> 
