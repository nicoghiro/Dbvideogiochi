<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Sviluppatore</title>
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
        <h1 class="mb-4">Aggiungi Sviluppatore</h1>
        <form action="aggiungi_sviluppatore_process.php" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Sviluppatore</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="sede_principale" class="form-label">Sede Principale</label>
                <input type="text" class="form-control" id="sede_principale" name="sede_principale" required>
            </div>
            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </form>
    </div>
</body>
</html>
