<?php
class Utils {
    //////
    public static function check($plate) {
        //////
        $value = false;
        $query = new Querys();
        $check = $query -> select();
        foreach ($check as $row) {
            if ($row['carPlate'] == $plate) {
                $value = true;
            }// end_if
        }// end_foreach
        //////
        return $value;
    }// end_check
    //////

    public static function consoleLog($data) {
        //////
        echo "<script>console.log('PHP: " . $data . "');</script>";
    }// end_consoleLog
    //////

    public static function redirect($url){
        //////
        die('<script>window.location.href="' . $url . '";</script>');
    }// end_redirect
    //////

    public static function formComplete($formData) {
        //////
		$carplate = $formData['carPlate'];
		$idCon = $formData['idCon'];
        $brand = $formData['brand'];
        $model = $formData['model'];
        $seats = $formData['seats'];
        $doors = $formData['doors'];
        $powerCV = "";
        $maxSpeed = $formData['maxSpeed'];
        $startDate = $formData['startDate'];
		$endDate = $formData['endDate'];
		$roadsArray = "";
        if (($_GET['op'] == "update") && ($_GET['carPlate'])) {
			$mode = 1;
			$redirect = "index.php?page=our-cars&op=list";
			$powerCV = $formData['cv'];
			$roadsArray = explode(":", $formData['roads']);
			/////
		}else {
			$mode = 0;
			$redirect = "index.php?page=our-cars&op=list";
			$powerCV = $formData['powerCV'];
			$roadsArray = $_POST?$_POST['exitRoads']:"";
			//////
        }// end_else
		//////
		if ($formData['idCon'] == "UM007") {
			$checkUM = "selected";
		}else if($formData['idCon'] == "GA003") {
			$checkGA = "selected";
		}else if ($formData['idCon'] == "CM005") {
			$checkCM = "selected";
		}else if ($formData['idCon'] == "AS002") {
			$checkAS = "selected";
		}else if ($formData['idCon'] == "AO006") {
			$checkAO = "selected";
		}else if ($formData['idCon'] == "AO001") {
			$checkAO1 = "selected";
		}else if ($formData['idCon'] == "AN004") {
			$checkAN = "selected";
		}
		if ($formData['gearShift'] == "Manual") {
			$checkMan = "checked";
		}else if ($formData['gearShift'] == "Auto") {
			$checkAuto = "checked";
		}// end_else
		//////
		if ($formData['typeEngine'] == "Electric") {
			$checkElec = "selected";
		}else if ($formData['typeEngine'] == "Hybrid") {
			$checkHyb = "seleted";
		}else if ($formData['typeEngine'] == "Combustion") {
			$checkComb = "selected";
		}// end_else
		//////
		
		if (in_array("City", $roadsArray)) {
			$checkCity = "selected";
		}// end_if
		if (in_array("Roadway", $roadsArray)) {
			$checkRWay = "selected";
		}// end_if
		if (in_array("Road", $roadsArray)) {
			$checkRoad = "selected";
		}// end_if
		if (in_array("Rural", $roadsArray)) {
			$checkRural = "selected";
		}// end_if
		if (in_array("Mountain", $roadsArray)) {
			$checkMnt = "selected";
		}// end_if
		//////
		if ($formData['extras'] == "Yes") {
			$checkExt = "checked";
		}// end_if
		//////
		return array('carPlate' => $carplate, 'checkUM' => $checkUM, 'checkGA' => $checkGA, 'checkCM' => $checkCM, 'checkAS' => $checkAS, 'checkAO' => $checkAO, 'checkAO1' => $checkAO1, 'checkAN' => $checkAN,'brand' => $brand, 'model' => $model, 'seats' => $seats, 
		'doors' => $doors, 'checkMan' => $checkMan, 'checkAuto' => $checkAuto,'powerCV' => $powerCV, 
		'maxSpeed' => $maxSpeed, 'checkElec' => $checkElec, 'checkHyb' => $checkHyb, 'checkComb' => $checkComb,
		'checkCity' => $checkCity, 'checkRWay' => $checkRWay, 'checkRoad' => $checkRoad, 'checkRural' => $checkRural,
		'checkMnt' => $checkMnt, 'checkExt' => $checkExt, 'startDate' => $startDate, 'endDate' => $endDate,'redirect' => $redirect, 'mode' => $mode);
    }// end_formComplete
}