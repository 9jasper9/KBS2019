<?php session_start();
if(strpos($_SERVER['PHP_SELF'], "products.php")) {
    if(!isset($_GET['category'])) {
        header('Location: index.php');
    }
}
include_once "includes/getPDO.php";
$connection = getPDO();

include_once "classes/products.class.php";
$products_class = new products();

include_once "classes/user.php";
$user_class = new user();

if(isset($_POST["register"])){

    $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $pass = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_STRING);
    $pass1 = filter_input(INPUT_POST, "psw-repeat", FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
    $lastname  = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
    $birthdate = filter_input(INPUT_POST, "date", FILTER_SANITIZE_STRING);
    $phone     = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);

    $postcode=filter_input(INPUT_POST, "postal_code", FILTER_SANITIZE_STRING);
    $huisnummer=filter_input(INPUT_POST, "street_number", FILTER_SANITIZE_STRING);
    $woonplaats=filter_input(INPUT_POST, "locality", FILTER_SANITIZE_STRING);
    $straatnaam=filter_input(INPUT_POST, "route", FILTER_SANITIZE_STRING);

    if($pass==$pass1){
        $message = $user_class->createAccount($email, $pass, $firstname, $lastname, $phone, $birthdate, $postcode, $huisnummer, $woonplaats, $straatnaam);
    }
}

if (isset($_POST['gebruikersnaam'], $_POST['wachtwoord'])) {
    $username = filter_input(INPUT_POST, "gebruikersnaam");
    $password = filter_input(INPUT_POST, "wachtwoord");
    if (strpos($username, '@') !== false) {
        $message = $user_class->login($username, $password);
    }
    else{
        $message = "Dit is geen correct e-mailadres.";
    }
}
if(isset($_GET['logout'])) {
    $user_class->logout();
}
 if (filter_has_var(INPUT_POST, "productid")) {
        $id = filter_input(INPUT_POST, "productid");
        $amount = filter_input(INPUT_POST, "productamount");

        if (isset($_SESSION["winkelmandje"])) {
            $winkelmandje = $_SESSION["winkelmandje"];
        } else {
            $winkelmandje = array();
        }

        $product["aantal"] = $amount;

        $winkelmandje[$id] = $product;

        $_SESSION["winkelmandje"] = $winkelmandje;

        if($amount <= 0) {
            unset($_SESSION['winkelmandje'][$id]);
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WWI Webshop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Wide World Importers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <?php if(!isset($_SESSION["userID"])) { ?>
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="document.location.href='regpage.php'"> Registreren</button>&nbsp;
                <a class="btn btn-outline-primary my-2 my-sm-0" href="inloggen.php">Inloggen</a>&nbsp;
                <?php } else {
                    $user = $user_class->fetch($_SESSION["userID"]); ?>
                    <b class="text-light my-2 my-sm-0" id="login-msg">Welkom <?php echo ucfirst($user["voornaam"]); ?></b>&nbsp;
                    <a class="btn btn-outline-danger my-2 my-sm-0" href="?logout=1">Uitloggen</a>&nbsp;
                <?php } ?>
                <a class="btn btn-outline-light my-2 my-sm-0" href="mand.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Winkelwagen <?php if(isset($_SESSION['winkelmandje'])) { ?>  <span id="cartcount"> <?php echo count($_SESSION["winkelmandje"]); ?></span><?php } ?></a>
            </form>
        </div>
    </nav>
</header>
<div id="sub_nav" class="row">
    <a href="index.php" class="col-lg-3">
        <img src="images/logo.png"
             class="img-fluid"
             alt="Wide World Importers">
    </a>
    <div class="col-lg-9">
        <form class="form-inline mt-2 mt-md-0" id="sub-nav-search" method="get" action="products.php">
            <input name="category" type="hidden" value="<?php if(isset($_GET['category'])){echo htmlspecialchars($_GET['category']);}else{ echo '0';}?>">
            <input name="search" class="form-control mr-sm-2 col-lg-8" type="text" placeholder="Search" aria-label="Search" value="<?php if(isset($_GET['search'])){echo htmlspecialchars($_GET['search']);} ?>">
            <button class="btn btn-primary my-2 my-sm-0 col-lg-2" type="submit">Zoeken</button>
        </form>
    <?php
        //include ("$connection");
        
    // momenteel gebruiken we de products class universele functie.
    // deze functie is daar geintegreerd, dus is hier enkel voor historische redenen aanwezig.
    // (oftewel, niet meer nodig, maar gewoon laten staan.)
        if (false and isset($_GET['search'])) { // Altijd FALSE
         print($_GET['search']);
         $search_sql = $connection->prepare("SELECT * from stockitems WHERE StockItemName LIKE :search");
         $search="%".$_GET['search']."%";
         $search_sql->bindparam(':search',$search,PDO::PARAM_STR);
         $search_sql->execute();
         $search_result=$search_sql->fetchAll();


         if(count($search_result)>0) {
         print("<p> search results </p>");
         
         foreach($search_result as $key => $product) {

            
        ?>
        <div class="col-lg-3 product-col">
                            <div class="card">
                                <span class="badge badge-dark">&euro; <?php echo number_format($product['RecommendedRetailPrice'], 2); ?></span>
                                <div class="card-body card-product">
                                    <h5 class="card-title"><?php echo $product['StockItemName']; ?></h5>
                                    <a href="#" class="btn btn-primary btn-block">Bekijken</a>
                                </div>
                            </div>
                        </div>
            <?php    }
        } else {
            echo "No results found";
        }
        }

        ?>
    </div>
</div>