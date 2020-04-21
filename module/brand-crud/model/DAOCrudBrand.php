<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'model/DAOGeneral.php');
include ($path . 'model/DB.php');
//////
class QuerysBrand {
    //////
    function selectInfo() {
        return DB::query() -> select('*', 'brandCars') -> execute() -> queryToArray();
    }// end_selectInfo
}// end_QuerysBrand