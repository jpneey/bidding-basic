<?php

class Router {

    /**
     * Render Current View
     * Based on $_SERVER["QUERY_STRING"].
     * Convert $_SERVER["QUERY_STRING"] to Array 
     * of Views and assign base $view based on
     * the first value in the array of views.
     */
    
    public function renderPage() {

        $view = 'home';

        if(isset($_SERVER["QUERY_STRING"])) {
            $uri = explode("/", $_SERVER["QUERY_STRING"]);
            $view = isset($uri[0]) && !empty($uri[0]) ? $uri[0] : 'index';
        }

        return $this->getPage($view);
    }

    public function getPage($pageTitle = '404') {

        require_once 'include/include.import.php';

        if($pageTitle == "i=1") {
            require_once './page/index.php';
            return;
        }
        
        if(file_exists("./page/".$pageTitle.".php")) {
            require_once './page/'.$pageTitle.'.php';
            return;
        }
        
        $pageTitle = $pageTitle.' - Not Found'; 
        require_once  './page/404.php';
        return;
    }

    public function loadView($view){
        $view = "./view/view".$view.".php";
        if(file_exists($view)) {
            require_once $view;
            return;
        }
        return '<b>Unable to load requested view</b>';
    }

}