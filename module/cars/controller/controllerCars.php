<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include($path . "module/cars/model/DAOCars.php");
include($path . "module/cars/model/Utils.php");

session_start();
//////

$carPlates = new Querys();
//////

switch($_GET['op']) {
	case 'list';
		try {
			$resSel = $carPlates -> select();
			include("module/cars/view/ourCars.php");
		}catch(Exception $e) {
			Utils::consoleLog($e);
			Utils::redirect('index.php?page=our-cars&op=list');
		}// end_catch
		break;
		//////
	case 'create';
		if ($_POST){
			if (!Utils::check($_POST['carPlate'])){
				$resIns = $carPlates -> insert($_POST);
				if ($resIns['done']) {
					echo '<script language="javascript">alert("Car created successfully.")</script>';
					Utils::redirect('index.php?page=our-carss&op=list');
				}else {
					$error = $resIns['error'];
				}// end_else2
			}else {
				$error = "You can't create a car with the Plate duplicated.";
			}// end_else
		}// end_if
		include ("module/cars/view/formCars.php");
		break;
		//////
	case 'read';
		$selCar = $carPlates -> selectOne($_GET['carPlate']);
		if (Utils::check($selCar['carPlate'])) {
			include ("module/cars/view/readCar.php");
		}else {
			Utils::redirect('index.php?page=error503');
		}// end_else
		break;
		//////
	case 'delete';
		if (!Utils::check($_GET['carPlate'])) {
			Utils::redirect('index.php?page=error503');
		}//end_if
		if ($_GET['del'] == "1") {
			$resDel = $carPlates -> delete($_GET['carPlate']);
			if ($resDel['done']) {
				echo '<script language="javascript">alert("Car deleted successfully.")</script>';
        		Utils::redirect('index.php?page=our-cars&op=list');
			}else {
				Utils::redirect('index.php?page=error503');
			}// end_else
		}else {
			$resUp = $carPlates -> selectOne($_GET['carPlate']);
			include ("module/cars/view/deleteCar.php");
		}// end_else
		break;
		//////
	case 'deleteAll';
		if ($_GET['delA'] == 1) {
			$resDelAll = $carPlates -> deleteAll();
			if ($resDelAll) {
				echo '<script language="javascript">alert("All Cars Deleted.")</script>';
        		Utils::redirect('index.php?page=our-cars&op=list');
			}else {
				Utils::redirect('index.php?page=error503');
			}// end_else
		}// end_if
		echo '<script language=javascript>
					if(confirm("Do you want to delete all the Cars?")){
						window.location.href="index.php?page=our-cars&op=deleteAll&delA=1";
					}else {
						window.location.href="index.php?page=our-cars&op=list";
					}
		</script>';
		break;
		//////
	case 'update';
		if (!Utils::check($_GET['carPlate'])) {
			Utils::redirect('index.php?page=error503');
		}//end_if
		//////
		if ($_POST) {
			if ((!Utils::check($_POST['carPlate'])) || ($_GET['carPlate'] == $_POST['carPlate'])) {
				$resUpd = $carPlates -> update($_POST, $_GET['carPlate']);
				if ($resUpd['done']) {
					echo '<script language="javascript">alert("Car updated successfully.")</script>';
					Utils::redirect('index.php?page=our-cars&op=list');
				}else {
					$error = $resUpd['error'];
				}//end_else2
			}else {
				$error = "You can't update a car with the Plate duplicated.";
			}// end_else
		}// end_if
		//////
		$resUp = $carPlates -> selectOne($_GET['carPlate']);
		include ("module/cars/view/formCars.php");
		break;
		//////
	case 'readModal';
		$readModalSel = $carPlates -> selectOne($_GET['carPlate']);
		if ($readModalSel) {
			echo json_encode($readModalSel);
			exit;
		}else {
			echo "error";
			exit;
		}// end_else
		break;
		//////
	default;
		include ("view/inc/error404.html");
		break;
		//////
}// end_switch