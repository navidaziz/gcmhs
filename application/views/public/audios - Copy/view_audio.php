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
				<a href="<?php echo site_url("audios/view/"); ?>">Audios</a>
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
					  <?php foreach($audios as $audio): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('audio_name'); ?></th>
                <td>
                    <?php echo $audio->audio_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('singer_name'); ?></th>
                <td>
                    <?php echo $audio->singer_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('writer_name'); ?></th>
                <td>
                    <?php echo $audio->writer_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_type'); ?></th>
                <td>
                    <?php echo $audio->audio_type; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_album'); ?></th>
                <td>
                    <?php echo $audio->audio_album; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_detail'); ?></th>
                <td>
                    <?php echo $audio->audio_detail; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_comment'); ?></th>
                <td>
                    <?php echo $audio->audio_comment; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_year'); ?></th>
                <td>
                    <?php echo $audio->audio_year; ?>
                </td>
            </tr>
            <tr>
                <th>Audio File</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$audio->audio_file));
                ?>
                </td>
            </tr>
            <tr>
                <th>Audio Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$audio->audio_image));
                ?>
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
