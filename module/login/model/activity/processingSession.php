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
    session_regenerate_id(true);
    //////
    $updatedSession = session_id();
    session_write_close();
    //////
    session_id($updatedSession);
    session_start();
    ini_set('session.use_only_cookies', true);
    $_SESSION['time'] = time();
}// end_updateSession

function loadSession($secret) {
    //////
    updateSession(true);
    //////
    $_SESSION['JWT_Secret'] = $secret;
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
        if (md5(session_id()) != $_POST['secureSession']) {
            throw new Exception("Session id missmatch.");
        }// end_if
        return true;
    }catch(Exception $e) {
        return false;
    }// end_catch
}// end_checkSession

function returnUserSession() {
    //////
    if ($_SESSION['JWT_Secret'] && (checkSession())) {
        updateSession();
        return md5(session_id());
    }else {
        session_destroy();
        return 'Something has ocurred.';
    }// end_else
}// end_returnUserSession