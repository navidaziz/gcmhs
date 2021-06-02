<?php 
//var_dump($movies);
$movie = $movies[0];

?>

<div class="row" >
<div class="col-md-6">
<video  height="300" width="70%" controls poster="<?php echo site_url("assets/movies/".$movie->location)."/".$movie->poster_thumbnail; ?>">  

     <source type="video/mp4" src="<?php echo site_url($movie_file); ?>" >   
     <track src="<?php echo site_url($subtitle); ?>" label="English" kind="captions" srclang="en-us" default >
    

</video>
</div>
<div class="col-md-6">
<div class="row">
  
    <img class="img-responsive" src="<?php echo site_url("assets/movies/".$movie->location)."/".$movie->poster_thumbnail; ?>"> 
   
   
        <h1><?php echo $movie->title; ?></h1>
        <h2><?php echo $movie->year; ?> <span class="pull-right"><?php echo $movie->rating; ?></span></h2>
        <h2>
          <?php foreach($movie->movie_genres as $movie_genre ){ 
		  	echo $movie_genre->gener_title." / ";
		   } ?>
        </h2>
        <p><?php echo $movie->description; ?></p>
      
      
        <p><?php echo $movie->plot; ?></p>
      
      
      <p>Similar Movies</p>
      <?php foreach($similar_movies as $similar_movie_title => $similar_movie){ ?>
       
      <a href="<?php echo site_url("movies/view_movie/".$similar_movie['movie_id']); ?>" title="<?php echo $similar_movie_title; ?>"><img src="<?php echo $similar_movie['poster']; ?>" alt="<?php echo $similar_movie_title; ?>"></a> 
      
     <?php } ?>
      
     
</div>
</div>

  

