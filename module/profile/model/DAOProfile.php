<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'model/DB.php');
//////
class DAOProfile {
    //////
    function selectFavs($username) {
        //////
        return DB::query() -> select(['carPlate', 'brand', 'model', 'image'], 'allCars') 
                            -> join([['userFav' => 'carPlate', 'allCars' => 'carPlate']], 'INNER')
                            -> where(['userFav.username' => [$username]]) 
                            -> execute() 
                            -> queryToArray();
    }// end_selectFavs
    //////

    function selectUser($username) {
        //////
        return DB::query() -> select(['username', 'email', 'registerDate', 'avatar'], 'users') -> where(['username' => [$username]]) -> execute() -> queryToArray();
    }// end_selectUser
    //////

    function deleteUser($username) {
        //////
        return DB::query() -> delete('users') -> where(['username' => [$username]]) -> execute(); 
    }// end_deleteUser
    //////
}// end_DAOProfile