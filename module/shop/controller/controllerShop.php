<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
//////
include ($path . 'module/shop/model/DAOShop.php');
include ($path . 'module/shop/model/DAOFav.php');
//////
$querys = new QuerysShop();
$querysFav = new QuerysFav();
session_start();

switch ($_GET['op']) {
    case 'list';
        include ('module/shop/view/list.html');
        break;
        //////
    case 'sendInfo';
        $selShop = $querys -> selectShop($_POST['totalItems'], $_POST['itemsPage']);
        //////
        if (!empty($selShop -> getResolve())) {
            echo json_encode($selShop -> getResolve());
        }else {
            echo $selShop -> getError();
        }// end_else
        break;
        //////
    case 'read';
        $selReadShop = $querys -> selectDetails($_GET['carPlate']);
        //////
        if (!empty($selReadShop -> getResolve())) {
            echo json_encode($selReadShop -> getResolve());
        }else {
            echo $selReadShop -> getError();
        }// end_else
        break;
        //////
    case 'sendFilters';
        $selFilter = $querys -> selectFilter();
        if (!empty($selFilter)) {
            echo json_encode($selFilter);
        }else {
            echo 'error';
        }// end_else
        break;
        //////
    case 'sendAllCon';
        $selAllCon = $querys -> selectMultiple('SELECT * FROM concessionaire');
        if (!empty($selAllCon)) {
            echo json_encode($selAllCon);
        }else {
            echo 'error';
        }// end_else
        break;
        //////
    case 'filter';
        $selCarFilter = $querys -> filterShop(json_decode($_GET['filters'], true), $_POST['totalItems'], $_POST['itemsPage']);
        //////
        if (!empty($selCarFilter -> getResolve())) {
            echo json_encode($selCarFilter -> getResolve());
        }else {
            echo $selCarFilter -> getError();
        }// end_else
        break;
        //////
    case 'viewUp';
        $viewUp = $querys -> selectBoolean('UPDATE allCars SET views = views + 1 WHERE carPlate = "' . $_POST['carPlate'] . '"');
        //////
        echo $viewUp;
        break;
        //////
    case 'countProd';
        //////
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
        break;
        //////
    case 'sendFavs';
        $favs = $querysFav -> selectFavs();
        //////
        if (!empty($favs -> getResolve())) {
            echo json_encode($favs -> getResolve());
        }else {
            echo $favs -> getError();
        }// end_else
        break;
        //////
    case 'updateFavs';
        $check = $querysFav -> checkCar($_POST['carPlate']);
        $result = $querysFav -> processFav($_POST['carPlate'], $check);
        //////
        if ($result['resolve']) {
            echo json_encode($result['func']);
        }else {
            echo 'error';
        }// end_else
        break;
        //////
    default;
        include ('view/inc/error404.html');
        break;
}// end_switch