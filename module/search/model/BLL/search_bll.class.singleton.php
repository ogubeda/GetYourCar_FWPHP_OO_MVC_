<?php
//////
class search_bll {
    static $_instance;
    private $dao;
    //////
    function __construct() {
        $this -> dao = search_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_of
        return self::$_instance;
    }// end_getInstance

    public function getProvinces_search_BLL() {
        return $this -> dao -> selectProvinces();
    }// end_getProvinces_search_bll

    public function getConc_search_BLL($args = null) {
        if ($args != null) {
            return $this -> dao -> selectConcesionaireArgs($args);
        }// end_if
        return $this -> dao -> selectConcesionaire();
    }// end_getConc_search_BLL

    public function getAutoComplete_search_BLL($args) {
        if (!empty($args[1])) {
            return $this -> dao -> autoCompleteConBrand($args[0], $args[1]);
        }else if (!empty($args[2]) && (empty($args[1]))) {
            return $this -> dao -> autoCompleteProvinceBrand($args[0], $args[2]);
        }else {
            return $this -> dao -> autoCompleteBrand($args[0]);
        }// end_else
    }// end_getAutoComplete_BLL
}// end_search_bll