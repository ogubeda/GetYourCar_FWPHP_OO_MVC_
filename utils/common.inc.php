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