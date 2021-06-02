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
				<a href="<?php echo site_url("exams/view/"); ?>">Exams</a>
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
					  <?php foreach($exams as $exam): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('year'); ?></th>
                <td>
                    <?php echo $exam->year; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('term'); ?></th>
                <td>
                    <?php echo $exam->term; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('passing_percentage'); ?></th>
                <td>
                    <?php echo $exam->passing_percentage; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('promotion_percentage'); ?></th>
                <td>
                    <?php echo $exam->promotion_percentage; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('exam_data'); ?></th>
                <td>
                    <?php echo $exam->exam_data; ?>
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
