<?php
//////
class cart_bll {
    static $_instance;
    private $dao;
    //////
    function __construct() {
        $this -> dao = cart_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function storeCartUser_cart_BLL($args) {
        $user = json_decode(jwt_process::decode($args[1], $args[2]), true)['name'];
        if ($this -> dao -> checkCartVal($args[0], $user) <= 0) {
            return $this -> dao -> saveCart($args[0], $args[3], $user);
        }// end_if
    }// end_storeCartUser_login_BLL

    public function getNoLogUser_cart_BLL($args) {
        return $this -> dao -> getCart($args);
    }// end_getNoLogUser_cart_BLL

    public function removeUser_cart_BLL($args) {
        return $this -> dao -> removeCart($args[0], json_decode(jwt_process::decode($args[1], $args[2]), true)['name']);
    }// end_removeUser_cart_BLL

    public function getDataPrint_cart_BLL($args) {
        return $this -> dao -> printCart(json_decode(jwt_process::decode($args[0], $args[1]), true)['name']);
    }// end_getDataPrint_cart_BLL

    public function getCheckOutData_cart_BLL($args) {
        return $this -> dao -> getCheckOutData(json_decode(jwt_process::decode($args[0], $args[1]), true)['name']);
    }// end_getCheckOutData_cart_BLL

    public function setDays_cart_BLL($args) {
        return $this -> dao -> updateDays($args[0], $args[1], json_decode(jwt_process::decode($args[2], $args[3]), true)['name']);
    }// end_setDays_cart_BLL

    public function setDiscount_cart_BLL($args) {
        return $this -> dao -> addDiscCode(json_decode(jwt_process::decode($args[0], $args[1]), true)['name'], $args[2]);
    }// end_setDiscount_cart_BLL

    public function removeDiscount_cart_BLL($args) {
        return $this -> dao -> removeDiscCode(json_decode(jwt_process::decode($args[0], $args[1]), true)['name'], $args[2]);
    }// end_removeDiscount_cart_BLL

    public function checkOut_cart_BLL($args) {
        $total = 0;
        $price = 0;
        $transaction = false;
        $username = json_decode(jwt_process::decode($args[0], $args[1]), true)['name'];
        $idPurchase = "$username" . date("Ymdhis");
        //////
        $valueCart = $this -> dao -> selectValueCart($username);
        foreach($valueCart as $row) {
            $price = $row['price'] * (1 + ($row['days'] / 10 - 0.1));
            $total = $total + $price;
            $disc = $row['discount'];
        }// end_for
        if ($disc > 0) {
            $total = $total - ($total * $disc / 100);
        }// end_if
        if ($total <= $this -> dao -> selectUserMoney($username)['money']) {
            $transaction = $this -> dao -> purchaseTransaction($username, $total, $idPurchase);
        }// end_if
        return $transaction;
    }// end_checkOut_cart_BLL
}// end_cart_bll