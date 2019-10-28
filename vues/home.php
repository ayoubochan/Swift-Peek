<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="vues/css/home.css">
  <title>Document</title>
</head>
<body>

    <!--AJOUT DE L'INCLUDE PHP-->
    <?php
    include 'components/header.php';
    ?>

  <ul id="movieList"></ul>

<script>
/*
console.log(new Date("02/25/2019").getTime());
console.log(new Date("02/26/2019").getTime());
var tab = [3,1,2];
 tab.sort(function(a,b){
   console.log(parseFloat(a)-parseFloat(b));
 })*/

   
  let limit = 0
  let page = 1
  let movies = []
  const list = document.querySelector('#movieList')

  list.onscroll = (e) => {
    if((list.scrollTop + list.offsetHeight) >= (list.scrollHeight - 500)) {
      page ++
      getMovies(page)
    }
  }

  function getMovies(page) {
    
    fetch(`https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=${page}`)
    .then(response  =>  response.json())
    .then(data  => {
      movies = movies.concat(data.results); 
      showMovies(movies, data.page)
      sortingDate(movies)
    })
  }
  getMovies()

  function showMovies(movies, moviePage) {
    console.log(movies)
    const movieList = movies.slice(limit).map((elem, index) => {
      const img = document.createElement('img')
      const li = document.createElement('li')
      list.appendChild(li)
      li.appendChild(img)
      img.src = `https://image.tmdb.org/t/p/w200/${elem.poster_path}`

      li.onclick = () => {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              window.location.href = `${window.location}?i=${elem.id}`
            }
        };
        xmlhttp.open("GET", "index.php?i=" + elem.id, true);
        xmlhttp.send();
      }
    })
    limit += 20
  }

  triage = [];
  function sortingDate(movies) {
    
    
      triage = movies.sort(parseInt(movies[0].release_date.substring(0, 4))); 
      console.log(triage)
  }

  </script>
</body>
</html>