<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Home-Page-Star</title>
<link rel="icon" href="<?php echo site_url("assets/public"); ?>/img/content/icon.png">
<!-- ========== CSS INCLUDES ========== -->
<link rel="stylesheet" href="<?php echo site_url("assets/public"); ?>/css/master.css">
</head>
<body>
<div class="page-loader">
  <div class="vertical-align align-center"> <img src="<?php echo site_url("assets/public"); ?>/loader/loader.gif" alt="" class="loader-img"> </div>
</div>

<!-- =============== START PLAYER ================ -->
<div class="main-music-player"> <a class="hide-player-button"> <i class="fa fa-plus"></i> <i class="fa fa-minus"></i> </a>
  <div id="mesh-main-player" class="jp-jplayer" data-audio-src="<?php echo site_url("assets/public"); ?>/audio/flute.mp3" data-title="See right through ft. Fiora" data-artist="Tensnake"></div>
  <div id="mesh-main-player-content" class="mesh-main-player" role="application" aria-label="media player">
    <div class="container">
      <div class="row">
        <div class="left-player-side">
          <div class="mesh-prev"> <i class="fa fa-step-backward"></i> </div>
          <div class="mesh-play"> <i class="fa fa-play"></i> </div>
          <div class="mesh-pause"> <i class="fa fa-pause"></i> </div>
          <div class="mesh-next"> <i class="fa fa-step-forward"></i> </div>
          <button id="playlist-toggle" class="jplayerButton"> <span class="span-1"></span> <span class="span-2"></span> <span class="span-3"></span> </button>
        </div>
        <div class="center-side">
          <div class="mesh-current-time"> </div>
          <div class="mesh-seek-bar">
            <div class="mesh-play-bar"> </div>
          </div>
          <div class="mesh-duration"> </div>
        </div>
        <div class="right-player-side">
          <div class="mesh-thumbnail"> <img src="<?php echo site_url("assets/public"); ?>/img/albums/cover3.jpg" alt=""> </div>
          <div class="mesh-title"> </div>
          <div class="mesh-artist"> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- =============== END PLAYER ================ --> 

<!-- =============== START PLAYLIST ================ -->
<div class="playlist-wrapper" id="playlist-wrapper">
  <div class="jp-playlist container">
    <div class="about-list clearfix"> <span class="about-name">NAME</span> <span class="about-length">LENGTH</span> <span class="about-available">AVAILABLE ON</span> </div>
    <div class="trak-item" data-audio="<?php echo site_url("assets/public"); ?>/audio/flute.mp3" data-artist="Tensnake" data-thumbnail="assets/img/albums/cover1.jpg" data-id="trak-200">
      <audio preload="metadata" src="<?php echo site_url("assets/public"); ?>/audio/flute.mp3" title="See right through ft. Fiora"></audio>
      <div class="additional-button">
        <div class="center-y-table"> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-headphones"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-apple"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-soundcloud"></i> </a> </div>
      </div>
      <div class="play-pause-button">
        <div class="center-y-table"> <i class="fa fa-play"></i> </div>
      </div>
      <div class="name-artist">
        <div class="center-y-table">
          <h2> Tensnake - See Right Through Ft. Fiora </h2>
        </div>
      </div>
      <time class="trak-duration"> 00:00 </time>
    </div>
    <div class="trak-item" data-audio="<?php echo site_url("assets/public"); ?>/audio/2.mp3" data-artist="Jack U ft. Kiesza" data-thumbnail="assets/img/albums/cover2.jpg" data-id="trak-201">
      <audio preload="metadata" src="<?php echo site_url("assets/public"); ?>/audio/2.mp3" title="Take You There"></audio>
      <div class="additional-button">
        <div class="center-y-table"> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-headphones"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-apple"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-soundcloud"></i> </a> </div>
      </div>
      <div class="play-pause-button">
        <div class="center-y-table"> <i class="fa fa-play"></i> </div>
      </div>
      <div class="name-artist">
        <div class="center-y-table">
          <h2> Jack U ft. Kiesza - Take You There </h2>
        </div>
      </div>
      <time class="trak-duration"> 00:00 </time>
    </div>
    <div class="trak-item" data-audio="<?php echo site_url("assets/public"); ?>/audio/3.mp3" data-artist="Bob Sinclair" data-thumbnail="assets/img/albums/cover3.jpg" data-id="trak-201">
      <audio preload="metadata" src="<?php echo site_url("assets/public"); ?>/audio/3.mp3" title="Cinderella"></audio>
      <div class="additional-button">
        <div class="center-y-table"> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-headphones"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-apple"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-soundcloud"></i> </a> </div>
      </div>
      <div class="play-pause-button">
        <div class="center-y-table"> <i class="fa fa-play"></i> </div>
      </div>
      <div class="name-artist">
        <div class="center-y-table">
          <h2> Bob Sinclair - Cinderella </h2>
        </div>
      </div>
      <time class="trak-duration"> 00:00 </time>
    </div>
    <div class="trak-item" data-audio="<?php echo site_url("assets/public"); ?>/audio/4.mp3" data-artist="Yuna" data-thumbnail="assets/img/albums/cover4.jpg" data-id="trak-201">
      <audio preload="metadata" src="<?php echo site_url("assets/public"); ?>/audio/4.mp3" title="Lullabies"></audio>
      <div class="additional-button">
        <div class="center-y-table"> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-headphones"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-apple"></i> </a> <a href="<?php echo site_url("assets/public"); ?>/#"> <i class="fa fa-soundcloud"></i> </a> </div>
      </div>
      <div class="play-pause-button">
        <div class="center-y-table"> <i class="fa fa-play"></i> </div>
      </div>
      <div class="name-artist">
        <div class="center-y-table">
          <h2> Yuna - Lullabies </h2>
        </div>
      </div>
      <time class="trak-duration"> 00:00 </time>
    </div>
  </div>
</div>
<!-- =============== END PLAYLIST ================ --> 

<!-- =============== START TOP HEADER ================ -->
<div class="topHeader" >
  <div class="header">
    <div class="rightTopHeader">
      <div class="cartContainer">
        <div class="myCart">
          <ul>
            <li class="cartTitle"><img src="<?php echo site_url("assets/public"); ?>/img/shop/cart.png" alt=""><span>0</span></li>
          </ul>
        </div>
        <!-- end myCart -->
        <div class="cartParent">
          <div class="cartItems">
            <ul>
              <li>
                <div class="priceCart"> <img src="<?php echo site_url("assets/public"); ?>/img/shop/cart1.jpg" alt=""> <a href="<?php echo site_url("assets/public"); ?>/#">Hoodie T.Brothers <!-- <span><i class="fa fa-times"></i></span> --></a>
                  <p>Price:&nbsp;<span>&pound;15,99</span></p>
                  <p class="quantity">Quantity: <span>1</span></p>
                </div>
              </li>
              <li>
                <div class="priceCart"> <img src="<?php echo site_url("assets/public"); ?>/img/shop/cart2.jpg" alt=""> <a href="<?php echo site_url("assets/public"); ?>/#">Hoodie T.Brothers <!-- <span><i class="fa fa-times"></i></span> --></a>
                  <p>Price:&nbsp;<span>&pound;15,99</span></p>
                  <p class="quantity">Quantity: <span>1</span></p>
                </div>
              </li>
              <li>
                <div class="total"> <a href="<?php echo site_url("assets/public"); ?>/#">Sub Total<span>31,98&pound;</span></a> </div>
              </li>
            </ul>
            <button type="submit" class="single_add_to_cart_button button alt buttonView"> View Cart </button>
            <button type="submit" class="single_add_to_cart_button button alt buttonCheck"> Checkout </button>
          </div>
          <!-- end cartItems --> 
        </div>
        <!-- end cartParent --> 
      </div>
      <!--end cartContainer  --> 
      <!-- Open Menu Button --> 
      <a class="open-menu"> 
      <!-- Buttons Bars --> 
      <span class="span-1"></span> <span class="span-2"></span> <span class="span-3"></span> </a> </div>
    <!-- end rightTopHeader --> 
  </div>
  <!-- end header --> 
  <!-- Menu Fixed Container -->
  <div class="menu-fixed-container"> 
    <!-- Menu Fixed Centred Container -->
    <nav> 
      <!-- Menu Fixed Close Button -->
      <div class="x-filter"> <span></span> <span></span> </div>
      <!-- Menu Fixed Primary List -->
      <ul>
        <!-- Menu Fixed Item -->
        <li> <a href="<?php echo site_url("assets/public"); ?>/index.html"> home </a>
          <ul class="sub-menu">
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/index.html"> home star </a> </li>
            <li> <a href="<?php echo site_url("assets/public"); ?>/index-royal-slider.html"> home royal slider </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/index-video.html"> home video </a> </li>
          </ul>
        </li>
        <li> <a href="<?php echo site_url("assets/public"); ?>/albumsGrid.html"> discography </a>
          <ul class="sub-menu">
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/albumsFullBackground.html"> albums full background </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/albumsGrid.html"> albums grid </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/albumsSingle1.html"> album description </a> </li>
          </ul>
        </li>
        <!-- Menu Fixed Item -->
        <li> <a href="<?php echo site_url("assets/public"); ?>/events.html"> events </a> </li>
        <!-- Menu Fixed Item -->
        <li> <a href="<?php echo site_url("assets/public"); ?>/#"> blog </a>
          <ul class="sub-menu">
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/blogGrid.html"> blog grid </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/blogSidebarRight.html"> blog sidebar </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/blogSingle.html"> blog single </a> </li>
          </ul>
        </li>
        <!-- Menu Fixed Item -->
        <li> <a href="<?php echo site_url("assets/public"); ?>/#"> gallery </a>
          <ul class="sub-menu">
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/galleryGrid.html"> albums grid </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/galleryScroll.html"> albums scroll </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/gallerySingle.html"> gallery single </a> </li>
          </ul>
        </li>
        <!-- Menu Fixed Item -->
        <li> <a href="<?php echo site_url("assets/public"); ?>/#"> Other Pages </a>
          <ul class="sub-menu">
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/biography.html"> Biography </a> </li>
            <!-- Menu Fixed Sub Menu Item -->
            <li> <a href="<?php echo site_url("assets/public"); ?>/video.html"> Video </a> </li>
          </ul>
        </li>
        <!-- Menu Fixed Item -->
        <li> <a href="<?php echo site_url("assets/public"); ?>/contact.html"> contact </a> </li>
        <!-- Menu Fixed Item -->
        <li> <a href="<?php echo site_url("assets/public"); ?>/shop.html"> shop </a> </li>
      </ul>
      <!-- Menu Fixed Close Button -->
      <div class="x-filter"> <span></span> <span></span> </div>
    </nav>
  </div>
  <!-- end menu-fixed-container --> 
  <!-- =============== STAR LOGO ================ -->
  <div class="logo-container-top"> <a href="<?php echo site_url("assets/public"); ?>/index.html"><img src="<?php echo site_url("assets/public"); ?>/img/logo/whiteLogo.png" alt="Aqura"></a> </div>
  <!-- end logo-container-top --> 
  <!-- =============== END LOGO ================ --> 
</div>
<!-- end topHeader --> 
<!-- =============== END TOP HEADER ================ --> 

<!-- =============== START BREADCRUMB ================ -->
<section class="no-mb">
  <div class="row">
    <div class="col-sm-12">
      <div class="breadcrumb-fullscreen-parent phone-menu-bg">
        <div class="breadcrumb breadcrumb-fullscreen alignleft small-description overlay almost-black-overlay" style="background-image: url('<?php echo site_url("assets/public"); ?>/img/starHomePage/star.jpg');" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0">
          <div id="home" style="position: absolute;left: 0;top: 0;">
            <div class="intro-header">
              <div class="js-height-full star" style="height: 955px;">
                <div class="star-pattern-1 js-height-full" style="height: 994px;"></div>
                <div class="col-sm-12">
                  <div class="starTitle">
                    <h4>www.chitral.com.pk</h4>
                    <div class="grid__item">
                      <h1> <a class="link link-yaku" href="<?php echo site_url("assets/public"); ?>/#"> <span>K</span><span> h</span><span> o</span><span> w</span><span> a</span><span> r</span> <br />
                        <span> M</span><span> u</span><span> s</span><span> i</span><span>c</span> </a> </h1>
                    </div>
                    <h4>www.music.chitral.com.pk</h4>
                  </div>
                  <canvas class="cover" width="1920" height="955"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- =============== END BREADCRUMB ================ --> 

<!-- =============== START ALBUM COVER SECTION ================ -->
<section class="padding albumsHome">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="sectionTitle paddingBottom"> <span class="heading-t3"></span>
          <h2><a href="<?php echo site_url("assets/public"); ?>/albumsFullBackground.html">Discography</a></h2>
          <span class="heading-b3"></span> </div>
        <!-- end sectionTtile --> 
      </div>
      <!-- end col-sm-12 --> 
    </div>
    <div class="list-albums">
      <ul class="list-feature col-md-12 col-xs-12 col-sm-12">
        <li class="col-md-3 col-sm-3 col-xs-12">
          <div class="album-icon"> <span class="thumbs-album"> <a href="<?php echo site_url("assets/public"); ?>/albumsSingle1.html"><img width="270" height="270" src="<?php echo site_url("assets/public"); ?>/img/content/albumCover.png" class="attachment-album-thumbnail wp-post-image" alt="album-cover-1"></a> </span> <span class="disk"></span> </div>
          <!-- END ALBUM ICON -->
          <div class="name">
            <h3>Noon Xoxo</h3>
            <p>Chillout</p>
          </div>
          <!-- end name --> 
        </li>
        <li class="col-md-3 col-sm-3 col-xs-12">
          <div class="album-icon albumIcon1"> <span class="thumbs-album"> <a href="<?php echo site_url("assets/public"); ?>/albumsSingle3.html"><img width="270" height="270" src="<?php echo site_url("assets/public"); ?>/img/content/albumCover1.png" class="attachment-album-thumbnail wp-post-image" alt="album-cover-1"></a> </span> <span class="disk"></span> </div>
          <div class="name">
            <h3>Stunt Vibe</h3>
            <p>Chillout</p>
          </div>
        </li>
        <li class="col-md-3 col-sm-3 col-xs-12">
          <div class="album-icon albumIcon2"> <span class="thumbs-album"> <a href="<?php echo site_url("assets/public"); ?>/albumsSingle4.html"><img width="270" height="270" src="<?php echo site_url("assets/public"); ?>/img/content/albumCover2.png" class="attachment-album-thumbnail wp-post-image" alt="album-cover-1"></a> </span> <span class="disk"></span> </div>
          <div class="name">
            <h3>Strange Clouds</h3>
            <p>Chillout</p>
          </div>
        </li>
        <li class="col-md-3 col-sm-3 col-xs-12">
          <div class="album-icon albumIcon3"> <span class="thumbs-album"> <a href="<?php echo site_url("assets/public"); ?>/albumsSingle2.html"><img width="270" height="270" src="<?php echo site_url("assets/public"); ?>/img/content/albumCover3.png" class="attachment-album-thumbnail wp-post-image" alt="album-cover-1"></a> </span> <span class="disk"></span> </div>
          <div class="name">
            <h3>Natural Earth</h3>
            <p>Chillout</p>
          </div>
        </li>
      </ul>
    </div>
    <!-- end list-albums --> 
  </div>
  <!-- end container --> 
</section>
<!-- =============== END ALBUM COVER SECTION ================ --> 

<!-- =============== START EVENTS SECTION-1 ================ -->
<!--<section style="background-image: url(assets/img/events/home-events-1.jpg);" class="background-properties paddingHomeEvents">
  <div class="tableEvents">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="sectionTitle paddingBottom"> <span class="heading-t3"></span>
            <h2><a href="<?php echo site_url("assets/public"); ?>/events.html">Events</a></h2>
            <span class="heading-b3"></span> </div>
         
          <table>
            <tr class="tableEventsTitle">
              <th class="date">Date</th>
              <th class="venue">Venue</th>
              <th class="location">Location</th>
              <th class="tickets">Tickets</th>
              <th></th>
            </tr>
            <tr>
              <td class="aqura-date"><a href="<?php echo site_url("assets/public"); ?>/#"><i class="fa fa-plus"></i></a><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Mar 06</a></td>
              <td class="aqura-location"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Central Park</a></td>
              <td class="aqura-city"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Cluj Napoca, Bontida Romania</a></td>
              <td class="aqura-tickets"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Tickets</a></td>
              <td class="aqura-vip"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">RSVP</a></td>
            </tr>
            <tr>
              <td class="aqura-date"><a href="<?php echo site_url("assets/public"); ?>/#"><i class="fa fa-plus"></i></a><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Mar 06</a></td>
              <td class="aqura-location"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Central Park</a></td>
              <td class="aqura-city"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Cluj Napoca, Bontida Romania</a></td>
              <td class="aqura-tickets"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Tickets</a></td>
              <td class="aqura-vip"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">RSVP</a></td>
            </tr>
            <tr>
              <td class="aqura-date"><a href="<?php echo site_url("assets/public"); ?>/#"><i class="fa fa-plus"></i></a><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Mar 06</a></td>
              <td class="aqura-location"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Central Park</a></td>
              <td class="aqura-city"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Cluj Napoca, Bontida Romania</a></td>
              <td class="aqura-tickets"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Tickets</a></td>
              <td class="aqura-vip"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">RSVP</a></td>
            </tr>
            <tr>
              <td class="aqura-date"><a href="<?php echo site_url("assets/public"); ?>/#"><i class="fa fa-plus"></i></a><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Mar 06</a></td>
              <td class="aqura-location"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Central Park</a></td>
              <td class="aqura-city"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Cluj Napoca, Bontida Romania</a></td>
              <td class="aqura-tickets"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Tickets</a></td>
              <td class="aqura-vip"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">RSVP</a></td>
            </tr>
            <tr>
              <td class="aqura-date"><a href="<?php echo site_url("assets/public"); ?>/#"><i class="fa fa-plus"></i></a><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Mar 06</a></td>
              <td class="aqura-location"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Central Park</a></td>
              <td class="aqura-city"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Cluj Napoca, Bontida Romania</a></td>
              <td class="aqura-tickets"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">Tickets</a></td>
              <td class="aqura-vip"><a href="<?php echo site_url("assets/public"); ?>/singleEvent.html">RSVP</a></td>
            </tr>
          </table>
        </div>
       
      </div>
      
    </div>
   
  </div>
  
</section>-->
<!-- =============== END EVENTS SECTION-1 ================ --> 

<!-- =============== START EVENTS SECTION-2 ================ -->
<!--<section class="padding countdownSection background-properties" style="background-image: url(assets/img/events/nextEvent.jpg);">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="countdownTitle">
          <h4>Next Event</h4>
          <a href="<?php echo site_url("assets/public"); ?>/singleEvent.html"><img src="<?php echo site_url("assets/public"); ?>/img/events/box.png" alt="Event"></a> </div>
        <div class="sm-countdown sm_content_element sm-style2" id="sm_countdown-19" data-date="2016/10/23">
          <div class="displayCounter">
            <div class="column">
              <div class="sm_countdown_inner">
                <input class="element days" readonly data-min="0" data-max="365" data-width="200" data-height="200" data-thickness="0.15" data-fgcolor="#fff" data-bgcolor="#8e8d8d" data-angleoffset="180">
                <span class="unit days-title">days</span> </div>
            </div>
            <div class="column">
              <div class="sm_countdown_inner">
                <input class="element hour" readonly data-min="0" data-max="24" data-width="200" data-height="200" data-thickness="0.15" data-fgcolor="#fff" data-bgcolor="#8e8d8d" data-angleoffset="180">
                <span class="unit hours-title">hrs</span> </div>
            </div>
            <div class="column">
              <div class="sm_countdown_inner">
                <input class="element minute" readonly data-min="0" data-max="60" data-width="200" data-height="200" data-thickness="0.15" data-fgcolor="#fff" data-bgcolor="#8e8d8d" data-angleoffset="180">
                <span class="unit mins-title">min</span> </div>
            </div>
            <div class="column">
              <div class="sm_countdown_inner">
                <input class="element second" readonly data-min="0" data-max="60" data-width="200" data-height="200" data-thickness="0.15" data-fgcolor="#fff" data-bgcolor="#8e8d8d" data-angleoffset="180">
                <span class="unit secs-title">sec</span> </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>-->
<!-- =============== END EVENTS SECTION-2 ================ --> 

<!-- =============== START HOME-BLOG SECTION ================ -->
<!--<section class="padding background-properties blogHomeSection" style="background-image: url(assets/img/blog/blog-home.jpg);">
  <div class="container">
    <div class="row">
      <div class="sectionTitle paddingBottom"> <span class="heading-t3"></span>
        <h2><a href="<?php echo site_url("assets/public"); ?>/blogGrid.html">News</a></h2>
        <span class="heading-b3"></span> </div>
      
      <div class="col-sm-4">
        <div class="blogBox">
          <div class="imgBox"><img src="<?php echo site_url("assets/public"); ?>/img/blog/box-img.jpg" alt="box-img"></div>
          <div class="blogBoxContent">
            <div class="blogHeader">
              <h1><a href="<?php echo site_url("assets/public"); ?>/blogSingle.html">Gallery Post</a></h1>
            </div>
            <div class="admin-list clearfix">
              <ul>
                <li><a href="<?php echo site_url("assets/public"); ?>/#">08 dec 2016</a>&nbsp;/&nbsp;</li>
                <li><a href="<?php echo site_url("assets/public"); ?>/#">By Admin</a></li>
              </ul>
            </div>
           
            <div class="blogParagraph">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
           
            <div class="rmButton"> <a href="<?php echo site_url("assets/public"); ?>/blogSingle.html">Read More</a> </div>
          </div>
         
        </div>
       
      </div>
      
      <div class="col-sm-4">
        <div class="blogBox">
          <div class="videoBox">
            <iframe src="<?php echo site_url("assets/public"); ?>/https://player.vimeo.com/video/145837856" width="600" height="410"  ></iframe>
          </div>
          <div class="blogBoxContent">
            <div class="blogHeader">
              <h1><a href="<?php echo site_url("assets/public"); ?>/blogSingle.html">Video Post</a></h1>
            </div>
            <div class="admin-list clearfix">
              <ul>
                <li><a href="<?php echo site_url("assets/public"); ?>/#">28 apr 2016</a>&nbsp;/&nbsp;</li>
                <li><a href="<?php echo site_url("assets/public"); ?>/#">By Admin</a></li>
              </ul>
            </div>
           
            <div class="blogParagraph">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
            
            <div class="rmButton"> <a href="<?php echo site_url("assets/public"); ?>/blogSingle.html">Read More</a> </div>
          </div>
          
        </div>
        
      </div>
     
      <div class="col-sm-4">
        <div class="blogBox">
          <div class="soundcloudBox">
            <iframe height="203" src="<?php echo site_url("assets/public"); ?>/https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/73595878&amp;color=bb9b69&amp;show_artwork=false&amp;auto_play=false&amp;hide_related=false&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false"></iframe>
          </div>
          <div class="blogBoxContent">
            <div class="blogHeader">
              <h1><a href="<?php echo site_url("assets/public"); ?>/blogSingle.html">Soundcloud Post</a></h1>
            </div>
            <div class="admin-list clearfix">
              <ul>
                <li><a href="<?php echo site_url("assets/public"); ?>/#">08 dec 2016</a>&nbsp;/&nbsp;</li>
                <li><a href="<?php echo site_url("assets/public"); ?>/#">By Admin</a></li>
              </ul>
            </div>
           
            <div class="blogParagraph">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
           
            <div class="rmButton"> <a href="<?php echo site_url("assets/public"); ?>/blogSingle.html">Read More</a> </div>
          </div>
         
        </div>
       
      </div>
     
    </div>
    
  </div>
  
</section>-->
<!-- =============== END HOME-NLOG SECTION ================ --> 

<!-- =============== START TWITTER SECTION ================ -->
<!--<section class="padding background-properties" style="background-image: url(assets/img/content/twitterBgk.jpg);">
  <div class="twitter">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="twitterLogo"> <a href="<?php echo site_url("assets/public"); ?>/#"><img src="<?php echo site_url("assets/public"); ?>/img/content/twitterLogo.png" alt="twitterLogo"></a> <a href="<?php echo site_url("assets/public"); ?>/#" class="linkTwitter">@ThemeBrothers</a> </div>
          <p>AQURA - Creative Theme for dj, bands and musicians #HTML#Theme now available on #ThemeForest - <a href="<?php echo site_url("assets/public"); ?>/https://twitter.com/electric_castle" class="twitter-follow-button" data-show-count="false">Follow @electric_castle</a><script async src="<?php echo site_url("assets/public"); ?>///platform.twitter.com/widgets.js" charset="utf-8"></script></p>
        </div>
      </div>
    </div>
  </div>
</section>-->
<!-- =============== END TWITTER SECTION ================ --> 

<!-- =============== START VIDEO SECTION ================ -->
<!--<section class="videoHome padding">
  <div class="container">
    <div class="row">
      <div class="sectionTitle"> <span class="heading-t3"></span>
        <h2><a href="<?php echo site_url("assets/public"); ?>/video.html">Upload Video</a></h2>
        <span class="heading-b3"></span>
        <p>Check out my latest videos and follow me on <a href="<?php echo site_url("assets/public"); ?>/#">Youtube</a> & <a href="<?php echo site_url("assets/public"); ?>/#">Vimeo</a> to view more.</p>
      </div>
      
      <div class="col-sm-4">
        <iframe width="560" height="315" src="<?php echo site_url("assets/public"); ?>/https://www.youtube.com/embed/VV-Q-aRHTDE"  allowfullscreen></iframe>
      </div>
    
      <div class="col-sm-4">
        <iframe width="560" height="315" src="<?php echo site_url("assets/public"); ?>/https://www.youtube.com/embed/VxG5C4q_rEs"  allowfullscreen></iframe>
      </div>
      
      <div class="col-sm-4">
        <iframe width="560" height="315" src="<?php echo site_url("assets/public"); ?>/https://www.youtube.com/embed/OkbuRa1o1wA"  allowfullscreen></iframe>
      </div>
      
    </div>
  </div>
</section>-->
<!-- =============== END VIDEO SECTION ================ --> 

<!-- =============== START GALLERY SECTION ================ -->
<!--<section style="padding-bottom:0; padding-top:0;">
  <div class="gallerySection">
    <div class="container-fluid" style="padding:0;">
      <div class="col-sm-12"> 
       
        <div class="content-container clearfix"> 
          
          <div class="single-photo-album-container">
            <div class="row"> 
              
              <article class="col-sm-12 col-md-6 col-xs-12"> 
               
                <figure> 
                  
                  <figcaption> 
                   
                    <div class="hovereffect"> <img class="img-responsive" src="<?php echo site_url("assets/public"); ?>/img/content/g1.jpg" alt="">
                      <div class="overlay"> <a class="info lightbox" href="<?php echo site_url("assets/public"); ?>/img/bigGallery/1.jpg"></a> </div>
                    </div>
                  </figcaption>
                  
                  
                </figure>
              </article>
             
              <article class="col-sm-3 col-xs-6"> 
                
                <figure> 
                  
                  <figcaption>
                    <div class="hovereffect"> <img class="img-responsive" src="<?php echo site_url("assets/public"); ?>/img/content/g2.jpg" alt="">
                      <div class="overlay"> <a class="info lightbox" href="<?php echo site_url("assets/public"); ?>/img/bigGallery/2.jpg"></a> </div>
                    </div>
                  </figcaption>
                </figure>
              </article>
             
              <article class="col-sm-3 col-xs-6"> 
               
                <figure> 
                  
                  <figcaption>
                    <div class="hovereffect"> <img class="img-responsive" src="<?php echo site_url("assets/public"); ?>/img/content/g3.jpg" alt="">
                      <div class="overlay"> <a class="info lightbox" href="<?php echo site_url("assets/public"); ?>/img/bigGallery/3.jpg"></a> </div>
                    </div>
                  </figcaption>
                </figure>
              </article>
           
              <article class="col-sm-3 col-xs-6"> 
                
                <figure> 
                
                  <figcaption>
                    <div class="hovereffect"> <img class="img-responsive" src="<?php echo site_url("assets/public"); ?>/img/content/g4.jpg" alt="">
                      <div class="overlay"> <a class="info lightbox" href="<?php echo site_url("assets/public"); ?>/img/bigGallery/4.jpg"></a> </div>
                    </div>
                  </figcaption>
                </figure>
              </article>
            
              <article class="col-sm-3 col-xs-6"> 
              
                <figure> 
                
                  <figcaption>
                    <div class="hovereffect"> <img class="img-responsive" src="<?php echo site_url("assets/public"); ?>/img/content/g5.jpg" alt="">
                      <div class="overlay"> <a class="info lightbox" href="<?php echo site_url("assets/public"); ?>/img/bigGallery/5.jpg"></a> </div>
                    </div>
                  </figcaption>
                </figure>
              </article>
             
              <article class="col-sm-12 col-md-6 col-xs-12"> 
               
                <figure> 
                 
                  <figcaption>
                    <div class="hovereffect"> <img class="img-responsive" src="<?php echo site_url("assets/public"); ?>/img/content/g6.jpg" alt="">
                      <div class="overlay"> <a class="info lightbox" href="<?php echo site_url("assets/public"); ?>/img/bigGallery/6.jpg"></a> </div>
                    </div>
                  </figcaption>
                </figure>
              </article>
            </div>
          </div>
        </div>
      </div>
    </div>
   
  </div>
</section>-->
<!-- =============== END GALLERY SECTION ================ --> 

<!-- =============== START HOME-SHOP SECTION ================ -->
<!--<section class="shopHomePage shopHomePadding">
  <div class="shopSection">
    <div class="container-fluid">
      <div class="shopContent">
        <div class="sectionTitle paddingBottom"> <span class="heading-t3"></span>
          <h2><a href="<?php echo site_url("assets/public"); ?>/shop.html">Shop Online</a></h2>
          <span class="heading-b3"></span> </div>
       
        <div class="row">
          <nav class="shop-products">
            <ul class="clearfix">
              <li class="col-sm-3">
                <figure>
                  <figcaption> <img src="<?php echo site_url("assets/public"); ?>/img/content/shop1.jpg" alt=""> </figcaption>
                  <div class="content">
                    <div class="shopHover">
                      <div class="price"> &pound; 15,99 </div>
                      <div  class="proTitle"> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html">Original T. Brothers</a> </div>
                      <div class="product">Hoodie Aqura</div>
                      <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-shopping-cart"></i><span></span></a> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-info"></i><span></span></a> </div>
                  </div>
                </figure>
              </li>
              <li class="col-sm-3">
                <figure>
                  <figcaption> <img src="<?php echo site_url("assets/public"); ?>/img/content/shop2.jpg" alt=""> </figcaption>
                  <div class="content">
                    <div class="shopHover">
                      <div class="price"> &pound; 15,99 </div>
                      <div  class="proTitle"> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html">Original T. Brothers</a> </div>
                      <div class="product">Hoodie Aqura</div>
                      <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-shopping-cart"></i><span></span></a> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-info"></i><span></span></a> </div>
                  </div>
                </figure>
              </li>
              <li class="col-sm-3">
                <figure>
                  <figcaption> <img src="<?php echo site_url("assets/public"); ?>/img/content/shop3.jpg" alt=""> </figcaption>
                  <div class="content">
                    <div class="shopHover">
                      <div class="price"> &pound; 15,99 </div>
                      <div  class="proTitle"> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html">Original T. Brothers</a> </div>
                      <div class="product">Hoodie Aqura</div>
                      <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-shopping-cart"></i><span></span></a> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-info"></i><span></span></a> </div>
                  </div>
                </figure>
              </li>
              <li class="col-sm-3">
                <figure>
                  <figcaption> <img src="<?php echo site_url("assets/public"); ?>/img/content/shop4.jpg" alt=""> </figcaption>
                  <div class="content">
                    <div class="shopHover">
                      <div class="price"> &pound; 15,99 </div>
                      <div  class="proTitle"> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html">Original T. Brothers</a> </div>
                      <div class="product">Hoodie Aqura</div>
                      <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-shopping-cart"></i><span></span></a> <a href="<?php echo site_url("assets/public"); ?>/shopSingle.html" class="icon-button shopIcon"><i class="fa fa-info"></i><span></span></a> </div>
                  </div>
                </figure>
              </li>
            </ul>
          </nav>
          
        </div>
        
      </div>
      
    </div>
  </div>
</section>-->
<!-- =============== END HOME-SHOP SECTION ================ --> 

<!-- =============== START FOOTER ================ -->
<section style="background-color:#eeeeee;">
  <div class="footer footerPadding">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <div class="copyFooter"> <a href="<?php echo site_url("assets/public"); ?>/#">&copy; Aqura 2016</a> </div>
        </div>
        <div class="col-sm-4">
          <nav class="social-icons">
            <ul class="clearfix">
              <li><a href="<?php echo site_url("assets/public"); ?>/#" class="icon-button shopIcon"><i class="fa fa-twitter"></i><span></span></a></li>
              <li><a href="<?php echo site_url("assets/public"); ?>/#" class="icon-button shopIcon"><i class="fa fa-facebook"></i><span></span></a></li>
              <li><a href="<?php echo site_url("assets/public"); ?>/#" class="icon-button shopIcon"><i class="fa fa-apple"></i><span></span></a></li>
              <li><a href="<?php echo site_url("assets/public"); ?>/#" class="icon-button shopIcon"><i class="fa fa-lastfm"></i><span></span></a></li>
              <li><a href="<?php echo site_url("assets/public"); ?>/#" class="icon-button shopIcon"><i class="fa fa-soundcloud"></i><span></span></a></li>
              <li><a href="<?php echo site_url("assets/public"); ?>/#" class="icon-button shopIcon"><i class="fa fa-youtube-play"></i><span></span></a></li>
              <li><a href="<?php echo site_url("assets/public"); ?>/#" class="icon-button shopIcon"><i class="fa fa-vimeo"></i><span></span></a></li>
            </ul>
          </nav>
        </div>
        <div class="col-sm-4">
          <div class="goTop back-to-top" id="back-to-top"> <i class="fa fa-angle-up"></i> <a href="<?php echo site_url("assets/public"); ?>/#">Go Top</a> </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- =============== END FOOTER ================ --> 

<!-- ================================================== --> 
<!-- =============== START JQUERY SCRIPTS ================ --> 
<!-- ================================================== --> 
<script src="<?php echo site_url("assets/public"); ?>/js/jquery.js"></script> 
<script src="<?php echo site_url("assets/public"); ?>/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo site_url("assets/public"); ?>/jplayer/jplayer/jquery.jplayer.js"></script> 
<script src="<?php echo site_url("assets/public"); ?>/js/jPlayer.js"></script> 
<script src="<?php echo site_url("assets/public"); ?>/js/plugins.js"></script> 
<script src="<?php echo site_url("assets/public"); ?>/js/main.js"></script> 
<!--[if lte IE 9 ]>
		<script src="<?php echo site_url("assets/public"); ?>/js/placeholder.js"></script>
		<script>
			jQuery(function() {
				jQuery('input, textarea').placeholder();
			});
		</script>
	<![endif]--> 
<!-- ================================================== --> 
<!-- =============== END JQUERY SCRIPTS ================ --> 
<!-- ================================================== -->
</body>
</html>