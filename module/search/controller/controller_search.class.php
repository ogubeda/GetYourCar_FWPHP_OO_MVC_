<?php
//////
class controller_search {
    function listProvinces() {
        echo common::accessModel('search_model', 'getProvinces_search') -> getResolve();
    }// end_listProvinces

    function listCon() {
        echo common::accessModel('search_model', 'getConc_search', $_POST['province']) -> getResolve();
    }// end_listCon

    function autoComplete() {
        echo common::accessModel('search_model', 'getAutoComplete_search', [$_POST['complete'], $_POST['dropCon'], $_POST['province']]) -> getResolve();
    }// end_autoComplete
}// end_controller_search