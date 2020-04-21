<?php
//////
session_start();
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'module/cart/model/DAOCart.php');
//////
$querys = new DAOCart();
switch ($_GET['op']) {
    case 'list';
        include ('module/cart/view/list.html');
        break;
        //////
    case 'storeCart';
        if (!empty($_POST['carPlate']) && isset($_SESSION['user'])) {
            $check = $querys -> checkCartVal($_POST['carPlate'], $_SESSION['user']);
            if ($check -> getResolve() == 0) {
                $data = $querys -> saveCart($_POST['carPlate'], $_POST['days'], $_SESSION['user']);
            }// end_if
            if ($data -> getResult()) {
                echo json_encode('Done.');
            }else {
                echo $data -> getError();
            }// end_else
        }else {
            echo 'no-login';
        }// end_else
        break;
        //////
    case 'getCart';
        $data = $querys -> getCart($_POST['cart']);
        //////
        if (!empty($data -> getResolve())) {
            echo json_encode($data -> getResolve());
        }else {
            echo $data -> getError();
        }// end_else
        break;
        //////
    case 'removeCart';
        if (isset($_SESSION['user'])) {
            $data = $querys -> removeCart($_POST['carPlate'], $_SESSION['user']);
            if ($data -> getResult()) {
                echo json_encode(true);
            }else {
                echo $data -> getError();
            }// end_else
        }else {
            echo json_encode(false);
        }// end_else
        break;
        //////
    case 'loadDataCart';
        if (isset($_SESSION['user'])) {
            $data = $querys -> getCheckOutData($_SESSION['user']);
        }// end_if
        if (!empty($data -> getResolve())) {
            echo json_encode($data -> getResolve());
        }else {
            echo $data -> getError();
        }// end_if
        break;
        //////
    case 'updateDays';
        if (isset($_SESSION['user'])) {
            $data = $querys -> updateDays($_POST['days'], $_POST['carPlate'], $_SESSION['user']);
        }// end_if
        if ($data -> getResult()) {
            echo json_encode('Done.');
        }else {
            echo $data -> getError();
        }
        break;
        //////
    case 'checkOut';
        if (isset($_SESSION['user'])) {
            $data = $querys -> addToPurchase($_SESSION['user']);
            if ($data -> getResult()) {
                echo json_encode($data -> getResult());
            }else {
                echo $data -> getError();
            }// end_else
        }else {
            echo json_encode('false');
        }// end_else
        break;
        //////
    case 'selectCart';
        if (isset($_SESSION['user'])) {
            $data = $querys -> printCart($_SESSION['user']);
            if (!empty($data -> getResolve())) {
                echo json_encode($data -> getResolve());
            }else {
                echo $data -> getError();
            }// end_else
        }else {
            echo json_encode('false');
        }// end_else
        break;
    case 'addDiscCode';
        if (isset($_SESSION['user'])) {
            $data = $querys -> addDiscCode($_SESSION['user'], $_POST['code']);
            if ($data != false) {
                echo json_encode('Done.');
            }else {
                echo 'error';
            }// end_else
        }else {
            echo 'no-login';
        }// end_else    
        break;
        //////
    case 'removeDiscCode';
        if (isset($_SESSION['user'])) {
            $data = $querys -> removeDiscCode($_SESSION['user']);
            if ($data -> getResult()) {
                echo json_encode('Done.');
            }else {
                echo 'error';
            }// end_else
        }else {
            echo 'no-login';
        }// end_else
        break;
        //////
    default;
        include ('view/inc/error404.html');
        break;
}// end_switch