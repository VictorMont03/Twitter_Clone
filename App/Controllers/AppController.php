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

        public function validateUser(){
            session_start();
            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
                header('Location: /?login=auth_error');
            }
        }

    }
?>