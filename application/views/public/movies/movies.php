<script>

function open_view_movie_model(movie_id){
	//$('#movie_detail').html("");
	$('#movie_video').html("");
	$.ajax({ type: "POST",
			//dataType: 'jsonp',
			 url: "<?php echo base_url("movies/view_movie/"); ?>/"+movie_id,
			 data:{ }}).done(function( data ){
				 
				 data = jQuery.parseJSON(data);
				poster = "<?php echo site_url("assets/movies/")."/"; ?>"+data.movie.title+" ("+data.movie.year+")/"+data.movie.poster;
				poster_thumbnail =  "<?php echo site_url("assets/movies/")."/"; ?>"+data.movie.title+" ("+data.movie.year+")/"+data.movie.poster_thumbnail;
				 
				
				 $('#movie_header').html(data.movie.title+' ('+data.movie.year+')');
				 $(".modal-dialog").css("background-image", "url('"+poster_thumbnail+"')");
				 $('#movie_description').html(data.movie.description+'<br />'+data.movie.plot+'');
				// document.getElementById('palyer').setAttribute('poster',poster_thumbnail);
				 similermovies = "";
				 console.log(data);
				 for(var i in data.similar_movies){
					 var similar_movie = data.similar_movies[i];
					 
					 similermovies = similermovies+'<div  class="col-sm-3 col-xs-3 col-md-3"><a href="#" onclick="open_view_movie_model(\''+similar_movie.movie_id+'\')" ><img  style="width:100%; height:98px; margin:2px;" src="'+similar_movie.poster+'" /></a></div>';
					 
					 
				 }
				 //console.log(similermovies);
				$('#similer_movies').html(similermovies);
				
				movie_source =  "<?php echo site_url() ?>"+data.movie_source;
				 
				$('#movie_video').html('<video width="100%" controls style="height:420px;"><source id="video_source" type="video/mp4" src="'+movie_source+'" ><track src="" label="English" kind="captions" srclang="en-us" default ></video>');
				 });
				// document.getElementById('palyer').setAttribute('poster',poster_thumbnail); 
	$("#view_model").modal();
	}

function clear_video(){
	$('#movie_video').html("");
	}	

</script>

<div id="view_model" class="modal modal-transparent fade" role="dialog" >
  <div class="modal-dialog" style="width:97% !important; background: url('http://localhost:8080/imdb/assets/movies/Finding Dory (2016)/Finding Dory.jpg') no-repeat center center; background-size: cover; -webkit-background-size: cover;-moz-background-size: cover; -o-background-size: cover; " > 
    
    <!-- Modal content-->
    <div class="modal-content" style="background: rgba(0, 0, 0, .5); color:white;" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="color:white !important;" 
        onclick='clear_video()'>&times;</button>
        <h4 class="modal-title" id="movie_header">Modal Header</h4>
      </div>
      <div class="modal-body" id="movie_detail" style="min-height:450px;" >
        <div class="container" >
          <div class="row" >
            <div class="col-md-8" id="movie_video" >
              <video id="palyer" width="100%" controls style="height:420px;">
                <source id="video_source" type="video/mp4" src="http://localhost:8080/imdb/assets/movies/Despite%20The%20Falling%20Snow%20(2016)/Despite.The.Falling.Snow.2016.1080p.BluRay.x264-[YTS.AG].mp4" >
                <track src="" label="English" kind="captions" srclang="en-us" default >
              </video>
            </div>
            <div class="col-md-4" >
              <div class="row"  id="similer_movies">
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="text-align:left !important;">
        <p id="movie_description"> </p>
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--> 
      </div>
    </div>
  </div>
</div>
<section class="movies">
  <div class="container">
    <div class="row">
      <?php foreach($movies as $movie): ?>
      <div class="col-sm-3 col-xs-6 col-md-2" >
        <div class="thumbnail" style="background:none; margin:0px; padding:0px; border:none;"> 
          <!--<div class="caption"> <i class="fa fa-star fa-2x" aria-hidden="true"></i>
            <h2 style="color:#FFF">6.6/10</h2>
            <?php
            foreach($movie->movie_genres as $movie_genre){
				echo "<h2>".$movie_genre->gener_title."</h2>";
				}
				 ?>
            <p> <a href="#" id="btnlink" class="btn btn-success" rel="tooltip" title="Preview">Preview</a></p>
          </div>-->
          <figure class="cap-left"> <img style="width:100%; height:250px; border: 5px solid #fff; border-radius:5px;" class="card-img-top" src="<?php echo site_url("assets/movies/".$movie->location)."/".$movie->poster_thumbnail; ?>" alt="Card image cap">
            <figcaption style="top:0px !important; width:100%; text-align:center;">
              <?php
		
		
		foreach($movie->movie_genres as $movie_genre){
			
			echo "<h3 style='line-height:0.3; '>".$movie_genre->gener_title."</h3>";
			
			}
		
		 ?>
              <button class="btn btn-success" style="margin-top:15px !important;" onclick="open_view_movie_model('<?php echo $movie->movie_id; ?>')">View Details</button>
            </figcaption>
          </figure>
          <div class="card-block">
            <h4 style="white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 200px; color:white;"><?php echo $movie->title; ?></h4>
            <p style="margin-top:-10px; color:#919191"><?php echo $movie->year; ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
