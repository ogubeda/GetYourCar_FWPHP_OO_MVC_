function addContactEvents () {
    $(document).on('click', '#send-email', function () {
        checkEmail();
    });
}// end_addContactEvents

function checkEmail() {
    let regName = /^[A-Za-z\s]{6,60}$/;
    let regMatter = /^[A-Za-z-\s]{6,60}$/;
    let regEmail = /^[A-Za-z0-9._-]{5,20}@[a-z]{3,6}.[a-z]{2,4}$/;
    let regMessage = /^[A-Za-z0-9-\s.]{15,200}$/;
    let fields = {'#contact-name': regName, '#contact-email': regEmail, '#contact-matter': regMatter,'#message': regMessage};
    let keys = Object.keys(fields);
    let error = false;
    //////
    $('.error').remove();
    for (row in keys) {
        result = regExContact(fields[keys[row]], $(keys[row]).val());
        if (result === false) {
            $('<span></span>').attr({'class': 'error'}).html("The string isn't valid.").appendTo($(keys[row]).parent());
            error = true;
        }else if (result === -1) {
            $('<span></span>').attr({'class': 'error'}).html("This field can't be empty.").appendTo($(keys[row]).parent());
            error = true;
        }// end_else
    }// end_for
    if (error === false) {
        sendEmail({name: $('#contact-name').val(), email: $('#contact-email').val(), matter: $('#contact-matter').val() ,message: $('#message').val()});
    }// end_if
    //////
}// end_checkEmail

function regExContact(regEx, value) {
    if (value.length > 0) {
        return regEx.test(value);
    }// end_if
    //////
    return -1;
}// end_regExContact

function sendEmail(content) {
    friendlyURL('?page=contact&op=sendEmail')
    .then(function(data) {
        ajaxPromise(data, 'POST', 'JSON', content)
        .then(function(data) {
            console.log(data);
            toastr.success('Email sended');
            $('#send-email-form').trigger('reset');
        }).catch(function(error) {
            toastr.error('Something happend when trying to send.' ,'Error');
            console.log(error);
        });
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
});