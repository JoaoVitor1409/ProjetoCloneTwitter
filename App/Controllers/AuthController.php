<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    Class AuthController extends Action{

        public function autenticar(){
            
            $usuario = Container::getModel("Usuario");


            $this->view->login = "";


            $usuario->__set("email", $_POST['email']);
            $usuario->__set("password", md5($_POST['password']));

            

            if($_POST['email'] == ""){
                $this->view->login = "erroE";
                header("Location: /?login=erroE");
            }elseif($_POST['password'] == ""){
                $this->view->login = "erroP";
                header("Location: /?login=erroP");
            }else{
                $usuario->autenticar();

                if($usuario->__get("id") != "" && $usuario->__get("name") != ""){
                    session_start();
                    $_SESSION['id'] = $usuario->__get("id");
                    $_SESSION['name'] = $usuario->__get("name");

                    header("Location: /timeline");
                }else{
                    $this->view->login = "erro";
                    header("Location: /?login=erro");
                }
            }
        }

        public function sair(){
            session_start();
            session_destroy();
            header("Location: /");
        }

    }