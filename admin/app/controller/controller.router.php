<?php

class Router {

    private $request;

    public function __construct($request){
        $request = explode("/", $request);
        $this->request = $request[2];
    }

    public function getView(){
        
        $view = $this->request;
        switch($view){
            case '':
            case '/':
            case 'home':
                require_once './app/page/home.php';
                break;
            case 'category':
                require_once './app/page/category.php';
                break;
            case 'library':
                require_once './app/page/library.php';
                break;
            case 'locations':
                require_once './app/page/locations.php';
                break;
            case 'login':
                require_once './app/page/login.php';
                break;
            case 'logout':
                require_once './app/page/logout.php';
                break;
            case 'blog':
                require_once './app/page/blogs.php';
                break;
            case 'add-blog':
                require_once './app/page/add-blog.php';
                break;
            case 'blog-update':
                require_once './app/page/update-blog.php';
                break;

            case 'view':
                require './app/page/as-user.php';
                break;
            case 'as':
                require_once './app/page/login-as.php';
                break;

            case 'maintenance':
                require_once './app/page/maintenance.php';
                break;

            case 'users':
                require_once './app/page/user.php';
                break;

            default:
                require_once './app/page/404.php';
                break;
        }
    }
    

}