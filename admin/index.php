<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Omgeving &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/style.css" />
    <script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once("includes/nav.php");
if(empty($_SESSION["token"])) {
    header("Location: login.php");
}

?>
<main>

<a href="nieuwproduct.php" class="nieuw-product-toevoegen-index">Nieuw Product Toevoegen</a>
    
</main>
</body>
</html>