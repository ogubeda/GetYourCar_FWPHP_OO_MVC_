<?php
//////
class search_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function selectProvinces() {
        return db::query() -> select(['province'], 'concessionaire', true) -> order(['province']) -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectProvinces

    public function selectConcesionaire() {
        return db::query() -> select(['*'], 'concessionaire') -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectConcesionaire

    public function selectConcesionaireArgs($province) {
        return db::query() -> select(['*'], 'concessionaire') -> where(['province' => [$province]]) -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectConcesioanireArgs

    public function autoCompleteBrand($brand) {
        return db::query() -> select(['brand'], 'allCars', true) -> where(['brand' => [$brand . '%']], 'AND', 'LIKE') -> execute() -> queryToArray(true) -> toJSON();
    }// end_autoCompleteBrand

    public function autoCompleteConBrand($brand, $idCon) {
        return db::query() -> select(['brand'], 'allCars', true) -> where(['idCon' => [$idCon]]) -> where(['brand' => [$brand . '%']], 'AND', 'LIKE') -> execute() -> queryToArray(true) -> toJSON();
    }// end_autoCompleteConBrand

    public function autoCompleteProvinceBrand($brand, $province) {
        return db::query() -> select(['brand'], 'allCars', true) -> manual(" WHERE idCon IN (SELECT idCon FROM concessionaire WHERE province ='$province')") -> where(['brand' => [$brand . '%']], 'AND', 'LIKE', true) -> execute() -> queryToArray(true) -> toJSON();
    }// end_autoCompleteProvinceBrand
}// end_search_dao