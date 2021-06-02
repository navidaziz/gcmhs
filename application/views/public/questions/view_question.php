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
				<a href="<?php echo site_url("questions/view/"); ?>">Questions</a>
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
					  <?php foreach($questions as $question): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('question_type'); ?></th>
                <td>
                    <?php echo $question->question_type; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('chapter_name'); ?></th>
                <td>
                    <?php echo $question->chapter_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('question_title'); ?></th>
                <td>
                    <?php echo $question->question_title; ?>
                </td>
            </tr>
            <tr>
                <th>Question Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$question->question_image));
                ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('option_one'); ?></th>
                <td>
                    <?php echo $question->option_one; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('option_two'); ?></th>
                <td>
                    <?php echo $question->option_two; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('option_three'); ?></th>
                <td>
                    <?php echo $question->option_three; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('option_four'); ?></th>
                <td>
                    <?php echo $question->option_four; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('qustion_correct_answer'); ?></th>
                <td>
                    <?php echo $question->qustion_correct_answer; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('Class_title'); ?></th>
                <td>
                    <?php echo $question->Class_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('subject_title'); ?></th>
                <td>
                    <?php echo $question->subject_title; ?>
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
