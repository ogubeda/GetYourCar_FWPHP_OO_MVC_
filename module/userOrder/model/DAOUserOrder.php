<?php
//////
$path  = $_SERVER['DOCUMENT_ROOT'] . "/frameworkCars.v.1.3/";
//////
include ($path . "/model/Connect.php");
include ($path . 'model/DB.php');
//////
class QuerysUser {
    //////
    function selectUserOrder() {
        return DB::query() -> select(['carPlate', 'brand', 'model','gearShift', 'typeEngine'], 'allCars') -> execute() -> queryToArray(true);
    }// end_selectUserOrder
}
