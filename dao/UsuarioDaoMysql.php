<?php

require_once "models/Usuario.php";

class UsuarioDaoMysql implements UsuarioDao{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function addUsuario(Usuario $u){
        $sql = $this->pdo->prepare("INSERT into usuarios (nome, email) VALUES (:nome, :email)");
        $sql->bindValue(':nome', $u->getNome());
        $sql->bindValue(':email', $u->getEmail());
        $sql->execute();

        $u->setId($this->pdo->lastInsertId());
        return $u;
    }


    public function findAll(){
         $array = [];

         $sql = $this->pdo->query('SELECT * from usuarios');

         if($sql->rowCount() > 0){
             $data = $sql->fetchAll();

             foreach($data as $item){
                 $u = new Usuario();
                 $u->setNome($item['nome']);
                 $u->setEmail($item['email']);
                 $u->setId($item['id']);

                 $array[] = $u;

             }

             return $array;
             //var_dump($array);

         }
     }


     public function findEmail($email){
         $sql = $this->pdo->prepare("SELECT * from usuarios where email = :email");
         $sql->bindValue(':email', $email);
         $sql->execute();

         if($sql->rowCount() > 0){
             $data = $sql->fetch();

             $u = new Usuario();
             $u->setId($data['id']);
             $u->setNome($data['nome']);
             $u->setEmail($data['email']);

             return $u;
         }else{
             return false;
         }

     }


     public function findId($id){
         $sql= $this->pdo->prepare("SELECT * from usuarios where id = :id");
         $sql->bindValue(':id', $id);
         $sql->execute();

         if($sql->rowCount() > 0){
             $data = $sql->fetch();

             $u = new Usuario();
             $u->setId($data['id']);
             $u->setNome($data['nome']);
             $u->setEmail($data['email']);

             return $u;
         }else{
             return false;
         }

         
     }

     public function updateUsuario(Usuario $u){
         $sql = $this->pdo->prepare("UPDATE usuarios SET nome= :nome, email = :email where id=:id");

         $sql->bindValue(':id', $u->getId());
         $sql->bindValue(':nome', $u->getNome());
         $sql->bindValue(':email', $u->getEmail());
         $sql->execute();

         return true;

     }

     public function deleteUsuario($id){
        $sql = $this->pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
     }

}

?>