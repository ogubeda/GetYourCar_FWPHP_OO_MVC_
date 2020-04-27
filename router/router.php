<?php
//////
require_once ('paths.php');
include (UTILS . 'common.inc.php');
include (UTILS . 'mail.inc.php');
ob_start();
session_start();

class router {
    private $uriModule;
    private $uriFunction;
    private $nameModule;
    //////
    function __construct() {
        $this -> uriModule = ($_GET['page']) ? $_GET['page'] : 'home';
        $this -> uriFunction = ($_GET['op']) ? $_GET['op'] : 'list';
    }// end_construct

    function rountingStart() {
        try {
            call_user_func(array($this -> loadModule($this -> uriModule), $this -> loadFunction($this -> nameModule, $this -> uriFunction)));
        }catch(Exception $e) {
            loadError();
        }// end_catch
    }// end_routingStart
    
    private function loadModule($uriModule) {
        if (file_exists('resources/modules.xml')) {
            $modules = simplexml_load_file('resources/modules.xml');
            foreach ($modules as $row) {
                //////
                if (in_array($uriModule, (Array) $row -> uri)) {
                    $path = MODULES_PATH . $row -> name . '/controller/controller_' . (String) $row -> name . '.class.php';
                    if (file_exists($path)) {
                        require_once($path);
                        $controllerName = 'controller_' . (String) $row -> name;
                        $this -> nameModule = (String) $row -> name;
                        return new $controllerName;
                    }// end_if
                }// end_if
            }// end_foreach
        }// end_if
        throw new Exception('Not Module found.');
    }// loadModule
    
    private function loadFunction($module, $uriFunction) {
        $path = MODULES_PATH . $module . '/resources/functions.xml';
        if (file_exists($path)) {
            $functions = simplexml_load_file($path);
            foreach ($functions as $row) {
                if ($uriFunction === (String) $row -> uri) {
                    return (String) $row -> name;
                }// end_if
            }// end_foreach
        }// end_if
        throw new Exception('Not Function found.');
    }// end_loadFunction
}// end_router
//////
$router = new router();
$router -> rountingStart();