function dataSource(data) {
    //////
    var dataSource = {
        localData: data,
        dataType: 'array',
        id: 'id',
        dataFields: [
            {name: 'carPlate', type: 'string'},
            {name: 'brand', type: 'string'},
            {name: 'model', type: 'string'},
            {name: 'gearShift', type: 'string'},
            {name: 'typeEngine', type: 'string'}
        ]
    };
    //////
    return dataSource;
}// end_dataSource
//////

function widgetDataTable(data) {
    //////
    var dataAdapter = new $.jqx.dataAdapter(dataSource(data));
    $('#userOrderTable').jqxDataTable({
        altRows: true,
        source: dataAdapter,
        sortable: true,
        columns: [
            { text: 'Car Plate', dataField: 'carPlate', width: 100, align: 'center', cellsAlign: 'center' },
            { text: 'Brand', dataField: 'brand', width: 100, align: 'center', cellsAlign: 'center' },
            { text: 'Model', dataField: 'model', width: 100, align: 'center', cellsAlign: 'center' },
            { text: 'Gear Shift', dataField: 'gearShift', width: 90, align: 'center', cellsAlign: 'center'},
            { text: 'Type Engine', dataField: 'typeEngine', width: 120, align: 'center', cellsAlign: 'center' }
        ]
    });
}// end_widgetDataTable
//////

function loadUserOrder() {
    //////
    $('<div></div>').attr('id', 'userOrderTable').appendTo('#userOrderList');
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'module/userOrder/controller/controllerUserOrder.php?op=userOrder'
    }).done(function(userOrder) {
        //////
        widgetDataTable(userOrder);
        //////
    }).fail(function() {
        //////
        $('#userOrderTable').html("<p>There's no available orders.</p>");
        //////
    });
}// end_loadUserOrder
//////

$(document).ready(function() {
    loadUserOrder();
}); // end_document.ready