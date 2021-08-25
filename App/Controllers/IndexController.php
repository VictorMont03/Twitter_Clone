<?php
    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;


    class IndexController extends Action{
        public function index(){
            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
            $this->render('index');
        }

        public function inscreverse(){
            $this->view->user = array(
                'nome' => '',
                'email' => '',
                'senha' => ''
            );
            $this->view->erroCadastro = false;
            $this->render('inscreverse'); 
        }

        public function registrar(){
           

            $user = Container::getModels('User');
            $user->__set('nome', $_POST['nome']);
            $user->__set('email', $_POST['email']);
            $user->__set('senha', $_POST['senha']);
            
            //print_r($user);

            if($user->validate()) {
                if(count($user->getUserPorEmail()) == 0){
                    $user->create();
                    $this->render('cadastro');
                }else{
                    $this->view->erroCadastro = true;
                    $this->render('inscreverse');
                }
            }else{
                $this->view->user = array(
                    'nome' => $_POST['nome'],
                    'email' => $_POST['email'],
                    'senha' => $_POST['senha']
                );
                $this->view->erroCadastro = true;
                $this->render('inscreverse');
            }      
        }
    }
?>