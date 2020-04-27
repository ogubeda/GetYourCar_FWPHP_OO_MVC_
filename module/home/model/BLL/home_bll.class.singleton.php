<?php
//////
require_once(SITE_ROOT . 'module/home/model/DAO/home_dao.class.singleton.php');
class home_bll {
    private $dao;
    static $_instance;

    private function __construct() {
        $this -> dao = home_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function getSlide_home_BLL() {
        return $this -> dao -> selectSlide();
    }// end_getSlide_home_BLL

    public function getCategories_home_BLL($args) {
        return $this -> dao -> selectCategories($args[0], $args[1]);
    }// end_getCategories_home_BLL

    public function IncView_home_BLL($args) {
        return $this -> dao -> incView($args);
    }// end_if
}// end_home_bll