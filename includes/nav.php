<?php
require_once("includes/database.php");
if(empty($_SESSION["email"])) {
?> <!-- Navigatie van gebruiker die NIET ingelogd is! -->
<nav>
    <div class="nav-container nav-links">
        <a href="."><h1>Supermarkt Bani</h1></a>
    </div>
    <div class="nav-container nav-rechts">
        <a href="#">Aanbiedingen</a>
        <a href="login.php">Inloggen</a>
    </div>
</nav>
<br><br><br><br><br><br>
<?php
} else {
?> <!-- Navigatie van gebruiker die WEL ingelogd is -->
<nav>
    <div class="nav-container nav-links">
        <a href="."><h1>Supermarkt Bani</h1></a>
    </div>
    <div class="nav-container nav-rechts">
        <a href="#">Aanbiedingen</a>
        <a href="mijnaccount.php">Mijn Account</a>
        <a href="uitloggen.php">Uitloggen</a>
        <a href="winkelwagen.php"><i class="fas fa-shopping-cart"></i></a>
    </div>
</nav>
<br><br><br><br><br><br>
<?php
}
?>