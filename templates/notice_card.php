<?php

  if(empty($movie->image)) {
    $movie->image = "movie_cover.jpg";
  }
?>

<div class="box-ultima-single">
    <img src="<?= $BASE_URL ?>img/movies/<?= $movie->image ?>" />
    <div class="conteudo-noticia-single">
        <h2><?= $movie->title ?></h2>
        <p>Categoria: <?= $movie->category ?></p>
        <p><?= substr($movie->description,0,50) . "..."  ?></p>
        <a href="<?= $BASE_URL ?>notice.php?id=<?= $movie->id?>">Continue Lendo...</a>
    </div>
</div>