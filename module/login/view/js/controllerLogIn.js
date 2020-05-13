function loadLogIn() {
    //////
    $('#register-btn').on('click', function() {
        friendlyURL('?page=register').then(function(url) {
            window.location.href = url;
        });
    });
    $('#login-btn').on('click', function() {
        checkLogIn();
    });
}// end_loadLogIn

function checkLogIn() {
    //////
    var error = false;
    var user = {'username': document.getElementById('username').value,
                'password': document.getElementById('password').value}
    //////
    var result = regExData(user);
    $('#error').remove();
    for (row in result) {
        if (result[row] == false) {
            error = true;
            $('<span></span>').attr({'id': 'error', 'style': 'position: relative; float: right', 'class': 'error'}).html('Invalid username/password').appendTo('#top-form');
            break;
        }// end_if
    }// end_for
    //////
    $('#logInForm').submit(function(event) {
        event.preventDefault();
        if (error == false) {
            user.password = CryptoJS.MD5(user.password).toString();
            requestLogIn(user);
        }//end_if
    });
}// end_checkLogIn

function requestLogIn(user) {
    //////
    friendlyURL('?page=login&op=logIn').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', user)
        .then(function(data) {
            localStorage.setItem('secureSession', data.secureSession);
            localStorage.setItem('token', data.jwt);
        }).then(function() {
            restoreCart();
        }).then(function() {
            if (localStorage.getItem('purchase') === "true") {
                localStorage.removeItem('purchase');
                window.location.href = "index.php?page=cart&op=list";
            }else {
                window.location.href = "index.php?page=home&op=list";
            }
        }).catch(function(error) {
            console.log(error);
            $('#error').remove();
            $('<span></span>').attr({'id': 'error', 'style': 'position: relative; float: right', 'class': 'error'}).html('Invalid username/password').appendTo('#top-form');
        });// end_promise
    });
}// end_requestLogIn

function loadRegister() {
    //////
    $('.container-login').empty();
    $('<form></form>').attr({'method': 'POST', 'name': 'registerForm', 'id': 'registerForm', 'class': 'separe-menu', 'autocomplete': 'off'}).html('<h2>Register</h2>').appendTo('.container-login');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<h6 id = "input-username">Username</h6><input type="text" name="username" id="username" placeholder = "Username"/>').appendTo('#registerForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<h6 id="input-email">Email</h6><input type="text" name="email" id="email" placeholder = "example@domain.com"/>').appendTo('#registerForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<h6 id="input-password">Password</h6><input type="password" name="password" id="password" placeholder = "Password"/>').appendTo('#registerForm');
    $('<div></div>').attr({'class': 'input', 'id': 'container-re_password', 'autocomplete': 'off'}).html('<h6 id="input-re_password">Re-type Password</h6><input type="password" name="re-password" id="re-password" placeholder = "Password"/>').appendTo('#registerForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="submit" value = "Register" class = "reg-check-btn" style = "color: #0ca3e9"/>').appendTo('#registerForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Back" class = "reg-back-btn" style = "color: #ff5722"/>').appendTo('#registerForm');
}// end_loadRegister

function btnsRegister() {
    //////
    $(document).on('click', '.reg-check-btn', function() {
        checkRegister();
    });
}// end_btnsRegister

function checkRegister() {
    //////
    var user = {'username': $('#username').val(), 
                'email': $('#email').val(), 
                'password': $('#password').val(), 
                're_password': $('#re-password').val()};
    //////
    var results = regExData(user);
    var error = false;
    //////
    $('.error').remove();
    $('#error-duplicated').remove();
    for (row in results) {
        if (results[row] == false) {
            error = true;
            $('<span></span>').attr({'id': 'error-' + row, 'style': 'position: relative; float: right', 'class': 'error'}).html('Invalid value').appendTo('#input-' + row);
            if (row == 'ePass') {
                $('<span></span>').attr({'id': 'error-' + row, 'style': 'position: relative; float: right', 'class':'error'}).html("Password don't match").appendTo('#container-re_password');
            }// end_if
        }// end_if
    }// end_for
    //////
    $('#registerForm').submit(function(event) {
        event.preventDefault();
        if (error == false) {
            user.password = CryptoJS.MD5(user.password).toString();
            friendlyURL('?page=login&op=register').then(function(url) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: user
                }).done(function(data) {
                    successRegister();
                    console.log(data);
                }).fail(function(error) {
                    console.log(error.responseText);
                    console.log('Fail when trying to register.');
                });// end_fail
            });
            $('#error-duplicated').remove();
            $('<span></span>').attr({'id': 'error-duplicated', 'style': 'position: relative; float: right', 'class': 'error'}).html('Username or email in use.').appendTo('#input-username');
        }// end_if
    });
}// end_checkRegister

function successRegister() {
    //////
    $('#registerForm').empty();
    $('<h2></h2>').html('Success').appendTo('#registerForm');
    $('<p></p>').html('You have registered succesfully').appendTo('#registerForm');
    $('<p></p>').html('Please select an option.').appendTo('#registerForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Go to Log In" class = "go-login-btn" style = "color: #0ca3e9"/>').appendTo('#registerForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Back to Home" class = "go-home-btn" style = "color: #ff5722"/>').appendTo('#registerForm');
}// end_successRegister

function regExData(user) {
    //////
    var regEx = "";
    var results = {};
    for (row in user) {
        if (row == 'email') {
            regEx = /^[A-Za-z0-9._-]{5,20}@[a-z]{3,6}.[a-z]{2,4}$/;
        }else if (row == 'username') {
            regEx = /^[A-Za-z0-9._-]{5,15}$/;
        }else {
            regEx = /^[A-Za-z0-9._-]{5,20}$/;
        }// end_else
        results[row] = regExContent(user[row], regEx);
    }// end_for
    if ((user.password != user.re_password) && ('re_password' in user)) {
        results.ePass = false;
    }// end_if
    //////
    return results;
}// end_regExData

function regExContent(value, regEx) {
    //////
    if (value.length > 0) {
        return regEx.test(value);
    }// end_if
    //////
    return false;
}// end_checkContent

function loadContent() {
    //////
    $('.container-search').remove();
    //////
    let path = window.location.pathname.split('/');
    if (path[2] === 'register') {
       loadRegister();
       btnsRegister();
    }else if (path[3] === 'recover'){
        setTimeout(function() {loadSetPassword(path[4])}, 100);
    }else if (path[3] === 'verify') {
        checkVerifyEmail(path[4]);
    }else {
        loadLogIn();
    }// end_else
}// end_loadContent

function handleAuthentication() {
    webAuth.parseHash(function(err, authResult) {
        if (authResult && authResult.accessToken && authResult.idToken) {
            window.location.hash = '';
            setSession(authResult);
        }else if (err) {
            console.log(err);
        }// end_else
    });
}// end_handleAuthentication

function setSession(authResult) {
    webAuth.client.userInfo(authResult.accessToken, function(err, profile) {
        if (profile) {
            friendlyURL('?page=login&op=socialLogIn').then(function(url) {
                ajaxPromise(url, 'POST', 'JSON', {profile: profile})
                .then(function(data) {
                    friendlyURL('?page=home').then(function(url) {
                        localStorage.setItem('secureSession', data.secureSession);
                        localStorage.setItem('token', data.jwt);
                        webAuth.logout({
                            returnTo: url
                        });
                    });
                }).catch(function(error) {
                    console.log(error);
                });
            });
        }else {
            console.log(err);
        }// end_else
    });
}// end_setSession

function addEventsLogin() {
    $(document).on('click', '#social-btn', function() {
        webAuth.authorize();
    });
    //////
    $(document).on('click', '#recover-btn', function() {
        loadRecoverForm();
    });
    $(document).on('click', '.reg-back-btn', function() {
        localStorage.setItem('currentPage', 'logIn')
        friendlyURL('?page=login').then(function(url) {
            window.location.href = url;
        });
    });
    $(document).on('click', '#send-recover-btn', function() {
        sendRecoverEmail();
    });
    $(document).on('click', '#update-pass-btn', function() {
        setRecoverPassword();
    });
    $(document).on('click', '.go-login-btn', function() {
        friendlyURL('?page=login').then(function(url) {
            window.location.href = url;
        });
    });
    $(document).on('click', '.go-home-btn', function() {
        friendlyURL('?page=home').then(function(url) {
            window.location.href = url;
        });
    });
}// end_addEventsLogin

function loadRecoverForm() {
    $('.container-login').empty();
    $('<form></form>').attr({'method': 'POST', 'name': 'recoverForm', 'id': 'recoverForm', 'class': 'separe-menu', 'autocomplete': 'off'}).html('<h2>Recover Password</h2>').appendTo('.container-login');
    $('<div></div>').attr({'class': 'input', 'id': 'user-input-recover','autocomplete': 'off'}).html('<h6 id = "input-username">Username</h6><input type="text" name="username-recover" id="username-recover" placeholder = "Username"/>').appendTo('#recoverForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" id = "send-recover-btn" value = "Recover" style = "color: #0ca3e9"/>').appendTo('#recoverForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Back" class = "reg-back-btn" style = "color: #ff5722"/>').appendTo('#recoverForm');
}// end_sendRecoverEmail

function sendRecoverEmail() {
    let user = {username : $('#username-recover').val()};
    let result = regExData(user);
    //////
    $('#error-username').remove();
    if (result.username == false) {
        $('<span></span>').attr({'id': 'error-username', 'style': 'position: relative; float: right', 'class': 'error'}).html('Invalid value').appendTo('#user-input-recover');
    }else {
        friendlyURL('?page=login&op=sendRecoverEmail').then(function(url) {
            ajaxPromise(url, 'POST', 'JSON', user)
            .then(function() {
                toastr.success('Email sended');
                $('#recoverForm').trigger('reset');
            }).catch(function() {
                toastr.error('Something happend when trying to send.' ,'Error');
                console.log(error);
            });
        });
    }// end_else
}// end_sendRecoverEmail

function loadSetPassword(token) {
    friendlyURL('?page=login&op=checkTokenRecover').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {token: token})
        .then(function() {
            loadSetPasswordContent();
        }).catch(function(error) {
            console.log(error);
            friendlyURL('?page=error404').then(function(url) {
                window.location.href = url;
            });
        });
    });
}// end_loadSetPassword

function loadSetPasswordContent() {
    $('.container-login').empty();
    $('<form></form>').attr({'method': 'POST', 'name': 'set-passwordForm', 'id': 'set-passwordForm', 'class': 'separe-menu', 'autocomplete': 'off'}).html('<h2>Set your new password.</h2>').appendTo('.container-login');
    $('<div></div>').attr({'class': 'input', 'id': 'new_password_cont','autocomplete': 'off'}).html('<h6 id = "input-new-password">Password</h6><input type="password" name="new-password" id="new_password" placeholder = "New Password"/>').appendTo('#set-passwordForm');
    $('<div></div>').attr({'class': 'input', 'id': 'new_re_password_cont','autocomplete': 'off'}).html('<h6 id = "input-new-re-password">Re-type Password</h6><input type="password" name="new_re_password" id="new_re_password" placeholder = "New Password"/>').appendTo('#set-passwordForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" id = "update-pass-btn" value = "Update" style = "color: #0ca3e9"/>').appendTo('#set-passwordForm');
    $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Back" class = "reg-back-btn" style = "color: #ff5722"/>').appendTo('#set-passwordForm');
}// end_loadSetPasswordContent

function setRecoverPassword() {
    let user = {password: $('#new_password').val(), re_password: $('#new_re_password').val()};
    let result = regExData(user);
    let error = false;
    //////
    $('#error-password').remove()
    for (row in result) {
        if (result[row] === false) {
            error = true;
            break;    
        }// end_if
    }// end_for
    if (error === false) {
        friendlyURL('?page=login&op=updatePassword').then(function(url) {
            user.password = CryptoJS.MD5(user.password).toString();
            ajaxPromise(url, 'POST', 'JSON', user)
            .then(function(data) {
                console.log(data);
                $('#set-passwordForm').empty();
                $('<h2></h2>').html('Password updated successfully.').appendTo('#set-passwordForm');
                $('<p></p>').html('Please select an option.').appendTo('#set-passwordForm');
                $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Go to Log In" class = "go-login-btn" style = "color: #0ca3e9"/>').appendTo('#set-passwordForm');
                $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Back to Home" class = "go-home-btn" style = "color: #ff5722"/>').appendTo('#set-passwordForm');
            }).catch(function(error) {
                console.log(error);
                toastr.error('Something happend when trying to update the password' ,'Error');
            });
        });
    }else {
        $('<span></span>').attr({'id': 'error-password', 'style': 'position: relative; float: right', 'class':'error'}).html("Invalid values").prependTo('#new_password_cont');
    }
}// end_setRecoverPassword

function checkVerifyEmail(token) {
    friendlyURL('?page=login&op=validateEmail').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {token: token})
        .then(function(data) {
            console.log(data);
            $('#logInForm').empty();
            $('<h2></h2>').html('Your email has been verified.').appendTo('#logInForm');
            $('<p></p>').html('Please select an option.').appendTo('#logInForm');
            $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Go to Log In" class = "go-login-btn" style = "color: #0ca3e9"/>').appendTo('#logInForm');
            $('<div></div>').attr({'class': 'input', 'autocomplete': 'off'}).html('<input type="button" value = "Back to Home" class = "go-home-btn" style = "color: #ff5722"/>').appendTo('#logInForm');
        }).catch(function(error) {
            console.log(error);
            friendlyURL('?page=error404').then(function(url) {
                window.location.href = url;
            });
        });
    });
}// end_checkVerifyEmail

var webAuth = new auth0.WebAuth({
    domain: authDomain,
    clientID: clientIDAuth,
    redirectUri: uriAuth,
    audience: 'https://' + authDomain + '/userinfo',
    responseType: 'token id_token',
    scope: 'openid email profile',
    leeway: 60
  });

$(document).ready(function() {
    handleAuthentication();
    loadContent();
    addEventsLogin();
});// end_document.ready