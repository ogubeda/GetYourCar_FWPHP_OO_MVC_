function loadSlider() {
    //////
    friendlyURL('?page=home&op=homePageSlide').then(function(data) {
        $.ajax({
            url: data,
            type: 'GET',
            dataType: 'JSON'
        }).done(function(data) {
            //////
            for (row in data) {
                $('<div></div>').attr({'id': data[row].carPlate, "class": "single-slide", "style": "background-image: url(http://192.168.0.182/frameworkCars.v.1.3/view/img/allCarsImg/" + data[row].image + ")"}).appendTo('.hero-slider')
                .html('<div class= "slide-content text-center"><h2>' + data[row].brand + " " + data[row].model + " " + data[row].carPlate + '</h2></div>');
            }// end_for
            $(".hero-slider").addClass('owl-carousel');
            $(".owl-carousel").owlCarousel({
                items: 1,
                autoplay: true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOutLeft',
                loop: true,
                autoplayHoverPause: true,
                nav: true,
                autoHeight:true,
                navText: [
                    '<i class="fa fa-angle-left"></i>',
                    '<i class="fa fa-angle-right"></i>'
                ]
            });
        }).fail(function(error) {
            console.log(error);
            // window.location.href = "index.php?page=error503";
        });
    });
    //////
}// end_loadSlider
//////

function loadCatBrands(loadeds = 0) {
    //////
    let items = 3;
    let loaded = loadeds;
    //////
    friendlyURL('?page=home&op=homePageCat').then(function(data) {
        ajaxPromise(data, 'POST', 'JSON', {items: items, loaded: loaded}).then(function(data) {
            for (row in data) {
                let brand = data[row].brand.replace(/ /g, "_");
                $('<div></div>').attr({'id': brand, 'class':'col-md-4 single-service-2'}).appendTo('#containerCategories');
                $('<div></div>').attr({'class':'inner'}).html('<img src = "http://192.168.0.182/frameworkCars.v.1.3/' + data[row].image + '" style = "max-width: 100%; height: 100px;"><h4 style = "padding-top: 25px">' + data[row].brand + '</h4></img>').appendTo('#' + brand);
            }// end_for
            //////
        }).catch(function() {
            //window.location.href = 'index.php?page=error503';
        });
    });
}// end_loadCatBrands
//////

function detectScrollBrands() {
    //////
    //////
    $(document).on('scroll', function() {
        let position = $(window).scrollTop();
        let bottom = $(document).height() - $(window).height();
            if (position == bottom) {
                loadCatBrands($('.col-md-4').length);
            }// end_if
    });
}// end_detectScrollBrands
///////

function loadMoreHistory() {
    //////
    $('<h1></h1>').html('Are you interested in history?').appendTo('#some-history');
    $('<div></div>').appendTo('#some-history').attr({'id': 'container-history', 'class': 'row'});
    //////
    ajaxPromise('http://ergast.com/api/f1/1997/qualifying/1.json', 'POST', 'JSON')
    .then(function(data) {
        const content = data.MRData.RaceTable.Races;
        //////
        for (row in content) {
            $('<div></div>').attr({'id' : content[row].Circuit.circuitId, 'class' : 'card-history'}).appendTo('#container-history');
            $('<div></div>').attr({'class': 'inner'}).appendTo('#' + content[row].Circuit.circuitId).html(content[row].raceName);
        }// end_for
        $('<div></div>').attr({'id': 'container-info-history'}).appendTo('#some-history').hide();
    }).then(function() {
        addAPI();
        showHistoryContent();
    }).catch(function() {
        console.log('Fail when trying to get the information.');
    });// end_Promise
}// end_loadMoreHistory
//////

function showHistoryContent() {
    //////
    $(document).on('click', '.card-history', function() {
        $(this).children().toggleClass('inner-active');
        //////
        ajaxPromise('http://ergast.com/api/f1/1997/circuits/' + this.getAttribute('id') + '/qualifying/1.json', 'POST', 'JSON')
        .then(function(data) {
            $('#container-info-history').empty();
            $('<div></div>').attr({'id': 'data-content', 'style': 'float: left; margin-right: 15px'}).appendTo('#container-info-history');
            $('<div></div>').attr({'id': 'gmap-content'}).appendTo('#container-info-history');
            $('<div></div>').attr({'id': 'map', 'style': 'width: auto; height: 400px'}).appendTo('#container-info-history');
            //////
            let circuitInfo = data.MRData.RaceTable.Races[0];
            let winerInfo = data.MRData.RaceTable.Races[0].QualifyingResults[0];
            let location = {lat: parseFloat(circuitInfo.Circuit.Location.lat), lng: parseFloat(circuitInfo.Circuit.Location.long)};
            let map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: location,
            });
            let marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'test',
            });
            //////
            $('<h3></h3>').html('Circuit').appendTo('#data-content');
            $('<h5></h5>').html(circuitInfo.Circuit.circuitName).appendTo('#data-content');
            $('<h5></h5>').html('Date: <span>' + circuitInfo.date + '</span>').appendTo('#data-content');
            $('<h5></h5>').html('Locality: <span>' + circuitInfo.Circuit.Location.locality + '</span>').appendTo('#data-content');
            $('<h3></h3>').html('Winner').appendTo('#data-content');
            $('<h5>/h5>').html(winerInfo.Driver.givenName + ' ' + winerInfo.Driver.familyName).appendTo('#data-content');
            $('<h5></h5>').html('Birth: <span>' + winerInfo.Driver.dateOfBirth + '</span>').appendTo('#data-content');
            $('<h5></h5>').html('Number: <span>' + winerInfo.number + '</span>').appendTo('#data-content');
            $('<h5></h5>').html('Nationality: <span>' + winerInfo.Driver.nationality + '</span>').appendTo('#data-content');
            $('#container-info-history').toggle();
        });// end_Promise
    });// end_click
}// end_showHistoryContent
//////

function addAPI() {
    //////
    const script = document.createElement('script');
    script.async = true;
    script.defer = true;
    script.src = 'https://maps.googleapis.com/maps/api/js?key=' + googleApi;
    $('head').append(script);
}// end_addAPI

function loadDivs() {
    //////
    //////
    $('<h1></h1>').html('Our Most Visited Brands').appendTo('#homePage').attr("style", "padding-bottom: 50px");
    $('<div></div>').attr({'id': "containerCategories", 'class':'row'}).appendTo('#homePage');
    //////
    loadSlider();
    loadMoreHistory();
    loadCatBrands();
    detectScrollBrands();
}// end_loadDivs
//////

function redirectShop() {
    //////
    $(document).on('click', '.single-service-2', function() {
        var brand = this.getAttribute('id').replace("_", " ");
        //////
        friendlyURL('?page=home&op=incrementView').then(function(data) {
            $.ajax({
                url: data,
                type: 'POST',
                data: {brand: brand}
            }).done(function(data) {
                if (data == 1) {
                    var filter = {'brand': [brand]};
                    localStorage.setItem('filters', JSON.stringify(filter));
                    localStorage.setItem('currentPage', 'shop');
                    window.location.href = "index.php?page=shop&op=list";
                }else {
                    console.log('Error when trying to find the brand.');
                }// end_else
            }); // end_done 
        });
    });
    //////
    $(document).on('click', '.single-slide', function() {
        localStorage.setItem('carPlate', this.getAttribute('id'));
        localStorage.setItem('currentPage', 'shop-details');
        friendlyURL('?page=shop').then(function(url) {
            window.location.href = url;
        });
    });
}// end_redirectShop

$(document).ready(function () {
    loadDivs();
    redirectShop();
});
