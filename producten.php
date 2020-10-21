<?php

$categorie = $_GET['categorie'];
$correctCategorieen = array("groenten_fruit", "vis_vlees", "kaas_vleeswaren", "bakkerij", "dranken", "alcohol");
$paginaTitel = "Laden...";
if (!in_array($categorie, $correctCategorieen)) {
    header("Location: index.php");
}

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
    <script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once("includes/nav.php");
?>
<main>
<div class="producten-wrapper">
<?php

$stmt = $connect->prepare("SELECT * FROM producten WHERE categorie = :categorie");
$stmt->execute(array(
    ":categorie" => $categorie
));
$producten = $stmt->fetchAll(PDO::FETCH_OBJ);

foreach($producten as $product) {
echo '
<div class="producten-product">
    <img src="'. $product->foto .'" />
    <h1>'. $product->naam .'</h1>
    <h2>Voorraad: '. $product->voorraad .'</h2>
    <h3>Prijs: '. $product->prijs .'&#8364;</h3>
    <a href="#">
        <button class="producten-product-knop" style="width: 80%;">Bekijken</button>
    </a>
    <a href="#">
        <button class="producten-product-knop" style="width: 18%;"><i class="fas fa-shopping-cart"></i></button>
    </a>
</div>';
}

?>




</div>

</main>
</body>
</html>