<?php

  if(empty($movie->image)) {
    $movie->image = "movie_cover.jpg";
  }
?>

<div id="main-container" class="veja-mais-notice">

    <div class="col-md-8">
      <div class="veja-mais-notice">
      <img class="veja-mais-image" src="<?= $BASE_URL ?>img/movies/<?= $movie->image ?>" /> 
        <div class="veja-mais-conteudo">
        <h2 class="veja-mais-title"><?= $movie->title ?></h2>
        <p class="veja-mais-description"><?= $movie->description ?></p>
      </div>
      <div class="offset-md-11 col-md-7 ">
        <a href="<?= $BASE_URL ?>notice.php?id=<?= $movie->id?>">Continue Lendo...</a>
      </div>
    </div>

</div>