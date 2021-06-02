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
				<a href="<?php echo site_url("audio_albums/view/"); ?>">Audio Albums</a>
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
					  <?php foreach($audio_albums as $audio_album): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('audio_album_name'); ?></th>
                <td>
                    <?php echo $audio_album->audio_album_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('audio_album_detail'); ?></th>
                <td>
                    <?php echo $audio_album->audio_album_detail; ?>
                </td>
            </tr>
            <tr>
                <th>Audio Album Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$audio_album->audio_album_image));
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
