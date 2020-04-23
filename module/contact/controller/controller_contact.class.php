<?php
//////
session_start();
//////
class controller_contact {
    function __construct() {
        $_SESSION['module'] = "contact";
    }// end_construct

    function list() {
        require (VIEW_PATH_INC . 'topPageContact.php');
        require (VIEW_PATH_INC . 'menu.html');
        require (VIEW_PATH_CONTACT . 'contactus.html');
        require (VIEW_PATH_INC . 'content.html');
    }// end_list

    function sendEmail() {
        $messageAdmin = ['type' => 'admin', 
                            'inputName' => $_POST['name'], 
                            'fromEmail' => $_POST['email'], 
                            'inputMatter' => $_POST['matter'], 
                            'inputMessage' => $_POST['message']];
        $messageClient = ['type' => 'contact', 
                            'toEmail' => $_POST['email'], 
                            'inputMatter' => '', 
                            'inputMessage' => ''];
        $emailAdmin = json_decode(setEmail($messageAdmin), true);
        //////
        if (!empty($emailAdmin['id'])) {
            $emailClient = json_decode(setEmail($messageClient), true);
            if (!empty($emailClient['id'])) {
                echo json_encode('Done!');
                //////
                return;
            }// end_if
        }// end_if
        echo 'error';
    }// end_sendEmail
}// end_controller_contact