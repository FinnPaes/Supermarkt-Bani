<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
</head>
<body>
<?php
require_once("includes/nav.php");
?>
<main>
<?php
$gebruikerID = $_SESSION["id"];

if(empty($_SESSION["email"])) {
    header("Location: .");
} else {
    // Pak alles in winkelwagen van gebruiker
    $stmt = $connect->prepare("SELECT * FROM winkelwagen WHERE gebruikerID = :gebruikerID");
    $stmt->execute(array(
        ":gebruikerID" => $gebruikerID
    ));
    $winkelwagenItems = $stmt->fetchAll(PDO::FETCH_OBJ);
    $winkelwagenItemsAantal = $stmt->rowCount();

    if ($winkelwagenItemsAantal < 1) {
        echo '<h1 class="winkelwagen-titel">Het lijkt erop dat u winkelwagen leeg is...</h1>';
    } else {
        echo '<h1 class="winkelwagen-titel">Winkelwagen:</h1>';
        $subTotaal = 0;

        foreach ($winkelwagenItems as $winkelwagenItem) {
            $productID = $winkelwagenItem->productID;
            $aantal = $winkelwagenItem->aantal;
        
            $stmt = $connect->prepare("SELECT * FROM producten WHERE id = :productID");
            $stmt->execute(array(
                ":productID" => $productID
            ));
            $product = $stmt->fetch(PDO::FETCH_OBJ);
        
            $productFoto = $product->foto;
            $productNaam = $product->naam;
            $productPrijs = $product->prijs;
            $productVoorraad = $product->voorraad;
            $subTotaal = $subTotaal + $productPrijs * $aantal;
            
            echo '<div class="winkelwagen-product-wrapper">
            <div class="winkelwagen-product-container">
                <img src="'. $productFoto .'" />
                <h1>'. $productNaam .'</h1>
                <p>'. $productPrijs .'&euro; /stuk</p>
            </div>
            <div class="winkelwagen-product-container">
                <form action="" method="POST">
                <input type="submit" class="winkelwagen-aantalknop" value="-" name="min">
                <p class="winkelwagen-aantal">'. $aantal .'</p>
                <input type="submit" class="winkelwagen-aantalknop" value="+" name="plus"><br>
                <input type="submit" class="winkelwagen-verwijderen" value="Verwijderen" name="verwijderen">
            </div>
        </div>
        ';
        }
        echo '<div class="winkelwagen-afrekenen">
        <p>Totaal: '. $subTotaal .'&euro;</p>
        <form type="POST" action="">
            <input type="submit" value="Afrekenen" name="afrekenen">
        </form>
    </div>';
    }
}

if(isset($_POST["afrekenen"])) {
    $stmt = $connect->prepare("INSERT INTO bestellingen (gebruikerID, subtotaal, datum) VALUES (:gebruikerID, :subtotaal, :datum)");
    $stmt->execute(array(
        ":gebruikerID" => $gebruikerID,
        ":subtotaal" => $subTotaal,
        ":datum" => date("Y-m-d")
    ));

    $stmt = $connect->prepare("SELECT bestellingaantal FROM gebruikers WHERE id = :gebruikerID");
    $stmt->execute(array(
        ":gebruikerID" => $gebruikerID
    ));
    $bestellingaantalDB = $stmt->fetch(PDO::FETCH_OBJ);
    $bestellingaantal = $bestellingaantalDB->bestellingaantal;
    $bestellingaantal++;
    echo $bestellingaantal;

    $stmt = $connect->prepare("UPDATE gebruikers SET bestellingaantal = :bestellingaantal WHERE id = :gebruikerID");
    $stmt->execute(array(
        ":bestellingaantal" => $bestellingaantal,
        ":gebruikerID" => $gebruikerID
    ));

    $stmt = $connect->prepare("DELETE FROM winkelwagen WHERE gebruikerID = :gebruikerID");
    $stmt->execute(array(
        ":gebruikerID" => $gebruikerID
    ));
    
    header("Location: mijnaccount.php");
    exit;
    
}
?>


</main>

<script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</body>
</html>