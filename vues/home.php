<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/7b840f6fa2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="vues/css/home.css">
  <title>Document</title>
</head>
<body id="body">
<a class="admin" href="AdminPage_Comment.php">Admin</a>
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
  const shopButton = document.querySelector('.shop-button')
  const formRegister = document.querySelector('.register-container')
  const switchConnexion = document.querySelector('#switch-connexion')
  const switchRegister = document.querySelector('#switch-register')
  let connexionState = true
  const header = document.querySelector('#header')
  const body = document.querySelector('#body')

  // Event for 100vh scroll down
  body.onscroll = () => {
    shopButton.style.zIndex = '5'
    body.style.transform = 'translate(0, -50%)'
    connexion.style.transform = 'translate(0, 100vh)'
    shopButton.style.transform = 'translate(0, 100vh)'
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

  // Handle form connexion and registration css
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

  // Create list of all genres in Select element
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

  // Pass the next page to fetch and stop fetch if last page
  function handleApi() {
      page ++
      callApi(page)
      if(page === 500) clearInterval(delay)
  }
  let delay = setInterval(handleApi, 300);

  // Redifince fetch method to prevent Errors causing by multiple fetch
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
        // Add all movies into one array
        movies = movies.concat(json.results)
        showMovies(movies)
        // Event for filter by search
        search.onkeyup = (e) => {
          list.innerHTML = ''
          searchValue = e.target.value
          limit = 0
          saveLimit = 1
          if(page === 500)showMovies(movies)
        }
        // Change genre value on select
        genres.onchange = () => {
          saveGenre = genres.options[genres.selectedIndex].value
          list.innerHTML = ''
          if(limit > 0) limit = -20
          else limit = 0
          saveLimit = 1
          if(page === 500)showMovies(movies)
        }
        // Handle slice value to load more movies on scroll
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
      // Conditions that verify if there's a filter to apply
      (saveGenre == '' ? '' : movies = movies.filter(elem => elem.genre_ids.includes(parseInt(saveGenre))));
      (searchValue == '' ? '' : movies = movies.filter(elem => elem.title.toLowerCase().includes(searchValue.toLowerCase())));
      saveLimit = limit
      // create movie list with map method
      const movieList = movies.slice(limit, limit + 20).map((elem, index) => {
      if(elem.poster_path !== null) {
        const img = document.createElement('img')
        const li = document.createElement('li')
        list.appendChild(li)
        li.appendChild(img)
        img.src = `https://image.tmdb.org/t/p/w200/${elem.poster_path}`

        // Send movie ID to detail page for another fetch on it
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
