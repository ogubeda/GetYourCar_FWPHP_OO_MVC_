<?php
//////
session_start();
class controller_cart {
    function list() {
        common::loadView('topPageCheckOut.php', VIEW_PATH_CART . 'list.html');
    }// end_list
}// end_controller_cart