<?php

  require_once("models/Carousel.php");
  require_once("models/Message.php");

  class CarouselDAO implements CarouselDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
      $this->conn = $conn;
      $this->url = $url;
      $this->message = new Message($url);
    }

    public function buildCarousel($data) {

      $carousel = new Carousel($data);

      $carousel->id = $data["id"];
      $carousel->image = $data["image"];
      $carousel->title = $data["title"];
      $carousel->description = $data["description"];

      return $carousel;

    }

    public function create(Carousel $carousel, $authUser = false) {

      $image = $_FILES["image"]['name'];
      $path = 'images/' . $image;

      $stmt = $this->conn->prepare("INSERT INTO carousel(
          image, title, description
        ) VALUES (
          :image, :title, :description
        )");

      $stmt->bindParam(":image", $carousel->image);
      $stmt->bindParam(":title", $carousel->title);
      $stmt->bindParam(":description", $carousel->description);

      $stmt->execute();

      // Mensagem de sucesso por adicionar Slider
      $this->message->setMessage("Slide adicionada com sucesso!", "success", "index.php");

    }

    public function getLatestSliders() {

      $carousel = [];

      $stmt = $this->conn->query("SELECT * FROM carousel ORDER BY id DESC");

      $stmt->execute();

      if($stmt->rowCount() > 0) {

        $carouselArray = $stmt->fetchAll();

        foreach($carouselArray as $carousel) {
          $carousel[] = $this->buildCarousel($carousel);
        }

      }

      return $carousel;

    }

  }