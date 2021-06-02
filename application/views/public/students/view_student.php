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
				<a href="<?php echo site_url("students/view/"); ?>">Students</a>
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
					  <?php foreach($students as $student): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('student_class_no'); ?></th>
                <td>
                    <?php echo $student->student_class_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <td>
                    <?php echo $student->student_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_father_name'); ?></th>
                <td>
                    <?php echo $student->student_father_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
                <td>
                    <?php echo $student->student_data_of_birth; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_address'); ?></th>
                <td>
                    <?php echo $student->student_address; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_admission_no'); ?></th>
                <td>
                    <?php echo $student->student_admission_no; ?>
                </td>
            </tr>
            <tr>
                <th>Student Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$student->student_image));
                ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Class_title'); ?></th>
                <td>
                    <?php echo $student->Class_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('section_title'); ?></th>
                <td>
                    <?php echo $student->section_title; ?>
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
