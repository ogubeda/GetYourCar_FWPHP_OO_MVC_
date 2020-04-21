function loadList() {
    //////
    $.ajax({
        type: "POST",
        url: "module/brand-crud/controller/controllerCrudBrand.php?op=sendInfo",
        dataType: "JSON",
        async: false,
    }).done(function(data) {
        let keys = Object.keys(data[0]);
        //////
        for (row in keys) {
            $('<th></th>').attr({'id': keys[row]}).appendTo('#column-name').html(keys[row]);
        }// end_for
        //////
        for (row in data) {
            $('<tr></tr>').attr({'id': data[row].brandID, 'class': 'hover-car-table'}).appendTo('#rows-content');
            $('<td></td>').html(data[row].brandID).appendTo('#' + data[row].brandID);
            $('<td></td>').html(data[row].brand).appendTo('#' + data[row].brandID);
            $('<td></td>').html(data[row].image).appendTo('#' + data[row].brandID);
            $('<td></td>').html(data[row].views).appendTo('#' + data[row].brandID);
        }// end_for
        //////
    }).fail(function() {
        console.log('?');
    }); // end_fail
}// end_loadList
//////

$(document).ready(function() {
    loadList();
    $('.car-table').DataTable();
});