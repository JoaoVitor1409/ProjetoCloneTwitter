<?php

    namespace App\Models;

    use MF\Model\Model;

    Class Usuario extends Model{

        private $id;
        private $name;
        private $email;
        private $password;
        private $idFollower;

        public function __get($attribute){
            return $this->$attribute;
        }

        public function __set($attribute, $value){
            $this->$attribute = $value;
        }

        public function save(){
            $query = "INSERT INTO Usuario(UsuarioNome,UsuarioEmail, UsuarioSenha) VALUES(:Pname, :Pemail, :Ppassword)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':Pname', $this->__get("name"));
            $stmt->bindValue(':Pemail', $this->__get("email"));
            $stmt->bindValue(':Ppassword', $this->__get("password"));
            $stmt->execute();

            return $this;
        }

        public function validarCadastro(){
            $valido = true;

            if(mb_strlen($this->name) < 3){
                $valido = false;
            }

            if(mb_strlen($this->email) < 3){
                $valido = false;
            }

            if(mb_strlen($this->password) < 3){
                $valido = false;
            }

            return $valido;
        }

        
        public function getUsuarioPorEmail(){
            $query = "SELECT UsuarioNome, UsuarioEmail FROM Usuario WHERE UsuarioEmail = :Pemail";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Pemail", $this->__get("email"));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function autenticar(){

            $query = "SELECT UsuarioID, UsuarioNome, UsuarioEmail FROM Usuario WHERE UsuarioEmail = :pemail AND UsuarioSenha = :ppassword";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":pemail", $this->__get("email"));
            $stmt->bindValue(":ppassword", $this->__get("password"));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($usuario['UsuarioID'] != "" && $usuario['UsuarioNome'] != ""){
                $this->__set('id', $usuario['UsuarioID']);
                $this->__set('name', $usuario['UsuarioNome']);
            }

            return $this;
        }

        public function getAllUsers(){
            $query = "SELECT UsuarioID, UsuarioNome from Usuario WHERE UsuarioNome LIKE :Pname";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(":Pname", "%" . $this->__get("name") . "%");
            $stmt->execute();

            $usuarios = $stmt->fetchAll(\PDO::FETCH_ASSOC);            

            return $usuarios;
        }

        public function follow(){
            $query = "INSERT INTO UsuSeguidores(UsuarioID, UsuarioIDSeguidor) VALUES(:PId, :PIdFollower)";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":PId", $this->__get("id"));
            $stmt->bindValue(":PIdFollower", $this->__get("idFollower"));
            $stmt->execute();
        }

        public function unfollow(){
            $query = "DELETE FROM UsuSeguidores WHERE UsuarioID = :Pid AND UsuarioIDSeguidor = :PidFollower";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Pid", $this->__get("id"));
            $stmt->bindValue(":PidFollower", $this->__get("idFollower"));
            $stmt->execute();
        }
    }