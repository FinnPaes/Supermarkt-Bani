<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
    <script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once("includes/nav.php");
?>
<main>

<h1 class="winkelwagen-titel">Winkelwagen:</h1>

<div class="winkelwagen-product-wrapper">
    <div class="winkelwagen-product-container">
        <img src="assets/images/producten/5f8eb69cb89886.36909379.jpg" />
        <h1>Banaan</h1>
        <p>2.00&euro; /stuk</p>
    </div>
    <div class="winkelwagen-product-container">
        <form action="" method="POST">
        <input type="submit" class="winkelwagen-aantalknop" value="-" name="min">
        <p class="winkelwagen-aantal">12</p>
        <input type="submit" class="winkelwagen-aantalknop" value="+" name="plus"><br>
        <input type="submit" class="winkelwagen-verwijderen" value="Verwijderen" name="verwijderen">
    </div>
</div>


    
</main>
</body>
</html>