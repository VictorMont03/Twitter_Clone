<?php
    namespace MF\Controller;

    abstract class Action{
        protected $view;

        public function __construct(){
            $this->view = new \stdClass();
        }

        protected function render($view, $layout = 'layout'){
            $this->view->page = $view;
            if(file_exists("../App/Views/".$layout.".phtml")){
               require_once "../App/Views/".$layout.".phtml";     
            }else{
                $this->content();
                echo "Internal error - ".$layout." error";
            }
            
        }

        protected function content(){
            $classAtual = get_class($this);//App//Controller//IndexController
            $classAtual = str_replace('App\\Controllers\\', '', $classAtual);//IndexController
            $classAtual = str_replace('Controller', '', $classAtual);//Index

            $classAtual = strtolower($classAtual);

            require_once "../App/Views/".$classAtual."/".$this->view->page.".phtml";
        }
    }
?>