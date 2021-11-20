<?php

    namespace App\Models;

    use MF\Model\Model;

    Class Tweet extends Model{
        private $id;
        private $userId;
        private $tweet;
        private $date;

        public function __get($attribute){
            return $this->$attribute;
        }

        public function __set($attribute, $value){
            $this->$attribute = $value;
        }

        public function save(){
            $query = "INSERT INTO Tweet(UsuarioID, Tweet) VALUES(:puserId, :ptweet)";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":puserId", $this->__get("userId"));
            $stmt->bindValue(":ptweet", $this->__get("tweet"));
            $stmt->execute();

            return $this;
        }

        public function getAll(){
            $query = "SELECT T.TweetID, T.UsuarioID, T.Tweet, U.UsuarioNome, DATE_FORMAT(TweetData, '%d/%m/%Y') as TweetData
            FROM Tweet T LEFT JOIN Usuario U on U.UsuarioID=T.UsuarioID WHERE UsuarioID = :puserId"; 

            $stmt = $this->db->prepare($query);            
            $stmt->bindValue(":puserId", $this->__get("userId"));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }