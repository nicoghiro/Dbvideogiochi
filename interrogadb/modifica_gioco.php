<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Videogioco</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
if($_SESSION["UTENTE"]==""){    
    echo "accesso non consentito";
    header("location:login.html");
}
?>
    <div class="container mt-5">
        <h1 class="mb-4">Modifica Videogioco</h1>
        <?php
        if(isset($_GET['id'])) {
            $gioco_id = $_GET['id'];

            try {
                $servername = "localhost";
                $username = "utente";
                $password = "12345";
                $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = "SELECT * FROM giochi WHERE IdGioco = :id";
                $statement = $conn->prepare($query);
                $statement->bindParam(':id', $gioco_id, PDO::PARAM_INT);
                $statement->execute();
                $gioco = $statement->fetch(PDO::FETCH_ASSOC);

                if($gioco) {
                    echo '
                    <form action="modifica_gioco_process.php" method="post">
                        <input type="hidden" name="id" value="' . $gioco['IdGioco'] . '">
                        <div class="mb-3">
                            <label for="titolo" class="form-label">Titolo</label>
                            <input type="text" class="form-control" id="titolo" name="titolo" value="' . $gioco['Titolo'] . '" required>
                        </div>
                        <div class="mb-3">
                            <label for="genere" class="form-label">Genere</label>
                            <input type="text" class="form-control" id="genere" name="genere" value="' . $gioco['Genere'] . '" required>
                        </div>
                        <div class="mb-3">
                            <label for="anno_lancio" class="form-label">Anno di Lancio</label>
                            <input type="number" class="form-control" id="anno_lancio" name="anno_lancio" value="' . $gioco['AnnoLancio'] . '" required>
                        </div>
                        <div class="mb-3">
                            <label for="piattaforma" class="form-label">Piattaforma</label>
                            <input type="text" class="form-control" id="piattaforma" name="piattaforma" value="' . $gioco['Piattaforma'] . '" required>
                        </div>
                        <div class="mb-3">
                            <label for="sviluppatore" class="form-label">Sviluppatore</label>
                            <select class="form-select" id="sviluppatore" name="sviluppatore" required>';
                                try {
                                    $querySviluppatori = 'SELECT * FROM sviluppatori;';
                                    $statementSviluppatori = $conn->prepare($querySviluppatori);
                                    $statementSviluppatori->execute();
                                    $sviluppatori = $statementSviluppatori->fetchAll();
                                    foreach ($sviluppatori as $sviluppatore) {
                                        $selected = ($sviluppatore['IdSviluppatore'] == $gioco['IdSviluppatore']) ? 'selected' : '';
                                        echo '<option value="' . $sviluppatore['IdSviluppatore'] . '" ' . $selected . '>' . $sviluppatore['Nome'] . '</option>';
                                    }
                                } catch(PDOException $e) {
                                    echo "Connessione al database fallita: " . $e->getMessage();
                                }
                            echo '</select>
                        </div>
                        <button type="submit" class="btn btn-primary">Modifica</button>
                    </form>';
                } else {
                    echo "<p>Nessun gioco trovato con l'ID fornito.</p>";
                }
            } catch(PDOException $e) {
                echo "Connessione al database fallita: " . $e->getMessage();
            }
            $conn = null;
        } else {
            echo "<p>Non è stato fornito un ID per il gioco da modificare.</p>";
        }
        ?>
    </div>
</body>
</html>
