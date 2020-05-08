<?php
//////
class login_model {
    static $_instance;
    private $bll;
    //////
    function __construct() {
        $this -> bll = login_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function registerUserClient_login($args) {
        return $this -> bll -> registerUserClient_login_BLL($args);
    }// end_registerUserClient

    public function accessUser_login($args) {
        return $this -> bll -> accessUser_login_BLL($args);
    }// end_accessUser_login

    public function accessUserSocial_login($args) {
        return $this -> bll -> accessUserSocial_login_BLL($args);
    }// end_accessUserSocial_login

    public function verifyUser_login($args) {
        return $this -> bll -> verifyUser_login_BLL($args);
    }// end_verifyUser_login

    public function checkRecoverToken_login($args) {
        return $this -> bll -> checkRecoverToken_login_BLL($args);
    }// end_checkRecoverToken_login

    public function setUserNewPassword_login($args) {
        return $this -> bll -> setUserNewPassword_login_BLL($args);
    }// end_setUserNewPassword_login

    public function verifyUserEmail_login($args) {
        return $this -> bll -> verifyUserEmail_login_BLL($args);
    }// end_verifyUserEmail_login

    public function getUserData_login($args) {
        return $this -> bll -> getUserData_login_BLL($args);
    }// end_getUserData_login
}// end_login_model