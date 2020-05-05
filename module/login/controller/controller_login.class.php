<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'module/login/model/activity/processingSession.php');
@session_start();
//////
class controller_login {
    function list() {
        common::loadView('topPageLogIn.php', VIEW_PATH_LOGIN . 'logIn.html');
    }// end_list

    function register() {
        echo common::accessModel('login_model', 'registerUserClient_login', [$_POST['username'], $_POST['email'], $_POST['password']]);
    }// end_register

    function logIn() {
        echo common::accessModel('login_model', 'accessUser_login', [$_POST['username'], $_POST['password']]);
    }// end_logIn

    function socialLogIn() {
        echo common::accessModel('login_model', 'accessUserSocial_login', $_POST['profile']);
    }// end_socialLogIn

    function returnSession() {
        echo returnUserSession();
    }// end_returnSession

    function reload() {
        updateSession(true);
        echo json_encode(md5(session_id()));
    }// end_reload

    function logOut() {
        if (session_destroy()) {
            unset($_SESSION['user']);
            unset($_SESSION['type']);
            echo json_encode('Done');
        }else {
            echo 'Error';
        }// end_else
    }// end_logOut
}// end_controller_login