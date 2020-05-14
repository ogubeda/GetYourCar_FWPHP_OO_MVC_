<?php
//////
class cart_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    function selectValueCart($username) {
        return db::query() -> manual("SELECT a.price, c.days, d.discount FROM allCars a INNER JOIN carts c ON a.carPlate = c.carPlate LEFT JOIN discounts d ON c.code_name = d.code_name WHERE username = '$username'") -> execute() -> queryToArray(true) -> getResolve();
    }// end_selectValueCart

    function selectUserMoney($username) {
        return db::query() -> select(['money'], 'users') -> where(['username' => [$username]]) -> execute() -> queryToArray() -> getResolve();
    }// end_selectUserMoney

    function purchaseTransaction($username, $total, $idPurchase) {
        $typedQuery = "INSERT INTO purchases (idpurchases, purchaseDate,carPlate, username, days, code_name) SELECT '$idPurchase', CURRENT_DATE, c.* FROM carts c WHERE username = '$username'";
        $transaction = db::query() -> manual($typedQuery) -> setTransaction();
        $transaction = $transaction -> update(['money' => "money - $total"], 'users') -> where(['username' => [$username]]) -> setTransaction();
        $transaction = $transaction -> delete('carts') -> where(['username' => [$username]]) -> setTransaction() -> execute(true) -> toJSON() -> getResolve();
        //////
        return $transaction;
    }// end_purchaseTransaction

    function saveCart($carPlate, $days, $username) {
        if (db::query() -> insert([['carPlate' => $carPlate, 'username' => $username, 'days' => $days, 'code_name' => 'NULL']], 'carts') -> execute() -> getResult()) {
            return db::query() -> update(['code_name' => 'NULL'], 'carts') -> where(['username' => [$username]]) -> execute() -> toJSON() -> getResolve();
        }// end_if
        return false;
    }// end_saveCart

    function getCart($cart) {
        //////
        $arrCart = array();
        foreach($cart as $row) {
            $arrCart[] = $row['carPlate'];
        }// end_foreach
        return db::query() -> select(['*'], 'allCars') -> where(['carPlate' => $arrCart]) -> execute() -> queryToArray(true) -> toJSON() -> getResolve();
    }// end_getCart

    function removeCart($carPlate, $username) {
        return db::query() -> delete('carts') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute() -> toJSON() -> getResolve();
    }// end_removeCart

    function deleteCart($username) {
        return db::query() -> delete('carts') -> where(['username' => [$username]]) -> execute();
    }// end_removeCart

    function getCheckOutData($username) {
        return db::query() -> select(['*'], 'allCars') -> join([['carts' => 'carPlate', 'allCars' => 'carPlate']], 'INNER') 
                                                        -> join([['discounts' => 'code_name', 'carts' => 'code_name']], 'LEFT')
                                                        -> where(['username' => [$username]]) -> execute() -> queryToArray(true) -> toJSON() -> getResolve();
    }// end_getCheckOutData

    function checkCartVal($carPlate, $username) {
        return db::query() -> select(['*'], 'carts') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute() -> count() -> getResolve();
    }// end_checkCartVal

    function updateDays($days, $carPlate, $username) {
        return db::query() -> update(['days' => $days], 'carts') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute() -> toJSON() -> getResolve();
    }// end_updateDays

    function printCart($username) {
        return db::query() -> select(['*'], 'carts') -> where(['username' => [$username]]) -> execute() -> queryToArray(true) -> toJSON() -> getResolve();
    }// end_printCart

    function addDiscCode($username, $discCode) {
        if (db::query() -> select(['code_name'], 'discounts') -> where(['code_name' => [$discCode]]) -> execute() -> count() -> getResolve() > 0) {
            return db::query() -> update(['code_name' => "'$discCode'"], 'carts') -> where(['username' => [$username]]) -> execute() -> toJSON() -> getResolve();
        }// end_if
        //////
        return false;
    }// end_DiscCode

    function removeDiscCode($username) {
        return db::query() -> update(['code_name' => 'NULL'], 'carts') -> where(['username' => [$username]]) -> execute() -> toJSON() -> getResolve();
    }// end_removeDiscCode
}// end_cart_dao