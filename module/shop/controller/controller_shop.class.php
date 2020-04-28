<?php
//////
session_start();

class controller_shop {
    function list() {
        loadView(VIEW_PATH_INC . 'topPageShop.php', VIEW_PATH_SHOP . 'list.html');
    }// end_list

    function sendInfo() {
        echo accessModel('shop_model', 'getInfo_shop', [$_POST['totalItems'], $_POST['itemsPage']]) -> getResolve();
    }// sendInfo

    function read() {
        echo accessModel('shop_model', 'getCarDetails_shop', $_POST['carPlate']) -> getResolve();
    }// end_read

    function sendFilters() {
        echo accessModel('shop_model', 'getFilters_shop');
    }// end_sendFilters

    function countProd() {
        echo accessModel('shop_model', 'getCountProds_shop') -> getResolve();
    }// end_countProd

    function filter() {
        echo accessModel('shop_model', 'filter_shop', [json_decode($_GET['param'], true), $_POST['totalItems'], $_POST['itemsPage']]) -> getResolve();
    }// end_filter

    function sendAllCon() {
        echo accessModel('shop_model', 'getAllConc_shop') -> getResolve();
    }// end_sendAllCon

    function viewUp() {
        echo accessModel('shop_model', 'setViewUpCars_shop', $_POST['carPlate']);
    }// end_viewUp

    function sendFavs() {
        echo accessModel('shop_model', 'getUserFavs_shop', $_SESSION['user']) -> getResolve();
    }// end_sendFavs

    function updateFavs() {
        if (isset($_SESSION['user'])) {
            echo accessModel('shop_model', 'setUserFav_shop', [$_POST['carPlate'], $_SESSION['username']]);
        }// end_if
        echo 'no-login';
    }// end_updateFavs
}// end_controller_shop