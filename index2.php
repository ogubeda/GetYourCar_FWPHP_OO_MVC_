<?php
    session_start();
	if ((isset($_GET['page'])) && ($_GET['page'] === "our-cars")){
		include("view/inc/topPageCars.html");
	}else if ((isset($_GET['page'])) && ($_GET['page'] === "user-order")){
        include ("view/inc/topPageUserOrder.html");
    }else if((isset($_GET['page'])) && ($_GET['page'] === "shop")) {
        include ("view/inc/topPageShop.html");
    }else if ((isset($_GET['page']) && ($_GET['page'] === "contact"))) {
        include ('view/inc/topPageContact.html');
    }else if ((isset($_GET['page'])) && ($_GET['page'] === 'log-in')) {
        include ('view/inc/topPageLogIn.html');
    }else if ((isset($_GET['page']) && ($_GET['page'] === 'our-brands'))) {
        include ('view/inc/topPageBrands.html');
    }else if ($_GET['page'] === 'profile') {
        include ('view/inc/topPageFav.html');
    }else if ($_GET['page'] === 'cart') {
        include ('view/inc/topPageCheckOut.html');
	}else {
		include ("view/inc/topPageHome.html");
	}// end_else
?>
<body>
    <div class="preloader">
        <span class="preloader-spin"></span>
    </div>
    <div class="site">
        <?php include("view/inc/menu.html"); ?>
    </div>
    <div class = "content">
        <?php include ("view/inc/pages.php");?>
    </div>
    <footer>
        <div class="footer-top">
            <div class="container">
                
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                
            </div>
        </div>
    </footer> 
</body>

</html>
