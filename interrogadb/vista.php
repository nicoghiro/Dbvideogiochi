<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina protetta</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
</head>
<body class="bodycl">
    <?php
    session_start();
    if($_SESSION["UTENTE"]==""){    
        echo "accesso non consentito";
        header("location:login.html");
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="reindirammento.php?selezionato=vista">Videogiochi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reindirammento.php?selezionato=Sviluppatori">Sviluppatori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reindirammento.php?selezionato=Commenti">Commenti</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="mt-5 text-center">
        <h1 class="h1pers">Videogiochi</h1>
    </div>
    <div class="table-responsive mt-4">
        <?php
        try {
            $servername = "localhost";
            $username = "utente";
            $password = "12345";
            $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if(isset($_GET["delete"])) {
                $deleteId = $_GET["delete"];
                $deleteGamesQuery = "DELETE FROM GiochiSviluppatori WHERE IdGioco = :id";
                $deleteGamesStatement = $conn->prepare($deleteGamesQuery);
                $deleteGamesStatement->bindParam(':id', $deleteId, PDO::PARAM_INT);
                $deleteGamesStatement->execute();
                
                $deleteReviewsQuery = "DELETE FROM recensioni WHERE IdGioco = :id";
                $deleteReviewsStatement = $conn->prepare($deleteReviewsQuery);
                $deleteReviewsStatement->bindParam(':id', $deleteId, PDO::PARAM_INT);
                $deleteReviewsStatement->execute();
                
                $deleteQuery = "DELETE FROM giochi WHERE IdGioco = :id";
                $deleteStatement = $conn->prepare($deleteQuery);
                $deleteStatement->bindParam(':id', $deleteId, PDO::PARAM_INT);
                $deleteStatement->execute();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
            if(isset($_GET["edit"])) {
              header("location:modifica_gioco.php?id=".$_GET["edit"]);
            }
            
            if(isset($_GET["Genere"])) {
                $genereSelezionato = $_GET["Genere"];
                $sql = 'SELECT * FROM giochi WHERE Genere = :genere;';
                $statement = $conn->prepare($sql);
                $statement->bindParam(':genere', $genereSelezionato, PDO::PARAM_STR);
                $statement->execute();
                $data = $statement->fetchAll();
            } else {
                $sql = 'SELECT * FROM giochi;';
                $statement = $conn->prepare($sql);
                $statement->execute();
                $data = $statement->fetchAll();
            }
            
            echo '<table class="table table-dark table-striped">
            <thead>
            <tr>
                <th scope="col">Titolo</th>
                <th scope="col">Genere</th>
                <th scope="col">Piattaforma</th>
                <th scope="col">Anno rilascio</th>
                <th scope="col">Azioni</th>
            </tr>
            </thead>
            <tbody>';
            
            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>' . $row['Titolo'] . '</td>';
                echo '<td>' . $row['Genere'] . '</td>';
                echo '<td>' . $row['Piattaforma'] . '</td>';
                echo '<td>' . $row['AnnoLancio'] . '</td>';
                echo '<td><a href="?edit=' . $row['IdGioco'] . '" class="btn btn-primary">Modifica</a>';
                echo '<a href="?delete=' . $row['IdGioco'] . '" class="btn btn-danger">Elimina</a></td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        // Chiudi la connessione
        $conn = null;
        ?>
    </div>
    <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="genreDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Filtra per Genere
    </button>
    <ul class="dropdown-menu" aria-labelledby="genreDropdown">
    <?php
try {
    $servername = "localhost";
    $username = "utente";
    $password = "12345";
    $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    $queryGeneri = 'SELECT DISTINCT Genere FROM giochi;';
        $statementGeneri = $conn->prepare($queryGeneri);
        $statementGeneri->execute();
        $generi = $statementGeneri->fetchAll();
        foreach ($generi as $genere) {
            echo '<li><a class="dropdown-item" href="vista.php?Genere='. $genere['Genere'] .'">' . $genere['Genere'] . '</a></li>';'</a></li>';
        }
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>
    </ul>
</div>
<div class="mt-3 text-center">
        <a href="aggiungi_Gioco.php" class="btn btn-success">Aggiungi Videogioco</a>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>