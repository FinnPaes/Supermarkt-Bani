<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
</head>
<body>
<?php
require_once("includes/nav.php");
?>
<main>

<div class="home-welkom">
    <h1>Welkom bij <span>Supermarkt Bani</span>!</h1>
</div>

<div class="home-productkeuze">
    <div class="home-productkeuze-product" onclick="categorie('groenten_fruit');">
        <img src="assets/images/home/groenten_fruit.webp" />
        <h2>Groenten en fruit</h2>
    </div>
    <div class="home-productkeuze-product" onclick="categorie('vis_vlees');">
        <img src="assets/images/home/vlees.webp" />
        <h2>Vis en vlees</h2>
    </div>
    <div class="home-productkeuze-product" onclick="categorie('kaas_vleeswaren');">
        <img src="assets/images/home/vleeswaren.webp" />
        <h2>Kaas en vleeswaren</h2>
    </div>
    <div class="home-productkeuze-product" onclick="categorie('bakkerij');">
        <img src="assets/images/home/bakkerij.webp" />
        <h2>Bakkerij</h2>
    </div>
    <div class="home-productkeuze-product" onclick="categorie('dranken');">
        <img src="assets/images/home/dranken.webp" />
        <h2>Dranken</h2>
    </div>
    <div class="home-productkeuze-product" onclick="categorie('alcohol');">
        <img src="assets/images/home/alcohol.webp" />
        <h2>Alcoholische dranken</h2>
    </div>
</div>

<script src="assets/scripts/index.js"></script>

<script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</main>
</body>
</html>