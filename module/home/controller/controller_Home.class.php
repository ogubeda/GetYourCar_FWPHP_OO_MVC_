<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . "/frameworkCars.v.1.3/";
//////
include ($path . 'module/home/model/DAOHomePage.php');
//////
$homeQuery = new QuerysHomePage();
switch ($_GET['op']) {
    case 'list';
        include ('module/home/view/homepage.html');
        break;
    case 'homePageSlide';
        $selSlide = $homeQuery -> selectSlide();
        if (!empty($selSlide -> getResolve())) {
            echo json_encode($selSlide -> getResolve());
        }else {
            echo $selSlide -> getError();
        }// end_else
        break;
    case 'homePageCat';
        $selCatBrand = $homeQuery -> selectBrands($_POST['loaded'], $_POST['items']);
        if (!empty($selCatBrand -> getResolve())) {
            echo json_encode($selCatBrand -> getResolve());
        }else{
            echo $selCatBrand -> getError();
        }// end_else
        break;
    case 'incrementView';
        $viewUp = $homeQuery -> incView($_POST['brand']);
        //////
        echo $viewUp -> getResult();
        break;
        //////
    default;
        include ('view/inc/error404.html');
        break;
}// end_switch