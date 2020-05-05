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

    public function insertClientUser($idUser, $username, $email, $password, $avatar, $activeToken) {
        return db::query() -> insert([['id_user' => $idUser, 'username' => $username, 'email' => $email, 'password' 
                                                => $password, 'registerDate' => date("Y/m/d"), 'avatar' => $avatar, 'type' 
                                                => 'client', 'money' => 10000, 'token_active' => $activeToken, 'token_recover' => 'NULL']], 'users') 
                            -> execute() -> toJSON() -> getResolve();
    }// end_insertClientUser

    public function checkUserKeys($username, $email) {
        return db::query() -> select(['username'], 'users') -> where(['username' => [$username], 'email' => [$email]], 'OR') -> execute() -> count();
    }// end_checkUserKeys

    public function selectUserData($username) {
        return db::query() -> select(['*'], 'users') -> where(['username' => [$username]]) -> execute() -> queryToArray() -> getResolve();
    }// end_selectUserData

    public function checkUserSocial($idUser) {
        return db::query() -> select(['id_user'], 'users') -> where(['id_user' => [$idUser]]) -> execute() -> count() -> getResolve();
    }// end_checkUserSocial
}// end_login_dao