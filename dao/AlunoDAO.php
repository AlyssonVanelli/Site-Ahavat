<?php

  require_once("models/Aluno.php");
  require_once("models/Message.php");

  class AlunoDAO implements AlunoDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
      $this->conn = $conn;
      $this->url = $url;
      $this->message = new Message($url);
    }

    public function buildUser($data) {

      $aluno = new Aluno();

      $aluno->id = $data["id"];
      $aluno->name = $data["name"];
      $aluno->lastname = $data["lastname"];
      $aluno->email = $data["email"];
      $aluno->password = $data["password"];
      $aluno->token = $data["token"];

      return $aluno;

    }

    public function create(Aluno $aluno, $authUser = false) {

      $stmt = $this->conn->prepare("INSERT INTO alunos(
          name, lastname, email, password, token
        ) VALUES (
          :name, :lastname, :email, :password, :token
        )");

      $stmt->bindParam(":name", $aluno->name);
      $stmt->bindParam(":lastname", $aluno->lastname);
      $stmt->bindParam(":email", $aluno->email);
      $stmt->bindParam(":password", $aluno->password);
      $stmt->bindParam(":token", $aluno->token);

      $stmt->execute();

      // Autenticar usuário, caso auth seja true
      if($authUser) {
        $this->setTokenToSession($aluno->token);
      }

    }

    public function update(Aluno $aluno, $redirect = true) {

      $stmt = $this->conn->prepare("UPDATE alunos SET
        name = :name,
        lastname = :lastname,
        email = :email,
        token = :token
      ");

      $stmt->bindParam(":name", $aluno->name);
      $stmt->bindParam(":lastname", $aluno->lastname);
      $stmt->bindParam(":email", $aluno->email);
      $stmt->bindParam(":token", $aluno->token);

      $stmt->execute();

      if($redirect) {

        // Redireciona para o perfil do usuario
        $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");

      }

    }

    public function verifyToken($protected = false) {

      if(!empty($_SESSION["token"])) {

        // Pega o token da session
        $token = $_SESSION["token"];

        $aluno = $this->findByToken($token);

        if($aluno) {
          return $aluno;
        } else if($protected) {

          // Redireciona usuário não autenticado
          $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");

        }

      } else if($protected) {

        // Redireciona usuário não autenticado
        $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");

      }

    }

    public function setTokenToSession($token, $redirect = true) {

      // Salvar token na session
      $_SESSION["token"] = $token;

      if($redirect) {

        // Redireciona para o perfil do usuario
        $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

      }

    }

    public function authenticateUser($email, $password) {

      $aluno = $this->findByEmail($email);

      if($aluno) {

        // Checar se as senhas batem
        if(password_verify($password, $aluno->password)) {

          // Gerar um token e inserir na session
          $token = $aluno->generateToken();

          $this->setTokenToSession($token, false);

          // Atualizar token no usuário
          $aluno->token = $token;

          $this->update($aluno, false);

          return true;

        } else {
          return false;
        }

      } else {

        return false;

      }

    }

    public function findByEmail($email) {

      if($email != "") {

        $stmt = $this->conn->prepare("SELECT * FROM alunos WHERE email = :email");

        $stmt->bindParam(":email", $email);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

          $data = $stmt->fetch();
          $aluno = $this->buildUser($data);
          
          return $aluno;

        } else {
          return false;
        }

      } else {
        return false;
      }

    }

    public function findById($id) {

      if($id != "") {

        $stmt = $this->conn->prepare("SELECT * FROM alunos WHERE id = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

          $data = $stmt->fetch();
          $aluno = $this->buildUser($data);
          
          return $aluno;

        } else {
          return false;
        }

      } else {
        return false;
      }
    }

    public function findByToken($token) {

      if($token != "") {

        $stmt = $this->conn->prepare("SELECT * FROM alunos WHERE token = :token");

        $stmt->bindParam(":token", $token);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

          $data = $stmt->fetch();
          $aluno = $this->buildUser($data);
          
          return $aluno;

        } else {
          return false;
        }

      } else {
        return false;
      }

    }

    public function destroyToken() {

      // Remove o token da session
      $_SESSION["token"] = "";

      // Redirecionar e apresentar a mensagem de sucesso
      $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");

    }

    public function changePassword(Aluno $aluno) {

      $stmt = $this->conn->prepare("UPDATE alunos SET
        password = :password
        WHERE id = :id
      ");

      $stmt->bindParam(":password", $aluno->password);
      $stmt->bindParam(":id", $aluno->id);

      $stmt->execute();

      // Redirecionar e apresentar a mensagem de sucesso
      $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");

    }

  }