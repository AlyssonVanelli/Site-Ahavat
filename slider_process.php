<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Carousel.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");
  require_once("dao/CarouselDAO.php");

  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $carouselDao = new carouselDAO($conn, $BASE_URL);

  // Resgata o tipo do formulário
  $type = filter_input(INPUT_POST, "type");

  // Resgata dados do usuário
  $userData = $userDao->verifyToken();

  if($type === "create") {

    // Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");

    $carousel = new Carousel();

    // Validação mínima de dados
    if(!empty($title) && !empty($description)) {

      $carousel->title = $title;
      $carousel->description = $description;
      $carousel->users_id = $userData->id;

      // Upload de imagem do filme
      if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        // Checando tipo da imagem
        if(in_array($image["type"], $imageTypes)) {

          // Checa se imagem é jpg
          if(in_array($image["type"], $jpgArray)) {
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
          } else {
            $imageFile = imagecreatefrompng($image["tmp_name"]);
          }

          // Gerando o nome da imagem
          $imageName = $carousel->imageGenerateName();

          imagejpeg($imageFile, "./img/slide/" . $imageName, 100);

          $carousel->image = $imageName;

        } else {

          $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

        }

      }

      $carouselDao->create($carousel);

    } else {

      $message->setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");

    }
}