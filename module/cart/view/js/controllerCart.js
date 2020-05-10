function addToCart() {
    //////
    $('.card-shop').on('click', '#cart-btn', function() {
        $(this).addClass('active-cart-btn');
        cartSys($(this).closest('.card-shop').attr('name'));
    });
    $('.container-others').on('click', '#cart-btn', function() {
        cartSys(localStorage.getItem('carPlate'));
    });
}// end_addToCart
//////

function paintCart() {
    //////
    friendlyURL('?page=cart&op=selectCart').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            if (data === 'false') {
                if (localStorage.getItem('cart')) {
                    data = JSON.parse(localStorage.getItem('cart'));
                }else {
                    return;
                }// end_else
            }// end_if
            for (row in data) {
                $('#' + data[row].carPlate).find('#cart-btn').addClass('active-cart-btn');
            }// end_for
        }).catch(function(error) {
            console.log(error);
        });
    });
}// end_paintCart   

function cartSys(carPlate) {
    //////
    friendlyURL('?page=cart&op=storeCart').then(function(url) {
        storeCart(url, carPlate, 1)
        .then(function() {
            console.log('Saved.');
        }).catch(function(error) {
            if (error === 'no-login') {
                insertCart(carPlate);
            }else {
                console.log(error);
            }// end_else
        });
    });
}// end_cartSys
//////

function insertCart(carPlate) {
    //////
    let localCart = JSON.parse(localStorage.getItem('cart')) || [];
    let objCart = {carPlate: "", days: ""};
    //////
    if (!localCart.some(e => e.carPlate === carPlate)) {
        objCart.carPlate = carPlate;
        objCart.days = 1;
        localCart.push(objCart);
    }// end_if
    localStorage.setItem('cart', JSON.stringify(localCart));
    //////
}// end_insertCart

function removeDBCart(url, carPlate) {
    //////
    return ajaxPromise(url, 'POST', 'JSON', {carPlate: carPlate, JWT: localStorage.getItem('token')});
}// end_removeDBCart
//////

function removeCart(carPlate) {
    //////
    let cart = JSON.parse(localStorage.getItem('cart'));
    let pos = 0;
    for (row in cart) {
        if (cart[row].carPlate === carPlate) {
            break;
        }// end_if
        pos++;
    }// end_for
    //////
    cart.splice(pos, 1);
    if ($(cart).size() <= 0) {
        deleteCart();
        return;
    }// end_if
    localStorage.setItem('cart', JSON.stringify(cart));
    //////
}// end_removeCart
//////

function deleteCart() {
    //////
    localStorage.removeItem('cart');
}// end_deleteCart
//////

function getCart(url) {
    return ajaxPromise(url, 'POST', 'JSON', {cart: JSON.parse(localStorage.getItem('cart'))});
}// end_getCart
//////

function storeCart(url, carPlate, days) {
    //////
    return ajaxPromise(url, 'POST', 'JSON', {carPlate: carPlate, days: days, JWT: localStorage.getItem('token')});
}// end_storeCart
//////

function restoreCart() {
    //////
    let values = JSON.parse(localStorage.getItem('cart')) || [];
    //////
    for (row in values) {
        friendlyURL('?page=cart&op=storeCart').then(function(url) {
            storeCart(url, values[row].carPlate, values[row].days).then(function() {
                console.log('Stored.');
            }).catch(function(error) {
                console.log(error);
            });
        });
    }// end_for
    deleteCart();
}// end_storeCart
//////

function updateDaysLocal(carPlate, days) {
    //////
    let localCart = JSON.parse(localStorage.getItem('cart'));
    let index = 0;
    if (localCart.some(e => e.carPlate === carPlate)) {
        index = localCart.findIndex(obj => obj.carPlate === carPlate);
        localCart[index].days = days;
        //////
        localStorage.setItem('cart', JSON.stringify(localCart));
    }// end_updateDays
}// end_updateDays
