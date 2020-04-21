<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'model/DB.php');
//////
class DAOCart {
    //////
    function addToPurchase($username) {
        //////
        $total = 0;
        $price = 0;
        //////
        $idPurchase = "$username" . date("Ymdhis");
        $cartValue = "SELECT a.price, c.days, d.discount FROM allCars a INNER JOIN carts c ON a.carPlate = c.carPlate LEFT JOIN discounts d ON c.code_name = d.code_name WHERE username = '$username'";
        $typedQuery = "INSERT INTO purchases (idpurchases, purchaseDate,carPlate, username, days, code_name) SELECT '$idPurchase', CURRENT_DATE, c.* FROM carts c WHERE username = '$username'";
        //////
        $valueMoney = DB::query() -> select(['money'], 'users') -> where(['username' => [$username]]) -> execute() -> queryToArray();
        $valueCart = DB::query() -> manual($cartValue) -> execute() -> queryToArray(true);
        //////
        foreach($valueCart -> getResolve() as $row) {
            $price = $row['price'] * (1 + ($row['days'] / 10 - 0.1));
            $total = $total + $price;
            $disc = $row['discount'];
        }// end_for
        if ($disc > 0) {
            $total = $total - ($total * $disc / 100);
        }// end_if
        if ($total <= $valueMoney -> getResolve()['money']) {
            $values = DB::query() -> manual($typedQuery) -> execute();
            if ($values -> getResult()) {
                $credit = $valueMoney -> getResolve()['money'] - $total;
                DB::query() -> update(['money' => $credit], 'users') -> where(['username' => [$username]]) -> execute();
                DB::query() -> delete('carts') -> where(['username' => [$username]]) -> execute();
            }// end_if
        }// end_if
        //////
        return $values;
    }// end_addToPurchase
    //////

    function saveCart($carPlate, $days, $username) {
        if (DB::query() -> insert([['carPlate' => $carPlate, 'username' => $username, 'days' => $days, 'code_name' => 'NULL']], 'carts') -> execute() -> getResult()) {
            return DB::query() -> update(['code_name' => 'NULL'], 'carts') -> where(['username' => [$username]]) -> execute();
        }// end_if
        return false;
    }// end_saveCart
    //////

    function getCart($cart) {
        //////
        $arrCart = array();
        foreach($cart as $row) {
            $arrCart[] = $row['carPlate'];
        }// end_foreach
        return DB::query() -> select(['*'], 'allCars') -> where(['carPlate' => $arrCart]) -> execute() -> queryToArray(true);
    }// end_getCart
    //////

    function removeCart($carPlate, $username) {
        return DB::query() -> delete('carts') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute();
    }// end_removeCart

    function deleteCart($username) {
        return DB::query() -> delete('carts') -> where(['username' => [$username]]) -> execute();
    }// end_removeCart
    //////

    function getCheckOutData($username) {
        return DB::query() -> select(['*'], 'allCars') -> join([['carts' => 'carPlate', 'allCars' => 'carPlate']], 'INNER') 
                                                        -> join([['discounts' => 'code_name', 'carts' => 'code_name']], 'LEFT')
                                                        -> where(['username' => [$username]]) -> execute() -> queryToArray(true);
    }// end_getCheckOutData
    //////

    function checkCartVal($carPlate, $username) {
        return DB::query() -> select(['*'], 'carts') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute() -> count();
    }// end_checkCartVal
    //////

    function updateDays($days, $carPlate, $username) {
        return DB::query() -> update(['days' => $days], 'carts') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute();
    }// end_updateDays
    //////

    function printCart($username) {
        return DB::query() -> select(['*'], 'carts') -> where(['username' => [$username]]) -> execute() -> queryToArray(true);
    }// end_printCart
    //////

    function addDiscCode($username, $discCode) {
        if (DB::query() -> select(['code_name'], 'discounts') -> where(['code_name' => [$discCode]]) -> execute() -> count() -> getResolve() > 0) {
            return DB::query() -> update(['code_name' => "'$discCode'"], 'carts') -> where(['username' => [$username]]) -> execute();
        }// end_if
        //////
        return false;
    }// end_DiscCode
    //////

    function removeDiscCode($username) {
        return DB::query() -> update(['code_name' => 'NULL'], 'carts') -> where(['username' => [$username]]) -> execute();
    }// end_removeDiscCode
}// endDAOCart