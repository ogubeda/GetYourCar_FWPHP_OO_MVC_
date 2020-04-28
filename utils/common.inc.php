<?php
//////
function loadError() {
    require_once (VIEW_PATH_INC . 'topPageHome.php');
    require_once (VIEW_PATH_INC . 'menu.html');
    require_once (VIEW_PATH_INC . 'error404.html');
    require_once (VIEW_PATH_INC . 'content.html');
}// end_loadError

function loadView($topPage, $view) {
    if ((file_exists($topPage)) && (file_exists($view))) {
        require_once ($topPage);
        require_once (VIEW_PATH_INC . 'menu.html');
        require_once ($view);
        require_once (VIEW_PATH_INC . 'content.html');
    }else {
        loadError();
    }// end_else
}// end_loadView

function accessModel($model, $function = null, $args = null) {
    $dir = explode('_', $model);
    $path = constant('MODEL_PATH_' . strtoupper($dir[0])) .  $model . '.class.singleton.php';
    if (file_exists($path)) {
        require_once ($path);
        if (method_exists($model, $function)) {
            $obj = $model::getInstance();
            if ($args != null) {
                return call_user_func(array($obj, $function), $args);
            }// end_if
            return call_user_func(array($obj, $function));
        }// end_if
    }// end_if
    //////
    throw new Exception();
}// end_accessModel