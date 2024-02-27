<?php
session_start();
if(empty($_SESSION["UTENTE"])){    
    echo "Accesso non consentito";
    header("Location: login.html");
    exit; 
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID non valido";
    exit;
}

$idSviluppatore = $_GET['id'];

try {
    $servername = "localhost";
    $username = "utente";
    $password = "12345";
    $dbname = "videogamesdb";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT S.Nome AS NomeSviluppatore, SP.locazione AS SedePrincipale, S.Sede_principale AS IdSedePrincipale
            FROM Sviluppatori S
            JOIN sede_principale SP ON S.Sede_principale = SP.id_sede
            WHERE S.IdSviluppatore = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $idSviluppatore, PDO::PARAM_INT);
    $statement->execute();
    $data = $statement->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connessione fallita: " . $e->getMessage();
    exit;
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Sviluppatore</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Modifica Sviluppatore</h1>
        <form action="modifica_sviluppatore_process.php" method="POST">
            <input type="hidden" name="id_sviluppatore" value="<?= $idSviluppatore ?>">
            <div class="mb-3">
                <label for="nome_sviluppatore" class="form-label">Nome Sviluppatore</label>
                <input type="text" class="form-control" id="nome_sviluppatore" name="nome_sviluppatore" value="<?= $data['NomeSviluppatore'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="sede_principale" class="form-label">Sede Principale</label>
                <input type="text" class="form-control" id="sede_principale" name="sede_principale" value="<?= $data['SedePrincipale'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salva Modifiche</button>
        </form>
    </div>
</body>
</html>
