<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw Product &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/style.css" />
    <script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once("includes/nav.php");
if(empty($_SESSION["token"])) {
    header("Location: login.php");
}

if(isset($_POST["productmaken"])) {
    $errorMessage = "";

    $naam = $_POST["naam"];
    $prijs = $_POST["prijs"];
    $voorraad = $_POST["voorraad"];
    $beschrijving = $_POST["beschrijving"];
    $foto = $_FILES["foto"];
    $categorie = $_POST["categorie"];

    if ($naam == "") {
        $errorMessage = "Alle velden moeten ingevuld worden";
    }
    if ($prijs == "") {
        $errorMessage = "Alle velden moeten ingevuld worden";
    }
    if ($voorraad == "") {
        $errorMessage = "Alle velden moeten ingevuld worden";
    }
    if ($beschrijving == "") {
        $errorMessage = "Alle velden moeten ingevuld worden";
    }
    if ($categorie == "") {
        $errorMessage = "Alle velden moeten ingevuld worden";
    }

    if ($errorMessage == "") {
        if(isset($_FILES["foto"])) {
        $foto_naam = $foto["name"];
        $foto_tmp = $foto["tmp_name"];
        $foto_size = $foto["size"];
        $foto_error = $foto["error"];

        $foto_ext = explode('.', $foto_naam);
        $foto_ext = strtolower(end($foto_ext));

        $toegestaanFotoType = array("jpg", "png", "jpeg");

        if (in_array($foto_ext, $toegestaanFotoType)) {
            if ($foto_error === 0) {
                
                $foto_naam_nieuw = uniqid('', true) . '.' . $foto_ext;
                $foto_locatie = "../assets/images/producten/" . $foto_naam_nieuw;
                $foto_locatieDB = "assets/images/producten/" . $foto_naam_nieuw;

                if (move_uploaded_file($foto_tmp, $foto_locatie)) {
                    $stmt = $connect->prepare("INSERT INTO producten (categorie, naam, beschrijving, foto, prijs, voorraad) VALUES (:categorie, :naam, :beschrijving, :foto, :prijs, :voorraad)");
                    $stmt->execute(array(
                        ":categorie" => $categorie,
                        ":naam" => $naam,
                        ":beschrijving" => $beschrijving,
                        ":foto" => $foto_locatieDB,
                        ":prijs" => $prijs,
                        ":voorraad" => $voorraad
                    ));
                    header("Location: .");
                    exit;
                }

            }
        }


    }
}
}

?>
<main>

<form action="" method="POST" enctype="multipart/form-data" class="nieuwproduct-form">
    <input type="text" class="nieuwproduct-form-input" placeholder="Naam" name="naam">
    <input type="text" class="nieuwproduct-form-input" placeholder="Prijs" name="prijs">
    <input type="number" class="nieuwproduct-form-input" placeholder="Voorraad" min="0" name="voorraad">
    <textarea name="beschrijving" rows="5" placeholder="Beschrijving van het product..." name="beschrijving"></textarea>

    <input type="file" name="foto" accept="image/x-png,image/jpeg" class="nieuwproduct-form-uploader">

    <input type="radio" id="groenten_fruit" value="groenten_fruit" name="categorie"><label for="groenten_fruit">groenten_fruit</label><br>
    <input type="radio" id="vis_vlees" value="vis_vlees" name="categorie"><label for="vis_vlees">vis_vlees</label><br>
    <input type="radio" id="kaas_vleeswaren" value="kaas_vleeswaren" name="categorie"><label for="kaas_vleeswaren">kaas_vleeswaren</label><br>
    <input type="radio" id="bakkerij" value="bakkerij" name="categorie"><label for="bakkerij">bakkerij</label><br>
    <input type="radio" id="dranken" value="dranken" name="categorie"><label for="dranken">dranken</label><br>
    <input type="radio" id="alcohol" value="alcohol" name="categorie"><label for="alcohol">alcohol</label><br>

    <input type="submit" name="productmaken" value="Maak product">

    
</form>
    
</main>
</body>
</html>