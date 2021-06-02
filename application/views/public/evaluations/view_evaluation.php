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
				<a href="<?php echo site_url("evaluations/view/"); ?>">Evaluations</a>
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
					  <?php foreach($evaluations as $evaluation): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('rate'); ?></th>
                <td>
                    <?php echo $evaluation->rate; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('teacher_name'); ?></th>
                <td>
                    <?php echo $evaluation->teacher_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('evaluator'); ?></th>
                <td>
                    <?php echo $evaluation->evaluator; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('academical_evaluation_title'); ?></th>
                <td>
                    <?php echo $evaluation->academical_evaluation_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Class_title'); ?></th>
                <td>
                    <?php echo $evaluation->Class_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('section_title'); ?></th>
                <td>
                    <?php echo $evaluation->section_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('subject_title'); ?></th>
                <td>
                    <?php echo $evaluation->subject_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('kpi_title'); ?></th>
                <td>
                    <?php echo $evaluation->kpi_title; ?>
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
