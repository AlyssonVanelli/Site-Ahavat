<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("models/Movie.php");
  require_once("dao/MovieDAO.php");

  // Pegar o id do filme
  $id = filter_input(INPUT_GET, "id");

  $movie;

  $movieDao = new MovieDAO($conn, $BASE_URL);

  $latestMovies = $movieDao->getLatestMovies();

  if(empty($id)) {

    $message->setMessage("O filme não foi encontrado!", "error", "index.php");

  } else {

    $movie = $movieDao->findById($id);

    // Verifica se o filme existe
    if(!$movie) {

      $message->setMessage("O filme não foi encontrado!", "error", "index.php");

    }

  }

  // Checar se o filme tem imagem
  if($movie->image == "") {
    $movie->image = "movie_cover.jpg";
  }

  // Checar se o filme é do usuário
  $userOwnsMovie = false;

  if(!empty($userData)) {

    if($userData->id === $movie->users_id) {
      $userOwnsMovie = true;
    }
 
  }

?>
<div id="main-container" class="container-fluid">
  <div class="row">
    <div class="offset-md-1 col-md-8 movie-container">
      <p class="movie-details">
        <span>Categoria: <?= $movie->category ?></span>
      </p>
      <h1 class="page-notice-title"><?= $movie->title ?></h1>
      <img class="movie-image-container" src="<?= $BASE_URL ?>img/movies/<?= $movie->image ?>" />
      <p class="movie-description-container" ><?= $movie->description ?></p>
    </div>
    <div class="offset-md-1 col-md-8 movie-container">
      <h3 class="veja-mais" >VEJA TAMBÉM</h3>

    </div>
  </div>
</div>
<?php
  require_once("templates/footer.php");
