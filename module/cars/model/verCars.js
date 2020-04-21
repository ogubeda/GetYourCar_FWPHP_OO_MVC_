function verCarPlate(carPlate) {
	//////
	 if (carPlate.length > 0) {
		 var regEx = /^([0-9]{4})-([A-Z]{3})$/;
		 //////
		 return regEx.test(carPlate);
	 }// end_if
	 return false;
}// end_verCarPlate
//////

function verIdCon(idCon) {
	//////
	 if (idCon.length > 0) {
		 //////
		 return true;
	 }// end_if
	 return false;
}// end_verCarPlate
//////

function verBrand(brand) {
	//////
	if (brand.length > 0) {
		var regEx = /^[A-Za-z-\s]{3,20}$/;
		//////
		return regEx.test(brand);
	}// end_if
	return false;
}// end_verBrand
//////

function verModel(model) {
	//////
	if (model.length > 0) {
		var regEx = /^[A-Za-z0-9-\s]{3,20}$/;
		//////
		return regEx.test(model);
	}// end_if
	return false;
}// end_verModel
//////

function verSeats(seats) {
	//////
	if (seats.length > 0) {
		var regEx = /^[2-8]{1}$/;
		//////
		return regEx.test(seats);
	}// end_if
	return false;
}// end_verSeats
//////
/////

function verDoors(doors) {
	//////
	if (doors.length > 0) {
		var regEx = /^[3-7]{1}$/;
		//////
		return regEx.test(doors);
	}// end_if
	return false;
}// end_verDoors
//////

function verGearShift(gearShift) {
	//////
	for (var i = 0; i < gearShift.length; i++) {
		if(gearShift[i].checked) {
			return true;
		}
	}
	return false;
}// end_verGearShift
//////

function verTypeEngine(typeEngine) {
	//////
	if (typeEngine.length > 0) {
		return true;
	}// end_if
	return false;
}// end_verTypeEngine
//////

function verPower(powerCV) {
	//////
	if (powerCV.length > 0) {
		var regEx = /^[0-9]{2,3}$/;
		//////
		return regEx.test(powerCV);
	}// end_if
	return false;
}// end_verPower
//////

function verSpeed(maxSpeed) {
	//////
	if (maxSpeed.length > 0) {
		var regEx = /^[0-9]{2,3}$/;
		//////
		return regEx.test(maxSpeed);
	}// end_if
	return false;
}// end_verSpeed
//////

function verExitRoads(exitRoads) {
	//////
	for (var i = 0; i < exitRoads.options.length; i++) {
		if (exitRoads.options[i].selected) {
			return true;
		}
	}
	return false;
}// end_verExitRoads

function verStartDate(startDate) {
	//////
	if (startDate.length > 0) {
		return true;
	}// end_if
	return false;
}// end_verStartDate
//////

function verEndDate(endDate) {
	//////
	if (endDate.length > 0) {
		return true;
	}// end_if
	return false;
}// verEndDate
//////

function verifyCar($mode) {
	//////
	var errorDet = false;
	var carPlate = document.getElementById("carPlate").value;
	var idCon = document.getElementById("idCon").value;
	var brand = document.getElementById("brand").value;
	var model = document.getElementById("model").value;
	var seats = document.getElementById("seats").value;
	var doors = document.getElementById("doors").value;
	var gearShift = document.getElementsByName("gearShift");
	var typeEngine = document.getElementById("typeEngine").value;
	var powerCV = document.getElementById("powerCV").value;
	var maxSpeed = document.getElementById("maxSpeed").value;
	var exitRoads = document.getElementById("exitRoads[]");
	var startDate = document.getElementById("startDate").value;
	var endDate = document.getElementById("endDate").value;
	var arrayOfVers = [verCarPlate(carPlate), verIdCon(idCon),verBrand(brand), verModel(model),
						verSeats(seats), verDoors(doors), verGearShift(gearShift),
						verTypeEngine(typeEngine), verPower(powerCV),
						verSpeed(maxSpeed), verExitRoads(exitRoads), verStartDate(startDate), verEndDate(endDate)];
	var arrayOfElements = ["carPlate", "idCon","brand", "model", "seats", "doors",
							"gearShift", "typeEngine",
							"powerCV", "maxSpeed", "exitRoads","startDate", "endDate"];
	//////
	for (i = 0; i < arrayOfVers.length; i++) {
		if (!arrayOfVers[i]){
			document.getElementById(arrayOfElements[i] + 'Error').innerHTML = "The " + arrayOfElements[i] + " of the car isn't valid.";
			errorDet = true;
		}else {
			document.getElementById(arrayOfElements[i] + 'Error').innerHTML = "";
		}// end_else
	}// end_for
	if (errorDet == false) {
		document.formCars.submit();
		if ($mode == 0) {
			document.formCars.action = "index.php?page=controllerCars&op=create";
		}else {
			document.formCars.action = "index.php?page=controllerCars&op=update";
		}// end_else
	}else {
		return false;
	}// end_else
}
