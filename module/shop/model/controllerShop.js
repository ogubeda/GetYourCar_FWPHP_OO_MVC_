function loadShop(modal = false, itemsPage = 12, totalItems = 0) {
    //////
    var filters = localStorage.getItem('filters') || false;
    //////
    if ((filters != false)) {
        var url = '?page=shop&op=filter&param=' + filters;
        if ($('#remove-filters').length == 0) {
            $('<button></button>').attr({'class':'default-button fadeInLeftAnimation', 'id': 'remove-filters'}).appendTo('.filter-content').html('Remove filters');
        }
    }else {
        $('#remove-filters').remove();
        var url = '?page=shop&op=sendInfo';
    }// end_else
    //////
    friendlyURL(url).then(function(data) {
        ajaxPromise(data, 'POST', 'JSON', {itemsPage: itemsPage, totalItems: totalItems})
    .then(function (data) {
        $('.container-shop').empty();
        $('#container-shop-gmaps').empty();
        for (row in data) {
            brand = data[row].brand.replace(/ /g, "_");
            $('<div></div>').attr({'id': data[row].carPlate, 'class':'card-shop show-details-btn fadeInAnimation', 'name': data[row].carPlate}).appendTo('.container-shop');
            $('<div></div>').attr({'class':'inner'}).html('<h4 style = "padding-top: 25px; margin-bottom: 70px">' + data[row].brand + " " + data[row].model + '</h4>' +
                                                            '<h5>' + data[row].price + '€</h5>' +
                                                            '<div id = "container-btns">'+
                                                            '<div id= "fav-btn" class = "normal-fav-btn" style = "flex: 25px 0 50%; margin-right: 100px">' + favBtn + '</div>' + 
                                                             '<div id = "cart-btn" class = "normal-cart-btn" style = "flex: 25px 0 50%">' + cartBtn +'</div>' +
                                                             '</div>').appendTo('#' + data[row].carPlate);
            //////
            if (modal == true) {
                $('<div></div>').attr({'name': data[row].carPlate, 'id': data[row].carPlate + '-modal', 'class':'card-shop-modal  show-details-btn fadeInAnimation'}).appendTo('#container-shop-gmaps');
                $('<div></div>').attr({'class':'inner'}).html('<h4 style = "padding-top: 25px">' + data[row].brand + " " + data[row].model + '</h4>').appendTo('#' + data[row].carPlate + '-modal');
            }// end_if
        }// end_for
        //////
        if ($('.container-shop').height() > $('.container-filter').height()) {
            $('#main-shop').css({'height' : ($('.container-shop').height() + 65)})
        }else {
            $('#main-shop').css({'height': ($('.container-filter').height() + 100)})
        }// end_else
    }).then(function() {
        sendFavs();
    }).then(function() {
        detectFav();// inside view/js/favorites.js
        addToCart();// inside view/js/controllerCart.js
        paintCart();
    }).catch(function(error) {
        console.log(error);
        localStorage.removeItem('filters');
        // location.reload();
    });// end_catch
    });
    
}// end_loadShop
//////

function loadFilters() {
    //////
    friendlyURL('?page=shop&op=sendFilters').then(function(data) {
        ajaxPromise(data, 'POST', 'JSON').then((data) => {
            $('<button></button>').attr({'class': 'default-button', 'id': 'modal-map-btn', 'style': 'margin-left: 15%; margin-bottom: 10px'}).appendTo('.container-filter').html('Open Map');
            for (row in data) {
                $('<h4 class = "filter-title"></h4>').html(row.toUpperCase()).appendTo('.container-filter');
                for (row_inner in data[row]) {
                    let keys = Object.keys(data[row][row_inner]);
                    $('<div></div>').attr({'class': 'filter-col', 'id': data[row][row_inner][row].replace(/ /g, "_") + keys + "-filter-div"})
                    .appendTo('.container-filter')
                    .html('<a style = "width: 100%" id="filter-btn" class = "' + row + '" name="' + data[row][row_inner][row]+ '">' + data[row][row_inner][row] + '</a>');
                    //////                
                }// end_for
            }// end_for
            highlightFilters();
            loadShop();
            $(document).on('click', '#filter-btn', function() {
                filter(this.getAttribute('class'), this.getAttribute('name'));
            });
            //////
        }).catch((error) => {
            console.log(error);
        }); // end_ajaxPromise
    });
    
}// end_loadFilters
//////

function loadMapModal() {
    //////
    $('<div></div>').attr({'id': 'container-map', 'style': 'margin: 5px 5px;'}).prependTo('#modalGMaps').hide();
    $('<div></div>').attr({'id': 'map', 'style': 'width: 40%; height: 400px; float: left'}).appendTo('#container-map');
    $('<div></div>').attr({'id': 'container-shop-gmaps', 'class': 'row', 'style': 'float:left; overflow-y: scroll; height: 450px'}).appendTo('#container-map');
    //////
    $(document).on('click', '#modal-map-btn', () => {
        loadGMaps();
        loadShop(true)
    });// end_click
}// end_loadMapModal

function loadGMaps() {
    //////
    friendlyURL('?page=shop&op=sendAllCon').then(function(data) {
        $.ajax({
            url: data,
            type: 'POST',
            dataType: 'JSON'
        }).done(function(data) {
            //////
            const center = {lat: 39.9203365, lng: -3.511509};
            const map = new google.maps.Map(document.getElementById('map'),{
                        zoom: 5.7,
                        center: center});
            //////
            for (row in data) {
                let idCon = data[row].idCon;
                let split = data[row].locationCon.split(",");
                let location = {lat: parseFloat(split[0]), lng: parseFloat(split[1])}
                //////
                const marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: data[row].nameCon
                });
                //////
                const infoWindow = new google.maps.InfoWindow({
                    content: data[row].nameCon
                });
                //////
                marker.addListener('click', () => {
                    filter('idCon', idCon, true);
                });
                marker.addListener('mouseover', () => {
                    infoWindow.open(marker.get('map'), marker);
                });
                //////
                marker.addListener('mouseout', () => {
                    infoWindow.close(marker.get('map'), marker);
                });
            }// end_for
            //////
            $("#container-map").show();
            $("#container-map").dialog({
                title: 'Maps',
                width : 1150,
                height: 550,
                resizable: "false",
                dialogClass: 'container-dialog',
                modal: "true",
                hide: "fold",
                show: "fold",
                buttons : {
                }// end_Buttons
            }); // end_Dialog
            $('#container-map').parent().removeClass('ui-widget-content');
        }).fail(function() {
            window.location.href = 'index.php?page=error503';
        });// end_ajax
    });
    
}// end_loadGMaps
//////

function highlightFilters() {
    //////
    $('.filter-col').removeClass('active-filter');
    if (localStorage.getItem('filters')) {
        const filters = JSON.parse(localStorage.getItem('filters'));
        for (row in filters) {
            for (row_inner in filters[row]) {
                let content = '#' + filters[row][row_inner].replace(/ /g, "_") + row + '-filter-div';
                $(content).addClass('active-filter');
            }// end_for
        }// end_for
    }// end_if
    //////
}// end_highlightFilters
//////

function showDetails() {
    //////
    friendlyURL('?page=shop&op=read').then(function(data) {
        ajaxPromise(data, 'POST', 'JSON', {carPlate: localStorage.getItem('carPlate')}).then(function(data) {
            friendlyURL('?page=shop&op=viewUp').then(function(url) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {carPlate: data.carPlate}
                }).done(function() {
                    console.log('Views updated.');
                }).fail(function() {
                    console.log('Error when trying to update views.');
                });// end_fail
            });
            //////
            $('.content').empty();
            $('<div></div>').attr({'class': 'top-details spt',}).appendTo('.content');
            $('<div><div>').attr({'class': 'top-photo'}).appendTo('.top-details');
            $('<div></div>').attr({'class': 'container separe-menu', 'id': 'container-shop-details'}).appendTo('.content');
            $('.top-photo').css({'background': 'url(http://192.168.0.182/frameworkCars.v.1.3/view/img/allCarsImg/' + data.image + ')', 'background-size': 'cover', 'background-position': 'center'});
            //////
            $('<div></div>').attr({'class': 'container-brand'}).appendTo('#container-shop-details');
            $('<h3></h3>').html(data.brand + " " + data.model).appendTo('.container-brand');
            //////
            $('<div></div>').attr({'class': 'container-specs'}).appendTo('#container-shop-details');
            $('.container-specs').html('<h5>Seats: ' + data.seats + ' Doors: ' + data.doors + '</h5>');
            //////
            $('<div></div>').attr({'class': 'container-engine'}).appendTo('#container-shop-details');
            $('.container-engine').html('<h5>Gear Shift: ' + data.gearShift + ' Type Engine:' + data.typeEngine + ' CV: ' + data.cv + ' Max Speed: ' + data.maxSpeed + '</h5>');
            //////
            $('<div></div>').attr({'class': 'container-others'}).appendTo('#container-shop-details');
            $('.container-others').html('<h5>Roads: ' + data.roads + ' Extras: ' + data.extras + ' Start Date: ' + data.startDate + ' End Date: ' + data.endDate + '</h5>' + 
                                            '<div id= "fav-btn" class = "normal-fav-btn" style = "width: 75px; height: 75px; cursor: pointer">' + favBtn + '</div>' + 
                                            '<div id = "cart-btn" class = "normal-cart-btn" style = "margin-top: 25px;width: 75px; height: 75px; cursor: pointer" >' + cartBtn +'</div>');
        }).then(function() {
            detectFav();
            sendFav();
            addToCart();// inside view/js/controllerCart.js
        }).catch(function(error) {
            console.log(error);
            window.location.href = 'index.php?page=error503'
        }); // end_ajaxPromise
    });
    
    //////
}// end_showModal
//////

function redirectDetails() {
    //////
    $('.container-shop').on("click", ".show-details-btn .inner" ,function(event) {
        if (!$(event.target).is('#fav-btn, svg, path, #cart-btn')) {
            localStorage.setItem('currentPage', 'shop-details');
            localStorage.setItem('carPlate', $(this).parent().attr('name'));
            location.reload();
        }// end_if
    });
}// end_redirectDetails
//////

function filter(key, value, modal = false) {
    //////
    let filterKey = key;
    let insFilter = value;
    //////
    if (localStorage.getItem('filters')) {
        var pastFilters = JSON.parse(localStorage.getItem('filters'));
        var obj = Object.keys(pastFilters);
        //////
        if (obj.includes(filterKey)) {
            //////
            if (pastFilters[filterKey].includes(insFilter)) {
                var arrPosition = pastFilters[filterKey].indexOf(insFilter);
                pastFilters[filterKey].splice(arrPosition, 1);
                //////
                if ($(pastFilters[filterKey]).size() == 0) {
                    //console.log((pastFilters[filterKey]).size());
                    delete pastFilters[filterKey];
                }// end_if
            }else {
                pastFilters[filterKey].push(insFilter);
            }// end_else
        }else {
            pastFilters[filterKey] = [insFilter];
        }// end_else
        //////
        if (Object.keys(pastFilters).length == 0) {
            localStorage.removeItem('filters');
        }else {
            localStorage.setItem('filters', JSON.stringify(pastFilters))
        }// end_else
    }else {
        var allFilters = {[filterKey] : [insFilter]};
        localStorage.setItem('filters', JSON.stringify(allFilters));
    }// end_else
    //////
    highlightFilters();
    loadShop(modal);
    loadPagination();
}// end_filter
//////

function loadPagination() {
    //////
    let localFilters = undefined;
    //////
    if (localStorage.getItem('filters')) {
        localFilters = {filters: localStorage.getItem('filters')};
    }// end_if
    //////
    friendlyURL('?page=shop&op=countProd').then(function(data) {
        $.ajax({
            url: data,
            dataType: 'JSON',
            type: 'POST',
            data: localFilters
        }).done(function(data) {
            let totalItems = 0, totalPages = 0;
            let prevPage = false, nextPage = false;
            //////
            for (let i = 0; i < data; i++) {
                if ((i % 12) == 0) {
                    totalPages = totalPages + 1;
                }// end_if
            }// end_for
            //////
            if (totalPages > 1) {
                prevPage = 'Prev';
                nextPage = 'Next';
            }// end_if
            //////
            $('#pagination-shop').bootpag({
                total: totalPages,
                page: 1,
                maxVisible: totalPages,
                prev: prevPage,
                next: nextPage
            }).on("page", function(event, num) {
                totalItems = 12 * (num - 1)
                loadShop(false, 12, totalItems);
                $('html, body').animate({scrollTop: $('.site').height()}, 500);
            });
        }).fail(function(error) {
            console.log(error);
        }); // end_fail
    });
    
}// end_loadPagination

function addAPI() {
    //////
    var script = document.createElement('script');
    script.async = true;
    script.defer = true;
    script.src = 'https://maps.googleapis.com/maps/api/js?key=' + googleApi;
    $('head').append(script);
}// end_addAPI

function removeFilters() {
    /////
    $(document).on('click', '#remove-filters', function() {
        localStorage.removeItem('filters');
        highlightFilters();
        loadShop();
        loadPagination();
    });
}// end_removeFilters
//////

function loadContent(){
    //////
    if (localStorage.getItem('currentPage') == 'shop-details') {
        showDetails();
    }else {
        addAPI();
        loadFilters();
        loadPagination();
        loadMapModal();
        redirectDetails();
        removeFilters();
    }// end_else
}// end_loadContent
$(document).ready(function() {
    loadContent();
}); // end_ready