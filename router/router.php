<?php
//////
require_once ('paths.php');
include (UTILS . 'common.inc.php');
include (UTILS . 'mail.inc.php');
ob_start();
session_start();

function rountingStart() {
    $uriModule = ($_GET['page']) ? $_GET['page'] : 'home';
    $uriFunction = ($_GET['op']) ? $_GET['op'] : 'list';
    //////
    try {
        call_user_func(array(loadModule($uriModule), loadFunction($uriModule, $uriFunction)));
    }catch(Exception $e) {
        loadError();
    }// end_catch
}// end_routingStart

function loadModule($uriModule) {
    if (file_exists('resources/modules.xml')) {
        $modules = simplexml_load_file('resources/modules.xml');
        foreach ($modules as $row) {
            if ($uriModule === (String) $row -> uri) {
                $path = MODULES_PATH . $uriModule . '/controller/controller_' . $uriModule . '.class.php';
                if (file_exists($path)) {
                    require_once($path);
                    $controllerName = 'controller_' . $uriModule;
                    return new $controllerName;
                }// end_if
            }// end_if
        }// end_foreach
    }// end_if
    throw new Exception('Not Module found.');
}// loadModule

function loadFunction($module, $uriFunction) {
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

rountingStart();