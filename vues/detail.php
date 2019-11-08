<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="vues/css/detail.css">
  <script src="https://kit.fontawesome.com/7b840f6fa2.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>
<body>
<div> 

</div>

  <?php
    include 'components/headerDetail.php';
  ?>
<section class="main-container">
  <div class="description-container">
  <ul>
    <li id="date"></li>
    <li class="separation"></li>
    <li id="duration"></li>
    <li class="separation"></li>
    <li id="genre"></li>
  </ul>

  <p id="producer"></p>
  <!--<form action="" method="POST"><button class="button-buy" type="submit" name="add" id="add"><h2>Buy</h2></button></form>-->
  <p id="actor"></p>
  <p id="description"></p>
  <?php
  addSession(); 
  ?>
  </div>

  <?php
      include 'components/comment_section.php';
      sendComment($db);
    ?>

    <ul id="comment-list">
      <?php 
      for($i = 0; $i < sizeof(showComment($db)); $i++) {
        echo showComment($db)[$i];
      }
      ?>

    </ul>
</section>

  <script>
    const header = document.querySelector('.detail-header')
    const video = document.querySelector('#video')
    const playButton = document.querySelector('.play-button')
    const loading = document.querySelector('.loading')
    const topPlay = document.querySelector('.top')
    const bottom = document.querySelector('.bottom')
    const left = document.querySelector('.left')
    const background = document.querySelector('#background')
    const videoContainer = document.querySelector('#video-container')
    let inProgress = false

    const date = document.getElementById("date");
    const duration = document.getElementById("duration");
    const producer = document.getElementById("producer");
    const actor = document.getElementById("actor");
    const description = document.getElementById("description");
    const genre = document.getElementById('genre')
    const commentList = document.getElementById('comment-list')
    const title = document.getElementById('title')
    
    // Use ID movie in URL to fetch a particular movie
    function getMovie() {
      fetch(`https://api.themoviedb.org/3/movie/<?php echo $_REQUEST['i']; ?>?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US`)
      .then(response  =>  response.json())
      .then(data  => {
        console.log(data)
        showMovie(data)
        showDescription(data);
      })
    }
    var session = []
    getMovie()
    function showMovie(movie) {
      header.style.backgroundImage = `url(https://image.tmdb.org/t/p/w1400_and_h450_bestv2${movie.backdrop_path})`
      header.style.animation = 'show 1s ease-in forwards'
    }

    function getTrailer() {
      fetch(`https://api.themoviedb.org/3/movie/<?php echo $_REQUEST['i']; ?>/videos?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US`)
      .then(response => response.json())
      .then(data => {
        showVideo(data.results)
      })
    }
    getTrailer()

    function showVideo(videos) {
      let teaser = ''
      for(let i = 0; i < videos.length; i++) {
        if(videos[i].type === 'Trailer') {
          video.src = `https://www.youtube.com/embed/${videos[i].key}?enablejsapi=1&html5=1&mute=1&autoplay=1`
          return
        } else if(videos[i].type === 'Teaser') {
          teaser = videos[i].key
        }
      }
      video.src = `https://www.youtube.com/embed/${teaser}?enablejsapi=1&html5=1&mute=1&autoplay=1`
    }

    // Import youtube API script
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    
    function onYouTubePlayerAPIReady() {
       video.onload = () => {
        player = new YT.Player('video', {
        events: {
          'onReady': onPlayerReady,
        }
      });
      }
    }

    // Handle video state and css animations
    function onPlayerReady(event) {
      player.pauseVideo()
      loading.style.opacity = '0'
      topPlay.style.opacity = '1'
      bottom.style.opacity = '1'
      left.style.opacity = '1'
      playButton.style.cursor = 'pointer'
      let delay;
      let ending;

      playButton.onclick = () => {

        if(inProgress) {
          player.mute()
          topPlay.style.opacity = '0'
          bottom.style.opacity = '0'
          topPlay.style.animation = 'show 200ms ease-in 0.5s forwards'
          bottom.style.animation = 'show 200ms ease-in 0.5s forwards'
          left.style.animation = 'shrink 0.5s ease-in forwards'
          video.style.animation = 'hide 1s ease-in forwards'
          background.style.animation = 'hide 1s ease-in forwards'
          delay = setTimeout(() => {
            player.seekTo(1)
            player.pauseVideo()
            clearTimeout(ending)
          }, 1050);
        } else {
          clearTimeout(delay)
          player.playVideo()
          player.unMute()
          videoContainer.style.animation = 'stretch 3.5s ease-in 2.5s forwards'
          topPlay.style.animation = 'hide 200ms ease-in forwards'
          bottom.style.animation = 'hide 200ms ease-in forwards'
          left.style.animation = 'scale 0.5s ease-in 200ms forwards'
          video.style.animation = 'show 1s ease-in 300ms forwards'
          background.style.animation = 'show 1s ease-in 300ms forwards'
          ending = setTimeout(() => {
            playButton.style.pointetEvents = 'none'
            playButton.style.cursor = 'default'
            video.style.animation = 'hide 1s ease-in forwards'
            background.style.animation = 'hide 1s ease-in forwards'
            inProgress = !inProgress
            setTimeout(() => {
              player.seekTo(1)
              player.pauseVideo()
              playButton.style.pointetEvents = 'default'
              playButton.style.cursor = 'pointer'
              topPlay.style.opacity = '0'
              bottom.style.opacity = '0'
              topPlay.style.animation = 'show 200ms ease-in 0.5s forwards'
              bottom.style.animation = 'show 200ms ease-in 0.5s forwards'
              left.style.animation = 'shrink 0.5s ease-in forwards'
            }, 1050);
          }, (player.getDuration() * 1000 - 2000));
        }
        inProgress = !inProgress
      };
    }
    
    function showDescription(movie){
     date.innerHTML = `<b>${movie.release_date}</b>`;
     duration.innerHTML = `<b>${movie.runtime} mins</b>`;
     genre.innerHTML = `<b>${movie.genres[0].name}</b>`
     description.textContent = movie.overview;
     title.textContent = movie.title;
     session.push(movie.title)
     let path = "https://image.tmdb.org/t/p/w1400_and_h450_bestv2" + movie.backdrop_path
     session.push(path)
     document.getElementById('add').value = session
    }

    function getCredit(){
    fetch(`https://api.themoviedb.org/3/movie/<?php echo $_REQUEST['i']; ?>/credits?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US`)
    .then(reponse=>reponse.json())
    .then(data=>{
      console.log(data);
      let prod = data.crew.filter(elem => elem.job === 'Producer')[0].name;
      producer.innerHTML = "<b>Producer : </b>"+prod;
      let act = data.cast.filter(elem => elem.order === 0)[0].name; 
      actor.innerHTML="<b>Main actor : </b>" + act
    });
    }
    getCredit();
    
    
    </script>
</body>
</html>
