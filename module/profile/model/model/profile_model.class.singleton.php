<?php
//////
class profile_model {
    static $_instance;
    private $bll;
    //////
    function __construct() {
        $this -> bll = profile_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function getFavsUser_profile($args) {
        return $this -> bll -> getFavsUser_profile_BLL($args);
    }// end_getFavsUser_profile

    public function getUserData_profile($args) {
        return $this -> bll -> getUserData_profile_BLL($args);
    }// end_getUserData_profile

    public function deleteUser_profile($args) {
        return $this -> bll -> deleteUser_profile_BLL($args);
    }// end_deleteUser_profile

    public function getUserPurchases_profile($args) {
        return $this -> bll -> getUserPurchases_profile_BLL($args);
    }// end_getUserPurchases_profile
}// end_profile_model