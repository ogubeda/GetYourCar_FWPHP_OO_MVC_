<?php
//////
class QuerysFav {
    //////
    function checkCar($carPlate) {
        if (DB::query() -> select(['*'], 'userFav') -> where(['username' => [$_SESSION['username']], 'carPlate' => [$carPlate]]) -> execute() -> count() -> getResolve() > 0) {
            return true;
        }// end_if
        return false;
    }// end_checkCar
    //////

    function processFav($carPlate, $check = false) {
        //////
        $typedQuery = "INSERT INTO userFav VALUES ('$carPlate', '$_SESSION[user]')";
        $funcFav = true;
        //////
        if ($check) {
            $typedQuery = "DELETE FROM userFav WHERE carPlate = '$carPlate' AND username = '$_SESSION[user]'";
            $funcFav = false;
        }// end_if
        //////
        if (isset($_SESSION['user'])) {
            $query = DAOGeneral::booleanQuery($typedQuery);
        }// end_if
        $query['func'] = $funcFav;
        //////
        return $query;
    }// end_processFav
    //////

    function selectFavs() {
        return DB::query() -> select(['*'], 'userFav') -> where(['username' => [$_SESSION['user']]]) -> execute() -> queryToArray(true);
    }// end_selectFavs
}// end_QuerysFav