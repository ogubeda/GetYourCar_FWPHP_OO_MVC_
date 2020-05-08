<?php
//////
class shop_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function selectFilter($args) {
        return db::query() -> select([$args], 'allCars', true) -> order([$args]) -> execute() -> queryToArray(true) -> getResolve();
    }// end_selectFilter

    public function selectShop($totalItems, $itemsPage) {
        return db::query() -> select(['carPlate', 'brand', 'model', 'image', 'price'], 'allCars') 
                            -> order(['views'], 'DESC') -> limit($itemsPage, $totalItems) -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectShop

    public function countProds() {
        return db::query() -> select(['*'], 'allCars') -> execute() -> count() -> toJSON();
    }// end_countProds

    public function filterShop($filters, $totalItems, $itemsPage) {
        return db::query() -> select(['carPlate', 'brand', 'model', 'image', 'price'], 'allCars') 
                            -> where($filters) -> limit($itemsPage, $totalItems) -> execute() -> queryToArray(true) -> toJSON();
    }// end_filterShop

    public function selectDetails($carPlate) {
        return db::query() -> select(['*'], 'allCars') -> where(['carPlate' => [$carPlate]]) -> execute() -> queryToArray() -> toJSON();    
    }// end_selectDetails

    public function selectAllCon() {
        return db::query() -> select(['*'], 'concessionaire') -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectAllCon

    public function viewUpCar($carPlate) {
        return db::query() -> update(['views' => 'views + 1'], 'allCars') -> where(['carPlate' => [$carPlate]]) -> execute() -> toJSON();
    }// end_viewUpCar

    public function checkCarFav($carPlate, $username) {
        return db::query() -> select(['*'], 'userFav') -> where(['username' => [$username], 'carPlate' => [$carPlate]]) -> execute() -> count();
    }// end_checkCar
 
    public function insertFav($carPlate, $username) {
        return db::query() -> insert([['carPlate' => $carPlate, 'username' => $username]], 'userFav') -> execute() -> toJSON() -> getResolve();
    }// end_inserFav

    public function deleteFav($carPlate, $username) {
        return db::query() -> delete('userFav') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute() -> toJSON() -> getResolve();
    }// end_deleteFav

    public function selectFavs($username) {
        return db::query() -> select(['*'], 'userFav') -> where(['username' => [$username]]) -> execute() -> queryToArray(true) -> toJSON() -> getResolve();
    }// end_selectFavs

}// end_QuerysShop