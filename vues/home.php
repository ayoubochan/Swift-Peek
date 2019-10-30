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
<form method="POST" action="">
    
    <p><input type="text" name="pseudo" placeholder ="pseudo" required></p>
    
    <p><input type="email" name="email" placeholder="email" required></p>

    <p><input type="password" placeholder="password" name="password" required></p>

    <p><input type="password" placeholder="confirmation password " name="password2" required></p>
    
    
    <p><input type="submit" value="submit" name="submit" /></p>

    </form>
    
  <ul id="movieList"></ul>

<script>
  let limit = 0
  let saveLimit = 1
  let page = 0
  let movies = []
  const list = document.querySelector('#movieList')

  function handleApi() {
    page ++
    callApi(page)
    if (page === 500) clearInterval(delay);
  }
  let delay = setInterval(handleApi, 300);

  const fetchWithTimeout = (uri, options = {}, time = 5000) => {
    const controller = new AbortController()
    const config = { ...options, signal: controller.signal }
    const timeout = setTimeout(() => {
      controller.abort()
    }, time)
    return fetch(uri, config)
      .then(response => {
        if (!response.ok) {
          throw new Error(`${response.status}: ${response.statusText}`)
        }
        return response
      })
      .catch(error => {
        if (error.name === 'AbortError') {
          throw new Error('Response timed out')
        }
        throw new Error(error.message)
      })
    }

    function callApi() {
      fetchWithTimeout(
      `https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=${page}`,
      { headers: { Accept: 'application/json' } },
      500
      )
      .then(response => response.json())
      .then(json => {
        console.log(json.page)
        movies = movies.concat(json.results)
        showMovies(movies)
        list.onscroll = (e) => {
          if((list.scrollTop + list.offsetHeight) >= (list.scrollHeight - 500)) {
            limit += 20
            showMovies(movies)
          }
        }
      })
      .catch(error => {
        console.error(error.message)
      })
    }

  function showMovies(movies) {
    
    if(limit !== saveLimit) {
      saveLimit = limit
      const movieList = movies.slice(limit, limit + 20).map((elem, index) => {
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
    console.log(movies.slice(limit, limit + 20), 'HERE')
    }
  }
  
  </script>
</body>
</html>