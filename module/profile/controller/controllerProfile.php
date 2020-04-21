<?php
//////
session_start();
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . "module/profile/model/DAOProfile.php");
//////
$querys = new DAOProfile;
//////
switch ($_GET['op']) {
    case 'list';
        include ("module/profile/view/list.html");
        break;
        //////
    case 'sendData';
        $data = $querys -> selectUser($_SESSION['user']);
        ////
        if (!empty($data -> getResolve())) {
            echo json_encode($data -> getResolve());
        }else {
            echo $data -> getError();
        }// end_else
        break;
        //////
    case 'sendUserFavs';
        $data = $querys -> selectFavs($_SESSION['user']);
        //////
        if (!empty($data -> getResolve())) {
            echo json_encode($data -> getResolve());
        }else {
            echo $data -> getError();
        }// end_else
        break;
        //////
    case 'deleteProfile';
        $data = $querys -> deleteUser($_SESSION['user']);
        //////
        if ($data -> getResult()) {
            session_destroy();
            echo json_encode('Done.');
        }else {
            echo $data -> getError();
        }// end_else
        break;
        //////
    default;
        include ("view/inc/error404.html");
        break;
}// end_switch