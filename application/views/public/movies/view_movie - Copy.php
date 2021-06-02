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
				<a href="<?php echo site_url("movies/view/"); ?>">Movies</a>
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
					  <?php foreach($movies as $movie): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('imdbID'); ?></th>
                <td>
                    <?php echo $movie->imdbID; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('title'); ?></th>
                <td>
                    <?php echo $movie->title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('year'); ?></th>
                <td>
                    <?php echo $movie->year; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('type'); ?></th>
                <td>
                    <?php echo $movie->type; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('rating'); ?></th>
                <td>
                    <?php echo $movie->rating; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('runtime'); ?></th>
                <td>
                    <?php echo $movie->runtime; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('poster'); ?></th>
                <td>
                    <?php echo $movie->poster; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('imdbURL'); ?></th>
                <td>
                    <?php echo $movie->imdbURL; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('description'); ?></th>
                <td>
                    <?php echo $movie->description; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('plot'); ?></th>
                <td>
                    <?php echo $movie->plot; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('location'); ?></th>
                <td>
                    <?php echo $movie->location; ?>
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
