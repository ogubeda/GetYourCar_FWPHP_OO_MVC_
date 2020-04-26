<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
//////
include ($path . 'module/shop/model/DAOShop.php');
include ($path . 'module/shop/model/DAOFav.php');
//////
session_start();

class controller_shop {
    function list() {
        loadView(VIEW_PATH_INC . 'topPageShop.php', VIEW_PATH_SHOP . 'list.html');
    }// end_list

    function sendInfo() {
        $querys = new QuerysShop();
        $selShop = $querys -> selectShop($_POST['totalItems'], $_POST['itemsPage']);
        //////
        if (!empty($selShop -> getResolve())) {
            echo json_encode($selShop -> getResolve());
        }else {
            echo $selShop -> getError();
        }// end_else
    }// sendInfo

    function read() {
        $querys = new QuerysShop();
        $selReadShop = $querys -> selectDetails($_POST['carPlate']);
        //////
        if (!empty($selReadShop -> getResolve())) {
            echo json_encode($selReadShop -> getResolve());
        }else {
            echo $selReadShop -> getError();
        }// end_else
    }// end_read

    function sendFilters() {
        $querys = new QuerysShop();
        $selFilter = $querys -> selectFilter();
        if (!empty($selFilter)) {
            echo json_encode($selFilter);
        }else {
            echo 'error';
        }// end_else
    }// end_sendFilters

    function countProd() {
        //////
        $querys = new QuerysShop();
        $select = 'SELECT count(*) prods FROM allCars';
        //////
        if ($_GET['filters']) {
            $mountQuery = $querys -> mountQuery(json_decode($_GET['filters'], true));
            $select = $select . $mountQuery;
        }// end_if
        //////
        $countProd = $querys -> selectSingle($select);
        //////
        if (!empty($countProd)) {
            echo json_encode($countProd);
        }else {
            echo 'error';
        }// end_else
    }// end_countProd

    function filter() {
        $querys = new QuerysShop();
        $selCarFilter = $querys -> filterShop(json_decode($_GET['param'], true), $_POST['totalItems'], $_POST['itemsPage']);
        //////
        if (!empty($selCarFilter -> getResolve())) {
            echo json_encode($selCarFilter -> getResolve());
        }else {
            echo $selCarFilter -> getError();
        }// end_else
    }// end_filter

    function sendAllCon() {
        $querys = new QuerysShop();
        $selAllCon = $querys -> selectMultiple('SELECT * FROM concessionaire');
        if (!empty($selAllCon)) {
            echo json_encode($selAllCon);
        }else {
            echo 'error';
        }// end_else
    }// end_sendAllCon

    function viewUp() {
        $querys = new QuerysShop();
        $viewUp = $querys -> selectBoolean('UPDATE allCars SET views = views + 1 WHERE carPlate = "' . $_POST['carPlate'] . '"');
        //////
        echo $viewUp;
    }// end_viewUp

    function sendFavs() {
        $querysFav = new QuerysFav();
        $favs = $querysFav -> selectFavs();
        //////
        if (!empty($favs -> getResolve())) {
            echo json_encode($favs -> getResolve());
        }else {
            echo $favs -> getError();
        }// end_else
    }// end_sendFavs

    function updateFavs() {
        $querysFav = new QuerysFav();
        $check = $querysFav -> checkCar($_POST['carPlate']);
        $result = $querysFav -> processFav($_POST['carPlate'], $check);
        //////
        if ($result['resolve']) {
            echo json_encode($result['func']);
        }else {
            echo 'error';
        }// end_else
    }// end_updateFavs
}// end_controller_shop