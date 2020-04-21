<h1><?php echo $selCar['brand'] . " " . $selCar['model']?></h1>
<br>
<div>
    <button style = "float: left" class = "default-button" name = "update" id = "update" data-tr = "Update" onclick = "location.href = 'index.php?page=controllerCars&op=update&carPlate=<?php echo $selCar['carPlate']?>'">
</div>
<div>
    <button class = "default-button" name = "delete" id = "delete" data-tr="Delete" onclick = "location.href = 'index.php?page=controllerCars&op=delete&carPlate=<?php echo $selCar['carPlate']?>'">
</div>
<br>
<ul>
    <table>
        <tr>
            <td><li data-tr = "Car Plate:"></li></td>
            <td><span><?php echo $selCar['carPlate']?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Brand:"></li></td>
            <td><span><?php echo $selCar['brand']?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Model:"></li></td>
            <td><span><?php echo $selCar['model']?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Seats:"></li></td>
            <td><span><?php echo $selCar['seats']?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Doors:"></li></td>
            <td><span><?php echo $selCar['doors']?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Gear Shift:"></li></td>
            <td><span><?php echo $selCar['gearShift'];?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Type Engine:"></li></td>
            <td><span><?php echo $selCar['typeEngine'];?></span></td>
        </tr>
        <tr>
            <td><li>CV:</li></td>
            <td><span><?php echo $selCar['cv'];?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Max Speed:"></li></td>
            <td><span><?php echo $selCar['maxSpeed'];?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Roads:"></li></td>
            <td><span><?php echo $selCar['roads'];?></span></td>
        </tr>
        <tr>
            <td><li>Extras:</li></td>
            <td><span><?php if ($selCar['extras'] == "yes") {
                        echo "Yes";
                    }else {
                        echo "No";
                    }?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "Start Date:"></li></td>
            <td><span><?php echo $selCar['startDate'];?></span></td>
        </tr>
        <tr>
            <td><li data-tr = "End Date:"></li></td>
            <td><span><?php echo $selCar['endDate'];?></span></td>
        </tr>
    </table>
</ul>
<br>
<div>
    <button class = "default-button" name = "back" id = "back"  data-tr="Back" onclick = "location.href = 'index.php?page=controllerCars&op=list'">
</div>
