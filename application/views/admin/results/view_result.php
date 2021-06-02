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
				<a href="<?php echo site_url(ADMIN_DIR."results/view/"); ?>"><?php echo $this->lang->line('Results'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."results/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."results/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
					  <?php foreach($results as $result): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('class_no'); ?></th>
                <td>
                    <?php echo $result->class_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('admission_no'); ?></th>
                <td>
                    <?php echo $result->admission_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('roll_no'); ?></th>
                <td>
                    <?php echo $result->roll_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('session'); ?></th>
                <td>
                    <?php echo $result->session; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('class'); ?></th>
                <td>
                    <?php echo $result->class; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('section'); ?></th>
                <td>
                    <?php echo $result->section; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <td>
                    <?php echo $result->student_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('islamiyat'); ?></th>
                <td>
                    <?php echo $result->islamiyat; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('urdu'); ?></th>
                <td>
                    <?php echo $result->urdu; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('english'); ?></th>
                <td>
                    <?php echo $result->english; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('math'); ?></th>
                <td>
                    <?php echo $result->math; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('arabi'); ?></th>
                <td>
                    <?php echo $result->arabi; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('drawing'); ?></th>
                <td>
                    <?php echo $result->drawing; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('computer'); ?></th>
                <td>
                    <?php echo $result->computer; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('general_studies'); ?></th>
                <td>
                    <?php echo $result->general_studies; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('history_geography'); ?></th>
                <td>
                    <?php echo $result->history_geography; ?>
                </td>
            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <td>
                                    <?php echo status($result->status); ?>
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
