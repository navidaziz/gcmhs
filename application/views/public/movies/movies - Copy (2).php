

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
		</div><div class="row">
			
                
                  
					  <?php foreach($movies as $movie):
					  
					  //$location = str_replace('\\', '/', $movie->location);
					   ?>
                      
                      <div class="col-md-2">
                      <div style="height:300px; padding:3px">
                      <img style="border:1px solid gray" src="<?php echo $movie->poster; ?>" width="100%"  />
                      <h6> <?php echo $movie->title; ?></h6>
                      </div>
                      
                      </div>
                      
                         
                        
                      <?php endforeach; ?>
						
                      
                      

           
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
