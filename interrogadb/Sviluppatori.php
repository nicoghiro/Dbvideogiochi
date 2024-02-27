<?php
session_start();
if(empty($_SESSION["UTENTE"])){    
    echo "Accesso non consentito";
    header("Location: login.html");
    exit; 
}

try {
    $servername = "localhost";
    $username = "utente";
    $password = "12345";
    $dbname = "videogamesdb";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT G.Titolo AS NomeGioco, S.Nome AS NomeSviluppatore, SP.locazione AS SedePrincipale,S.idSviluppatore AS IdSviluppatore
            FROM GiochiSviluppatori GS
            JOIN Giochi G ON GS.IdGioco = G.IdGioco
            RIGHT JOIN Sviluppatori S ON GS.IdSviluppatore = S.IdSviluppatore
            JOIN sede_principale SP ON S.Sede_principale = SP.id_sede';
    if(isset($_GET["Casa"])) {
        $sql .= ' WHERE S.Nome = :nomeCasaProduttrice';
    }
    
    $statement = $conn->prepare($sql);
    if(isset($_GET["Casa"])) {
        $statement->bindParam(':nomeCasaProduttrice', $_GET["Casa"], PDO::PARAM_STR);
    }
    $statement->execute();
    $data = $statement->fetchAll();
} catch(PDOException $e) {
    echo "Connessione fallita: " . $e->getMessage();
    exit; 
}
if(isset($_GET["delete"])) {
  try {
      $deleteId = $_GET["delete"];
      $deleteGamesQuery = "DELETE FROM GiochiSviluppatori WHERE IdSviluppatore = :id";
      $deleteGamesStatement = $conn->prepare($deleteGamesQuery);
      $deleteGamesStatement->bindParam(':id', $deleteId, PDO::PARAM_INT);
      $deleteGamesStatement->execute();
      $deleteOrphanedGamesQuery = "DELETE FROM giochi WHERE IdGioco NOT IN (SELECT IdGioco FROM GiochiSviluppatori)";
      $deleteOrphanedGamesStatement = $conn->prepare($deleteOrphanedGamesQuery);
      $deleteOrphanedGamesStatement->execute();
      $deleteQuery = "DELETE FROM Sviluppatori WHERE IdSviluppatore = :id";
      $deleteStatement = $conn->prepare($deleteQuery);
      $deleteStatement->bindParam(':id', $deleteId, PDO::PARAM_INT);
      $deleteStatement->execute();
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
  } catch(PDOException $e) {
      echo "Errore durante l'eliminazione dello sviluppatore: " . $e->getMessage();
      exit;
  }
}
if(isset($_GET["edit"])) {
  header("Location:modifica_sviluppatore.php?id=".$_GET['edit']);
}
try {
    $queryCase = 'SELECT Nome FROM sviluppatori';
    $statementCase = $conn->query($queryCase);
    $case = $statementCase->fetchAll(PDO::FETCH_COLUMN);
} catch(PDOException $e) {
    echo "Errore durante il recupero delle case di sviluppo: " . $e->getMessage();
    exit; 
}

// Chiudi la connessione
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pagina protetta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
</head>
<body class="bodycl">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="reindirammento.php?selezionato=Sviluppatori">Sviluppatori</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reindirammento.php?selezionato=vista">Videogiochi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reindirammento.php?selezionato=Commenti">Commenti</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="mt-5 text-center">
        <h1 class="h1pers">Sviluppatori</h1>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">Titolo</th>
                    <th scope="col">Sviluppatore</th>
                    <th scope="col">Sede Sviluppatore</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= $row['NomeGioco'] ?></td>
                        <td><?= $row['NomeSviluppatore'] ?></td>
                        <td><?= $row['SedePrincipale'] ?></td>
                        <td>
                            <a href="?edit=<?= $row['IdSviluppatore'] ?>" class="btn btn-primary btn-sm">Modifica</a>
                            <a href="?delete=<?= $row['IdSviluppatore'] ?>" class="btn btn-danger btn-sm">Elimina</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="genreDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Casa di sviluppo
        </button>
        <ul class="dropdown-menu" aria-labelledby="genreDropdown">
            <?php foreach ($case as $casa): ?>
                <li><a class="dropdown-item" href="Sviluppatori.php?Casa=<?= $casa ?>"><?= $casa ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="mt-3 text-center">
        <a href="aggiungi_sviluppatore.php" class="btn btn-success">Aggiungi Sviluppatore</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
