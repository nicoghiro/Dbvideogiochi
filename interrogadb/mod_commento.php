<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Commento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Modifica Commento</h1>
        <?php
        $servername = "localhost";
        $username = "utente";
        $password = "12345";
        $db = "videogamesdb";
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if(isset($_GET['id'])) {
                $id_commento = $_GET['id'];
                $sql = "SELECT * FROM Recensioni WHERE IdRecensione = :id";
                $statement = $conn->prepare($sql);
                $statement->bindParam(':id', $id_commento);
                $statement->execute();
                $commento = $statement->fetch(PDO::FETCH_ASSOC);
                $sql_giochi = "SELECT IdGioco, Titolo FROM Giochi";
                $statement_giochi = $conn->query($sql_giochi);
                $giochi = $statement_giochi->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "Errore: ID del commento non specificato.";
            }
        } catch(PDOException $e) {
            echo "Connessione fallita: " . $e->getMessage();
        }
        ?>
        <form action="SalvaModifica.php" method="POST">
            <input type="hidden" name="id_commento" value="<?php echo $commento['IdRecensione']; ?>">
            <div class="mb-3">
                <label for="gioco" class="form-label">Gioco</label>
                <select class="form-select" id="gioco" name="gioco" required>
                    <?php foreach ($giochi as $gioco) : ?>
                        <option value="<?php echo $gioco['IdGioco']; ?>" <?php if ($gioco['IdGioco'] == $commento['IdGioco']) echo 'selected'; ?>><?php echo $gioco['Titolo']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="voto" class="form-label">Voto (da 1 a 10)</label>
                <input type="number" class="form-control" id="voto" name="voto" min="1" max="10" value="<?php echo $commento['Voto']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="commento" class="form-label">Commento</label>
                <textarea class="form-control" id="commento" name="commento" rows="5" required><?php echo $commento['Commento']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salva Modifiche</button>
        </form>
        <a href="Commenti.php" class="btn btn-secondary mt-3">Annulla</a>
    </div>
</body>
</html>
