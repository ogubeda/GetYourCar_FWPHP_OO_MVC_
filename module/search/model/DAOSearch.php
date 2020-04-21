<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'model/DAOGeneral.php');
include ($path . 'model/DB.php');
//////
class QuerysSearch {
    function multiple($query) {
        // $query = DAOGeneral::query($query);
        // $retrArr = array();
        // //////
        // if (mysqli_num_rows($query['query']) > 0) {
        //     while ($row = mysqli_fetch_assoc($query['query'])) {
        //         $retrArr[] = $row;
        //     }// end_while
        // }// end_if
        // //////
        // return $retrArr;
        return DB::query() -> manual($query) -> execute() -> queryToArray(true);
    }// end_multiple
}// end_QuerysSearch