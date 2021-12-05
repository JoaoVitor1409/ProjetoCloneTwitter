<?php

    namespace App;

    use MF\Init\Bootstrap; // Require

    class Route extends Bootstrap{
        
        protected function initRoutes(){
            $routes['home'] = array(
                'route' => '/',
                'controller' => 'indexController',
                'action' => 'index'
            );

            $routes['inscreverse'] = array(
                'route' => '/inscreverse',
                'controller' => 'indexController',
                'action' => 'inscreverse'
            );

            $routes['registrar'] = array(
                'route' => '/registrar',
                'controller' => 'indexController',
                'action' => 'registrar'
            );

            $routes['autenticar'] = array(
                'route' => '/autenticar',
                'controller' => 'AuthController',
                'action' => 'autenticar'
            );

            $routes['sair'] = array(
                'route' => '/sair',
                'controller' => 'AuthController',
                'action' => 'sair'
            );

            $routes['timeline'] = array(
                'route' => '/timeline',
                'controller' => 'AppController',
                'action' => 'timeline'
            );

            $routes['tweet'] = array(
                'route' => '/tweet',
                'controller' => 'AppController',
                'action' => 'tweet'
            );

            $routes['quemSeguir'] = array(
                'route' => '/quemSeguir',
                'controller' => 'AppController',
                'action' => 'quemSeguir'
            );

            $routes['pesquisa'] = array(
                'route' => '/pesquisa',
                'controller' => 'AppController',
                'action' => 'pesquisa'
            );

            $routes['deletar'] = array(
                'route' => '/deletar',
                'controller' => 'AppController',
                'action' => 'deletar'
            );

            $routes['seguir'] = array(
                'route' => '/seguir',
                'controller' => 'AppController',
                'action' => 'seguir'
            );

            $routes['deixarSeguir'] = array(
                'route' => '/deixarSeguir',
                'controller' => 'AppController',
                'action' => 'deixarSeguir'
            );

            $this->setRoutes($routes);  
        }        
    }
?>