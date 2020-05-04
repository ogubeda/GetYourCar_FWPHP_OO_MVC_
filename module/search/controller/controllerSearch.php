<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'module/search/model/DAOSearch.php');
//////
$searchQuerys = new QuerysSearch();
//////
switch ($_GET['op']) {
    case 'autoComplete';
        $select = 'SELECT DISTINCT brand FROM allCars';
        if (isset($_POST['dropCon'])) {
            $select = $select . ' WHERE idCon ="' . $_POST['dropCon'] . '" AND brand LIKE "' . $_POST['complete'] . '%"';
        }else if ((isset($_POST['province'])) && (!isset($_POST['dropCon']))) {
            $select = $select . ' WHERE idCon IN (SELECT idCon FROM concessionaire WHERE province ="' . $_POST['province']. '") AND brand like "' . $_POST['complete'] . '%"';
        }else {
            $select = $select . ' WHERE brand LIKE "' . $_POST['complete'] . '%"';
        }// end_else
        $selAutoComplete = $searchQuerys -> multiple($select);
        //////
        if (!empty($selAutoComplete -> getResolve())) {
            echo json_encode($selAutoComplete -> getResolve());
        }else {
            echo $selAutoComplete -> getError();
        }// end_else
        break;
        //////
    default;
        break;
}// end_switch