<?php
    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action{
        public function timeline(){
            session_start();
            if($_SESSION['id'] != '' && $_SESSION['nome'] != ''){
                //echo 'TIMELINE';
                //print_r($_SESSION); 
                $this->render('timeline'); 
            }else{
                header('Location: /?login=auth_error');
            }      
        }

    }
?>