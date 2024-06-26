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
				<a href="<?php echo site_url(ADMIN_DIR."students_exams_subjects_marks/view/"); ?>"><?php echo $this->lang->line('Students Exams Subjects Marks'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."students_exams_subjects_marks/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."students_exams_subjects_marks/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
		</div>
        <div class="box-body">

            <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."students_exams_subjects_marks/update_data/$student_exam_subject_mark->student_exam_subject_mark_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("student_exam_subject_mark_id", $student_exam_subject_mark->student_exam_subject_mark_id); ?>
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('term'), "Exam Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("exam_id", $exams, $student_exam_subject_mark->exam_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("exam_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('class_subjec_id'), "class_subjec_id", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "class_subjec_id",
                        "id"            =>  "class_subjec_id",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('class_subjec_id'),
                        "value"         =>  set_value("class_subjec_id", $student_exam_subject_mark->class_subjec_id),
                        "placeholder"   =>  $this->lang->line('class_subjec_id')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("class_subjec_id", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('student_id'), "student_id", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "student_id",
                        "id"            =>  "student_id",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('student_id'),
                        "value"         =>  set_value("student_id", $student_exam_subject_mark->student_id),
                        "placeholder"   =>  $this->lang->line('student_id')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("student_id", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('obtain_mark'), "obtain_mark", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "obtain_mark",
                        "id"            =>  "obtain_mark",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('obtain_mark'),
                        "value"         =>  set_value("obtain_mark", $student_exam_subject_mark->obtain_mark),
                        "placeholder"   =>  $this->lang->line('obtain_mark')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("obtain_mark", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="col-md-offset-2 col-md-10">
            <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Update'),
                    "class" =>  "btn btn-primary",
                    "style" =>  ""
                );
                echo form_submit($submit); 
            ?>
            
            
            
            <?php
                $reset = array(
                    "type"  =>  "reset",
                    "name"  =>  "reset",
                    "value" =>  $this->lang->line('Reset'),
                    "class" =>  "btn btn-default",
                    "style" =>  ""
                );
                echo form_reset($reset); 
            ?>
            </div>
            <div style="clear:both;"></div>
            
            <?php echo form_close(); ?>
            
        </div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
