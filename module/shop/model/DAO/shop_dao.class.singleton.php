<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
//////
include ($path . 'model/DAOGeneral.php');
include ($path . 'model/DB.php');
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

    public function selectFilter() {
        //////
        $colsArr = array('brand', 'seats', 'doors', 'typeEngine', 'gearShift');
        $returnArrBrands = array();
        foreach ($colsArr as $row) {
            $returnArrBrands[$row] = DB::query() -> select([$row], 'allCars', true) -> order([$row]) -> execute() -> queryToArray(true) -> getResolve();
        }//end_foreach
        //////
        return $returnArrBrands;
    }// end_selectFilter

    public function selectShop($totalItems, $itemsPage) {
        return DB::query() -> select(['carPlate', 'brand', 'model', 'image', 'price'], 'allCars') 
                            -> order(['views'], 'DESC') -> limit($itemsPage, $totalItems) -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectShop

    public function countProds() {
        return DB::query() -> select(['*'], 'allCars') -> execute() -> count() -> toJSON();
    }// end_countProds

    public function filterShop($filters, $totalItems, $itemsPage) {
        return DB::query() -> select(['carPlate', 'brand', 'model', 'image', 'price'], 'allCars') 
                            -> where($filters) -> limit($itemsPage, $totalItems) -> execute() -> queryToArray(true) -> toJSON();
    }// end_filterShop

    public function selectDetails($carPlate) {
        return DB::query() -> select(['*'], 'allCars') -> where(['carPlate' => [$carPlate]]) -> execute() -> queryToArray() -> toJSON();    
    }// end_selectDetails

    public function selectAllCon() {
        return DB::query() -> select(['*'], 'concessionaire') -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectAllCon

    public function viewUpCar($carPlate) {
        return DB::query() -> update(['views' => 'views + 1'], 'allCars') -> where(['carPlate' => [$carPlate]]) -> execute() -> toJSON();
    }// end_viewUpCar

    public function checkCarFav($carPlate, $username) {
        return DB::query() -> select(['*'], 'userFav') -> where(['username' => [$username], 'carPlate' => [$carPlate]]) -> execute() -> count();
    }// end_checkCar
 
    public function insertFav($carPlate, $username) {
        return DB::query() -> insert([['carPlate' => $carPlate, 'username' => $username]], 'userFav') -> execute() -> toJSON();
    }// end_inserFav

    public function deleteFav($carPlate, $username) {
        return DB::query() -> delete('userFav') -> where(['carPlate' => [$carPlate], 'username' => [$username]]) -> execute() -> toJSON();
    }// end_deleteFav

    public function selectFavs($username) {
        return DB::query() -> select(['*'], 'userFav') -> where(['username' => [$username]]) -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectFavs

}// end_QuerysShop