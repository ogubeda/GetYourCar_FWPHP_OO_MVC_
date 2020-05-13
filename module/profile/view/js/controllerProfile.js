function addBTNEvents() {
    //////
    $(document).on('click', '#show-favs', function() {
        if ($('#container-fav').length <= 0) {
            showUserFavs();
        }//end_if
    });//
    //////
    $(document).on('click', '#back-btn', function() {
        loadContent();
        loadUserData(true);
    });//
    //////
    $(document).on('click', '#delete-btn', function() {
        deleteProfile();
    });//
    $(document).on('click', '#show-purchases', function() {
        showUserPurchases();
    });
    //////
}// end_addBTNEvents
//////

function showUserPurchases() {
    friendlyURL('?page=profile&op=showPurchases').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            console.log(data);
            $('#profile-right').empty();
            $('<div></div>').attr({'id': 'container-purchases'}).appendTo('#profile-right');
            $('<div></div>').attr({'id': 'header-purchases', 'style': 'display: flex; margin-bottom: 40px; border-bottom: 1px solid #FFF;'}).appendTo('#container-purchases');
            $('<a></a>').attr({'id': 'back-btn', 'style': 'flex: 50%; max-width: 50px; margin-right: 50px'}).html('<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left" class="svg-inline--fa fa-arrow-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"></path></svg>').appendTo('#header-purchases');
            $('<h2></h2>').attr({'style': 'flex: 50%'}).html('Purchases').appendTo('#header-purchases');
            $('<div></div>').attr({'id': 'data-purchases'}).appendTo('#profile-right');
            for (row in data) {
                console.log(data[row]);
                $('<a></a>').attr({'id': data[row].carPlate + '-' + row, 'class': 'fav-cars', 'style': 'display:block'}).appendTo('#data-purchases');
                $('<img></img>').attr({'src': 'view/img/allCarsImg/' + data[row].image, 'style': 'max-width: 35%; max-height: 35%'}).appendTo('#' +  data[row].carPlate + '-' + row);
                $('<div></div>').attr({'style': 'font-weight: bold; font-size: 18px'}).html(data[row].brand + ' ' + data[row].model + ' ' + data[row].carPlate).appendTo('#' + data[row].carPlate + '-' + row);
            }// end_for
        }).catch(function(error) {
            console.log(error);
        });
    });
}// end_showUserPurchases

function deleteProfile() {
    //////
    friendlyURL('?page=profile&op=deleteProfile').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            console.log(data);
            logOut();
        }).catch(function (error) {
            console.log(error);
        });// end_ajax
    });
}// end_deleteProfile

function loadUserData(again = false) {
    //////
    friendlyURL('?page=profile&op=sendData').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            console.log(data);
            document.title = data.username;
            if (again === false) {
                $('<img></img>').attr({'src': data.avatar}).appendTo('#container-avatar');
            }// end_if
            $('<span></span>').html(data.username).appendTo('#container-username');
            $('<span></span>').html(data.email).appendTo('#container-email');
            $('<span></span>').html(data.registerDate).appendTo('#container-date');
        }).catch(function(error) {
            console.log(error);
        });// end_catch
    });
    //////
}// end_loadUserData
//////

function showUserFavs() {
    //////
    friendlyURL('?page=profile&op=sendUserFavs').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            console.log(data);
            $('#profile-right').empty();
            $('<div></div>').attr({'id': 'container-fav'}).appendTo('#profile-right');
            $('<div></div>').attr({'id': 'header-favs', 'style': 'display: flex; margin-bottom: 40px; border-bottom: 1px solid #FFF;'}).appendTo('#container-fav');
            $('<a></a>').attr({'id': 'back-btn', 'style': 'flex: 50%; max-width: 50px; margin-right: 50px'}).html('<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left" class="svg-inline--fa fa-arrow-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"></path></svg>').appendTo('#header-favs');
            $('<h2></h2>').attr({'style': 'flex: 50%'}).html('Favorites').appendTo('#header-favs');
            $('<div></div>').attr({'id': 'data-favs'}).appendTo('#profile-right')
            for (row in data) {
                $('<a></a>').attr({'id': data[row].carPlate, 'class': 'fav-cars', 'style': 'display:block'}).appendTo('#data-favs');
                $('<img></img>').attr({'src': 'view/img/allCarsImg/' + data[row].image, 'style': 'max-width: 35%; max-height: 35%'}).appendTo('#' +  data[row].carPlate);
                $('<div></div>').attr({'style': 'font-weight: bold; font-size: 18px'}).html(data[row].brand + ' ' + data[row].model + ' ' + data[row].carPlate).appendTo('#' + data[row].carPlate);
            }// end_for
        }).catch(function (error) {
            console.log(error);
        }); // end_ajax
    });
    //////
}//

function loadContent() {
    //////
    $('.container-search').remove();
    $('#profile-right').empty();
    $('<div></div>').attr({'id': 'container-data'}).appendTo('#profile-right');
    $('<div></div>').attr({'id': 'container-username', 'class': 'neumorph-child'}).html('<a>Username</a>').appendTo('#container-data');
    $('<div></div>').attr({'id': 'container-email', 'class': 'neumorph-child', 'style': 'margin-top: 20px'}).html('<a>Email</a>').appendTo('#container-data');
    $('<div></div>').attr({'id': 'container-date', 'class': 'neumorph-child', 'style': 'margin-top: 20px'}).html('<a>Register Date</a>').appendTo('#container-data');
    $('<div></div>').attr({'id': 'modify-profile'}).appendTo('#profile-right').html('<a id = "delete-btn" class = "neumorph-btn" style = "margin-top: 100px;">Delete Account</a>');
    //////
    
}//end_loadContent

$(document).ready(function() {
    loadContent();
    setTimeout(function() { loadUserData()}, 100);
    addBTNEvents();
});