<style>

.redcircle {
	border-radius: 50%;
	width: 20px;
	height: 20px;
	padding: 1px;
	border: 1px solid red;
	color: red;
	text-align: center;
	background-color: red;
	color: white;
	 
}
.blackcircle {
	border-radius: 50%;
	width: 20px;
	height: 20px;
	padding: 1px;
	border: 1px solid black;
	color: red;
	text-align: center;
	background-color: black;
	color: white;
	
}



</style>
<!-- PAGE HEADER-->
<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
        <div class="col-md-6">
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."results/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."results/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>
      </div>
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
          <script src="<?php echo site_url("assets/admin/Highcharts"); ?>/js/highcharts.js"></script> 
          <script src="<?php echo site_url("assets/admin/Highcharts"); ?>/js/modules/exporting.js"></script>
          <?php 
		  $print_id = 1;
		  
		  foreach($all_results as $class => $results){ 
		  
		
			
			$printId= $print_id++."_print";
			 ?>
          <table  id="<?php echo $printId ?>"  class="table table-bordered" style="font-size:12px !important; color:#000 !important; width:100%;  text-align:center !important">
            <thead>
              <tr>
                <th colspan="8"> 
                <h3 style="text-align:center" >Top 3 Position Holders</h3>
                <h4 style="text-align:center"><?php echo 'Class  '.$class.' Year '.$results[0]->session. ''; ?> </h4>
                </th>
              </tr>
              <tr style="border:1px solid #666 !important;">
                <th>#</th>
                
                <th ><?php echo $this->lang->line('roll_no'); ?></th>
                <th ><?php echo $this->lang->line('class_no'); ?></th>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <!--<th><?php echo $this->lang->line('islamiyat'); ?></th>
                <th><?php echo $this->lang->line('urdu'); ?></th>
                <th><?php echo $this->lang->line('english'); ?></th>
                <th><?php echo $this->lang->line('math'); ?></th>
                <th><?php echo $this->lang->line('arabi'); ?></th>
                <th><?php echo $this->lang->line('drawing'); ?></th>
                <th><?php echo $this->lang->line('computer'); ?></th>
                <th><?php echo "General Science" ?></th>
                <th><?php echo $this->lang->line('history_geography'); ?></th>-->
                <th><?php echo "Obtain Marks";  ?></th>
                <th><?php echo "Total Marks";  ?></th>
                <th><?php echo "%age";  ?></th>
                <th><?php echo "Grade";  ?></th>
                <!--<th><?php echo "Pass/Fail";  ?></th>-->
                <!-- <th><?php echo $this->lang->line('Action'); ?></th>--> 
              </tr>
            </thead>
            
            <!--<tfoot>
            <tr>
            <td colspan="17" style="text-align:left">
            <p style="padding:20px;"><span style="float:left !important text-align:center">Exam Cell<br />GCMHS Boy Chitral</span>
           <span style="float:right !important; text-align:center"> Principal<br />GCMHS Boy Chitral </span> 
           </p></td>
            </tr>
            </tfoot>-->
            <tbody>
              <?php 
			  $s_no = 1;
			  foreach($results as $result): ?>
              <tr style="border:1px solid #000 !important;">
                <td><?php echo $s_no++; ?></td>
                <td><?php echo $result->roll_no; ?></td>
                <td><?php echo $result->class_no; ?></td>
                <td><?php echo $result->student_name; ?></td>
                <!--<td><?php echo paper_pass_fail($result->islamiyat); ?></td>
                <td><?php echo paper_pass_fail($result->urdu);  ?></td>
                <td><?php echo paper_pass_fail( $result->english); ?></td>
                <td><?php echo paper_pass_fail( $result->math); ?></td>
                <td><?php echo paper_pass_fail( $result->arabi); ?></td>
                <td><?php echo paper_pass_fail( $result->drawing); ?></td>
                <td><?php echo paper_pass_fail( $result->computer); ?></td>
                <td><?php echo paper_pass_fail( $result->general_science); ?></td>
                <td><?php echo paper_pass_fail( $result->history_geography); ?></td>-->
                <td><?php echo $result->obtain_marks; ?></td>
                <td><?php echo get_total_marks(); ?></td>
                <td><?php echo $percentage = round(($result->obtain_marks*100)/900,2)."%"; ?></td>
                <td><?php echo get_grade($percentage); ?></td>
                <!--<td><?php echo pass_fail($percentage); ?></td>-->
                <!--<td><a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."results/view_result/".$result->result_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."results/edit/".$result->result_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."results/trash/".$result->result_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a></td>--> 
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          
          <br />
          <br /><br />
          
          
          <br />
          <br /><br />

     <script>     
       
	   
	$(document).ready(function() {
    $('#<?php echo $printId ?>').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
} );
	
} );
</script>
          <?php  
		
}
?>
          <?php //echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" > </script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" />
