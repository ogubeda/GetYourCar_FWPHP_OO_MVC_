<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . "/frameworkCars.v.1.3/";
//////
include ($path . 'module/home/model/DAOHomePage.php');
//////
class controller_home {
    function __construct() {
        $_SESSION['module'] = "home";
    }// end_construct

    function list() {
        loadView(VIEW_PATH_INC . 'topPageHome.php', VIEW_PATH_HOME . 'homepage.html');
    }// end_list

    function homePageSlide() {
        $homeQuery = new QuerysHomePage();
        $selSlide = $homeQuery -> selectSlide();
        if (!empty($selSlide -> getResolve())) {
            echo json_encode($selSlide -> getResolve());
        }else {
            echo $selSlide -> getError();
        }// end_else
    }// end_homePageSlide

    function homePageCat() {
        $homeQuery = new QuerysHomePage();
        $selCatBrand = $homeQuery -> selectBrands($_POST['loaded'], $_POST['items']);
        if (!empty($selCatBrand -> getResolve())) {
            echo json_encode($selCatBrand -> getResolve());
        }else{
            echo $selCatBrand -> getError();
        }// end_else
    }// end_homePageCat

    function incrementView() {
        $homeQuery = new QuerysHomePage();
        $viewUp = $homeQuery -> incView($_POST['brand']);
        //////
        echo $viewUp -> getResult();
    }// end_incrementView

}// end_controller_home