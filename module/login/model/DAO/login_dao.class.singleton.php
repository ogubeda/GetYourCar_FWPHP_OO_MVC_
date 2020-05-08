<?php
//////
class login_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function insertClientUser($idUser, $username, $email, $password, $avatar, $activeToken, $active) {
        return db::query() -> insert([['id_user' => $idUser, 'username' => $username, 'email' => $email, 'password' 
                                                => $password, 'registerDate' => date("Y/m/d"), 'avatar' => $avatar, 'type' 
                                                => 'client', 'money' => 10000, 'token_active' => $activeToken, 'token_recover' => 'NULL', 'active' => $active]], 'users') 
                            -> execute() -> getResult();
    }// end_insertClientUser

    public function checkUserKeys($username, $email) {
        return db::query() -> select(['id_user'], 'users') -> where(['username' => [$username], 'email' => [$email]], 'OR') -> execute() -> count();
    }// end_checkUserKeys

    public function selectUserData($username) {
        return db::query() -> select(['*'], 'users') -> where(['id_user' => [$username]]) -> execute() -> queryToArray() -> getResolve();
    }// end_selectUserData

    public function checkUserSocial($idUser) {
        return db::query() -> select(['email'], 'users') -> where(['id_user' => [$idUser]]) -> execute() -> queryToArray() -> getResolve();
    }// end_checkUserSocial

    public function addEmailToken($idUser, $token) {
        return db::query() -> update(['token_recover' => $token, 'active' => 0], 'users', true) -> where(['id_user' => [$idUser]]) -> execute() -> getResult();
    }// end_addEmailToken

    public function checkTokenEmail($token) {
        return db::query() -> select(['token_recover'], 'users') -> where(['token_recover' => [$token]]) -> execute() -> count() -> getResolve();
    }// end_checkTokenEmail

    public function updateUserPassword($password, $token) {
        return db::query() -> update(['token_recover' => "NULL", 'password' => $password], 'users', true) -> where(['token_recover' => [$token]]) -> execute() -> toJSON() -> getResolve();
    }// end_updateUserPassword

    public function verifyEmailToken($token) {
        return db::query() -> select(['token_active'], 'users') -> where(['token_active' => [$token]]) -> execute() -> count() -> getResolve();
    }// end_verifyEmailToken

    public function updateVerifyToken($token) {
        return db::query() -> update(['token_active' => 'NULL', 'active' => 1], 'users', true) -> where(['token_active' => [$token]]) -> execute() -> toJSON() -> getResolve();
    }// end_updateVerifyToken

    public function selectUserMenuData($idUser) {
        return db::query() -> select(['username', 'avatar', 'type'], 'users') -> where(['id_user' => [$idUser]]) -> execute() -> queryToArray() -> getResolve();
    }// end_selectUserMenuData
}// end_login_dao