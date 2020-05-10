<?php
//////
class cart_model {
    static $_instance;
    private $bll;
    //////
    function __construct() {
        $this -> bll = cart_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function storeCartUser_cart($args) {
        return $this -> bll -> storeCartUser_cart_BLL($args);
    }// end_storeCartUser_cart

    public function getNoLogUser_cart($args) {
        return $this -> bll -> getNoLogUser_cart_BLL($args);
    }// end_getNoLogUser_cart

    public function removeUser_cart($args) {
        return $this -> bll -> removeUser_cart_BLL($args);
    }// end_removeUser_cart

    public function getDataPrint_cart($args) {
        return $this -> bll -> getDataPrint_cart_BLL($args);
    }// end_getDataPrint_cart

    public function getCheckOutData_cart($args) {
        return $this -> bll -> getCheckOutData_cart_BLL($args);
    }// end_getCheckOutData_cart

    public function setDays_cart($args) {
        return $this -> bll -> setDays_cart_BLL($args);
    }// end_setDays_cart

    public function setDiscount_cart($args) {
        return $this -> bll -> setDiscount_cart_BLL($args);
    }// end_setDiscount_cart

    public function removeDiscount_cart($args) {
        return $this -> bll -> removeDiscount_cart_BLL($args);
    }// end_removeDiscount_cart

    public function checkOut_cart($args) {
        return $this -> bll -> checkOut_cart_BLL($args);
    }// end_checkOut_cart
}// end_cart_model