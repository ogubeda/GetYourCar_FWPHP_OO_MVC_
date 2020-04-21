function showModal(carTitle, carPlate) {
    //////
    $("#detailsCars").show();
    $("#carModal").dialog({
        title: carTitle,
        width : 850,
        height: 500,
        resizable: "false",
        modal: "true",
        hide: "fold",
        show: "fold",
        buttons : {
            Update: function() {
                        window.location.href = 'index.php?page=our-cars&op=update&carPlate=' + carPlate;
                    },
            Delete: function() {
                        window.location.href = 'index.php?page=our-cars&op=delete&carPlate=' + carPlate;
                    }
        }// end_Buttons
    }); // end_Dialog
}// end_showModal
//////

function loadContentModal() {
    //////
    $(".hover-car-table").on("click", function() {
        var carId = this.getAttribute('id');
        //////
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: 'module/cars/controller/controllerCars.php?op=readModal&carPlate=' + carId,
            //////
        }).done(function(jsonCar) {
            $('<div></div>').attr('id', 'detailsCars', 'type', 'hidden').appendTo('#carModal');
            $('<div></div>').attr('id', 'containerCars').appendTo('#detailsCars');
            $('#containerCars').empty();
            $('<div></div>').attr('id', 'Div1').appendTo('#containerCars');
            $('#Div1').html(function() {
                var content = "";
                for (row in jsonCar) {
                    content += '<br><span>' + row + ': <span id =' + row + '>' + jsonCar[row] + '</span></span>';
                }// end_for
                //////
                return content;
                });
                //////
                showModal(carTitle = jsonCar.brand + " " + jsonCar.model, jsonCar.carPlate);
                //////
        }).fail(function() {
            window.location.href = 'index.php?page=error503';
        });
    });
}// end_loadContentModal
//////

function loadCarDivs() {
    //////
    $('<table></table>').attr('id', 'car-table').appendTo('#list-cars');
}// end_loadCarDivs
//////

$(document).ready(function() {
    localStorage.setItem('currentPage', 'crud');
    loadContentModal();
    $('.car-table').DataTable();
});