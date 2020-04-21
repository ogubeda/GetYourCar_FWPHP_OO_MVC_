<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . '/module/brand-crud/model/DAOCrudBrand.php');
//////
$querys = new QuerysBrand();
switch ($_GET['op']) {
    case 'list';
        include ('module/brand-crud/view/list.html');
        break;
        //////
    case 'sendInfo';
        $infoBrand = $querys -> selectInfo();
        //////
        if (!empty($infoBrand -> getResolve())) {
            echo json_encode($infoBrand -> getResolve());
        }else {
            echo 'error';
        }// end_else
        break;
    case 'create';
        break;
        //////
    case 'read';
        break;
        //////
    case 'update';
        break;
        //////
    case 'delete';
        break;
        //////
    default;
        include ('view/inc/error404.html');
        break;
        //////
}// end_switch
