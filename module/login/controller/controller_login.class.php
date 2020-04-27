<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'module/login/model/DAOLogin.php');
include ($path . 'module/login/model/activity/processingSession.php');
@session_start();
//////
// $querys = new LogInQuerys();
//////
// switch ($_GET['op']) {
//     case 'register';
//         $check = $querys -> checkKeys($_POST['username'], $_POST['email']);
//         //////
//         if ($check -> getResolve() <= 0) {
//             $registerQuery = $querys -> register($_POST['username'], $_POST['email'], $_POST['password']);
//             //////
//             $registerQuery -> getQuery();
//             if ($registerQuery -> getResult()) {
//                 echo json_encode('done');
//             }else {
//                 echo $registerQuery -> getError();
//             }// end_if
//         }else { 
//             echo 'Duplicated';
//         }// end_else
//         break;
//         //////
//     case 'logIn';
//         $getUserData = $querys -> logIn($_POST['username']);
//         if (!empty($getUserData -> getResolve())) {
//             loadSession($getUserData -> getResolve()['username'], $getUserData -> getResolve()['type'], $getUserData -> getResolve()['avatar']);
//             echo json_encode(md5(session_id()));
//         }else {
//             echo "error";
//         }// end_else
//         break;
//         //////
//     case 'returnSession';
//         echo returnUserSession();
//         break;
//         //////
//     case 'logOut';
//         if (session_destroy()) {
//             unset($_SESSION['user']);
//             unset($_SESSION['type']);
//             echo json_encode('Done');
//         }else {
//             echo 'Error';
//         }// end_else
//         break;
//         //////
//     case 'reload';
//         updateSession(true);
//         echo json_encode(md5(session_id()));
//         break;
//         //////
//     default;
//         include ("view/inc/error404.html");
//         break;
// }// end_switch

class controller_login {
    function list() {
        loadView(VIEW_PATH_INC . 'topPageLogIn.php', VIEW_PATH_LOGIN . 'logIn.html');
    }// end_list
}// end_controller_login