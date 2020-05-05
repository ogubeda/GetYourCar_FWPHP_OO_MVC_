<?php
//////
class login_bll {
    static $_instance;
    private $dao;
    //////
    function __construct() {
        $this -> dao = login_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function registerUserClient_login_BLL($args) {
        $hashEmail = md5(strtolower(trim($args[1])));
        $selectedAvatar = "https://avatars.dicebear.com/v2/jdenticon/" . $hashEmail . ".svg";
        $pass = password_hash($args[2], PASSWORD_DEFAULT);
        //////
        return $this -> dao -> insertClientUser($args[0], $args[0], $args[1], $pass, $selectedAvatar, common::generate_Token_secure(20));
    }// end_registerUserClient_BLL

    public function accessUser_login_BLL($args) {
        $user = $this -> dao -> selectUserData($args[0]);
        if (password_verify($args[1], $user['password'])) {
            loadSession($user['username'], $user['type'], $user['avatar']);
            return json_encode(md5(session_id()));
        }// end_if
        return 'Fail';
    }// end_if

    public function accessUserSocial_login_BLL($args) {
        if ($this -> dao -> checkUserSocial($args['nickname']) <= 0) {
            $this -> dao -> insertClientUser($args['nickname'], $args['nickname'], $args['email'],'NULL', $args['picture'], 'NULL');
        }// end_if
        $user = $this -> dao -> selectUserData($args['nickname']);
        loadSession($user['username'], $user['type'], $user['avatar']);
        return json_encode(md5(session_id()));
    }// end_acessUserSocial_login_BLL
}// end_login_bll