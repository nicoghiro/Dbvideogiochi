<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_commento'], $_POST['voto'], $_POST['commento'])) {
        $id_commento = $_POST['id_commento'];
        $voto = $_POST['voto'];
        $commento = $_POST['commento'];
        $gioco = $_POST['gioco'];
        $servername = "localhost";
        $username = "utente";
        $password = "12345";
        $db = "videogamesdb";
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE Recensioni SET Voto = :voto, Commento = :commento, IdGioco = :idGioco WHERE IdRecensione = :id";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':voto', $voto);
            $statement->bindParam(':commento', $commento);
            $statement->bindParam(':idGioco', $gioco);
            $statement->bindParam(':id', $id_commento);
            $statement->execute();
            header("Location: Commenti.php");
            exit();
        } catch(PDOException $e) {
            echo "Errore di connessione al database: " . $e->getMessage();
        }
    } else {
        echo "Errore: Dati mancanti.";
    }
} else {
    header("Location: mod_commento.php");
    exit();
}

