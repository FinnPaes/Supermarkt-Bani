<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Account &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
</head>
<body>
<?php
require_once("includes/nav.php");
if(empty($_SESSION["email"])) {
    header("Location: .");
}
$stmt = $connect->prepare("SELECT * FROM gebruikers WHERE id = :id");
$stmt->execute(array(
    ":id" => $_SESSION["id"]
));
$gebruikersData = $stmt->fetch(PDO::FETCH_OBJ);

$gebruiker_naam = $gebruikersData->naam;
$gebruiker_email = $gebruikersData->email;
$gebruiker_bestellingaantal = $gebruikersData->bestellingaantal;
$gebruiker_woonplaats = $gebruikersData->woonplaats;
$gebruiker_straatnaam = $gebruikersData->straatnaam;
$gebruiker_postcode = $gebruikersData->postcode;
$gebruiker_huisnummer = $gebruikersData->huisnummer;



?>
<main>

<div class="mijn-account-wrapper">
    <div class="mijn-account-container" id="mijn-account-links">
        <h1>Account Gegevens</h1><br>
        <p><span>Naam:</span> <?php echo $gebruiker_naam; ?></p>
        <p><span>Email:</span> <?php echo $gebruiker_email; ?></p>
        <p><span>Totaal Aantal Bestellingen:</span> <?php echo $gebruiker_bestellingaantal; ?></p>
        <br><h1>Adres Gegevens</h1><br>
        <p><span>Woonplaats:</span> <?php echo $gebruiker_woonplaats; ?></p>
        <p><span>Straatnaam:</span> <?php echo $gebruiker_straatnaam; ?></p>
        <p><span>Postcode:</span> <?php echo $gebruiker_postcode; ?></p>
        <p><span>Huisnummer:</span> <?php echo $gebruiker_huisnummer; ?></p>
    </div>
    <div class="mijn-account-container" id="mijn-account-rechts">
        <h1>Mijn Bestellingen</h1>
<?php
if ($gebruiker_bestellingaantal < 1) {
    echo "<p class='mijn-account-nooit-besteld'>Geen bestellingen gevonden...</p>";
}
?>
    </div>
</div>
    
<script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</main>
</body>
</html>