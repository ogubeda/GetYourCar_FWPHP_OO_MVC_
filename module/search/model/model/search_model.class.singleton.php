<?php
//////
class search_model {
    static $_instance;
    private $bll;
    //////
    function __construct() {
        $this -> bll = search_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function getProvinces_search() {
        return $this -> bll -> getProvinces_search_BLL();
    }// end_getProvinces_search

    public function getConc_search($args = null) {
        return $this -> bll -> getConc_search_BLL($args);
    }// end_getConc_search

    public function getAutoComplete_search($args) {
        return $this -> bll -> getAutoComplete_search_BLL($args);
    }// end_getAutoComplete_search
}// end_search_model