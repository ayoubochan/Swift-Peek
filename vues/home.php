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
  <select>
    <option value="">Tous les genres</option>
    <option value="28">Action</option>
    <option value="12">Adventure</option>
    <option value="16">Animation</option>
  </select>
  <ul id="movieList"></ul>

<script>
  let limit = 0
  let saveLimit = 1
  let page = 0
  let movies = []
  const list = document.querySelector('#movieList')
  const genres = document.getElementsByTagName('select')[0]
  let saveGenre = ''

  function getGenres() {
    fetch('https://api.themoviedb.org/3/genre/movie/list?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US')
    .then(response => response.json())
    .then(data => {
      data.genres.map(elem => {
        const option = document.createElement('option')
        genres.appendChild(option)
        option.textContent = elem.name
        option.value = elem.id
      })
    })
  }
  getGenres()

  function handleApi() {
      page ++
      callApi(page)
      if(page === 500) clearInterval(delay)
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
        movies = movies.concat(json.results)
        showMovies(movies)
        genres.onchange = () => {
          saveGenre = genres.options[genres.selectedIndex].value
          list.innerHTML = ''
          if(limit > 0) limit = -20
          else limit = 0
          saveLimit = 1
          handleApi()
        }
        list.onscroll = (e) => {
          if((list.scrollTop + list.offsetHeight) >= (list.scrollHeight - 500)) {
            if(saveGenre !== '') {
              if((json.page * 100 > limit )) {
                limit += 20
                showMovies(movies)
              }
            } else {
              if((json.page * 18 > limit )) {
                limit += 20
                showMovies(movies)
              }
            }
          }
        }
      })
      .catch(error => {
        console.error(error.message)
      })
    }

  function showMovies(movies) {
    console.log(limit, 'limit')
    if(limit !== saveLimit) {
      (saveGenre == '' ? '' : movies = movies.filter(elem => elem.genre_ids.includes(parseInt(saveGenre))))
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
    }
  }
  
  </script>
</body>
</html>