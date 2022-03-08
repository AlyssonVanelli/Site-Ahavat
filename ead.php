<?php
  require_once("templates/header.php");

  require_once("models/Aluno.php");
  require_once("dao/AlunoDAO.php");


  $user = new Aluno();
  $userDao = new AlunoDAO($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

  $fullName = $user->getFullName($userData);


?>

<div id="main-container" class="container-fluid">
  <h2>EAD</h2>
</div>

<?php
  require_once("templates/footer.php");
?>