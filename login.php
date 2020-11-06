<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css" />
</head>
<body>
<?php
require_once("includes/nav.php");
if(empty($_SESSION["email"])) {
    // Sessie leeg, persoon mag inloggen
} else {
    header("Location: ."); // Verstuur naar homepagina, gebruiker is al ingelogd
}

// Login process

if(isset($_POST["login"])) { // Login submit knop ingedrukt bij form
    $errorMessage = "";

    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];

    if ($email == "") { // Kijk of email niet leeg is
        $errorMessage = "Geen email ingevuld";
    }
    if ($wachtwoord == "") { // Kijk of wachtwoord niet leeg is
        $errorMessage = "Geen wachtwoord ingevuld";
    }

    if ($errorMessage == "") { // Kijk of errormessage variable leeg is, als dat zo is, voer dit uit.
        try { // Try capsule zodat errors opgepakt kunnen worden
            $stmt = $connect->prepare("SELECT * FROM gebruikers WHERE email = :email"); // SQL Query
            $stmt->execute(array( // Uitvoeren met execute array, hierdoor worden :email gebind vanuit variable
                ":email" => $email
            ));
            $data = $stmt->fetch(PDO::FETCH_ASSOC); // Haal de data op die uit de database voor komt

            if ($data == false) { // Kijk of de data leeg is, zo ja:
                $errorMessage = "De combinatie van het Email adres en wachtwoord komen niet overeen bij ons";
            } else { // Data is niet leeg, ga door
                if (password_verify($wachtwoord, $data["wachtwoord"])) { // Check de hash met het plain wachtwoord wat in de wachtwoord veld stond
                    $_SESSION["id"] = $data["id"]; // Maak sessies aan met id, naam en de email van de gebruiker. Deze kan later gebruikt worden en staat lokaal in de browser. Soort cookie.
                    $_SESSION["naam"] = $data["naam"];
                    $_SESSION["email"] = $data["email"];
                    
                    header("Location: ."); // Stuur naar home pagina als inlog process klaar is.
                    exit;
                } else { // Als de hash niet overeenkwam met het wachtwoord wat de gebruiker invulde krijgt hij deze error.
                    $errorMessage = "De combinatie van het Email adres en wachtwoord komen niet overeen bij ons";
                }
            }
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
        }
    }
}

?>
<main>

<form action="" method="POST" class="login-register-formulier">
    <div class="login-register-header">
        <h1>Inloggen</h1>
        <?php if(isset($errorMessage)) { echo "<p class='login-register-error'>" . $errorMessage . "</p>"; } ?>
    </div>
    <div class="login-register-content">
        <input type="email" placeholder="E-mail" class="login-register-formulier-input" name="email" required>
        <input type="password" placeholder="Wachtwoord" class="login-register-formulier-input" name="wachtwoord" required>

        <input type="submit" value="Inloggen" class="login-register-formulier-btn" name="login">
        <p>Heeft u nog geen account? <a href="register.php">Maak een account!</a></p>
    </div>
</form>

<script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</main>
</body>
</html>