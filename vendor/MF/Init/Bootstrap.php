<?php
    namespace MF\Init;

    abstract class Bootstrap{
        private $routes;

        public function __construct(){
            $this->initRoutes();
            $this->run($this->getURL());
        }

        abstract protected function initRoutes();

        public function getRoutes(){
            return $this->routes;
        }

        public function setRoutes(array $routes){
            $this->routes = $routes;
        }

        public function run($url){
            //echo $url;
            forEach($this->getRoutes() as $key => $route){
                if($url == $route['route']){
                    $class = "App\\Controllers\\".ucfirst($route['controller']);// App/Controllers/IndexController dinamico
                    $controller = new $class;
                    $action = $route['action'];
                    $controller->$action();

                }
            }
        }

        public function getURL(){
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);//, PHP_URL_PATH - string do path
        }
    }
?>