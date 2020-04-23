function ajaxPromise(sUrl, sType, sTData, sData = undefined) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData
        }).done((data) => {
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            reject(jqXHR.responseText);
        }); // end_ajax
    });
}// end_ajaxPromise

function loadMenu() {
    //////
    Promise.all([friendlyURL('?page=shop'), friendlyURL('?page=services'), friendlyURL('?page=contact'),])
    .then(function(values) {
        $('<li></li>').html('<a href = "' + values[0] + '" class = "menu-btn" id  = "shop" data-tr = "Shop">Shop</a>').appendTo('#fixed-menu');
        $('<li></li>').html('<a href="' + values[1] + '" class = "menu-btn" id = "services" data-tr="Services">Services</a>').appendTo('#fixed-menu');
        $('<li></li>').html('<a href="' + values[2] +'" class = "menu-btn" id = "contact" data-tr="Contact Us">Contact Us</a>').appendTo('#fixed-menu');
        //////
        ajaxPromise('http://192.168.0.182/frameworkCars.v.1.3/module/login/controller/controllerLogIn.php?op=returnSession', 'POST', 'JSON', {secureSession: localStorage.getItem('secureSession')})
        .then(function(data) {
            $('<li></li>').html('<a class = "menu-btn" id = "profile-btn" style = "background : url(' + data.avatar + ') no-repeat; padding-left: 30px; margin-left: 15px">' + 
                                '<span style= "float: left;">' + data.user + '</span></a>').attr({'class': 'item-sideNav', 'id': 'profile-submenu'}).appendTo('#fixed-menu');
            //////
            $('<ul></ul>').attr({'class': 'sub-menu'}).html('<li><a href = "index.php?page=profile&op=list" id = "profile">Profile</a></li>' + 
                                                            '<li><a id = "log-out-btn">Log Out</a></li>').appendTo('#profile-submenu');
            //////
            if (data.type === 'admin') {
                adminMenu();
            }else if (data.type === 'client') {
                clientMenu();
            }// end_else
            //////
            addActivity();
            logOutClick();
            localStorage.setItem('secureSession', data.secureSession);
        }).catch(function() {
            $('<li></li>').html('<a href = "index.php?page=log-in&op=list" class = "menu-btn" id = "logIn">Log In</a>').appendTo('#fixed-menu');
        }).then(function() {
            fixedMenu();
        });
    });
    
    //////
}// end_loadMenu
//////

function adminMenu() {
    //////
    $('<li></li>').attr({'class': 'item-sideNav', 'style': 'display: block'})
        .html('<a href="index.php?page=our-cars&op=list" class = "menu-btn" id = "ourCars">Our Cars</a>')
        .appendTo('#navbar-menu-side');
    $('<li></li>').attr({'class': 'item-sideNav', 'style': 'display: block'})
        .html('<a href = "index.php?page=our-brands&op=list" class = "menu-btn" id = "ourBrands">Our Brands</a>')
        .appendTo('#navbar-menu-side');
}// end_adminMenu
//////

function clientMenu() {
    //////
    $('<li></li>').attr({'class': 'item-sideNav', 'style': 'display: block'})
        .html('<a href="index.php?page=user-order&op=list" class = "menu-btn item-sideNav" id = "userOrder">User Order</a>')
        .appendTo('#navbar-menu-side');
}// end_clientMenu

function fixedMenu(bagBtn1 = bagBtn) {
    //////
    $('<li></li>').html('<a href = "index.php?page=cart&op=list" class = "menu-btn" id = "cart">' + bagBtn1 + '</a>').appendTo('#fixed-menu');
    $('<li></li>').html('<a class = "menu-btn" id = "more-options">More Options</a>').appendTo('#fixed-menu');
    $('<li></li>').html('<a id = "close-options-sideNav">Close</a>').prependTo('#navbar-menu-side').attr({'style': 'display: block'});
    //////
    $('<li></li>').html('<a href="#">Languages</a>').appendTo('#navbar-menu-side').attr({'class': ' has-child item-sideNav', 'id': 'lang-submenu'});
    $('<ul></ul>').attr({'class': 'sub-menu'}).html('<li><a id = "btn-en">English</a></li>' + 
                                                    '<li><a id = "btn-es">Spanish</a></li>' +
                                                    '<li><a id = "btn-val">Valencian</a></li>').appendTo('#lang-submenu');
}// end_fixedMenu
//////

function logOutClick() {
    //////
    $(document).on('click', '#log-out-btn', function() {
        logOut();
    });
}// end_logOutClick
//////

function logOut() {
    $.ajax({
        url: 'http://192.168.0.182/frameworkCars.v.1.3/module/login/controller/controllerLogIn.php?op=logOut',
        type: 'POST',
        dataType: 'JSON'
    }).done(function() {
        console.log('Session closed.');
        localStorage.removeItem('secureSession');
        window.location.href = "index.php?page=home&op=list";
    }).fail(function() {
        console.log('Something has occured');
    });// end_ajax
}// end_logOut

function addActivity() {
    var script = document.createElement('script');
    script.src = "module/login/model/activity/js/activity.js";
    $('head').append(script);
}// end_addActivity

$(document).ready(function() {
    loadMenu();
});