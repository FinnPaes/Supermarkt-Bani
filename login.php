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
    // Niks
} else {
    header("Location: .");
}

// Login process

if(isset($_POST["login"])) {
    $errorMessage = "";

    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];

    if ($email == "") {
        $errorMessage = "Geen email ingevuld";
    }
    if ($wachtwoord == "") {
        $errorMessage = "Geen wachtwoord ingevuld";
    }

    if ($errorMessage == "") {
        try {
            $stmt = $connect->prepare("SELECT * FROM gebruikers WHERE email = :email");
            $stmt->execute(array(
                ":email" => $email
            ));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data == false) {
                $errorMessage = "De combinatie van het Email adres en wachtwoord komen niet overeen bij ons";
            } else {
                if (password_verify($wachtwoord, $data["wachtwoord"])) {
                    $_SESSION["id"] = $data["id"];
                    $_SESSION["naam"] = $data["naam"];
                    $_SESSION["email"] = $data["email"];
                    
                    header("Location: .");
                    exit;
                } else {
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