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
				<a href="<?php echo site_url("questions_answers/view/"); ?>">Questions Answers</a>
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
					  <?php foreach($questions_answers as $question_answer): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('answer'); ?></th>
                <td>
                    <?php echo $question_answer->answer; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('test_title'); ?></th>
                <td>
                    <?php echo $question_answer->test_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('question_title'); ?></th>
                <td>
                    <?php echo $question_answer->question_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <td>
                    <?php echo $question_answer->student_name; ?>
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
