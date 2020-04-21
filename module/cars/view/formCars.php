<h1 data-tr = "<?php 
	if ($_GET['op'] == "update") {
		echo "Update a car";
	}else {
		echo "Create a car";
	}?>" class = "spt"></h1>
<form method="post" name="formCars" id="formCars" class = "container">
		<?php
		if(isset($error)){
			print ("<BR><span CLASS='styerror'>" . "* ".$error . "</span><br/>");
		}// end_if
		//////
		if (($_GET['op'] == "update") && ($_GET['carPlate'])) {
			$returnedArray = Utils::formComplete($resUp);
		}else {
			$returnedArray = Utils::formComplete($_POST?$_POST:"");
		}
		?>
		<table>
			<tr>
				<td><label for="carPlate" data-tr="Car Plate:"></label></td>
				<td><input name="carPlate" id="carPlate" type="text" placeholder="0000-XXX" value="<?php echo $returnedArray['carPlate'];?>"/></td>
				<td><span id="carPlateError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="idCon" data-tr="Concessionaire:"></label></td>
				<td><select id = "idCon" name = "idCon" placeholder = "Concessionaire">
						<option value = "UM007" <?php echo $returnedArray['checkUM'];?>>Ulsan Motor</option>
						<option value = "GA003" <?php echo $returnedArray['checkGA'];?>>Gyata</option>
						<option value = "CM005" <?php echo $returnedArray['checkCM'];?>>Conde Motor</option>
						<option value = "AS002" <?php echo $returnedArray['checkAS'];?>>Auto Salon</option>
						<option value = "AO006" <?php echo $returnedArray['checkAO'];?>>Auto Clariano</option>
						<option value = "AO001" <?php echo $returnedArray['checkAO1'];?>>Auto Ocasion</option>
						<option value = "AN004" <?php echo $returnedArray['checkAN'];?>>Ancrisa</option>
					</select></td>
				<td><span id="idConError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="brand" data-tr = "Brand:"></label></td>
				<td><input name="brand" id="brand" type="text" placeholder="Brand" value="<?php echo $returnedArray['brand'];?>" /></td>
				<td><span id="brandError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="model" data-tr = "Model:"></label></td>
				<td><input name="model" id="model" type="text" placeholder="Model" value="<?php echo $returnedArray['model']; ?>" /></td>
				<td><span id="modelError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="seats" data-tr="Seats:"></label></td>
				<td><input name="seats" id="seats" type="text" placeholder="Seats" value="<?php echo $returnedArray['seats']; ?>" /></td>
				<td><span id="seatsError" class="styerror"></span></td>
			</tr>
        	<tr>
				<td><label for="doors" data-tr="Doors:"></label></td>
				<td><input name="doors" id="doors" type="text" placeholder="Doors" value="<?php echo $returnedArray['doors']; ?>" /></td>
				<td><span id="doorsError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for = "gearShift" data-tr="Gear Shift:"></label></td>
				<td><input type = "radio" name = "gearShift" id = "gearShift" value = "Manual" placeholder= "gearShift" <?php echo $returnedArray['checkMan'];?>/>Manual
				<input type = "radio" name = "gearShift" id = "gearShift" value = "Auto" placeholder = "gearShift" <?php echo $returnedArray['checkAuto'];?>/>Auto</td>
				<td><span id = "gearShiftError" class = "styerror"></span></td>
			</tr>
			<tr>
				<td><label for = "typeEngine" data-tr = "Type Engine:"></label></td>
				<td><select id = "typeEngine" name = "typeEngine" placeholder = "typeEngine">
						<option value = "Electric" <?php echo $returnedArray['checkElec'];?>>Electric</option>
						<option value = "Hybrid" <?php echo $returnedArray['checkHyb'];?>>Hybrid</option>
						<option value = "Combustion" <?php echo $returnedArray['checkComb'];?>>Combustion</option>
					</select></td>
				<td><span id = "typeEngineError" class = "styerror"></span></td>
			</tr>
			<tr>
				<td><label for="powerCV">CV: </label></td>
				<td><input name="powerCV" id="powerCV" type="text" placeholder="CV" value="<?php echo $returnedArray['powerCV']; ?>" /></td>
				<td><span id="powerCVError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="maxSpeed" data-tr = "Max Speed:"></label></td>
				<td><input name="maxSpeed" id="maxSpeed" type="text" placeholder="Max Speed" value="<?php echo $returnedArray['maxSpeed']; ?>" /></td>
				<td><span id="maxSpeedError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="exitRoads" data-tr="Roads:"></label></td>
				<td><select multiple size = "3" id = "exitRoads[]" name = "exitRoads[]" placeholder = "exitRoads">
					<option value = "City" <?php echo $returnedArray['checkCity'];?>>City</option>
					<option value = "Roadway" <?php echo $returnedArray['checkRWay'];?>>Roadway</option>
					<option value = "Road" <?php echo $returnedArray['checkRoad'];?>>Road</option>
					<option value = "Rural" <?php echo $returnedArray['checkRural'];?>>Rural</option>
					<option value = "Mountain" <?php echo $returnedArray['checkMnt'];?>>Mountain</option>
				</select></td>
				<td><span id="exitRoadsError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="extras">Extras: </label></td>
				<td><input name="extras" id="extras" type="checkbox" value = "yes" <?php echo $returnedArray['checkExt'];?>/></td>
			</tr>
			<tr>
				<td><label for="startDate" data-tr="Start Date:"></label></td>
				<td><input id="startDate" type="text" name="startDate" readonly="readonly" value = "<?php echo $returnedArray['startDate']; ?>"/></td>
				<td><span id="startDateError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><label for="endDate" data-tr="End Date:"></label></td>
				<td><input id="endDate" type="text" name="endDate" readonly="readonly" value = "<?php echo $returnedArray['endDate']; ?>"/></td>
				<td><span id="endDateError" class="styerror"></span></td>
			</tr>
			<tr>
				<td><input type = "button" class = "conf-button" name="create" id="create" value = "Continue" onclick="verifyCar(<?php echo $returnedArray['mode'];?>)"></td>
				<td><input type = "button" class = "default-button" name = "back" id = "back" " value = "Back" onclick = "location.href ='<?php echo $returnedArray['redirect'];?>' "></td>
			</tr>
		</table>
	</form>
	