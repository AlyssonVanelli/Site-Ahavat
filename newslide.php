<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("dao/UserDAO.php");
  // Verifica se usuário está autenticado
  require_once("models/Carousel.php");
  
  $carousel = new Carousel();
  $userDao = new UserDao($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

?>
  <div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
      <h1 class="page-title">Adicionar Slide</h1>
      <form action="<?= $BASE_URL ?>slider_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="type" value="create">
        <div class="form-group">
          <label for="title">Título:</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do Slide">
        </div>
        <div class="form-group">
          <label for="image">Imagem:</label>
          <input type="file" class="form-control-file" name="image" id="image">
        </div>
        <div class="form-group">
          <label for="description">Descrição:</label>
          <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o slide..."></textarea>
        </div>
        <input type="submit" class="btn card-btn" value="Adicionar Slide">
      </form>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>