<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['titolo']) && isset($_POST['genere']) && isset($_POST['anno_lancio']) && isset($_POST['piattaforma']) && isset($_POST['sviluppatore'])) {
        $titolo = $_POST['titolo'];
        $genere = $_POST['genere'];
        $anno_lancio = $_POST['anno_lancio'];
        $piattaforma = $_POST['piattaforma'];
        $sviluppatore_id = $_POST['sviluppatore'];
        try {
            $servername = "localhost";
            $username = "utente";
            $password = "12345";
            $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO giochi (Titolo, Genere, AnnoLancio, Piattaforma) VALUES (:titolo, :genere, :anno_lancio, :piattaforma)";
            $statement = $conn->prepare($query);
            $statement->bindParam(':titolo', $titolo);
            $statement->bindParam(':genere', $genere);
            $statement->bindParam(':anno_lancio', $anno_lancio);
            $statement->bindParam(':piattaforma', $piattaforma);
            $statement->execute();
        
            $gioco_id = $conn->lastInsertId();
        
            $query_giochisviluppatori = "INSERT INTO giochisviluppatori (IdGioco, IdSviluppatore) VALUES (:id_gioco, :id_sviluppatore)";
            $statement_giochisviluppatori = $conn->prepare($query_giochisviluppatori);
            $statement_giochisviluppatori->bindParam(':id_gioco', $gioco_id);
            $statement_giochisviluppatori->bindParam(':id_sviluppatore', $sviluppatore_id);
            $statement_giochisviluppatori->execute();
            header("Location: reindirammento.php?selezionato=vista");
            exit();
        } catch(PDOException $e) {
            echo "Errore di connessione al database: " . $e->getMessage();
        }
        $conn = null;
    } else {
        echo "Tutti i campi sono obbligatori.";
    }
} else {
    header("Location: aggiungi_videogioco.php");
    exit();
}
?>
