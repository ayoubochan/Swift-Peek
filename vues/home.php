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
    include 'components/headerHome.php';
    ?>

  <ul id="movieList"></ul>

<script>
  let backdrop = ''
  let limit = 0
  let saveLimit = 1
  let stock = []
  let page = 1
  const list = document.querySelector('#movieList')

//   function get() {
//     for(let i = 1; i <= 20; i++) {
//       fetch(`https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=${i}`)
//       .then(response  =>  response.json())
//       .then(data  => {
//         movies = movies.concat(data.results)
//         if(i % 10 === 0) show()
//     })
//   }
// }

// window.onload = () => {get()}

//   function show() {
//     if(movies[0] === undefined) {
//       document.location.reload()
//     } else {
//       console.log(movies)
//     }
//   }

  list.onscroll = () => {
    if((list.scrollTop + list.offsetHeight) >= (list.scrollHeight - 100)) {
      limit += 20
      showMovies()
    }
  }

  function getMovies() {
    for(let i = 1; i <= 20; i++) {
      fetch(`https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=${i}`)
      .then(response  =>  response.json())
      .then(data  => {
        stock = stock.concat(data.results)
        if(i % 10 === 0) showMovies(stock)
    })
    }
  }
  getMovies()

  function showMovies(movies) {
    if(movies[0] === undefined) {
      document.location.reload()
    } else {
      if(limit !== saveLimit) {
      saveLimit = limit
      movies.slice(limit, limit + 20).map((elem, index) => {
        if(elem.poster_path !== null) {
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
        }
      })
    }
    }
  }
  
  </script>
</body>
</html>