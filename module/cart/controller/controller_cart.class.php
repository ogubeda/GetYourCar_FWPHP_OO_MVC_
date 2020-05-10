<?php
//////
session_start();
class controller_cart {
    function list() {
        common::loadView('topPageCheckOut.php', VIEW_PATH_CART . 'list.html');
    }// end_list

    function storeCart() {
        if (!empty($_POST['carPlate']) && !empty($_POST['JWT'])) {
            echo common::accessModel('cart_model', 'storeCartUser_cart', [$_POST['carPlate'], $_POST['JWT'], $_SESSION['JWT_Secret'], $_POST['days']]);
        }else {
            echo 'no-login';
        }// end_else
    }// end_storeCart

    function getCart() {
        echo common::accessModel('cart_model', 'getNoLogUser_cart', $_POST['cart']);
    }// end_getCart

    function removeCart() {
        if ((!empty($_POST['JWT'])) && (isset($_SESSION['JWT_Secret']))) {
            echo common::accessModel('cart_model', 'removeUser_cart', [$_POST['carPlate'], $_POST['JWT'], $_SESSION['JWT_Secret']]);
        }else {
            echo json_encode(false);
        }// end_else
    }// end_removeCart

    function loadDataCart() {
        if ((!empty($_POST['JWT'])) && (isset($_SESSION['JWT_Secret']))) {
            echo common::accessModel('cart_model', 'getCheckOutData_cart', [$_POST['JWT'], $_SESSION['JWT_Secret']]);
        }else {
            echo 'no-login';
        }// end_else
    }// end_loadDataCart

    function updateDays() {
        if ((!empty($_POST['JWT'])) && (isset($_SESSION['JWT_Secret']))) {
            echo common::accessModel('cart_model', 'setDays_cart', [$_POST['days'], $_POST['carPlate'], $_POST['JWT'], $_SESSION['JWT_Secret']]);
        }else {
            echo 'no-login';
        }// end_else
    }// end_updateDays

    function checkOut() {
        if ((!empty($_POST['JWT'])) && (isset($_SESSION['JWT_Secret']))) {
            echo common::accessModel('cart_model', 'checkOut_cart', [$_POST['JWT'], $_SESSION['JWT_Secret']]);
        }else {
            echo json_encode('false');
        }// end_else
    }// end_checkOut

    function selectCart() {
        if ((!empty($_POST['JWT'])) && (isset($_SESSION['JWT_Secret']))) {
            echo common::accessModel('cart_model', 'getDataPrint_cart', [$_POST['JWT'], $_SESSION['JWT_Secret']]);
        }else {
            echo json_encode('false');
        }// end _false
    }// end_selectCart

    function addDiscCode() {
        if ((!empty($_POST['JWT'])) && (isset($_SESSION['JWT_Secret']))) {
            echo common::accessModel('cart_model', 'setDiscount_cart', [$_POST['JWT'], $_SESSION['JWT_Secret'], $_POST['code']]);
        }else {
            echo 'no-login';
        }// end_else
    }// end_addDiscCode

    function removeDiscCode() {
        if ((!empty($_POST['JWT'])) && (isset($_SESSION['JWT_Secret']))) {
            echo common::accessModel('cart_model', 'removeDiscount_cart', [$_POST['JWT'], $_SESSION['JWT_Secret'], $_POST['code']]);
        }else {
            echo 'no-login';
        }// end_else
    }// end_removeDiscCode
}// end_controller_cart