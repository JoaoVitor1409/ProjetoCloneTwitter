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
            $query = "SELECT u.UsuarioNome, us.UsuarioIDSeguidor, t.TweetID, t.Tweet,
            DATE_FORMAT(t.TweetData, '%d/%m/%Y %H:%i') as 'TweetData'
            FROM
            usuario u INNER JOIN ususeguidores us ON u.UsuarioID = us.UsuarioIDSeguidor
            INNER JOIN tweet t ON us.UsuarioIDSeguidor = t.UsuarioID
            WHERE us.UsuarioID = :Pid"; 

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Pid", $this->__get("userId"));            
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function delete(){
            $query = "DELETE FROM Tweet WHERE TweetID = :PTweetId";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":PTweetId", $this->__get("id"));
            $stmt->execute();     
        }


        public function qtdTweets(){
            $query = "SELECT COUNT(tweetID) as qtd FROM tweet WHERE UsuarioID = :PuserId";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":PuserId", $this->__get("userId"));            
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function qtdFollows(){
            $query = "SELECT COUNT(UsuarioIDSeguidor) as qtd FROM usuSeguidores WHERE UsuarioID = :PuserId";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":PuserId", $this->__get("userId"));            
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function qtdFollowers(){
            $query = "SELECT COUNT(UsuarioIDSeguidor) as qtd FROM usuSeguidores WHERE UsuarioIDSeguidor = :PuserId";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":PuserId", $this->__get("userId"));            
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }