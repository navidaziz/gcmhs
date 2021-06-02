<style>
.redcircle {
	border-radius: 50%;
	width: 20px;
	height: 20px;
	padding: 1px;
	border: 1px solid red;
	color: red;
	text-align: center;
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
          <table class="table table-bordered" style="font-size:10px !important; color:#000 !important">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('class_no'); ?></th>
                <th><?php echo $this->lang->line('admission_no'); ?></th>
                <th><?php echo $this->lang->line('roll_no'); ?></th>
                <th><?php echo $this->lang->line('session'); ?></th>
                <th><?php echo $this->lang->line('class'); ?></th>
                <th><?php echo $this->lang->line('section'); ?></th>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <th><?php echo $this->lang->line('islamiyat'); ?></th>
                <th><?php echo $this->lang->line('urdu'); ?></th>
                <th><?php echo $this->lang->line('english'); ?></th>
                <th><?php echo $this->lang->line('math'); ?></th>
                <th><?php echo $this->lang->line('arabi'); ?></th>
                <th><?php echo $this->lang->line('drawing'); ?></th>
                <th><?php echo $this->lang->line('computer'); ?></th>
                <th><?php echo $this->lang->line('general_studies'); ?></th>
                <th><?php echo $this->lang->line('history_geography'); ?></th>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($results as $result): ?>
              <tr>
                <td><?php echo $result->class_no; ?></td>
                <td><?php echo $result->admission_no; ?></td>
                <td><?php echo $result->roll_no; ?></td>
                <td><?php echo $result->session; ?></td>
                <td><?php echo $result->class; ?></td>
                <td><?php echo $result->section; ?></td>
                <td><?php echo $result->student_name; ?></td>
                <td><?php echo pass_fail($result->islamiyat); ?></td>
                <td><?php echo pass_fail($result->urdu);  ?></td>
                <td><?php echo pass_fail( $result->english); ?></td>
                <td><?php echo pass_fail( $result->math); ?></td>
                <td><?php echo pass_fail( $result->arabi); ?></td>
                <td><?php echo pass_fail( $result->drawing); ?></td>
                <td><?php echo pass_fail( $result->computer); ?></td>
                <td><?php echo pass_fail( $result->general_studies); ?></td>
                <td><?php echo pass_fail( $result->history_geography); ?></td>
                <td><?php echo status($result->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($result->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."results/publish/".$result->result_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($result->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."results/draft/".$result->result_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."results/view_result/".$result->result_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."results/edit/".$result->result_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."results/trash/".$result->result_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php //echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
