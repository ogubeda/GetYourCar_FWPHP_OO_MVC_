<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
require_once ($path . 'model/Querys.php');

class DB {
    //////
    public static function enable() {
        $ini_file = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/model/api-keys/apis.ini');
        $connection = mysqli_connect($ini_file['IPAddress'], $ini_file['username'], $ini_file['password'], $ini_file['dataBase']);
        //////
        if (!$connection) {
            echo mysqli_connect_error();
        }// end_if
        return $connection;
    }// end_enable

    public static function close($connection) {
        mysqli_close($connection);
    }// end_close
    
    public static function query() {
        return new Querys();
    }// end_query

}// end_DB