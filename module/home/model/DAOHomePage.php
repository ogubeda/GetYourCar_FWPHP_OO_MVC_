<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . "model/DB.php");
//////
class QuerysHomePage {
    //////
    function selectSlide() {
        return DB::query() -> select(['carPlate' ,'brand', 'model', 'image'], 'allCars') -> order(['cv'], 'DESC') -> limit(5) -> execute() -> queryToArray(true);
    }// end_selectSlide

    function selectBrands($itemsPage, $totalItems) {
        return DB::query() -> select(['*'], 'brandCars') -> order(['views'], 'DESC') -> limit($itemsPage, $totalItems) -> execute() -> queryToArray(true);
    }// end_selectBrands

    function incView($brand) {
        return DB::query() -> update(['views' => 'views + 1'], 'brandCars') -> where(['brand' => [$brand]]) -> execute();
    }// end_incView
}// end_QuerysHomePage