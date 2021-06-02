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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."students/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."students/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                
                    <table class="table table-bordered">
						<thead>
						  <tr>
                          
							<th><?php echo $this->lang->line('student_class_no'); ?></th>
<th><?php echo $this->lang->line('student_name'); ?></th>
<th><?php echo $this->lang->line('student_father_name'); ?></th>
<th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
<th><?php echo $this->lang->line('student_address'); ?></th>
<th><?php echo $this->lang->line('student_admission_no'); ?></th>
<th><?php echo $this->lang->line('student_image'); ?></th>
<th><?php echo $this->lang->line('Class_title'); ?></th>
<th><?php echo $this->lang->line('section_title'); ?></th><th><?php echo $this->lang->line('Status'); ?></th><th><?php echo $this->lang->line('Action'); ?></th>
                        </tr>
						</thead>
						<tbody>
					  <?php foreach($students as $student): ?>
                         
                         <tr>
                         
                             
            <td>
                <?php echo $student->student_class_no; ?>
            </td>
            <td>
                <?php echo $student->student_name; ?>
            </td>
            <td>
                <?php echo $student->student_father_name; ?>
            </td>
            <td>
                <?php echo $student->student_data_of_birth; ?>
            </td>
            <td>
                <?php echo $student->student_address; ?>
            </td>
            <td>
                <?php echo $student->student_admission_no; ?>
            </td>
            <td>
            <?php
                echo file_type(base_url("assets/uploads/".$student->student_image));
            ?>
            </td>
            <td>
                <?php echo $student->Class_title; ?>
            </td>
            <td>
                <?php echo $student->section_title; ?>
            </td>
                                <td>
                                    <?php echo status($student->status,  $this->lang); ?>
                                    <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($student->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."students/publish/".$student->student_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($student->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."students/draft/".$student->student_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                                </td>
                                <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."students/view_student/".$student->student_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."students/edit/".$student->student_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."students/trash/".$student->student_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
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
