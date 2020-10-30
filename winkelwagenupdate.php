<?php
require_once("includes/database.php");

if(isset($_GET["id"])) { // 
    $gebruikerID = $_SESSION["id"];
    $productID = $_GET["id"];

    $stmt = $connect->prepare("SELECT * FROM winkelwagen WHERE gebruikerID = :gebruikerID AND productID = :productID");
    $stmt->execute(array(
        ":gebruikerID" => $gebruikerID,
        ":productID" => $productID
    ));
    $winkelwagenData = $stmt->fetch(PDO::FETCH_OBJ);

    if ($stmt->rowCount() < 1) {
        $stmt = $connect->prepare("INSERT INTO winkelwagen (gebruikerID, productID, aantal) VALUES (:gebruikerID, :productID, :aantal)");
        $stmt->execute(array(
            ":gebruikerID" => $gebruikerID,
            ":productID" => $productID,
            ":aantal" => 1
        ));
        header("Location: .");
    } else {
        $huidigAantal = $winkelwagenData->aantal;
        $huidigAantal++;

        $stmt = $connect->prepare("UPDATE winkelwagen SET aantal = :aantal WHERE gebruikerID = :gebruikerID AND productID = :productID");
        $stmt->execute(array(
            ":aantal" => $huidigAantal,
            ":gebruikerID" => $gebruikerID,
            ":productID" => $productID
        ));
        header("Location: .");

    }


} else {
    header("Location: .");
}

?>