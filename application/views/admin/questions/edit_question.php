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
				<a href="<?php echo site_url(ADMIN_DIR."questions/view/"); ?>"><?php echo $this->lang->line('Questions'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."questions/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."questions/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR."questions/update_data/$question->question_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("question_id", $question->question_id); ?>
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('Class_title'), "Class Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("class_id", $classes, $question->class_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("class_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('subject_title'), "Subject Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("subject_id", $subjects, $question->subject_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("subject_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('question_type'), "question_type", $label);
                ?>

                <div class="col-md-10">
                    <?php 
					$options = array("Fill Blanks" => "Fill Blanks", 
									 "True/False" => "True/False",
									 "MCQs" => "MCQs",
									 "Matching Words" => "Matching Words");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "question_type",
                                "id"          => "question_type",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );if($option_value == $question->question_type){
                                    $data["checked"] = TRUE;
                                }
                            echo form_radio($data)."<label for=\"question_type\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("question_type", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('chapter_name'), "chapter_name", $label);
                ?>

                <div class="col-md-10">
                    <?php 
					$options = array("Chapter One" => "Chapter One", 
									 "Chapter Tow" => "Chapter Two",
									 "Chapter Three" => "Chapter Three",
									 "Chapter Four" => "Chapter Four", 
									 "Chapter Five" => "Chapter Five",
									 "Chapter Six" => "Chapter Six",
									 "Chapter Seven" => "Chapter Seven", 
									 "Chapter Eight" => "Chapter Eight",
									 "Chapter Nine" => "Chapter Nine",
									 "Chapter Ten" => "Chapter Ten"
									 );
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "chapter_name",
                                "id"          => "chapter_name",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );if($option_value == $question->chapter_name){
                                    $data["checked"] = TRUE;
                                }
                            echo form_radio($data)."<label for=\"chapter_name\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("chapter_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('question_title'), "question_title", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "question_title",
                        "id"            =>  "question_title",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('question_title'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("question_title", $question->question_title),
                        "placeholder"   =>  $this->lang->line('question_title')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("question_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('question_image')."<br />".file_type(base_url("assets/uploads/".$question->question_image)), "question_image", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "question_image",
                        "id"            =>  "question_image",
                        "class"         =>  "form-control",
                        "style"         =>  "",
						"title"         =>  $this->lang->line('question_image'),
                        "value"         =>  set_value("question_image", $question->question_image),
                        "placeholder"   =>  $this->lang->line('question_image')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$question->question_image")); ?>-->
                    
                <?php echo form_error("question_image", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('option_one'), "option_one", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "option_one",
                        "id"            =>  "option_one",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('option_one'),
                        "value"         =>  set_value("option_one", $question->option_one),
                        "placeholder"   =>  $this->lang->line('option_one')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("option_one", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('option_two'), "option_two", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "option_two",
                        "id"            =>  "option_two",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('option_two'),
                        "value"         =>  set_value("option_two", $question->option_two),
                        "placeholder"   =>  $this->lang->line('option_two')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("option_two", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('option_three'), "option_three", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "option_three",
                        "id"            =>  "option_three",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('option_three'),
                        "value"         =>  set_value("option_three", $question->option_three),
                        "placeholder"   =>  $this->lang->line('option_three')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("option_three", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('option_four'), "option_four", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "option_four",
                        "id"            =>  "option_four",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('option_four'),
                        "value"         =>  set_value("option_four", $question->option_four),
                        "placeholder"   =>  $this->lang->line('option_four')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("option_four", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('qustion_correct_answer'), "qustion_correct_answer", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "qustion_correct_answer",
                        "id"            =>  "qustion_correct_answer",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('qustion_correct_answer'),
                        "value"         =>  set_value("qustion_correct_answer", $question->qustion_correct_answer),
                        "placeholder"   =>  $this->lang->line('qustion_correct_answer')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("qustion_correct_answer", "<p class=\"text-danger\">", "</p>"); ?>
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
