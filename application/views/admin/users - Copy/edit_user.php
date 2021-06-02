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
				<a href="<?php echo site_url(ADMIN_DIR."users/view/"); ?>"><?php echo $this->lang->line('Users'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."users/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."users/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
			    //var_dump($user->group_id);
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."users/edit/$user->user_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("user_id", $user->user_id); ?>
            
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
                                );if("$role_id" == $user->role_id){
                                    $data["checked"] = TRUE;
                                }
                            echo form_radio($data)."<label for=\"$role_id\" style=\"margin-left:10px;\">$role_title</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("role_id", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            
            
            
            
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label("NGO Name", "ngo_id", $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("ngo_id", $ngos, $user->ngo_id, "class=\"form-control\" style=\"\"");
                    ?>
                </div>
                <?php echo form_error("ngo_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
             <input type="hidden" value="1" name="manager_id" />
         <input type="hidden" value="1" name="manager_role_id" />
         
         
            <!------for all Groups--kamran---->
        <div class="form-group">
            <?php
                    //var_dump($groups);
					$label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('Group Name'), "groups",$label);
					
					
				  
				  
				  //var_dump($groupId);
				  
				  //$groupids =str_replace("-","," $groupss);
				  
				  // $where=array("group_id" => $groupids);
			      //$groupss['groups'] = $this->user_model->getList("groups", "group_id", "group_name", $where);
				  // foreach($groups as $g_id => $g_name)
				  //{ 
				  
				  //}
				  //var_dump($groups);
                  //var_dump($groupsSelectd);
				  //exit;
				?>
                  <div class="col-md-10">
                  <select multiple name="group_id[]"  
                  class="select2-container select2-container-multi col-md-12" id="groups" required 	
                  style="padding:0px !important; margin:0px !important; border:0px !important; z-index:50; ">
                  <?php 
				  
				 $selected_ids=array();
				  foreach($groupsSelectd as $g_id => $g_name){
					$selected_ids[]= $g_id;
				  }
				  //var_dump($g_name);
				  
				  foreach($groups as $index => $gSelectd){
				  
				  if(in_array($index,$selected_ids)){
					  print "<option value=".$index."  selected>".$gSelectd."</option>";  
					  }
				  else {
					  print "<option value=".$index." >".$gSelectd."</option>";
					  }
				  ?>
                  
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
                        "value"         =>  set_value("user_title", $user->user_title),
                        "placeholder"   =>  $this->lang->line('user_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("user_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
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
                        "value"         =>  set_value("user_email", $user->user_email),
                        "placeholder"   =>  $this->lang->line('user_email')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("user_email", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
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
                        "value"         =>  set_value("user_name", $user->user_name),
                        "placeholder"   =>  $this->lang->line('user_name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("user_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
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
                        "value"         =>  set_value("user_password", $user->user_password),
                        "placeholder"   =>  $this->lang->line('user_password')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("user_password", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
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
                        "value"         =>  set_value("user_image", $user->user_image),
                        "placeholder"   =>  $this->lang->line('user_image')
                    );
                    echo  form_input($file);
                ?>
                    <?php echo file_type(base_url("assets/uploads/$user->user_image"), 10); ?>
                    
                <?php echo form_error("user_image", "<p class=\"text-danger\">", "</p>"); ?>
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
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/select2/select2.min.js"></script> 
<script>
		
		$('#groups').select2({
			placeholder: "Select Groups"
			});
</script>
