<?php

    class Carousel{

        public $id;
        public $image;
        public $title;
        public $description;

        public function imageGenerateName() {
            return bin2hex(random_bytes(60)) . ".jpg";
          }

    }

    interface CarouselDAOInterface {

        public function create(Carousel $carousel);

    }