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
				<a href="<?php echo site_url(ADMIN_DIR."audios/view/"); ?>"><?php echo $this->lang->line('Audios'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."audios/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."audios/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
					  <?php foreach($audios as $audio): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('audio_name'); ?></th>
                <td>
                    <?php echo $audio->audio_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('singer_name'); ?></th>
                <td>
                    <?php echo $audio->singer_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('writer_name'); ?></th>
                <td>
                    <?php echo $audio->writer_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_type'); ?></th>
                <td>
                    <?php echo $audio->audio_type; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_album'); ?></th>
                <td>
                    <?php echo $audio->audio_album; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_detail'); ?></th>
                <td>
                    <?php echo $audio->audio_detail; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_comment'); ?></th>
                <td>
                    <?php echo $audio->audio_comment; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_year'); ?></th>
                <td>
                    <?php echo $audio->audio_year; ?>
                </td>
            </tr>
            <tr>
                <th>Audio File</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$audio->audio_file));
                ?>
                </td>
            </tr>
            <tr>
                <th>Audio Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$audio->audio_image));
                ?>
                </td>
            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <td>
                                    <?php echo status($audio->status); ?>
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
