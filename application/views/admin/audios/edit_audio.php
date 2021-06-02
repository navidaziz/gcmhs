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
		</div>
        <div class="box-body">

            <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."audios/update_data/$audio->audio_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("audio_id", $audio->audio_id); ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('audio_name'), "audio_name", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "audio_name",
                        "id"            =>  "audio_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('audio_name'),
                        "value"         =>  set_value("audio_name", $audio->audio_name),
                        "placeholder"   =>  $this->lang->line('audio_name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("audio_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('singer_name'), "singer_name", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "singer_name",
                        "id"            =>  "singer_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('singer_name'),
                        "value"         =>  set_value("singer_name", $audio->singer_name),
                        "placeholder"   =>  $this->lang->line('singer_name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("singer_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('writer_name'), "writer_name", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "writer_name",
                        "id"            =>  "writer_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('writer_name'),
                        "value"         =>  set_value("writer_name", $audio->writer_name),
                        "placeholder"   =>  $this->lang->line('writer_name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("writer_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('audio_type'), "audio_type", $label);
                ?>

                <div class="col-md-10">
                    <?php 
					$options = array("Yes" => "Yes", "No" => "No");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "audio_type",
                                "id"          => "audio_type",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );if($option_value == $audio->audio_type){
                                    $data["checked"] = TRUE;
                                }
                            echo form_radio($data)."<label for=\"audio_type\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("audio_type", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('audio_album'), "audio_album", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "audio_album",
                        "id"            =>  "audio_album",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('audio_album'),
                        "value"         =>  set_value("audio_album", $audio->audio_album),
                        "placeholder"   =>  $this->lang->line('audio_album')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("audio_album", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('audio_detail'), "audio_detail", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "audio_detail",
                        "id"            =>  "audio_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('audio_detail'),
                        "value"         =>  set_value("audio_detail", $audio->audio_detail),
                        "placeholder"   =>  $this->lang->line('audio_detail')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("audio_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('audio_comment'), "audio_comment", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "audio_comment",
                        "id"            =>  "audio_comment",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('audio_comment'),
                        "value"         =>  set_value("audio_comment", $audio->audio_comment),
                        "placeholder"   =>  $this->lang->line('audio_comment')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("audio_comment", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('audio_year'), "audio_year", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "audio_year",
                        "id"            =>  "audio_year",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('audio_year'),
                        "value"         =>  set_value("audio_year", $audio->audio_year),
                        "placeholder"   =>  $this->lang->line('audio_year')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("audio_year", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('audio_file')."<br />".file_type(base_url("assets/uploads/".$audio->audio_file)), "audio_file", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "audio_file",
                        "id"            =>  "audio_file",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('audio_file'),
                        "value"         =>  set_value("audio_file", $audio->audio_file),
                        "placeholder"   =>  $this->lang->line('audio_file')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$audio->audio_file")); ?>-->
                    
                <?php echo form_error("audio_file", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('audio_image')."<br />".file_type(base_url("assets/uploads/".$audio->audio_image)), "audio_image", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "audio_image",
                        "id"            =>  "audio_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('audio_image'),
                        "value"         =>  set_value("audio_image", $audio->audio_image),
                        "placeholder"   =>  $this->lang->line('audio_image')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$audio->audio_image")); ?>-->
                    
                <?php echo form_error("audio_image", "<p class=\"text-danger\">", "</p>"); ?>
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
