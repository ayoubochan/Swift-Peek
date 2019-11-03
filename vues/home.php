<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="vues/css/home.css">
  <title>Document</title>
</head>
<body id="body">
<a href="AdminPage_Comment.php">To Admin Page Here ! </a>
  <?php
    include 'components/headerHome.php';
  ?>

  <section>
    <div class="list-container">
      <div class="filters">
        <select>
        <option value="">Tous les genres</option>
        </select>

        <input id="search" type="text" placeholder="Title">
        <img src="assets/search.png">
      </div>
        
      <ul id="movieList"></ul>
    </div>
  </section>

<script>
  let limit = 0
  let saveLimit = 1
  let page = 0
  let movies = []
  const list = document.querySelector('#movieList')
  const genres = document.getElementsByTagName('select')[0]
  let saveGenre = ''
  const search = document.querySelector('#search')
  let searchValue = ''
  const connexion = document.querySelector('.connexion')
  const formConnexion = document.querySelector('.connexion-container')
  const formRegister = document.querySelector('.register-container')
  const switchConnexion = document.querySelector('#switch-connexion')
  const switchRegister = document.querySelector('#switch-register')
  let connexionState = true
  const header = document.querySelector('#header')
  const body = document.querySelector('#body')

  body.onscroll = () => {
    body.style.transform = 'translate(0, -50%)'
    connexion.style.transform = 'translate(0, 100vh)'
    formConnexion.style.transform = 'translate(0, 100vh)'
    formRegister.style.transform = 'translate(0, 100vh)'
  }

  function getBackground() {
    fetch('https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US')
    .then(response => response.json())
    .then(data => {
      console.log(data.results)
      header.style.backgroundImage = `url(https://image.tmdb.org/t/p/original/${data.results[0].backdrop_path})`
    })
  }
  getBackground()

  switchConnexion.onclick = () => {
    formConnexion.style.zIndex = '-1'
    formRegister.style.zIndex = '3'
  }

  switchRegister.onclick = () => {
    formConnexion.style.zIndex = '3'
    formRegister.style.zIndex = '-1'
  }

  connexion.onclick = () => {
    if(connexionState) {
      formConnexion.style.zIndex = '3'
      connexionState = false
    } else {
      formConnexion.style.zIndex = '-1'
      formRegister.style.zIndex = '-1'
      connexionState = true
    }

  }

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
        search.onkeyup = (e) => {
          list.innerHTML = ''
          searchValue = e.target.value
          limit = 0
          saveLimit = 1
          if(page === 500)showMovies(movies)
        }
        genres.onchange = () => {
          saveGenre = genres.options[genres.selectedIndex].value
          list.innerHTML = ''
          if(limit > 0) limit = -20
          else limit = 0
          saveLimit = 1
          if(page === 500)showMovies(movies)
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
        console.error(error.message);
      })
    }

  function showMovies(movies) {
    if(limit !== saveLimit) {
      (saveGenre == '' ? '' : movies = movies.filter(elem => elem.genre_ids.includes(parseInt(saveGenre))));
      (searchValue == '' ? '' : movies = movies.filter(elem => elem.title.toLowerCase().includes(searchValue.toLowerCase())));
      saveLimit = limit
      const movieList = movies.slice(limit, limit + 20).map((elem, index) => {
      if(elem.poster_path !== null) {
        const img = document.createElement('img')
        const li = document.createElement('li')
        list.appendChild(li)
        li.appendChild(img)
        img.src = `https://image.tmdb.org/t/p/w200/${elem.poster_path}`

        li.onclick = () => {
          search.value = ''
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
