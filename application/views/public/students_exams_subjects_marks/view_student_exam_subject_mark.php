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
				<a href="<?php echo site_url("students_exams_subjects_marks/view/"); ?>">Students Exams Subjects Marks</a>
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
					  <?php foreach($students_exams_subjects_marks as $student_exam_subject_mark): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('obtain_mark'); ?></th>
                <td>
                    <?php echo $student_exam_subject_mark->obtain_mark; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('term'); ?></th>
                <td>
                    <?php echo $student_exam_subject_mark->term; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('subject_id'); ?></th>
                <td>
                    <?php echo $student_exam_subject_mark->subject_id; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <td>
                    <?php echo $student_exam_subject_mark->student_name; ?>
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
