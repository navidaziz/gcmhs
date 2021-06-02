
<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."users/view/"); ?>"><?php echo $this->lang->line('Users'); ?></a> </li>
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
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."users/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."users/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
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
       
      </div>
      <div class="box-body">
        <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."users/add", $add_form_attr);
            ?>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label("Role Title", "role_id", $label);
                ?>
          <div class="col-md-10">
            <?php 
                        foreach($roles as $role_id => $role_title){
                            
                            $data = array(
                                "name"        => "role_id",
                                "id"          => "$role_id",
                                "value"       => "$role_id",
                                "style"       => "",
                                "class"       => "uniform"
                                );
                            echo form_radio($data)."<label for=\"$role_id\" style=\"margin-left:10px;\">$role_title</label><br />";
                            
                        }
                    ?>
            <?php echo form_error("role_id", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        <input type="hidden" value="1" name="manager_id" />
         <input type="hidden" value="1" name="manager_role_id" />
          <input type="hidden" value="3" name="ngo_id" />
         
         
         
        
        
        
            
            
          <!------for all Groups--kamran---->
        <div class="form-group">
            <?php
                    //var_dump($groups);
					$label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label("Group", "groups",$label);
                ?>
            <div class="col-md-10">
                  <select multiple name="group_ids[]"  
                  class="select2-container select2-container-multi col-md-12" id="groups" required 	
                  style="padding:0px !important; margin:0px !important; border:0px !important; z-index:50; ">
                  <?php 
				  
				  foreach($groups as $g_id => $g_name){ 
				  //var_dump($g_name);
				  ?>
                  <option value="<?php echo $g_id ?>"><?php echo $g_name ?></option>
                  <?php } ?>
                  </select>
                  <?php echo form_error("group_ids", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <!------for all Groups--kamran--END-->   
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('user_title'), "user_title", $label);
                ?>
          <div class="col-md-10">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "user_title",
                        "id"            =>  "user_title",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('user_title'),
                        "value"         =>  set_value("user_title"),
                        "placeholder"   =>  $this->lang->line('user_title')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("user_title", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('user_email'), "user_email", $label);
                ?>
          <div class="col-md-10">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "user_email",
                        "id"            =>  "user_email",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('user_email'),
                        "value"         =>  set_value("user_email"),
                        "placeholder"   =>  $this->lang->line('user_email')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("user_email", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('user_name'), "user_name", $label);
                ?>
          <div class="col-md-10">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "user_name",
                        "id"            =>  "user_name",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('user_name'),
                        "value"         =>  set_value("user_name"),
                        "placeholder"   =>  $this->lang->line('user_name')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("user_name", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('user_password'), "user_password", $label);
                ?>
          <div class="col-md-10">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "user_password",
                        "id"            =>  "user_password",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('user_password'),
                        "value"         =>  set_value("user_password"),
                        "placeholder"   =>  $this->lang->line('user_password')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("user_password", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
       
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('user_image'), "user_image", $label);
                ?>
          <div class="col-md-10">
            <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "user_image",
                        "id"            =>  "user_image",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('user_image'),
                        "value"         =>  set_value("user_image"),
                        "placeholder"   =>  $this->lang->line('user_image')
                    );
                    echo  form_input($file);
                ?>
            <?php echo form_error("user_image", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="col-md-offset-2 col-md-10">
          <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Save'),
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
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/select2/select2.min.js"></script> 
<script>
		
		$('#groups').select2({
			placeholder: "Select Groups"
			});
</script>
