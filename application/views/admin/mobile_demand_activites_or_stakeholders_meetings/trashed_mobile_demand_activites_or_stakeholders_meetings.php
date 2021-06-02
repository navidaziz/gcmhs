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
                
                    <table class="table table-table-bordered">
						<thead>
						  <tr>
							<th><?php echo $this->lang->line('id'); ?></th>
<th><?php echo $this->lang->line('meeting_id'); ?></th>
<th><?php echo $this->lang->line('stakeholder_or_activity_type_id'); ?></th>
<th><?php echo $this->lang->line('meeting_demand_id'); ?></th>
<th><?php echo $this->lang->line('user_id'); ?></th>
<th><?php echo $this->lang->line('stakeholder_and_activty'); ?></th>
<th><?php echo $this->lang->line('stakehoder_rating'); ?></th>
<th><?php echo $this->lang->line('stakeholder_and_activity_detail'); ?></th>
                            <th><?php echo $this->lang->line('Action'); ?></th>
						  </tr>
						</thead>
						<tbody>
					  <?php foreach($mobile_demand_activites_or_stakeholders_meetings as $mobile_demand_activites_or_stakeholders_meetings): ?>
                         <tr>
                            
                            
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->id; ?>
            </td>
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->meeting_id; ?>
            </td>
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakeholder_or_activity_type_id; ?>
            </td>
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->meeting_demand_id; ?>
            </td>
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->user_id; ?>
            </td>
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakeholder_and_activty; ?>
            </td>
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakehoder_rating; ?>
            </td>
            <td>
                <?php echo $mobile_demand_activites_or_stakeholders_meetings->stakeholder_and_activity_detail; ?>
            </td>
                            
                            <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view_mobile_demand_activites_or_stakeholders_meetings/".$mobile_demand_activites_or_stakeholders_meetings->m_d_a_or_s_m_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-restore" href="<?php echo site_url(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/restore/".$mobile_demand_activites_or_stakeholders_meetings->m_d_a_or_s_m_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-undo"></i></a>
                                <a class="llink llink-delete" href="<?php echo site_url(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/delete/".$mobile_demand_activites_or_stakeholders_meetings->m_d_a_or_s_m_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-times"></i></a>
                            </td>
                         </tr>
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      <?php echo $pagination; ?>

            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
