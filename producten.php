<?php

$categorie = $_GET["categorie"]; // Pak categorie uit de GET url
$correctCategorieen = array("groenten_fruit", "vis_vlees", "kaas_vleeswaren", "bakkerij", "dranken", "alcohol"); // Alle categorien die bestaan
$paginaTitel = "Laden...";
if (!in_array($categorie, $correctCategorieen)) { // Als de categorie uit de GET url niet in de array staat, stuur naar home pagina.
    header("Location: index.php");
}

// Verander pagina titel naar de titel van de GET url
if ($categorie == "groenten_fruit") {
    $paginaTitel = "Groenten & Fruit";
} else if ($categorie == "vis_vlees") {
    $paginaTitel = "Vis & Vlees";
} else if ($categorie == "kaas_vleeswaren") {
    $paginaTitel = "Kaas & Vleeswaren";
} else if ($categorie == "bakkerij") {
    $paginaTitel = "Bakkerij";
} else if ($categorie == "dranken") {
    $paginaTitel = "Dranken";
} else if ($categorie == "alcohol") {
    $paginaTitel = "Alcoholische Dranken";
}



?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $paginaTitel; ?> &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
</head>
<body>
<?php
require_once("includes/nav.php"); // Importeer nav
?>
<main>
<?php
if(empty($_SESSION["email"])) { // Als je niet ingelogd bent krijg je een tekst bovenaan dat je een account moet maken om te bestellen.
    echo '<h1 class="u-moet-inloggen">Om te bestellen moet u een account aanmaken.</h1>';
}
?>
<div class="producten-wrapper">
<?php

$stmt = $connect->prepare("SELECT * FROM producten WHERE categorie = :categorie"); // SQL Query
$stmt->execute(array( // Bind :categorie en voer query uit.
    ":categorie" => $categorie
));
$producten = $stmt->fetchAll(PDO::FETCH_OBJ); // Haal de data op uit db

if(empty($_SESSION["email"])) { // Email sessie leeg? Dan mag je niet bestellen, dus andere knoppen/opties.
    foreach($producten as $product) {
        $voorraadKleur = "#000000"; // Standaard voorraadkleur (De voorraadkleur is de kleur van het getal hoeveel er in voorraad is)
        if ($product->voorraad <= 5) { // Als er 5 of minder in voorraad zijn, maak tekst oranje.
            $voorraadKleur = "#ff7900";
        }
        if ($product->voorraad <= 0) { // Als er minder dan 0 zijn, dus geen vooraad, maak het rood. !important voor overwrite CSS.
            $voorraadKleur = "#db0200!important";
        }
echo '
<div class="producten-product">
    <img src="'. $product->foto .'" />
    <h1>'. $product->naam .'</h1>
    <h2>Voorraad: <span style="color: '. $voorraadKleur .'">'. $product->voorraad .'</span></h2>
    <h3>Prijs: '. $product->prijs .'&#8364;</h3>
    <a href="product.php?id='. $product->id .'">
        <button class="producten-product-knop" style="width: 100%;">Bekijken</button>
    </a>
</div>';
}

} else { // Alles zelfde als hierboven, maar dan wel bestel knop, beetje dubbelop maar ja... je moet wat he
    foreach($producten as $product) {
        $voorraadKleur = "#000000";
        if ($product->voorraad <= 5) {
            $voorraadKleur = "#ff7900";
        }
        if ($product->voorraad <= 0) {
            $voorraadKleur = "#db0200!important";
        }

        if ($product->voorraad < 1) {
            echo '
            <div class="producten-product">
                <img src="'. $product->foto .'" />
                <h1>'. $product->naam .'</h1>
                <h2>Voorraad: <span style="color: '. $voorraadKleur .'">'. $product->voorraad .'</span></h2>
                <h3>Prijs: '. $product->prijs .'&#8364;</h3>
                <a href="product.php?id='. $product->id .'">
                    <button class="producten-product-knop" style="width: 80%;">Bekijken</button>
                </a>
                <button class="producten-product-knop" style="width: 18%;" onclick="alert(&#39;Dit product is helaas niet meer in voorraad.&#39;);"><i class="fas fa-shopping-cart"></i></button>
            </div>';   
        } else {
            echo '
        <div class="producten-product">
            <img src="'. $product->foto .'" />
            <h1>'. $product->naam .'</h1>
            <h2>Voorraad: <span style="color: '. $voorraadKleur .'">'. $product->voorraad .'</span></h2>
            <h3>Prijs: '. $product->prijs .'&#8364;</h3>
            <a href="product.php?id='. $product->id .'">
                <button class="producten-product-knop" style="width: 80%;">Bekijken</button>
            </a>
            <a href="winkelwagenupdate.php?id='. $product->id .'">
                <button class="producten-product-knop" style="width: 18%;"><i class="fas fa-shopping-cart"></i></button>
            </a>
        </div>';
        }
        }
        
}


?>




</div>

<script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</main>
</body>
</html>