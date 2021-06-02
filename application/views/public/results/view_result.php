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
				<a href="<?php echo site_url("results/view/"); ?>">Results</a>
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
					  <?php foreach($results as $result): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('class_no'); ?></th>
                <td>
                    <?php echo $result->class_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('admission_no'); ?></th>
                <td>
                    <?php echo $result->admission_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('roll_no'); ?></th>
                <td>
                    <?php echo $result->roll_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('session'); ?></th>
                <td>
                    <?php echo $result->session; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('class'); ?></th>
                <td>
                    <?php echo $result->class; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('section'); ?></th>
                <td>
                    <?php echo $result->section; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <td>
                    <?php echo $result->student_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('islamiyat'); ?></th>
                <td>
                    <?php echo $result->islamiyat; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('urdu'); ?></th>
                <td>
                    <?php echo $result->urdu; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('english'); ?></th>
                <td>
                    <?php echo $result->english; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('math'); ?></th>
                <td>
                    <?php echo $result->math; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('arabi'); ?></th>
                <td>
                    <?php echo $result->arabi; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('drawing'); ?></th>
                <td>
                    <?php echo $result->drawing; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('computer'); ?></th>
                <td>
                    <?php echo $result->computer; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('general_studies'); ?></th>
                <td>
                    <?php echo $result->general_studies; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('history_geography'); ?></th>
                <td>
                    <?php echo $result->history_geography; ?>
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
