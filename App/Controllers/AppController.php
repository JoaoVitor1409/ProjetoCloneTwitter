<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

Class AppController extends Action{

        public function timeline(){
            $this->validaAutenticacao();

            $tweet = Container::getModel("Tweet");
            $tweet->__set("userId", $_SESSION['id']);
            $tweets = $tweet->getAll();

            $this->view->tweets = $tweets;
            
            $this->render("timeline");         
        }

        public function tweet(){
            $this->validaAutenticacao();

            $tweet = Container::getModel("Tweet");

            $tweet->__set("tweet", $_POST['tweet']);
            $tweet->__set("userId", $_SESSION['id']);

            $tweet->save();

            header("Location: /timeline");
        }

        public function validaAutenticacao(){
            session_start();
            if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
                header("Location: /?login=erro");
            }
        }
    }