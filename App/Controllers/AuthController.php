<?php
    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AuthController extends Action{
        public function autenticar(){
            $user = Container::getModels('User');
            $user->__set('email', $_POST['email']);
            $user->__set('senha', $_POST['senha']);

           $user->autenticar();
        
            if(!empty($user->__get('id')) && !empty($user->__get('nome'))){
                session_start();
                $_SESSION['id'] = $user->__get('id');
                $_SESSION['nome'] = $user->__get('nome');

                header('Location: /timeline');
            }else{
                header('Location: /?login=auth_error');
            }
        }

        public function sair(){
            session_start();
            session_destroy();
            header('Location: /');
        }
    }
?>