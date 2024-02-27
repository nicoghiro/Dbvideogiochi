<?php
session_start();
if($_SESSION["UTENTE"]==""){    
    echo "Accesso non consentito";
    header("location:login.html");
    exit();
}
try {
    $servername = "localhost";
    $username = "utente";
    $password = "12345";
    $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connessione fallita: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_gioco'], $_POST['voto'], $_POST['commento'])) {
        $titolo = $_POST['id_gioco'];
        $voto = $_POST['voto'];
        $commento = $_POST['commento'];
        $sql = "INSERT INTO Recensioni (IdGioco, Voto, Commento) VALUES (:idGioco, :voto, :commento)";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':idGioco', $titolo);
        $statement->bindParam(':voto', $voto);
        $statement->bindParam(':commento', $commento);
        $statement->execute();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $sql = "DELETE FROM Recensioni WHERE IdRecensione = :idRecensione";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':idRecensione', $deleteId);
    $statement->execute();
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit'])) {
    header("Location: mod_commento.php?id=" . $_GET['edit']);
    exit();
}
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina protetta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bodycl">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Commenti</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reindirammento.php?selezionato=Sviluppatori">Sviluppatori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reindirammento.php?selezionato=vista">Videogiochi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="mt-5 text-center">
        <h1 class="h1pers">Commenti</h1>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">Titolo</th>
                    <th scope="col">Voto</th>
                    <th scope="col">Commento</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $sql = 'SELECT Giochi.Titolo, Recensioni.Voto, Recensioni.Commento,Recensioni.IdRecensione FROM  Giochi INNER JOIN Recensioni ON Giochi.IdGioco = Recensioni.IdGioco;';
                    $statement = $conn->prepare($sql);
                    $statement->execute();
                    $data = $statement->fetchAll();
                    foreach ($data as $row) {
                        echo '<tr>';
                        echo '<td>'.$row['Titolo'].'</td>';
                        echo '<td>'.$row['Voto'].'</td>';
                        echo '<td>'.$row['Commento'].'</td>';
                        echo '<td>';
                        echo '<a href="?edit='.$row['IdRecensione'].'" class="btn btn-primary btn-sm">Modifica</a>';
                        echo '<a href="?delete='.$row['IdRecensione'].'" class="btn btn-danger btn-sm">Elimina</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } catch(PDOException $e) {
                    echo "Connessione fallita: " . $e->getMessage();
                } 
                $conn = null;
                ?>
               
            </tbody>
        </table>
    </div>
    <div class="mt-3 text-center">
        <a href="aggiungi_commento.php" class="btn btn-success">Aggiungi commento</a>
    </div>
</body>
</html>
