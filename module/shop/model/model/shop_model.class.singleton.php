<?php
//////
class shop_model {
    private $bll;
    static $_instance;
    //////
    private function __construct() {
        $this -> bll = shop_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function getInfo_shop($args) {
        return $this -> bll -> getInfo_shop_BLL($args);
    }// end_getInfo_shop

    public function getFilters_shop() {
        return $this -> bll -> getFilters_shop_BLL();
    }// end_getFilters_shop

    public function getCountProds_shop() {
        return $this -> bll -> getCountProds_shop_BLL();
    }// end_getCountProds_shop

    public function filter_shop($args) {
        return $this -> bll -> filter_shop_BLL($args);
    }// end_filter_shop

    public function getCarDetails_shop($args) {
        return $this -> bll -> getCarDetails_shop_BLL($args);
    }// end_getCartDetails_shop

    public function getAllConc_shop() {
        return $this -> bll -> getAllConc_shop_BLL();
    }// end_getAllConc_shop

    public function setViewUpCars_shop($args) {
        return $this -> bll -> setViewUpCars_shop_BLL($args);
    }// end_setViewUpCars_shop

    public function getUserFavs_shop($args) {
        return $this -> bll -> getUserFavs_shop_BLL($args);
    }// end_getUserFavs_shop

    public function setUserFav_shop($args) {
        return $this -> bll -> setUserFav_shop_BLL($args);
    }// end_setUserFav_shop
}// end_shop_model