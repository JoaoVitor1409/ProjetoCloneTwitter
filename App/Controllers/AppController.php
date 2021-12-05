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
            $this->view->qtdTweets = $tweet->qtdTweets();
            $this->view->qtdFollows = $tweet->qtdFollows();
            $this->view->qtdFollowers = $tweet->qtdFollowers();

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

        public function quemSeguir(){
            $this->validaAutenticacao();

            $tweet = Container::getModel("Tweet");
            $tweet->__set("userId", $_SESSION['id']);
            $this->view->qtdTweets = $tweet->qtdTweets();
            $this->view->qtdFollows = $tweet->qtdFollows();
            $this->view->qtdFollowers = $tweet->qtdFollowers();

            $this->render("quemSeguir");
        }

        public function pesquisa(){
            session_start();
            $user = Container::getModel("Usuario");
            $user->__set("name", $_POST['name']);
            $users[] = [
                'logado' => $_SESSION['id']
            ];
            $users[] = $user->getAllUsers();

            echo json_encode($users);
        }

        public function deletar(){
            $tweet = Container::getModel("Tweet");
            $tweet->__set("id", $_POST['id']);

            $tweet->delete();
            header("Location: /timeline");
        }


        public function seguir(){
            session_start();
            $user = Container::getModel("Usuario");
            $user->__set("id", $_SESSION['id']);
            $user->__set("idFollower", $_GET['id']);            
            $user->follow();

            header("Location: /timeline");
        }

        public function deixarSeguir(){
            session_start();
            $user = Container::getModel("Usuario");
            $user->__set("id", $_SESSION['id']);
            $user->__set("idFollower", $_GET['id']);
            $user->unfollow();

            header("Location: /timeline");
        }

        public function validaAutenticacao(){
            session_start();
            if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
                header("Location: /?login=erro");
            }
        }
    }