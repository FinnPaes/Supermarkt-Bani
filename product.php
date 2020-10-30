<?php
require_once("includes/database.php");
$productID = $_GET["id"];
$stmt = $connect->prepare("SELECT * FROM producten WHERE id = :productID");
$stmt->execute(array(
    ":productID" => $productID
));
$product = $stmt->fetch(PDO::FETCH_OBJ);

if ($product === false) {
    header("Location: .");
}

$productNaam = $product->naam;
$productBeschrijving = $product->beschrijving;
$productFoto = $product->foto;
$productPrijs = $product->prijs;
$productVoorraad = $product->voorraad;

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productNaam; ?> &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
</head>
<body>
<?php
require_once("includes/nav.php");
?>
<main>

<div class="productpagina-product">
    <img src="<?php echo $productFoto; ?>" />
    <h1><?php echo $productNaam; ?></h1>
    <h2><span>Prijs:</span> <?php echo $productPrijs; ?>&euro;<br><span>Voorraad:</span> <?php echo $productVoorraad; ?></h2>
    <hr>
    <p><?php echo nl2br($productBeschrijving); ?></p>
    <button>Bestellen</button>
</div>
    
<script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>

</main>
</body>
</html>