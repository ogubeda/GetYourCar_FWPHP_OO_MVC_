<?php
//////
session_start();
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
        $hashEmail = md5(strtolower(trim($args[0])));
        $selectedAvatar = "https://avatars.dicebear.com/v2/jdenticon/" . $hashEmail . ".svg";
        $pass = password_hash($args[2], PASSWORD_DEFAULT);
        $token = common::generate_Token_secure(20);
        //////
        return array('query' => $this -> dao -> insertClientUser($args[0], $args[0], $args[1], $pass, $selectedAvatar, $token, 0), 'token' => $token);
    }// end_registerUserClient_BLL

    public function accessUser_login_BLL($args) {
        $user = $this -> dao -> selectUserData($args[0]);
        if (password_verify($args[1], $user['password'])) {
            $secure = common::generate_Token_secure(20);
            $jwt = jwt_process::encode($secure, $user['id_user']);
            loadSession($secure);
            return json_encode(array('secureSession' => md5(session_id()), 'jwt' => $jwt));
        }// end_if
        return 'Fail';
    }// end_if

    public function accessUserSocial_login_BLL($args) {
        $result = true;
        if (empty($this -> dao -> checkUserSocial($args['sub']))) {
            $result = $this -> dao -> insertClientUser($args['sub'], $args['nickname'], $args['email'],'NULL', $args['picture'], 'NULL', 1);
        }// end_if
        if ($result) {
            $user = $this -> dao -> selectUserData($args['sub']);
            $secure = common::generate_Token_secure(20);
            loadSession($secure);
            $jwt = jwt_process::encode($secure, $user['id_user']);
            return json_encode(array('secureSession' => md5(session_id()), 'jwt' => $jwt));
        }// end_if
        return 'Empty';
    }// end_acessUserSocial_login_BLL

    public function verifyUser_login_BLL($args) {
        $result = $this -> dao -> checkUserSocial($args);
        $token = common::generate_Token_secure(20);
        if (!empty($result)) {
            $this -> dao -> addEmailToken($args, $token);
            return array('email' => $result['email'], 'token' => $token);
        }// end_if
        return false;
    }// end_verifyUser_login_BLL

    public function checkRecoverToken_login_BLL($args) {
        if ($this -> dao -> checkTokenEmail($args) > 0) {
            $_SESSION['token'] = $args;
            return json_encode('Done');
        }// end_if
        return 'fail';
    }// end_checkRecoverToken_login_BLL

    public function setUserNewPassword_login_BLL($args) {
        return $this -> dao -> updateUserPassword(password_hash($args[0], PASSWORD_DEFAULT), $args[1]);
    }// end_setUserNewPassword_login_BLL

    public function verifyUserEmail_login_BLL($args) {
        if ($this -> dao -> verifyEmailToken($args) > 0) {
            return $this -> dao -> updateVerifyToken($args);
        }// end_if
        return 'fail';
    }// end_verifyUserEmail_login_BLL

    public function getUserData_login_BLL($args) {
        $secure = common::generate_Token_secure(20);
        $userName = json_decode(jwt_process::decode($args[0], $args[1]), true)['name'];
        $user = $this -> dao -> selectUserMenuData($userName);
        loadSession($secure);
        $user['secureSession'] = md5(session_id());
        $user['jwt'] = jwt_process::encode($secure, $userName);
        return json_encode($user);
    }// end_getUserData_login_BLL
}// end_login_bll