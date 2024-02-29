<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Videogioco</title>
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
        <h1 class="mb-4">Aggiungi Videogioco</h1>
        <form action="aggiungi_videogioco_process.php" method="post">
            <div class="mb-3">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="titolo" required>
            </div>
            <div class="mb-3">
                <label for="genere" class="form-label">Genere</label>
                <input type="text" class="form-control" id="genere" name="genere" required>
            </div>
            <div class="mb-3">
                <label for="anno_lancio" class="form-label">Anno di Lancio</label>
                <input type="number" class="form-control" id="anno_lancio" name="anno_lancio" required>
            </div>
            <div class="mb-3">
                <label for="piattaforma" class="form-label">Piattaforma</label>
                <input type="text" class="form-control" id="piattaforma" name="piattaforma" required>
            </div>
            <div class="mb-3">
                <label for="sviluppatore" class="form-label">Sviluppatore</label>
                <select class="form-select" id="sviluppatore" name="sviluppatore" required>
                    <option selected disabled>Seleziona uno sviluppatore</option>
                    <?php
                    try {
                        $servername = "localhost";
                        $username = "utente";
                        $password = "12345";
                        $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $querySviluppatori = 'SELECT * FROM sviluppatori;';
                        $statementSviluppatori = $conn->prepare($querySviluppatori);
                        $statementSviluppatori->execute();
                        $sviluppatori = $statementSviluppatori->fetchAll();
                        foreach ($sviluppatori as $sviluppatore) {
                            echo '<option value="' . $sviluppatore['IdSviluppatore'] . '">' . $sviluppatore['Nome'] . '</option>';
                        }
                    } catch(PDOException $e) {
                        echo "Connessione al database fallita: " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </form>
    </div>
</body>
</html>
