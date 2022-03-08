<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");
  require_once("dao/AlunoDAO.php");

  $message = new Message($BASE_URL);

  $flassMessage = $message->getMessage();

  if(!empty($flassMessage["msg"])) {
    // Limpar a mensagem
    $message->clearMessage();
  }

  $userDao = new UserDAO($conn, $BASE_URL);

  $userData = $userDao->verifyToken(false);

  $alunoDao = new AlunoDAO($conn, $BASE_URL);

  $alunoData = $alunoDao->verifyToken(false);


?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ahavat Chessed</title>
  <link rel="short icon" href="<?= $BASE_URL ?>img/moviestar.ico" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <!-- CSS do projeto -->
  <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>
<body>
  <header>
    <nav id="main-navbar" class="navbar navbar-expand-lg">
      <a href="<?= $BASE_URL ?>" class="navbar-brand">
        <img src="<?= $BASE_URL ?>img/logo.png" alt="AhavatChessed" id="logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav">
            <?php if($alunoData): ?>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>index.php" class="nav-link">Inicio</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>sobre.php" class="nav-link">Sobre</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>estudos.php" class="nav-link">Estudos</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>videos.php" class="nav-link">Videos</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>contribua.php" class="nav-link">Contribua</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>contato.php" class="nav-link">Fale Conosco</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>ead.php" class="nav-link bold">
                <p>Aluno: <?= $alunoData->name ?></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair</a>
            </li>
            <?php elseif($userData): ?>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>newnotice.php" class="nav-link">
                <i class="far fa-plus-square"></i> Nova Publicação
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>newstudy.php" class="nav-link">
                <i class="far fa-plus-square"></i> Novo Estudo
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>newvideo.php" class="nav-link">
                <i class="far fa-plus-square"></i> Novo Video
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>newslide.php" class="nav-link">
                <i class="far fa-plus-square"></i> Novo Slide
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>index.php" class="nav-link">Inicio</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>sobre.php" class="nav-link">Sobre</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>estudos.php" class="nav-link">Estudos</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>videos.php" class="nav-link">Videos</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>contribua.php" class="nav-link">Contribua</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>contato.php" class="nav-link">Fale Conosco</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>aluno.php" class="nav-link">EAD</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold">
                <?= $userData->name ?>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>index.php" class="nav-link">Inicio</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>sobre.php" class="nav-link">Sobre</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>estudos.php" class="nav-link">Estudos</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>videos.php" class="nav-link">Videos</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>contribua.php" class="nav-link">Contribua</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>contato.php" class="nav-link">Fale Conosco</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>aluno.php" class="nav-link">EAD</a>
            </li>
            <?php endif;?>
        </ul>
      </div>
      <form action="<?= $BASE_URL ?>search.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
        <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Search">
        <button class="btn my-2 my-sm-0" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </nav>
  </header>
  <?php if(!empty($flassMessage["msg"])): ?>
    <div class="msg-container">
      <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
    </div>
  <?php endif; ?>