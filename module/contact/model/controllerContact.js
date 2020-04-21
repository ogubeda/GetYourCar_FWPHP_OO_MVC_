function addContactEvents () {
    $(document).on('click', '#send-email', function () {
        checkEmail();
    });
}// end_addContactEvents

function checkEmail() {
    let regName = /^[A-Za-z-\s]{6,60}/;
    let regEmail = /^[A-Za-z0-9._-]{5,20}@[a-z]{3,6}.[a-z]{2,4}$/;
    let regMessage = /^[A-Za-z0-9.]{15,200}/;
    //////
}// end_checkEmail

function regExContact() {

}// end_regExContact

function sendEmail() {
    ajaxPromise('http://192.168.0.182/frameworkCars.v.1.3/index.php?page=contact&op=sendEmail', 'POST', 'JSON')
    .then(function(data) {
        console.log(data);
    }).catch(function(error) {
        console.log(error);
    });
}// end_sendEmail

function addAPI() {
    //////
    var script = document.createElement('script');
    script.async = true;
    script.defer = true;
    script.src = 'https://maps.googleapis.com/maps/api/js?key=' + googleApi + '&callback=loadMap';
    $('head').append(script);
}// end_addAPI

function loadMap() {
    var location = {lat: 38.809893, lng: -0.604617}; 
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: location
    }); // end_map
    ////
    var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h4>Ontinyent</h4>'+
        '<div id="bodyContent">'+
        '<p><b>Get your Car</b></p>'+
        '<a href="index.php?page=controllerHomePage&op=list">Home</a>'+
        '</div>'+
        '</div>';
        //////
    var popWindow = new google.maps.InfoWindow({
        content: contentString
    });
    var marker = new google.maps.Marker({
        position: location,
        map: map,
        title: 'Get your Car'
    });
    //////
    marker.addListener('click', function() {
        popWindow.open(map, marker);
    });
}// end_loadMap
//////

$(document).ready(function() {
    addAPI();
    addContactEvents();
    localStorage.setItem('currentPage', 'contact');
    //loadMap();
});