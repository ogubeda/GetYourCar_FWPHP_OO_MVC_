<?php
//////
session_start();
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'module/login/model/activity/processingSession.php');
//////
class controller_login {
    function list() {
        common::loadView('topPageLogIn.php', VIEW_PATH_LOGIN . 'logIn.html');
    }// end_list

    function register() {
        $result = common::accessModel('login_model', 'registerUserClient_login', [$_POST['username'], $_POST['email'], $_POST['password']]);
        $email = [];
        //////
        if ($result['query'] != false) {
            $email = ['type' => 'validate', 'token' => $result['token'], 'toEmail' => $_POST['email']];
            $sendedEmail = json_decode(mail::setEmail($email), true);
        }// end_if
        if (!empty($sendedEmail['id'])) {
            echo json_encode('Done');
            return;
        }// end_if
        echo 'fail';
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

    function sendRecoverEmail() {
        $result = common::accessModel('login_model', 'verifyUser_login', $_POST['username']);
        $email = [];
        if ($result != false) {
            $email = ['type' => 'recover', 'token' => $result['token'], 'toEmail' => $result['email']];
            $sendedEmail = json_decode(mail::setEmail($email), true);
        }// end_if
        if (!empty($sendedEmail['id'])) {
            echo json_encode('Done!');
            return;
        }// end_if
        echo 'Fail';
    }// end_recoverPassword

    function checkTokenRecover() {
        echo common::accessModel('login_model', 'checkRecoverToken_login', $_POST['token']);
    }// end_checkTokenRecover

    function updatePassword() {
        echo common::accessModel('login_model', 'setUserNewPassword_login', [$_POST['password'], $_SESSION['token']]);
    }// end_updatePassword

    function validateEmail() {
        echo common::accessModel('login_model', 'verifyUserEmail_login', $_POST['token']);
    }// end_validateEmail
}// end_controller_login