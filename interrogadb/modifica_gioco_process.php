<?php
// Verifica se è stato inviato un metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se tutti i campi sono stati compilati
    if (isset($_POST['id']) && isset($_POST['titolo']) && isset($_POST['genere']) && isset($_POST['anno_lancio']) && isset($_POST['piattaforma']) && isset($_POST['sviluppatore'])) {
        $id = $_POST['id'];
        $titolo = $_POST['titolo'];
        $genere = $_POST['genere'];
        $anno_lancio = $_POST['anno_lancio'];
        $piattaforma = $_POST['piattaforma'];
        $id_sviluppatore = $_POST['sviluppatore'];

        try {
            // Connessione al database
            $servername = "localhost";
            $username = "utente";
            $password = "12345";
            $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepara e esegue la query di aggiornamento per il gioco
            $query = "UPDATE giochi SET Titolo = :titolo, Genere = :genere, AnnoLancio = :anno_lancio, Piattaforma = :piattaforma WHERE IdGioco = :id";
            $statement = $conn->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':titolo', $titolo, PDO::PARAM_STR);
            $statement->bindParam(':genere', $genere, PDO::PARAM_STR);
            $statement->bindParam(':anno_lancio', $anno_lancio, PDO::PARAM_INT);
            $statement->bindParam(':piattaforma', $piattaforma, PDO::PARAM_STR);
            $statement->execute();

            // Prepara e esegue la query di aggiornamento per gli sviluppatori collegati al gioco
            $updateSviluppatoriQuery = "UPDATE giochisviluppatori SET IdSviluppatore = :id_sviluppatore WHERE IdGioco = :id";
            $updateSviluppatoriStatement = $conn->prepare($updateSviluppatoriQuery);
            $updateSviluppatoriStatement->bindParam(':id', $id, PDO::PARAM_INT);
            $updateSviluppatoriStatement->bindParam(':id_sviluppatore', $id_sviluppatore, PDO::PARAM_INT);
            $updateSviluppatoriStatement->execute();

            // Reindirizza alla pagina principale
            header("Location: vista.php");
            exit;
        } catch (PDOException $e) {
            // Gestione dell'errore di connessione al database
            echo "Errore di connessione al database: " . $e->getMessage();
        }

        // Chiudi la connessione
        $conn = null;
    } else {
        // Se non sono stati compilati tutti i campi, reindirizza alla pagina di errore
        header("Location: modifica_gioco.php");
        exit;
    }
} else {
    // Se non è stato inviato un metodo POST, reindirizza alla pagina di errore
    header("Location: modifica_gioco.php");
    exit;
}
?>
