<?php
//////
session_start();
//////
class controller_contact {
    function __construct() {
        $_SESSION['module'] = "contact";
    }// end_construct

    function list() {
        require (VIEW_PATH_INC . 'topPageContact.html');
        require (VIEW_PATH_INC . 'menu.html');
        require (VIEW_PATH_CONTACT . 'contactus.html');
        require (VIEW_PATH_INC . 'content.html');
    }// end_list

    function sendEmail() {
        echo json_encode('holis');
    }// end_sendEmail
}// end_controller_contact