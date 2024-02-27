<?php
session_start();
if(empty($_SESSION["UTENTE"])){    
    echo "Accesso non consentito";
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_sviluppatore']) && isset($_POST['nome_sviluppatore']) && isset($_POST['sede_principale'])) {
        $idSviluppatore = $_POST['id_sviluppatore'];
        $nomeSviluppatore = $_POST['nome_sviluppatore'];
        $sedePrincipale = $_POST['sede_principale'];

        try {
            $servername = "localhost";
            $username = "utente";
            $password = "12345";
            $dbname = "videogamesdb";
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $querySede = "SELECT Sede_principale FROM Sviluppatori WHERE IdSviluppatore = :id";
            $statementSede = $conn->prepare($querySede);
            $statementSede->bindParam(':id', $idSviluppatore, PDO::PARAM_INT);
            $statementSede->execute();
            $row = $statementSede->fetch(PDO::FETCH_ASSOC);
            $idSedePrincipale = $row['Sede_principale'];
            $updateSedeQuery = "UPDATE sede_principale SET locazione = :sedePrincipale WHERE id_sede = :idSede";
            $statementSede = $conn->prepare($updateSedeQuery);
            $statementSede->bindParam(':sedePrincipale', $sedePrincipale, PDO::PARAM_STR);
            $statementSede->bindParam(':idSede', $idSedePrincipale, PDO::PARAM_INT);
            $statementSede->execute();
            $updateQuery = "UPDATE Sviluppatori SET Nome = :nome WHERE IdSviluppatore = :id";
            $statement = $conn->prepare($updateQuery);
            $statement->bindParam(':nome', $nomeSviluppatore, PDO::PARAM_STR);
            $statement->bindParam(':id', $idSviluppatore, PDO::PARAM_INT);
            $statement->execute();
            header("Location: Sviluppatori.php");
            exit;
        } catch(PDOException $e) {
            echo "Connessione fallita: " . $e->getMessage();
            exit;
        }
    } else {
        echo "Tutti i campi sono obbligatori";
        exit;
    }
} else {
    echo "Metodo di richiesta non valido";
    exit;
}
?>
