<?php

        $db_name = "ahavat chessed";
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "";
      
        $conn = new PDO("mysql:dbname=". $db_name .";host=". $db_host, $db_user, $db_pass);
        $conn2 = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
      
        // Habilitar erros PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);