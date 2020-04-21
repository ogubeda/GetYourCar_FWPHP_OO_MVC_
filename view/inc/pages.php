<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'] . "/frameworkCars.v.1.3/";
//////
switch ($_GET['page']) {
	case "home";
		include ("module/home/controller/controllerHomePage.php");
		break;
	case "shop";
		include ("module/shop/controller/controllerShop.php");
		break;
	case "our-cars";
		if ($_SESSION['type'] == "admin") {
			include ("module/cars/controller/controllerCars.php");
		}else {
			include ("view/inc/error404.html");
		}// end_eñse
		break;
	case "our-brands";
		if ($_SESSION['type'] == 'admin') {
			include ("module/brand-crud/controller/controllerCrudBrand.php");
		}else {
			include ("view/inc/error404.html");
		}// end_else
		break;
	case "services";
		include ("module/services/services.html");
		break;
	case "contact";
		include ("module/contactus/controller/controllerContact.php");
		break;
	case "user-order";
		if ($_SESSION['type'] == "client") {
			include ("module/userOrder/controller/controllerUserOrder.php");
		}else {
			include ('view/inc/error404.html');
		}// end_else
		break;
	case "log-in";
		if (!isset($_SESSION['user'])) {
			include ("module/login/controller/controllerLogIn.php");
		}else {
			include ('view/inc/error404.html');
		}// end_else
		break;
	case 'profile';
		if (isset($_SESSION['user'])) {
			include ("module/profile/controller/controllerProfile.php");
		}else {
			include ("view/inc/error404.html");
		}// end_else
		break;
	case 'cart';
		include ("module/cart/controller/controllerCart.php");
		break;
	case "error404";
		include ("view/inc/" . $_GET['page'] . ".html");
		break;
	case "error503";
		include ("view/inc/" . $_GET['page'] . ".html");
		break;
	default;
		$_GET['op'] = "list";
		include ("module/home/controller/controllerHomePage.php");
		break;
}
?>