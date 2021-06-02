<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<!-- STYLER -->
			
			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/"); ?>"><?php echo $this->lang->line('Mobile Demand Activites Or Stakeholders Meetings'); ?></a>
			</li><li><?php echo $title; ?></li>
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
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
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
		</div><div class="box-body">
			
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($mobile_demand_activites_or_stakeholders_meetings as $mobile_demand_activites_or_stakeholders_meetings): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('id'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->id; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('meeting_id'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->meeting_id; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('stakeholder_or_activity_type_id'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakeholder_or_activity_type_id; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('meeting_demand_id'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->meeting_demand_id; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('user_id'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->user_id; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('stakeholder_and_activty'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakeholder_and_activty; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('stakehoder_rating'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakehoder_rating; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('stakeholder_and_activity_detail'); ?></th>
                <td>
                    <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakeholder_and_activity_detail; ?>
                </td>
            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <td>
                                    <?php echo status($mobile_demand_activites_or_stakeholders_meetings->status); ?>
                                </td>
                            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
