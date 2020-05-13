<?php
//////
class profile_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstace

    function selectFavs($username) {
        //////
        return db::query() -> select(['carPlate', 'brand', 'model', 'image'], 'allCars') 
                            -> join([['userFav' => 'carPlate', 'allCars' => 'carPlate']], 'INNER')
                            -> where(['userFav.username' => [$username]]) 
                            -> execute() 
                            -> queryToArray(true) -> toJSON() -> getResolve();
    }// end_selectFavs
    //////

    function selectUser($username) {
        //////
        return db::query() -> select(['username', 'email', 'registerDate', 'avatar'], 'users') -> where(['id_user' => [$username]]) -> execute() -> queryToArray() -> toJSON() -> getResolve();
    }// end_selectUser
    //////

    function deleteUser($username) {
        //////
        return db::query() -> delete('users') -> where(['id_user' => [$username]]) -> execute() -> toJSON() -> getResolve(); 
    }// end_deleteUserç

    function selectPurchases($username) {
        return db::query() -> select(['*'], 'purchases')
                            -> join([['allCars' => 'carPlate', 'purchases' => 'carPlate']], 'INNER') 
                            -> where(['username' => [$username]]) 
                            -> execute() -> queryToArray(true) -> toJSON() -> getResolve(); 
    }// end_selectPurchases
}// end_profile_dao