<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."products/view/"); ?>"><?php echo $this->lang->line('Products'); ?></a> </li>
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
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."products/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."products/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row"> 
<?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."products/save_data", $add_form_attr);
            ?>
  <!-- MESSENGER -->
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i><?php echo $this->lang->line('Product Detail') ?></h4>
        
      </div>
      <div class="box-body">
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_category_title'), "Product Category Id" , $label);
                ?>
          <div class="col-md-8">
            <?php
                    echo form_dropdown("product_category_id", $product_categories, "", "class=\"form-control\" required style=\"\"");
                    ?>
          </div>
          <?php echo form_error("product_category_id", "<p class=\"text-danger\">", "</p>"); ?> </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_type_title'), "Product Type Id" , $label);
                ?>
          <div class="col-md-8">
            <?php
                    echo form_dropdown("product_type_id", $product_types, "", "class=\"form-control\" required style=\"\"");
                    ?>
          </div>
          <?php echo form_error("product_type_id", "<p class=\"text-danger\">", "</p>"); ?> </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_sub_type_title'), "Product Sub Type Id" , $label);
                ?>
          <div class="col-md-8">
            <?php
                    echo form_dropdown("product_sub_type_id", $product_sub_types, "", "class=\"form-control\" required style=\"\"");
                    ?>
          </div>
          <?php echo form_error("product_sub_type_id", "<p class=\"text-danger\">", "</p>"); ?> </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_brand_title'), "Product Brand Id" , $label);
                ?>
          <div class="col-md-8">
            <?php
                    echo form_dropdown("product_brand_id", $product_brands, "", "class=\"form-control\" required style=\"\"");
                    ?>
          </div>
          <?php echo form_error("product_brand_id", "<p class=\"text-danger\">", "</p>"); ?> </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('product_title'), "product_title", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_title",
                        "id"            =>  "product_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_title'),
                        "value"         =>  set_value("product_title"),
                        "placeholder"   =>  $this->lang->line('product_title')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("product_title", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('product_short_detail'), "product_short_detail", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_short_detail",
                        "id"            =>  "product_short_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_short_detail'),
                        "value"         =>  set_value("product_short_detail"),
                        "placeholder"   =>  $this->lang->line('product_short_detail')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("product_short_detail", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('product_detail'), "product_detail", $label);
                ?>
          <div class="col-md-8">
            <?php
                    
                    $textarea = array(
                        "name"          =>  "product_detail",
                        "id"            =>  "product_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('product_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("product_detail"),
                        "placeholder"   =>  $this->lang->line('product_detail')
                    );
                    echo form_textarea($textarea);
                ?>
            <?php echo form_error("product_detail", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('product_price'), "product_price", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "product_price",
                        "id"            =>  "product_price",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_price'),
                        "value"         =>  set_value("product_price"),
                        "placeholder"   =>  $this->lang->line('product_price')
                    );
                    echo  form_input($number);
                ?>
            <?php echo form_error("product_price", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('product_main_image'), "product_main_image", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "product_main_image",
                        "id"            =>  "product_main_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('product_main_image'),
                        "value"         =>  set_value("product_main_image"),
                        "placeholder"   =>  $this->lang->line('product_main_image')
                    );
                    echo  form_input($file);
                ?>
            <?php echo form_error("product_main_image", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_in_stock'), "product_in_stock", $label);
                ?>
          <div class="col-md-8">
            <?php 
					$options = array("Yes" => "Yes", "No" => "No");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "product_in_stock",
                                "id"          => "product_in_stock",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );
                            echo form_radio($data)."<label for=\"product_in_stock\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
            <?php echo form_error("product_in_stock", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('product_on_sale'), "product_on_sale", $label);
                ?>
          <div class="col-md-8">
            <?php 
					$options = array("Yes" => "Yes", "No" => "No");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "product_on_sale",
                                "id"          => "product_on_sale",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );
                            echo form_radio($data)."<label for=\"product_on_sale\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
            <?php echo form_error("product_on_sale", "<p class=\"text-danger\">", "</p>"); ?> </div>
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
         </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $this->lang->line('Product Additional Information'); ?></h4>
      </div>
      <div class="box-body">
      <script>
      function add_row(id){
		  if(id == 'product_additional_information_table'){
		  $('#'+id+' tr:last').after('<tr><td><?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_additional_information_title[]",
                        "id"            =>  "product_additional_information_title[]",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_additional_information_title'),
                        "value"         =>  set_value("product_additional_information_title"),
                        "placeholder"   =>  $this->lang->line('product_additional_information_title')
                    );
                    echo  form_input($text);
                ?></td><td><?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_additional_information_value[]",
                        "id"            =>  "product_additional_information_value[]",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_additional_information_value'),
                        "value"         =>  set_value("product_additional_information_value"),
                        "placeholder"   =>  $this->lang->line('product_additional_information_value')
                    );
                    echo  form_input($text);
                ?></td><td><i class="fa fa-times" aria-hidden="true" onclick="$(this).closest (\'tr\').remove ();"></i></td></tr>');
		  }
		  
		  
		  
		  if(id == 'product_additional_image_table'){
		  $('#'+id+' tr:last').after('<tr><td><?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "product_additional_image[]",
                        "id"            =>  "product_additional_image[]",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_additional_image'),
                        "value"         =>  set_value("product_additional_image"),
                        "placeholder"   =>  $this->lang->line('product_additional_image')
                    );
                    echo  form_input($file);
                ?></td><td><?php
                    
                    $textarea = array(
                        "name"          =>  "product_additional_image_detail[]",
                        "id"            =>  "product_additional_image_detail[]",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('product_additional_image_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("product_additional_image_detail"),
                        "placeholder"   =>  $this->lang->line('product_additional_image_detail')
                    );
                    echo form_textarea($textarea);
                ?></td><td><i class="fa fa-times" aria-hidden="true" onclick="$(this).closest (\'tr\').remove ();"></i></td></tr>');
		  }
		  
		  }
      
      </script>
      
        <table class="table table-bordered" id="product_additional_information_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('product_additional_information_title'); ?></th>
              <th><?php echo $this->lang->line('product_additional_information_value'); ?></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_additional_information_title[]",
                        "id"            =>  "product_additional_information_title[]",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_additional_information_title'),
                        "value"         =>  set_value("product_additional_information_title"),
                        "placeholder"   =>  $this->lang->line('product_additional_information_title')
                    );
                    echo  form_input($text);
                ?></td>
              <td><?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "product_additional_information_value[]",
                        "id"            =>  "product_additional_information_value[]",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_additional_information_value'),
                        "value"         =>  set_value("product_additional_information_value"),
                        "placeholder"   =>  $this->lang->line('product_additional_information_value')
                    );
                    echo  form_input($text);
                ?></td>
                <td><!--<i class="fa fa-times" aria-hidden="true" onclick="$(this).remove();"></i>--></td>
            </tr>
          </tbody>
        </table>
       <a href="javascript:void(0);" onclick="add_row('product_additional_information_table')" >Add Row</a>
      </div>
    </div>
  </div>
  
  <div class="col-md-6">
	<div class="box border blue" id="messenger">
		<div class="box-title">
			<h4><i class="fa fa-bell"></i> <?php echo $this->lang->line('product_additional_image'); ?></h4>
			
		</div>
        <div class="box-body">
        
        
        <table class="table table-bordered" id="product_additional_image_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('product_additional_image'); ?></th>
              <th><?php echo $this->lang->line('product_additional_image_detail'); ?></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
           <tr>
              <td><?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "product_additional_image[]",
                        "id"            =>  "product_additional_image[]",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('product_additional_image'),
                        "value"         =>  set_value("product_additional_image"),
                        "placeholder"   =>  $this->lang->line('product_additional_image')
                    );
                    echo  form_input($file);
                ?> </td>
             
            <td>
            <?php
                    
                    $textarea = array(
                        "name"          =>  "product_additional_image_detail[]",
                        "id"            =>  "product_additional_image_detail[]",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('product_additional_image_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("product_additional_image_detail"),
                        "placeholder"   =>  $this->lang->line('product_additional_image_detail')
                    );
                    echo form_textarea($textarea);
                ?>
            
            </td>
            <td></td>
            </tr> 
            </tbody>
            </table> 

            <a href="javascript:void(0);" onclick="add_row('product_additional_image_table')" >Add Row</a>
            
        </div>
		
	</div>
	</div>
  
  <?php echo form_close(); ?>
  <!-- /MESSENGER --> 
</div>
