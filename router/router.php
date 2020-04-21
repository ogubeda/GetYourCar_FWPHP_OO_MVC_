<?php
//////
require_once ('paths.php');
require_once (UTILS . 'common.inc.php');
ob_start();
session_start();

function rountingStart() {
    $uriModule = ($_GET['page']) ? $_GET['page'] : 'home';
    $uriFunction = ($_GET['op']) ? $_GET['op'] : 'list';
    //////
    loadModule($uriModule, $uriFunction);
}// end_routingStart

function loadModule($uriModule, $uriFunction) {
    if (file_exists('resources/modules.xml')) {
        $modules = simplexml_load_file('resources/modules.xml');
        foreach ($modules as $row) {
            if ($uriModule === (String) $row -> uri) {
                $path = MODULES_PATH . $uriModule . '/controller/controller_' . $uriModule . '.class.php';
                if (file_exists($path)) {
                    require_once($path);
                    $controllerName = 'controller_' . $uriModule;
                    $controller = new $controllerName;
                    loadFunction((String) $row -> name, $controller, $uriFunction);
                }else {
                    loadError();
                }// end_else
            }// end_if
        }// end_foreach
    }else {
        loadError();
    }// end_else
}// loadModule

function loadFunction($module, $controller, $uriFunction) {
    $functions = simplexml_load_file(MODULES_PATH . $module . '/resources/functions.xml');
    $exist = false;
    //////
    foreach ($functions as $row) {
        if ($uriFunction === (String) $row -> uri) {
            $exist = true;
            $event = (String) $row -> name;
            break;
        }// end_if
    }// end_foreach
    //////
    if ($exist) {
        call_user_func(array($controller, $event));
    }else {
        loadError();
    }// end_else
}// end_loadFunction

rountingStart();