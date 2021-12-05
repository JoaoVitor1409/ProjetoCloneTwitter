<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;
    class IndexController extends Action{

        public function index(){
            $this->validaAutenticacao();
            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
            $this->render('index');            
        }

        public function inscreverse(){
            $this->validaAutenticacao();
            $this->view->erroCampos = false; 
            $this->view->erroEmail = false; 
            $this->render('inscreverse');                     
        }

        public function registrar(){
            $this->validaAutenticacao();
            
            $usuario = Container::getModel("Usuario");

            $usuario->__set("name", $_POST['name']);
            $usuario->__set("email", $_POST['email']);
            $usuario->__set("password", md5($_POST['password']));

            if($usuario->validarCadastro()){
                if(count($usuario->getUsuarioPorEmail()) == 0){
                    $usuario->save();
                    $this->render('cadastro');
                }else{
                    $this->view->erroCampos = false;
                    $this->view->erroEmail = true;
                    $this->render('inscreverse');
                }
            }else{
                $this->view->erroCampos = true;
                $this->view->erroEmail = false;
                $this->render('inscreverse');
            }            
        }
        
        public function validaAutenticacao(){
            session_start();
            if(isset($_SESSION['id'])){
                header("Location: /timeline");
            }
        }
    }