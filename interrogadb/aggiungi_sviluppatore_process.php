<?php
session_start();
if($_SESSION["UTENTE"]==""){    
    echo "accesso non consentito";
    header("location:login.html");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nome"]) || empty($_POST["sede_principale"])) {
        echo "Compilare tutti i campi.";
        exit;
    }
    $nome = htmlspecialchars($_POST["nome"]);
    $sede_principale = htmlspecialchars($_POST["sede_principale"]);

    try {
        $servername = "localhost";
        $username = "utente";
        $password = "12345";
        $dbname = "videogamesdb";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO sede_principale (locazione) VALUES (:sede)");
        $stmt->bindParam(':sede', $sede_principale);
        $stmt->execute();
        $id_sede = $conn->lastInsertId();
        $sql = "INSERT INTO sviluppatori (Nome, Sede_principale) VALUES (:nome, :sede_principale)";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
        $statement->bindParam(':sede_principale', $id_sede, PDO::PARAM_INT);
        $statement->execute();
        header("Location: Sviluppatori.php");
    } catch(PDOException $e) {
        echo "Errore durante l'inserimento dello sviluppatore: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo "Metodo non consentito.";
}
?>
