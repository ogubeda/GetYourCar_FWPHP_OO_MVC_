<?php
//////
function updateSession($force = false) {
    //////
    if ((!isset($_SESSION['address'])) || ($force)) {
        $_SESSION['address']  = md5($_SERVER['REMOTE_ADDR']);
    }//end if
    if ((!isset($_SESSION['agent'])) || ($force)) {
        $_SESSION['agent'] = md5($_SERVER['userAgent']);
    }// end_if
    //////
    $oldID = session_id();
    session_regenerate_id(true);
    //////
    $updatedSession = session_id();
    session_write_close();
    //////
    session_id($updatedSession);
    session_start();
    ini_set('session.use_only_cookies', true);
    $_SESSION['time'] = time();
    $_SESSION['old'] = $oldID;
}// end_updateSession

function loadSession($id_user, $username, $type, $avatar) {
    //////
    updateSession(true);
    //////
    $_SESSION['id_user'] = $id_user;
    $_SESSION['user'] = $username;
    $_SESSION['type'] = $type;
    $_SESSION['avatar'] = $avatar;
    $_SESSION['epyt'] = md5($type);
    $_SESSION['resu'] = md5($username);
}// end_loadSession

function checkSession() {
    //////
    try {
        if ($_SESSION['address'] != md5($_SERVER['REMOTE_ADDR'])) {
            throw new Exception("The IP Addresses aren't the same.");
        }// end_if
        if ($_SESSION['agent'] != md5($_SERVER['userAgent'])) {
            throw new Exception("The Browsers between session aren't the same.");
        }// end_if
        if ($_SESSION['old'] == session_id()) {
            throw new Exception("You're using an old ID");
        }// end_if
        if (md5($_SESSION['type']) != $_SESSION['epyt']) {
            throw new Exception("The type of the user missmatch.");
        }// end_if
        if (md5($_SESSION['user']) != $_SESSION['resu']) {
            throw new Exception("The usernames missmatch.");
        }//
        if (md5(session_id()) != $_POST['secureSession']) {
            throw new Exception("Session id missmatch.");
        }
        return true;
    }catch(Exception $e) {
        return false;
    }// end_catch
}// end_checkSession

function returnUserSession() {
    //////
    if ($_SESSION['user'] && (checkSession())) {
        updateSession();
        return json_encode(array('user' => $_SESSION['user'], 'type' => $_SESSION['type'], 'avatar' => $_SESSION['avatar'], 'secureSession' => md5(session_id())));
    }else {
        session_destroy();
        return 'Something has ocurred.';
    }// end_else
}// end_returnUserSession