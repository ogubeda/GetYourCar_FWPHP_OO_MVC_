<h1 data-tr = "Delete Car" class = "container separe-menu"></h1>
<p data-tr = "Do you want to delete this car?"></p>
<p><?php echo $resUp['brand'] . " " . $resUp['model'] . " " . $resUp['carPlate']?></p>
<br>
<div>
    <input class = "conf-button" style = "float: left" name = "confirm" id = "confirm" type = "button" value = "Confirm" onclick = "location.href = 'index.php?page=our-cars&op=delete&carPlate=<?php echo $_GET['carPlate']?>&del=1'">
</div>
<div>
    <input class = "default-button" name = "back" id = "back" type = "button" value = "Back" onclick = "location.href = 'index.php?page=our-cars&op=list'">
</div>