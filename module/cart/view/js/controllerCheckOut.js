function addCartEvents() {
    //////
    $(document).on('change', '.select-drop-days', function() {
        if ($(this).val() > 0 && $(this).val() <= 10) {
            updateDays($(this).val(), $(this).closest('.product-element').attr('id'));
        }else {
            console.log('Invalid quantity of days.');
        }// end_else
    });//
    //////
    $(document).on('click', '#checkout-btn', function() {
        checkOutCart();
    });
    $(document).on('click', '#delete-btn', function() {
        const thisBtn = $(this);
        friendlyURL('?page=cart&op=removeCart').then(function(url) {
            removeDBCart(url, thisBtn.closest('.product-element').attr('id'))
            .then(function(data) {
                if (data === false) {
                    if (localStorage.getItem('cart')) {
                        removeCart(thisBtn.closest('.product-element').attr('id'));
                    }// end_if
                }// end_if
                getDataCart();
            }).catch(function(error) {
                console.log(error);
            });//
        });
    });//
    //////
    $(document).on('click', '#code-disc-btn', function() {
        if ($('#code-disc-input').val().length > 0) {
            addDiscCode($('#code-disc-input').val());
        }else {
            console.log('Empty.');
        }// end_else
    });//
    //////
    $(document).on('click', '#remove-disc-code', function() {
        removeDiscCode();
    });
}// end_addCartEvents
//////

function removeDiscCode() {
    //////
    friendlyURL('?page=cart&op=removeDiscCode').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            console.log(data);
            getDataCart();
        }).catch(function(error){
            console.log(error);
        });
    });
}// end_removeDiscCode
//////

function addDiscCode(discCode) {
    //////
    friendlyURL('?page=cart&op=addDiscCode').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {code: discCode, JWT: localStorage.getItem('token')})
        .then(function() {
            getDataCart();
        }).catch(function(error) {
            console.log(error);
            if (error === 'no-login') {
                localStorage.setItem('purchase', true);
                window.location.href = 'index.php?page=log-in&op=list';
            }// end_if
        });
    });
}// end_addDiscCode
//////

function checkOutCart() {
    //////
    friendlyURL('?page=cart&op=checkOut').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            console.log(data);
            if (data === "false") {
                localStorage.setItem('purchase', true);
                window.location.href = 'index.php?page=log-in&op=list';
            }else {
                $('#container-details-cart').empty();
                $('#price-cart-calc').empty();
                $('#header-price-cart').empty();
                $('#checkout-btn').remove();
                //////
                $('<h1></h1>').html('Succesfull purchase').appendTo('#container-details-cart');
            }// end_else
        }).catch(function(error){
            console.log(error);
        });
    });
}// end_checkOutCart

function updateDays(days, carPlate) {
    //////
    friendlyURL('?page=cart&op=updateDays').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {days: days, carPlate: carPlate, JWT: localStorage.getItem('token')})
        .then(function() {
            getDataCart();
        }).catch(function(error) {
           if (localStorage.getItem('cart')) {
               updateDaysLocal(carPlate, days);
               getDataCart();
           }else {
               console.log(error);
           }// end_else
        });
    });
}// end_updateDays
//////

function getDataCart() {
    //////
    friendlyURL('?page=cart&op=loadDataCart').then(function(url) {
        ajaxPromise(url, 'POST', 'JSON', {JWT: localStorage.getItem('token')})
        .then(function(data) {
            printDataCart(data);
        }).catch(function(error) {
            console.log(error);
            if (!localStorage.getItem('cart')) {
                $('#container-details-cart').empty();
                $('#price-cart-calc').empty();
                $('#checkout-btn').remove();
                $('<h3></h3>').attr({'id': 'error-cart-load'}).html('It seems your cart is empty :(').appendTo('#container-details-cart');
            }else {
                friendlyURL('?page=cart&op=getCart').then(function(url) {
                    getCart(url)
                    .then(function(data) {
                        console.log(data);
                        printDataCart(data, JSON.parse(localStorage.getItem('cart')));
                    }).catch(function(error) {
                        console.log(error);
                        $('#container-details-cart').empty();
                        $('#price-cart-calc').empty();
                        $('#container-price-cart').empty();
                        $('<h3></h3>').attr({'id': 'error-cart-load'}).html('It seems your cart is empty :(').appendTo('#container-details-cart');
                    });
                });
            }// end_else
        });
    });
}// end_getDataCart
//////

function printDataCart(cart, localCart = null) {
    //////
    let totalPrice = 0, price = 0, days = 0, disc = 0;
    let code = "";
    $('#container-details-cart').empty();
    $('#price-cart-calc').empty();
    $('#checkout-btn').remove();
    //////
    $('<h1></h1>').html('Products').appendTo('#container-details-cart');
    $('<div></div>').attr({'id': 'container-disc-code', 'style': 'float: right'}).html('Discount Code').appendTo('#container-details-cart');
    $('<input></input>').attr({'type': 'text', 'style': 'display:block', 'id': 'code-disc-input'}).appendTo('#container-disc-code');
    $('<a></a>').html('Apply').attr({'class': 'default-button', 'id': 'code-disc-btn'}).appendTo('#container-disc-code');
    for (row in cart) {
        code = cart[row].code_name;
        disc = parseInt(cart[row].discount) || 0;
        days = parseFloat(cart[row].days) || parseFloat(localCart[row].days) || 1;
        price = parseFloat(cart[row].price) * (1 + (days / 10 - 0.1));
        totalPrice = totalPrice + price;
        //////
        $('<div></div>').attr({'id': cart[row].carPlate, 'class': 'product-element', 'style': 'margin-top: 25px; width: 75%'}).appendTo('#container-details-cart');
        $('<span></span>').attr({'id': 'info-cont'}).html(cart[row].brand + ' ' + cart[row].model).appendTo('#' + cart[row].carPlate);
        $('<span></span>').attr({'id': 'select-days' + cart[row].carPlate}).html('Days ').appendTo('#' + cart[row].carPlate);
        $('<select></select>').attr({'class': 'select-drop-days', 'name': 'quantity-days', 'autocomplete': 'off', 'id': 'select-daysI-' + cart[row].carPlate, 'style': 'width: 60%'}).appendTo('#select-days' + cart[row].carPlate);
        for (let i = 0; i < 10; i++) {
            $('<option></option>').attr({'value': i + 1, 'selected':function() {
                if ((i + 1 ) === days) {
                    return true
                }// end_if
                return false;
            } }).html(i + 1).appendTo('#select-daysI-' + cart[row].carPlate);

        }// end_for
        $('<a></a>').attr({'style': 'margin-left: 15px', 'id': 'delete-btn'}).html('Delete').appendTo('#' + cart[row].carPlate)
        $('<span></span>').attr({'id': 'info-price'}).html(price + '€').appendTo('#' + cart[row].carPlate);
    }// end_for
    if (disc > 0) {
        $('<div></div>').attr({'style': 'margin-top: 15px'}).html(code + '<span style = "float: right">' + disc + '%</span>').appendTo('#container-disc-code');
        $('<a></a>').attr({'id': 'remove-disc-code', 'class': 'default-button'}).html('Remove Code').appendTo('#container-disc-code');
        $('<span></span>').attr({'id': 'i', 'style': 'display: block'}).html(totalPrice + '€').appendTo('#price-cart-calc');
        $('<span></span>').attr({'style': 'display: block'}).html('- ' + totalPrice * disc / 100 + '€').appendTo('#price-cart-calc');
        totalPrice = totalPrice - (totalPrice * disc / 100);
    }// end_if
    $('<span></span>').attr({'id': 'i'}).html(totalPrice + '€').appendTo('#price-cart-calc');
    $('<a></a>').attr({'id': 'checkout-btn', 'class': 'default-button'}).html('Check out').appendTo('#container-price-cart');
}// end_printDataCart
//////

$(document).ready(function() {
    setTimeout(function() {getDataCart()}, 100);
    addCartEvents();
});