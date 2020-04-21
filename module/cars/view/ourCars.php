<div class = "page-title sp separe-menu">
	<div class = "container text-center">
		<h2 data-tr="Our Cars"></h2>
	</div>
</div>
<div class = "container separe-menu">
<div>
    <button class = "default-button" style = "float: left" name = "create" id = "create" type = "button" data-tr = "Create" onclick = "location.href = 'index.php?page=our-cars&op=create'">
</div>
<div>
    <button class = "default-button" style = "float: left" name = "create_con" id = "create_con" type = "button" data-tr = "Add Brand" onclick="location.href = 'index.php?page=our-cars&op=createBrand'"></button>
</div>
<div>
    <button class = "default-button" name = "deleteAll" id = "deleteAll" data-tr = "Delete All" onclick = "location.href = 'index.php?page=our-cars&op=deleteAll'">
</div>
<br>
<div class = "list-cars">
    <table class="car-table">
        <thead>
            <tr>
                <th data-tr = "brand"></th><th data-tr = "model"></th><th data-tr="carPlate"></th><th data-tr="gearShift"></th><th data-tr="typeEngine"></th>
            </tr>
        </thead>
        <tbody>
<?php
//////
    if (empty($resSel)){
        echo '<p data-tr = "There is no available cars."></p>';
    }else {
        foreach ($resSel as $car) {
            echo '<tr class="hover-car-table" id="' . $car['carPlate'] . '">';
            echo '<td>' . $car['brand'] . '</td><td>' . $car['model'] . '</td><td>' . $car['carPlate'] . '</td><td>' . $car['gearShift'] . '</td><td>' . $car['typeEngine'] . '</td>';
            echo '</tr>';
        }// end_foreach
    }// end_else 
?>
        </tbody>
    </table>
</div>

<section id = "carModal"></section>
</div>