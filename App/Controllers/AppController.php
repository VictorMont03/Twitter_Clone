<?php
    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action{
        public function timeline(){
           $this->validateUser();
            //echo 'TIMELINE';
            //print_r($_SESSION); 
            $tweet = Container::getModels('Tweet');
            $tweets = $tweet->read();
            $this->view->tweets = $tweets;
            $this->render('timeline'); 
               
        }

        public function tweet(){
           $this->validateUser();
                //print_r($_POST); 
            $tweet = Container::getModels('Tweet');
            $tweet->__set('tweet', $_POST['tweet']);
            $tweet->__set('id_usuario', $_SESSION['id']);
            
            $tweet->create();
            header('Location: /timeline');
            
        }

        public function quem_seguir(){
            $this->validateUser();
           
            //print_r($_GET);
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            $users = array();
            if($pesquisa != ''){
                $usuario = Container::getModels('User');
                $usuario->__set('nome', $pesquisa);
                $searchResult = $usuario->getAll();
                $users = $searchResult;
            }

            $this->view->users = $users;
            $this->render('quemSeguir');
        }

        public function acao(){
            $this->validateUser();

            print_r($_GET);

            $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
            $id_follow = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

            $usuario = Container::getModels('User');
            $usuario->__set('id', $_SESSION['id']);

            if($acao == 'seguir'){
                $usuario->followUser($id_follow);
            }
            if($acao == 'deixar_de_seguir'){
                $usuario->unfollowUser($id_follow);
            }

            header("Location: /quem_seguir");

              
        }

        public function validateUser(){
            session_start();
            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
                header('Location: /?login=auth_error');
            }
        }

        

    }
?>