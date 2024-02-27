<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se i campi richiesti sono vuoti
    if (empty($_POST["nome"]) || empty($_POST["sede_principale"])) {
        echo "Compilare tutti i campi.";
        exit;
    }

    // Sanitizzazione dei dati inseriti
    $nome = htmlspecialchars($_POST["nome"]);
    $sede_principale = htmlspecialchars($_POST["sede_principale"]);

    try {
        // Connessione al database
        $servername = "localhost";
        $username = "utente";
        $password = "12345";
        $dbname = "videogamesdb";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inserimento della nuova sede principale (se non esiste già)
        $stmt = $conn->prepare("INSERT INTO sede_principale (locazione) VALUES (:sede)");
        $stmt->bindParam(':sede', $sede_principale);
        $stmt->execute();

        // Recupero dell'ID della sede principale appena inserita
        $id_sede = $conn->lastInsertId();

        // Inserimento del nuovo sviluppatore
        $sql = "INSERT INTO sviluppatori (Nome, Sede_principale) VALUES (:nome, :sede_principale)";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
        $statement->bindParam(':sede_principale', $id_sede, PDO::PARAM_INT);
        $statement->execute();

        echo "Sviluppatore aggiunto con successo.";
    } catch(PDOException $e) {
        echo "Errore durante l'inserimento dello sviluppatore: " . $e->getMessage();
    }

    // Chiudi la connessione
    $conn = null;
} else {
    echo "Metodo non consentito.";
}
?>
