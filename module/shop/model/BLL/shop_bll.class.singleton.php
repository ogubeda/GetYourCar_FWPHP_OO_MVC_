<?php
//////
class shop_bll {
    private $dao;
    static $_instance;
    //////
    function __construct() {
        $this -> dao = shop_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function getInfo_shop_BLL($args) {
        return $this -> dao -> selectShop($args[0], $args[1]);
    }// end_getInfo_shop

    public function getFilters_shop_BLL() {
        $colsArr = array('brand', 'seats', 'doors', 'typeEngine', 'gearShift');
        $returnArrBrands = array();
        foreach ($colsArr as $row) {
            $returnArrBrands[$row] = $this -> dao -> selectFilter($row);
        }//end_foreach
        if (!empty($returnArrBrands)) {
            return json_encode($returnArrBrands);
        }// end_if
        return 'Empty.';
    }// end_getFilters_shop_BLL

    public function getCountProds_shop_BLL() {
        return $this -> dao -> countProds();
    }// end_getCountProds_shop_BLL

    public function filter_shop_BLL($args) {
        return $this -> dao -> filterShop($args[0], $args[1], $args[2]);
    }// end_filter_shop_BLL

    public function getCarDetails_shop_BLL($args) {
        return $this -> dao -> selectDetails($args);
    }// end_getCarDetails_shop_BLL

    public function getAllConc_shop_BLL() {
        return $this -> dao -> selectAllCon();
    }// end_getAllConc_shop_BLL

    public function setViewUpCars_shop_BLL($args) {
        return $this -> dao -> viewUpCar($args);
    }// end_setViewUpCars_shop_BLL

    public function getUserFavs_shop_BLL($args) {
        return $this -> dao -> selectFavs($args);
    }// end_getUserFavs_shop_BLL

    public function setUserFav_shop_BLL($args) {
        if ($this -> dao -> checkCarFav($args[0], $args[1]) -> getResolve() > 0) {
            return $this -> dao -> deleteFav($args[0], $args[1]);
        }// end_if
        return $this -> dao -> insertFav($args[0], $args[1]);
    }//
}// end_shop_bll