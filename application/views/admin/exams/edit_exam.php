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
				<a href="<?php echo site_url(ADMIN_DIR."exams/view/"); ?>"><?php echo $this->lang->line('Exams'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."exams/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."exams/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR."exams/update_data/$exam->exam_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("exam_id", $exam->exam_id); ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('year'), "year", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "year",
                        "id"            =>  "year",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('year'),
                        "value"         =>  set_value("year", $exam->year),
                        "placeholder"   =>  $this->lang->line('year')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("year", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('term'), "term", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "term",
                        "id"            =>  "term",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('term'),
                        "value"         =>  set_value("term", $exam->term),
                        "placeholder"   =>  $this->lang->line('term')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("term", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('passing_percentage'), "passing_percentage", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "passing_percentage",
                        "id"            =>  "passing_percentage",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('passing_percentage'),
                        "value"         =>  set_value("passing_percentage", $exam->passing_percentage),
                        "placeholder"   =>  $this->lang->line('passing_percentage')
                    );
                    echo  form_input($number);
                ?>
                <?php echo form_error("passing_percentage", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('promotion_percentage'), "promotion_percentage", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "promotion_percentage",
                        "id"            =>  "promotion_percentage",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('promotion_percentage'),
                        "value"         =>  set_value("promotion_percentage", $exam->promotion_percentage),
                        "placeholder"   =>  $this->lang->line('promotion_percentage')
                    );
                    echo  form_input($number);
                ?>
                <?php echo form_error("promotion_percentage", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('exam_data'), "exam_data", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $date = array(
                        "type"          =>  "date",
                        "name"          =>  "exam_data",
                        "id"            =>  "exam_data",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('exam_data'),
                        "value"         =>  set_value("exam_data", $exam->exam_data),
                        "placeholder"   =>  $this->lang->line('exam_data')
                    );
                    echo  form_input($date);
                ?>
                <?php echo form_error("exam_data", "<p class=\"text-danger\">", "</p>"); ?>
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
