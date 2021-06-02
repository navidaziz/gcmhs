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
				<a href="<?php echo site_url(ADMIN_DIR."products/view/"); ?>"><?php echo $this->lang->line('Products'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."products/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."products/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR."products/update_data/$product->product_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("product_id", $product->product_id); ?>
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_category_title'), "Product Category Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("product_category_id", $product_categories, $product->product_category_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("product_category_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_type_title'), "Product Type Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("product_type_id", $product_types, $product->product_type_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("product_type_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_sub_type_title'), "Product Sub Type Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("product_sub_type_id", $product_sub_types, $product->product_sub_type_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("product_sub_type_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_brand_title'), "Product Brand Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("product_brand_id", $product_brands, $product->product_brand_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("product_brand_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('product_title'), "product_title", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_title",
                        "id"            =>  "product_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_title'),
                        "value"         =>  set_value("product_title", $product->product_title),
                        "placeholder"   =>  $this->lang->line('product_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("product_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('product_short_detail'), "product_short_detail", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_short_detail",
                        "id"            =>  "product_short_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_short_detail'),
                        "value"         =>  set_value("product_short_detail", $product->product_short_detail),
                        "placeholder"   =>  $this->lang->line('product_short_detail')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("product_short_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('product_detail'), "product_detail", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "product_detail",
                        "id"            =>  "product_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('product_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("product_detail", $product->product_detail),
                        "placeholder"   =>  $this->lang->line('product_detail')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("product_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('product_price'), "product_price", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "product_price",
                        "id"            =>  "product_price",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_price'),
                        "value"         =>  set_value("product_price", $product->product_price),
                        "placeholder"   =>  $this->lang->line('product_price')
                    );
                    echo  form_input($number);
                ?>
                <?php echo form_error("product_price", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('product_main_image')."<br />".file_type(base_url("assets/uploads/".$product->product_main_image)), "product_main_image", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "product_main_image",
                        "id"            =>  "product_main_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('product_main_image'),
                        "value"         =>  set_value("product_main_image", $product->product_main_image),
                        "placeholder"   =>  $this->lang->line('product_main_image')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$product->product_main_image")); ?>-->
                    
                <?php echo form_error("product_main_image", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_in_stock'), "product_in_stock", $label);
                ?>

                <div class="col-md-10">
                    <?php 
					$options = array("Yes" => "Yes", "No" => "No");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "product_in_stock",
                                "id"          => "product_in_stock",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );if($option_value == $product->product_in_stock){
                                    $data["checked"] = TRUE;
                                }
                            echo form_radio($data)."<label for=\"product_in_stock\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("product_in_stock", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_on_sale'), "product_on_sale", $label);
                ?>

                <div class="col-md-10">
                    <?php 
					$options = array("Yes" => "Yes", "No" => "No");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "product_on_sale",
                                "id"          => "product_on_sale",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );if($option_value == $product->product_on_sale){
                                    $data["checked"] = TRUE;
                                }
                            echo form_radio($data)."<label for=\"product_on_sale\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("product_on_sale", "<p class=\"text-danger\">", "</p>"); ?>
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
