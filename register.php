<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
    <script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once("includes/nav.php");
if(empty($_SESSION["email"])) {
    // Niks
} else {
    header("Location: .");
}

// Registratie process

if(isset($_POST["register"])) {
    $errorMessage = "";

    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $rawWachtwoord = $_POST["wachtwoord"];
    $wachtwoord = password_hash($rawWachtwoord, PASSWORD_BCRYPT);
    $postcode = $_POST["postcode"];
    $huisnummer = $_POST["huisnummer"];
    $straatnaam = $_POST["straatnaam"];
    $woonplaats = $_POST["woonplaats"];

    if ($naam == "") {
        $errorMessage = "Geen naam ingevuld";
    }
    if ($email == "") {
        $errorMessage = "Geen E-mail ingevuld";
    }
    if ($rawWachtwoord == "") {
        $errorMessage = "Geen wachtwoord ingevuld";
    }
    if ($postcode == "") {
        $errorMessage = "Geen postcode ingevuld";
    }
    if ($huisnummer == "") {
        $errorMessage = "Geen huisnummer ingevuld";
    }
    if ($straatnaam == "") {
        $errorMessage = "Geen straatnaam ingevuld";
    }
    if ($woonplaats == "") {
        $errorMessage = "Geen woonplaats ingevuld";
    }

    if (strlen($rawWachtwoord) < 6) {
        $errorMessage = "Wachtwoord moet minimaal 6 tekens bevatten";
    }

    if ($errorMessage == "") {
        try {
            $stmt = $connect->prepare("INSERT INTO gebruikers (naam, email, wachtwoord, postcode, huisnummer, straatnaam, woonplaats) VALUES (:naam, :email, :wachtwoord, :postcode, :huisnummer, :straatnaam, :woonplaats)");
            $stmt->execute(array(
                ":naam" => $naam,
                ":email" => $email,
                ":wachtwoord" => $wachtwoord,
                ":postcode" => $postcode,
                ":huisnummer" => $huisnummer,
                ":straatnaam" => $straatnaam,
                ":woonplaats" => $woonplaats
            ));
            header("Location: login.php");
            exit;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>
<main>

<form action="" method="POST" class="login-register-formulier">
    <div class="login-register-header">
        <h1>Registreren</h1>
        <?php if(isset($errorMessage)) { echo "<p class='login-register-error'>" . $errorMessage . "</p>"; } ?>
    </div>
    <div class="login-register-content">
        <input type="text" placeholder="Naam" class="login-register-formulier-input" name="naam" required>
        <input type="email" placeholder="E-mail" class="login-register-formulier-input" name="email" required>
        <input type="password" placeholder="Wachtwoord" class="login-register-formulier-input" name="wachtwoord" required>
        <input type="text" placeholder="Postcode" class="login-register-formulier-input" maxlength="7" name="postcode" required>
        <input type="text" placeholder="Huisnummer" class="login-register-formulier-input" name="huisnummer" required>
        <input type="text" placeholder="Straatnaam" class="login-register-formulier-input" name="straatnaam" required>
        <input type="text" placeholder="Woonplaats" class="login-register-formulier-input" name="woonplaats" required>

        <input type="submit" value="Registreren" class="login-register-formulier-btn" name="register">
        <p>Heeft u al een account? <a href="login.php">Log in!</a></p>
    </div>
</form>

</main>
</body>
</html>