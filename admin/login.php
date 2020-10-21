<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login &mdash; Bani Supermarkt</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/style.css" />
    <script src="https://kit.fontawesome.com/0724c1067d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once("includes/nav.php");
if(empty($_SESSION["token"])) {
    // Niks
} else {
    header("Location: index.php");
}

if(isset($_POST["login"])) {
    $errorMessage = "";

    $token = $_POST["token"];

    if ($token == "") {

    }

    if ($errorMessage == "") {
        try {
            $stmt = $connect->prepare("SELECT * FROM admin WHERE token = :token");
            $stmt->execute(array(
                ":token" => $token
            ));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data == false) {
                $errorMessage = "De admin token klopt niet";
            } else {
                if ($token == $data["token"]) {
                    $_SESSION["token"] = $data["token"];

                    header("Location: index.php");
                    exit;
                } else {
                    $errorMessage = "De admin token klopt niet";
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
        <input type="text" placeholder="Admin Token" class="login-register-formulier-input" name="token" required>

        <input type="submit" value="Inloggen" class="login-register-formulier-btn" name="login">
    </div>
</form>

</main>
</body>
</html>