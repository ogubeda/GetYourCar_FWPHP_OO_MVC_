function changeLang(lang) {
    //////
    lang = lang || localStorage.getItem('app-lang') || 'en';
    localStorage.setItem('app-lang', lang);
    //////
    var elmnts = document.querySelectorAll('[data-tr]');
    //////
    $.ajax({
        url: 'http://192.168.0.182/frameworkCars.v.1.3/view/lang/' + lang + '.json',
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                for (var i = 0; i < elmnts.length; i++) {
                    elmnts[i].innerHTML = data.hasOwnProperty(lang) ? data[lang][elmnts[i].dataset.tr] : elmnts[i].dataset.tr;
                }// end_for
            }// end_success
    })// end_ajax
}// end_changeLang

$(document).ready(function() {
    changeLang();
    $(document).on("click", "#btn-es",function() {
        changeLang('es')
        });
    $(document).on("click", "#btn-en",function() {
        changeLang('en')
        });
    $(document).on("click", "#btn-val",function() {
        changeLang('val')
    });
});