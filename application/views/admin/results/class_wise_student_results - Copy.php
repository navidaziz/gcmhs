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
         
          <?php 
		  $print_id = 1;
		  
		  foreach($all_results as $class => $results){ 
		  
		
			
			$printId= $print_id++."_print";
			 ?>
          <table  id="<?php echo $printId ?>"  class="table table-bordered" style="font-size:12px !important; color:#000 !important; width:100%;  text-align:center !important">
            <thead>
              <tr>
                <th colspan="12"> 
                <h3 style="text-align:center" >Class <?php echo $class; ?>  Sections </h3>
               <!-- <h4 style="text-align:center"><?php echo 'Class  '.$class.' Year '.$results[0]->session. ''; ?> </h4>-->
                </th>
              </tr>
              <tr style="border:1px solid #666 !important;">
                <th>#</th>
                
                <th ><?php echo $this->lang->line('roll_no'); ?></th>
                <th ><?php echo $this->lang->line('class_no'); ?></th>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <th ><?php echo $this->lang->line('section'); ?></th>
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
                <th><?php echo "Pass/Fail";  ?></th>
                <th><?php echo "Remarks";  ?></th>
                 <th>New Class/Section</th>
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
			 $class_number =1;
			  $fail="";
			  $others="";
			  foreach($results as $result): ?>
              
              
              
              
              <?php 
			  
			  if($s_no<=30){ $color_name = "#00FF99"; 
			  				 $new_section_name = $result->promote_class." - Green";
							  }else{
								  if($s_no<=60){ 
								   $color_name = "#33CCFF";
								   $new_section_name = $result->promote_class." - Blue";
								    }else{
										if($s_no<=90){ 
										 $color_name =  "#FFFF99";
										 $new_section_name = $result->promote_class." - Yellow";
										 }else{
										   $color_name =  "#FFFFFF";
										 $new_section_name = $result->promote_class." - Others";
						
						
						}  
					  }
				  
				  } ?>
              
              
              
              <?php 
			  
			  
			  if($class_number>30){
				  $class_number=1;
				  }
			  
			  $percentage = $result->percentage;
			  $remarks = "";
			  if($result->section=='Jugoor'){ $remarks =  remarks($percentage, 24.5); }else{
					if($result->section=='Khurkashan Deh'){ $remarks = remarks($percentage, 24.5); }else{
						if($result->class=='5th'){
							$remarks = remarks($percentage, 24.5);
							}else{
								if($result->class=='8th'){
								$remarks = remarks($percentage, 24.5);
								}else{
								$remarks = remarks($percentage, 14.5);
									}
						}
						}
					}
			$pass_fail = pass_fail($percentage); 		
			 if($remarks=='pass' or $remarks=='promote'){
				$promoted_class = "";
				if($result->class == '8th'){ $promoted_class = "9th"; } 
				if($result->class == '7th'){ $promoted_class = "8th"; } 
				if($result->class == '6th'){ $promoted_class = "7th"; } 
				if($result->class == '5th'){ $promoted_class = "6th"; } 
				
	/*$query = "UPDATE `results` SET `promote_class`='".$promoted_class."'  WHERE `result_id` = '".$result->result_id."'";
	$this->db->query($query);
		*/		
				 
			  ?>
              
              <tr style="border:1px solid #000 !important; 
             
              background-color:<?php echo $color_name; ?>">
                <td><?php echo $class_number++; ?></td>
                <td><?php echo $result->roll_no; ?></td>
                <td><?php echo $result->class_no; ?></td>
                <td><?php echo $result->student_name; ?></td>
                <td><?php echo $result->section; ?></td>
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
                <td><?php echo $result->total_marks; ?></td>
                <td><?php echo $percentage; ?></td>
                <td><?php echo get_grade($percentage); ?></td>
                <td><?php echo $pass_fail; ?></td>
                <td><?php  echo $remarks; ?></td>
                <td>
                
                <?php echo $new_section_name; ?>
                </td>
              </tr>
              <?php 
			  $s_no++;
			  
			  }else{
			
			
			/*$query = "UPDATE `results` SET `promote_class`='".$result->class."'  WHERE `result_id` = '".$result->result_id."'";
	$this->db->query($query);*/
			
			
			if($result->section=='Jugoor' or $result->section=='Khurkashan Deh'){ 
					
              $others.= '<tr style="border:1px solid #000 !important; background-color:gray; ">
                <td> # </td>
                <td>'.$result->roll_no.'</td>
                <td>'.$result->class_no.'</td>
                <td>'.$result->student_name.'</td>
				 <td>'.$result->section.'</td>
                <!--<td>'.paper_pass_fail($result->islamiyat).'</td>
                <td>'.paper_pass_fail($result->urdu).'</td>
                <td>'.paper_pass_fail( $result->english).'</td>
                <td>'.paper_pass_fail( $result->math).'</td>
                <td>'.paper_pass_fail( $result->arabi).'</td>
                <td>'.paper_pass_fail( $result->drawing).'</td>
                <td>'.paper_pass_fail( $result->computer).'</td>
                <td>'.paper_pass_fail( $result->general_science).'</td>
                <td>'.paper_pass_fail( $result->history_geography).'</td>-->
                <td>'.$result->obtain_marks.'</td>
                <td>'.$result->total_marks.'</td>
                <td>'.$percentage.'</td>
                <td>'.get_grade($percentage).'</td>
                <td>'.$pass_fail.'</td>
				 <td>'.$remarks.'</td>
				<td>-</td>
              </tr>';
			}else{
				$fail.= '<tr style="border:1px solid #000 !important; background-color:#FF3333; ">
                <td>'.$class_number++.'</td>
                <td>'.$result->roll_no.'</td>
                <td>'.$result->class_no.'</td>
                <td>'.$result->student_name.'</td>
				 <td>'.$result->section.'</td>
                <!--<td>'.paper_pass_fail($result->islamiyat).'</td>
                <td>'.paper_pass_fail($result->urdu).'</td>
                <td>'.paper_pass_fail( $result->english).'</td>
                <td>'.paper_pass_fail( $result->math).'</td>
                <td>'.paper_pass_fail( $result->arabi).'</td>
                <td>'.paper_pass_fail( $result->drawing).'</td>
                <td>'.paper_pass_fail( $result->computer).'</td>
                <td>'.paper_pass_fail( $result->general_science).'</td>
                <td>'.paper_pass_fail( $result->history_geography).'</td>-->
                <td>'.$result->obtain_marks.'</td>
                <td>'.$result->total_marks.'</td>
                <td>'.$percentage.'</td>
                <td>'.get_grade($percentage).'</td>
                <td>'.$pass_fail.'</td>
				<td>'.$remarks.'</td>
				<td>'. $new_section_name.'</td>
              </tr>';
				$s_no++;
				
				}
			  
			  
			  
               } ?>
              <?php 
			  
			  endforeach;
			  
			  echo $fail;
			  
			  echo $others;
			  
			   ?>
            </tbody>
          </table>
          
          <br />
          <br /><br />
          
          
          <br />
          <br /><br />

  
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
<!--<script type="text/javascript">
$(function () {
    $('#chart_1').highcharts({

        chart: {
            type: 'boxplot'
        },

        title: {
            text: 'Highcharts Box Plot Example'
        },

        legend: {
            enabled: false
        },

        xAxis: {
            categories: ['1', '2', '3', '4', '5'],
            title: {
                text: 'Experiment No.'
            }
        },

        yAxis: {
            title: {
                text: 'Observations'
            },
            plotLines: [{
                value: 932,
                color: 'red',
                width: 1,
                label: {
                    text: 'Theoretical mean: 932',
                    align: 'center',
                    style: {
                        color: 'gray'
                    }
                }
            }]
        },

        series: [{
            name: 'Observations',
            data: [
                [760, 801, 848, 895, 965],
                [733, 853, 939, 980, 1080],
                [714, 762, 817, 870, 918],
                [724, 802, 806, 871, 950],
                [834, 836, 864, 882, 910]
            ],
            tooltip: {
                headerFormat: '<em>Experiment No {point.key}</em><br/>'
            }
        }, {
            name: 'Outlier',
            color: Highcharts.getOptions().colors[0],
            type: 'scatter',
            data: [ // x, y positions where 0 is the first category
                [0, 644],
                [4, 718],
                [4, 951],
                [4, 969]
            ],
            marker: {
                fillColor: 'white',
                lineWidth: 1,
                lineColor: Highcharts.getOptions().colors[0]
            },
            tooltip: {
                pointFormat: 'Observation: {point.y}'
            }
        }]

    });
});
		</script>
<script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/Highcharts/js/highcharts.js"></script> 

<script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/Highcharts/js/highcharts-more.js"></script> 

<script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/Highcharts/js/modules/exporting.js"></script> 

<script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/Highcharts/js/modules/drilldown.js"></script> -->