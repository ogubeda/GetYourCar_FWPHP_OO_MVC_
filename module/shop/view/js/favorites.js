function detectFav(details = undefined) {
    //////
    $(document).on('click', '#fav-btn', function() {
        const thisBtn = $(this);
        let carPlate = "";
        if ($(this).closest('.card-shop').attr('name') === undefined) {
            carPlate = localStorage.getItem('carPlate');
        }else {
            carPlate = $(this).closest('.card-shop').attr('name');
        }
        //////
        friendlyURL('?page=shop&op=updateFavs').then(function(url) {
            ajaxPromise(url, 'POST', 'JSON', {carPlate: carPlate, jwt: localStorage.getItem('token')})
            .then(function(data) {
                if (data === true) {
                    thisBtn.addClass('active-fav-btn');
                }else {
                    thisBtn.removeClass('active-fav-btn');
                }// end_else
            }).catch(function(error) {
                console.log(error);
                // window.location.href = "index.php?page=log-in&op=list";
            }); // end_ajaxPromise
        });
    });
}// end_detectFav
//////

function sendFav() {
    //////
    ajaxPromise('module/shop/controller/controllerShop.php?op=sendFavs', 'POST', 'JSON')
    .then(function(data) {
        for (row in data) {
            if (localStorage.getItem('carPlate') === data[row].carPlate) {
                $('.container-others').find('#fav-btn').addClass('active-fav-btn');
            }// end_if
        }// end_for
    }).catch(function(error) {
        console.log(error);
    }); // end_sendFavs
}// end_sendFav

function sendFavs() {
    //////
    friendlyURL('?page=shop&op=sendFavs').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {jwt: localStorage.getItem('token')})
        .then(function(data) {
            for (row in data) {
                $('#' + data[row].carPlate).find('#fav-btn').addClass('active-fav-btn');
            }// end_for
        }).catch(function(error) {
            console.log(error);
        }); // end_sendFavs
    });
}// end_sendFavs