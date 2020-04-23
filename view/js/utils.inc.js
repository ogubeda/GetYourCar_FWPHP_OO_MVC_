function friendlyURL(url) {
    return new Promise(function(resolve, reject) {
        let link="";
        url = url.replace("?", "");
        url = url.split("&");
        //////
        $.ajax({
            url: 'http://' + window.location.hostname + '/frameworkCars.v.1.3/paths.php?op=get',
            type: 'POST',
            dataType: 'JSON'
        }).done(function(data) {
            if (data === true) {
                for (let i = 0; i < url.length; i++) {
                    let aux = url[i].split("=");
                    link +=  "/" + aux[1];
                }// end_for
            }// end_if
            resolve ("http://192.168.0.182/frameworkCars.v.1.3" + link);
        }).fail(function(error) {
            reject (error);
        });
    }); 
}// end_friendlyURL