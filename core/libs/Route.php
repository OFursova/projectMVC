<?php
namespace Core\Libs;
use Core\Views\View;

use Core\Controllers\MainController;
use Core\Libs\Exceptions\NotFoundException;

class Route {
    public static $page;

    public static function start(){
        self::$page = $_GET['page'] ?? '/';
        $routes = require __DIR__.'/../web.php';

        $isRouteFound = false;
        foreach ($routes as $pattern => $controllerAndMethod) {
            preg_match('~^'.$pattern.'$~', self::$page, $matches);
            if(!empty($matches)){
                $isRouteFound = true;
                break;
            }
        }
        
        if ($isRouteFound){
            list($nameController, $nameMethod) = explode('@', $controllerAndMethod);
            if (file_exists('core/controllers/'.$nameController.'.php')) {
                //require 'core/controllers/'.$nameController.'.php'; // switching off due to autoload in index.php
                $pathController = 'Core\\Controllers\\'.$nameController;
                $controller = new $pathController();
                if (method_exists($controller, $nameMethod)) {
                    unset($matches[0]);

                    $controller->$nameMethod(...$matches);
                } else {
                    echo 'Method not found';
                }
            } else {
                echo 'FILE not found';
            }
        } else {
            throw new NotFoundException();
        }
    }

    public static function getPage(){
        return self::$page;
    }
}