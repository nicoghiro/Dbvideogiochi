<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Commento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Aggiungi un Commento</h1>
        <form action="Commenti.php" method="POST">
            <div class="mb-3">
                <label for="id_gioco" class="form-label">Gioco</label>
                <select class="form-select" id="id_gioco" name="id_gioco" required>
                    <option value="">Seleziona un gioco</option>
                    <?php
                    try {
                        $servername = "localhost";
                        $username = "utente";
                        $password = "12345";
                        $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT IdGioco, Titolo FROM Giochi";
                        $statement = $conn->prepare($sql);
                        $statement->execute();
                        $giochi = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($giochi as $gioco) {
                            echo "<option value='" . $gioco['IdGioco'] . "'>" . $gioco['Titolo'] . "</option>";
                        }
                    } catch(PDOException $e) {
                        echo "Connessione fallita: " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="voto" class="form-label">Voto (da 1 a 10)</label>
                <input type="number" class="form-control" id="voto" name="voto" min="1" max="10" required>
            </div>
            <div class="mb-3">
                <label for="commento" class="form-label">Commento</label>
                <textarea class="form-control" id="commento" name="commento" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Aggiungi Commento</button>
        </form>
        <a href="Commenti.php" class="btn btn-secondary mt-3">Torna alla Pagina Commenti</a>
    </div>
</body>
</html>
