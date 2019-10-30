<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="vues/css/detail.css">
  <title>Document</title>
</head>
<body>
<div> 


<ul>
<li id="date"></li>
<li id="duration"></li>
</ul>

<p id="producer"></p>
<p id="actor"></p>
<p id="description" ></p>

</div>
	
  <?php
  include 'vues/components/Back-button.php';
  include 'components/comment_section.php';
  ?>

  <script>
  const date = document.getElementById("date");
  const duration = document.getElementById("duration");
  const producer = document.getElementById("producer");
  const actor = document.getElementById("actor");
  const description = document.getElementById("description");
=======
  <?php
    include 'components/headerDetail.php';
    include 'vues/components/Back-button.php';
    include 'components/comment_section.php';
  ?>

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

    function getMovie() {
      fetch(`https://api.themoviedb.org/3/movie/<?php echo $_REQUEST['i']; ?>?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US`)
      .then(response  =>  response.json())
      .then(data  => {
        console.log(data)
        showMovie(data)
      })
    }
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
  
  
  function getMovie() {
      fetch(`https://api.themoviedb.org/3/movie/<?php echo $_REQUEST['i']; ?>?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US`)
      .then(response  =>  response.json())
      .then(data  => {
        console.log(data)
        showDescription(data);
      })
    }
    getMovie();
    
    //fonction permettant d'avoir et afficher le descriptif, la date de sortie et la durée du film
    function showDescription(movie){
     date.textContent = "Release Date : "+movie.release_date;
     duration.textContent = "Duration : "+movie.runtime+" minutes.";
     description.textContent = movie.tagline + movie.overview;
     getCredit()
    }
    //fonction permettant d'avoir les credits supplementaire ( à savoir le producteur et l'acteur)
    function getCredit(){
    fetch(`https://api.themoviedb.org/3/movie/<?php echo $_REQUEST['i']; ?>/credits?api_key=b53ba6ff46235039543d199b7fdebd90`)
    .then(reponse=>reponse.json())
    .then(donnee=>{
      console.log(donnee);
      //pour le producteur principal et l'afficher
      let prod = donnee.crew.filter(elem => elem.job === 'Producer')[0].name;
      producer.textContent = "Producer : "+prod;
      //bug resolu
      // Pour l'acteur principal et l'afficher
      let act = donnee.cast.filter(elem => elem.order === 0)[0].name;
      actor.textContent="Actors :"+act;

      /*let act = donnee.cast.filter(elem => elem.order = '0')[0].name; 
      let act2 = donnee.cast.filter(elem => elem.order = '1')[1].name;
      actor.textContent="Actors : "act+act2;*/

    });
    }
    

    
    
    </script>
</body>
</html>
