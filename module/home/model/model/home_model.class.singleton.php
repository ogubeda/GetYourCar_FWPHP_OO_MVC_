<?php
//////
class home_model {
    private $bll;
    static $_instance;
    //////
    function __construct() {
        $this -> bll = home_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function getSlider_home() {
        return $this -> bll -> getSlide_home_BLL();
    }// end_getSlider_home

    public function getCategories_home($args) {
        return $this -> bll -> getCategories_home_BLL($args);
    }// end_getCategories_home

    public function IncView_home($args) {
        return $this -> bll -> IncView_home_BLL($args);
    }// end_IncView_home
}// end_home_model