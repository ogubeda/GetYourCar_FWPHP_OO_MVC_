<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . "/frameworkCars.v.1.3/";

//////
include ($path . "module/userOrder/model/DAOUserOrder.php");

//////
$rdyQuery = new QuerysUser();
switch ($_GET['op']) {
    //////
    case 'list';
        include ("module/userOrder/view/listUserOrder.html");
        break;
    case 'userOrder';
        $userOrderSel = $rdyQuery -> selectUserOrder();
        if (!empty($userOrderSel -> getResolve())) {
            echo json_encode($userOrderSel -> getResolve());
        }else {
            echo $userOrderSel -> getError();
        }// end_else
        break;
    default;
        include ("view/inc/error404.html");
        break;
}// end_switch