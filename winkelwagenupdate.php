<?php
require_once("includes/database.php");

if(isset($_GET["id"])) { // Product toevoegen aan winkelwagen
    $gebruikerID = $_SESSION["id"];
    $productID = $_GET["id"];

    // Haal alle producten uit winkelwagen van gebruiker
    $stmt = $connect->prepare("SELECT * FROM winkelwagen WHERE gebruikerID = :gebruikerID AND productID = :productID");
    $stmt->execute(array(
        ":gebruikerID" => $gebruikerID,
        ":productID" => $productID
    ));
    $winkelwagenData = $stmt->fetch(PDO::FETCH_OBJ);

    // Haal product info op voor later gebruik met voorraad etc.
    $stmt2 = $connect->prepare("SELECT * FROM producten WHERE id = :productID");
    $stmt2->execute(array(
        ":productID" => $productID
    ));
    $productInformatie = $stmt2->fetch(PDO::FETCH_OBJ);


    if ($stmt->rowCount() < 1) { // Als het product nog niet voor komt in de winkelwagen wordt het product toegevoegd
        $stmt = $connect->prepare("INSERT INTO winkelwagen (gebruikerID, productID, aantal) VALUES (:gebruikerID, :productID, :aantal)");
        $stmt->execute(array(
            ":gebruikerID" => $gebruikerID,
            ":productID" => $productID,
            ":aantal" => 1
        ));

        // Haal 1 voorraad aantal eraf
        $huidigVoorraad = $productInformatie->voorraad;
        $huidigVoorraad--;
        $stmt = $connect->prepare("UPDATE producten SET voorraad = :voorraad WHERE id = :productID");
        $stmt->execute(array(
            ":voorraad" => $huidigVoorraad,
            ":productID" => $productID
        ));
        
        header("Location: .");
    } else { // Als het product al in de winkelwagen zit, wordt het aantal met 1+ opgeplust.
        $huidigAantal = $winkelwagenData->aantal;
        $huidigAantal++;

        $stmt = $connect->prepare("UPDATE winkelwagen SET aantal = :aantal WHERE gebruikerID = :gebruikerID AND productID = :productID");
        $stmt->execute(array(
            ":aantal" => $huidigAantal,
            ":gebruikerID" => $gebruikerID,
            ":productID" => $productID
        ));

        // Haal 1 voorraad aantal eraf
        $huidigVoorraad = $productInformatie->voorraad;
        $huidigVoorraad--;
        $stmt = $connect->prepare("UPDATE producten SET voorraad = :voorraad WHERE id = :productID");
        $stmt->execute(array(
            ":voorraad" => $huidigVoorraad,
            ":productID" => $productID
        ));
        
        header("Location: .");

    }


} else { // Als er geen parameters in de URL zijn meegegeven wordt je hier weggestuurd.
    header("Location: .");
}

?>