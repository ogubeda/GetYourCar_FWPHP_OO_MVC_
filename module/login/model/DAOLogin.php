<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'model/DB.php');
//////

class LogInQuerys {
    //////
    function register($username, $email, $password) {
        $hashEmail = md5(strtolower(trim($email)));
        $selectedAvatar = "https://avatars.dicebear.com/v2/jdenticon/" . $hashEmail . ".svg";
        //////
        return DB::query() -> insert([['username' => $username, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'registerDate' => date("Y/m/d"), 'avatar' => $selectedAvatar, 'type' => 'client', 'money' => 10000]], 'users') -> execute();
    }// end_register

    function checkKeys($username, $email) {
        return DB::query() -> select(['username'], 'users') -> where(['username' => [$username], 'email' => [$email]], 'OR') -> execute() -> count();
    }// end_checkKeys

    function logIn($username) {
        return DB::query() -> select(['*'], 'users') -> where(['username' => [$username]]) -> execute() -> queryToArray();
    }// end_logIn
}// end_LogInQuerys
