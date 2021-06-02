<!-- PAGE HEADER-->
<div class="breadcrumb-box">
  <div class="container">
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url("Home"); ?>">Home</a>
					<span class="divider">/</span>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url("class_subject_teacher /view/"); ?>">Class Subject Teacher </a>
				<span class="divider">/</span>
			</li><li ><?php echo $title; ?> </li>
				</ul>
			</div>
		</div>
		<!-- .breadcrumb-box --><section id="main">
			  <header class="page-header">
				<div class="container">
				  <h1 class="title"><?php echo $title; ?></h1>
				</div>
			  </header>
			  <div class="container">
			  <div class="row">
			  <?php $this->load->view(PUBLIC_DIR."components/nav"); ?><div class="content span9 pull-right">
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($class_subject_teacher  as $class_subject_teacher): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('class_teacher'); ?></th>
                <td>
                    <?php echo $class_subject_teacher->class_teacher; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('paper_checked_by'); ?></th>
                <td>
                    <?php echo $class_subject_teacher->paper_checked_by; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('term'); ?></th>
                <td>
                    <?php echo $class_subject_teacher->term; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('subject_id'); ?></th>
                <td>
                    <?php echo $class_subject_teacher->subject_id; ?>
                </td>
            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			</div>
		</div>
	 </div>
  <!-- .container --> 
</section>
<!-- #main -->
