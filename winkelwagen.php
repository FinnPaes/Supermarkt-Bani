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
$gebruikerID = $_SESSION["id"]; // GebruikerID wordt veel gebruikt, uit sessie gehaald en in variable gezet.

if(empty($_SESSION["email"])) { // Kijk of persoon is ingelogd, zo nee: stuur door naar home pagina
    header("Location: .");
} else {
    // Pak alles in winkelwagen van gebruiker
    $stmt = $connect->prepare("SELECT * FROM winkelwagen WHERE gebruikerID = :gebruikerID"); // SQL Query
    $stmt->execute(array(
        ":gebruikerID" => $gebruikerID
    ));
    $winkelwagenItems = $stmt->fetchAll(PDO::FETCH_OBJ); // Pak alle items uit winkelwagen table
    $winkelwagenItemsAantal = $stmt->rowCount(); // Tel hoeveel items erin zitten.

    if ($winkelwagenItemsAantal < 1) { // Minder dan 1 item, dus geen items in winkelwagen, dan is winkelwagen leeg en krijg je dit bericht:
        echo '<h1 class="winkelwagen-titel">Het lijkt erop dat u winkelwagen leeg is...</h1>';
    } else { // Als er meer 0 rows uit de database komen gaan we die door printen
        echo '<h1 class="winkelwagen-titel">Winkelwagen:</h1>';
        $subTotaal = 0; // Prijs van alle producten defineren

        foreach ($winkelwagenItems as $winkelwagenItem) { // Voor elk item in de winkelwagen gaat dit uitgevoerd worden
            $productID = $winkelwagenItem->productID; // Sla product id op..
            $aantal = $winkelwagenItem->aantal; // Kijk hoeveel er in de winkelwagen zitten
        
            $stmt = $connect->prepare("SELECT * FROM producten WHERE id = :productID"); // SQL Query
            $stmt->execute(array( // Weer parameter binden en uitvoeren van query
                ":productID" => $productID
            ));
            $product = $stmt->fetch(PDO::FETCH_OBJ); // Data ophalen
        
            // Alle product info in variables zetten
            $productFoto = $product->foto;
            $productNaam = $product->naam;
            $productPrijs = $product->prijs;
            $productVoorraad = $product->voorraad;
            $subTotaal = $subTotaal + $productPrijs * $aantal; // Product * aantal optellen bij huidige subtotaal
            
            // echo het product in winkelwagen
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
        //Echo afreken knop
        echo '<div class="winkelwagen-afrekenen">
        <p>Totaal: '. $subTotaal .'&euro;</p>
        <form type="POST" action="">
            <input type="submit" value="Afrekenen" name="afrekenen" class="nieuw-product-toevoegen-index">
        </form>
    </div>';
    }
}

if(isset($_POST["afrekenen"])) { // Afreken knop ingedrukt
    $stmt = $connect->prepare("INSERT INTO bestellingen (gebruikerID, subtotaal, datum) VALUES (:gebruikerID, :subtotaal, :datum)"); //SQL Query
    $stmt->execute(array( // Parameters binden aan query en uitvoeren van SQL query...
        ":gebruikerID" => $gebruikerID,
        ":subtotaal" => $subTotaal,
        ":datum" => date("Y-m-d") // Datum van vandaag jaar-maand-dag wordt via PHP date erin gezet
    ));

    $stmt = $connect->prepare("SELECT bestellingaantal FROM gebruikers WHERE id = :gebruikerID"); // SQL query
    $stmt->execute(array( // Parameters binden aan query en uitvoeren van SQL query...
        ":gebruikerID" => $gebruikerID
    ));
    $bestellingaantalDB = $stmt->fetch(PDO::FETCH_OBJ); // Data ophalen uit database
    $bestellingaantal = $bestellingaantalDB->bestellingaantal;
    $bestellingaantal++; // Database bestellingaantal  +1, dit wordt later geupdate in database
    echo $bestellingaantal;

    $stmt = $connect->prepare("UPDATE gebruikers SET bestellingaantal = :bestellingaantal WHERE id = :gebruikerID"); // SQL query
    $stmt->execute(array( // Parameters binden aan query en uitvoeren van SQL query...
        ":bestellingaantal" => $bestellingaantal,
        ":gebruikerID" => $gebruikerID
    ));

    $stmt = $connect->prepare("DELETE FROM winkelwagen WHERE gebruikerID = :gebruikerID"); //SQL Query
    $stmt->execute(array( // Parameters binden aan query en uitvoeren van SQL query...
        ":gebruikerID" => $gebruikerID
    ));
    
    header("Location: mijnaccount.php"); // Stuur naar mijn account wanneer bestelling voltooid is.
    exit;
    
}
?>


</main>

<script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</body>
</html>