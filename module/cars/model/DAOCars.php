<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . "model/DAOGeneral.php");
class Querys {
    //////
    function select() {
        //////
        $select = "SELECT * FROM allCars";
        $res = DAOGeneral::query($select);
        $arrCarPlates = array();
        //////
        if (mysqli_num_rows($res['query']) > 0) {
            while ($row = mysqli_fetch_assoc($res['query'])) {
                $arrCarPlates[] = $row;
            }// end_while
        }// end_if
        //////
        return $arrCarPlates;
    }// end_select
    //////

    function selectOne($carPlate) {
        //////
        $select = 'SELECT * FROM allCars WHERE carPlate ="' . $carPlate . '"';
        $res = DAOGeneral::query($select);
        $car = array();
        //////
        if (mysqli_num_rows($res['query']) > 0) {
            $car = mysqli_fetch_assoc($res['query']);
        }// end_if
        return $car;
    }// end_selectOne
    //////

    function insert($car) {
        //////
        $roads = "";
        $done = false;
        $error = "";
        $connection = Connect::enable();
        foreach($car['exitRoads'] as $row){
            $roads = $roads  . "$row:";
        }// end_foreach
        if ($car['extras'] == "yes") {
            $extras = "Yes";
        }else {
            $extras = "No";
        }// end_else
        $price = 100 * ($car['seats'] + $car['doors']);
        $insertSQL = "INSERT INTO allCars (carPlate, idCon, brand, model, seats, doors, gearShift, typeEngine, cv, maxSpeed, roads, extras, startDate, endDate, views, price)
            VALUES ('$car[carPlate]', '$car[idCon]','$car[brand]', '$car[model]', '$car[seats]', '$car[doors]', '$car[gearShift]', 
            '$car[typeEngine]','$car[powerCV]', '$car[maxSpeed]', '$roads', '$extras', '$car[startDate]', '$car[endDate]', 0, $price);";
        if (mysqli_query($connection, $insertSQL)) {
            $done = true;
        }else {
            $error = mysqli_error($connection);
        }// end_else
        Connect::close($connection);
        //////
        return array('done' => $done, 'error' => $error);
    }// end_insert
    //////
    /////

    function delete($carPlate) {
        $done = false;
        $error = "";
        $connection = Connect::enable();
        $deleteSQL = "DELETE FROM allCars WHERE carPlate = '$carPlate'";
        if (mysqli_query($connection, $deleteSQL)){
            $done = true;
        }else {
            $error = mysqli_error($connection);
        }
        Connect::close($connection);
        //////
        return array('done' => $done, 'error' => $error);
    }// end_delete
    //////

    function deleteAll() {
        //////
        $connection = Connect::enable();
        $deleteAll = "DELETE FROM allCars";
        $deleteAllSQL = mysqli_query($connection, $deleteAll);
        Connect::close($connection);
        //////
        return $deleteAllSQL;
    }// end_deleteAll

    function update($car, $plate) {
        //////
        $roads = "";
        $done = false;
        $error = "";
        $connection = Connect::enable();
        foreach($car['exitRoads'] as $row){
            $roads = $roads  . "$row:";
        }// end_foreach
        if ($car['extras'] == "yes") {
            $extras = "Yes";
        }else {
            $extras = "No";
        }// end_else
        $price = 100 * ($car['seats'] + $car['doors']);
        $updateSQL = "UPDATE allCars SET carPlate = '$car[carPlate]', idCon = '$car[idCon]', brand = '$car[brand]', model = '$car[model]', seats = '$car[seats]', doors = '$car[doors]', 
                gearShift = '$car[gearShift]', typeEngine = '$car[typeEngine]', cv = '$car[powerCV]', maxSpeed = '$car[maxSpeed]', roads = '$roads',
                extras = '$extras', startDate = '$car[startDate]', endDate = '$car[endDate]', price = $price WHERE carPlate = '$plate'";
        if (mysqli_query($connection, $updateSQL)) {
            $done = true;
        }else {
            $error = mysqli_error($connection);
        }
        Connect::close($connection);
        //////
        return array('done' => $done, 'error' => $error);
    }
}// end_Querys
