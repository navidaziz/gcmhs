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
				<a href="<?php echo site_url(ADMIN_DIR."tests/view/"); ?>"><?php echo $this->lang->line('Tests'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."tests/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."tests/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
	<div class="col-md-3">
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
					  <?php foreach($tests as $test): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('test_type'); ?></th>
                <td>
                    <?php echo $test->test_type; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('test_title'); ?></th>
                <td>
                    <?php echo $test->test_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('test_discription'); ?></th>
                <td>
                    <?php echo $test->test_discription; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Class_title'); ?></th>
                <td>
                    <?php echo $test->Class_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('subject_title'); ?></th>
                <td>
                    <?php echo $test->subject_title; ?>
                </td>
            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <td>
                                    <?php echo status($test->status); ?>
                                </td>
                            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			
		</div>
		
	</div>
	</div>
    
    
    <div class="col-md-9">
    
    <script>
    
	function change_state(question_id){
		test_id = <?php echo $tests[0]->test_id;  ?>;
		
		$.ajax({ type: "POST",
				 url: "<?php echo base_url(ADMIN_DIR."test_questions/add_or_remove/"); ?>",
				 data:{test_id:test_id,
				 	   question_id:question_id}
				  }).done(function(data) {
					  
					  $('#response').html(data);
					  
					  });
		}
    
    </script>
            <div id="response"></div>
            <?php 
			
			$questions=array();
			  foreach($chapters as $chapter_name => $questions){
			  echo "<h3>".$chapter_name."</h3>";
			
			
			?>
            
            
           
              <?php 
			  
			  foreach($questions as $question): 
              
				echo file_type(base_url("assets/uploads/".$question->question_image),false,20,20);
				
				echo $question->question_title; 
				
				echo "<br /><strong>1. ".$question->option_one."    2. ".$question->option_two."    3.".$question->option_three."   4.".$question->option_three."</strong><br /><br />";
				?>
                
               
              <?php endforeach; ?>
             
            
             <?php } ?>
            </div>
    
	<!-- /MESSENGER -->
</div>
