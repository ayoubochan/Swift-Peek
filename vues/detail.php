<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Document sans titre</title>
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
      // Pour l'acteur principal et l'afficher
      let act = donnee.cast.filter(elem => elem.order === 0)[0].name;
      actor.textContent="Actors :"+act;
    });
    }
    

    
    
    </script>
</body>
</html>