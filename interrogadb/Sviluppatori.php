<html>
  <head>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina protetta</title>
  <link rel="stylesheet" href="style.css">
  </head>
  <body class="bodycl">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  
    <?php
session_start();
if($_SESSION["UTENTE"]==""){    
    echo "accesso non consentito";
    header("location:login.html");
}
?>
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
  
<?php
try {
    $servername = "localhost";
    $username = "utente";
    $password = "12345";
    $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if(isset($_GET["Casa"])){
      $sql = 'SELECT G.Titolo AS NomeGioco, S.Nome AS NomeSviluppatore, SP.locazione AS SedePrincipale
      FROM GiochiSviluppatori GS
      JOIN Giochi G ON GS.IdGioco = G.IdGioco
      JOIN Sviluppatori S ON GS.IdSviluppatore = S.IdSviluppatore
      JOIN sede_principale SP ON S.Sede_principale = SP.id_sede
      WHERE S.Nome = :nomeCasaProduttrice;';
       $statement = $conn->prepare($sql);
      $statement->bindParam(':nomeCasaProduttrice', $_GET["Casa"], PDO::PARAM_STR);
    $statement->execute();
    $data = $statement->fetchAll();
    }else{
    $sql = 'SELECT G.Titolo AS NomeGioco, S.Nome AS NomeSviluppatore, SP.locazione AS SedePrincipale FROM GiochiSviluppatori GS JOIN Giochi G ON GS.IdGioco = G.IdGioco JOIN Sviluppatori S ON GS.IdSviluppatore = S.IdSviluppatore JOIN sede_principale SP ON S.Sede_principale = SP.id_sede;';
    $statement = $conn->prepare($sql);
    $statement->execute();
    $data = $statement->fetchAll();
    }
    echo '<table class="table table-dark table-striped">
    <thead>
    <tr>
      <th scope="col">Titolo</th>
      <th scope="col">Sviluppatore</th>
      <th scope="col">Sede Sviluppatore</th>
    </tr>
  </thead>
         <tbody>';
  foreach ($data as $row) {
    echo '<tr>'.'<td>'.$row[0].'</td>'.'<td>'. $row[1].'</td>'.'<td>'. $row[2].'</td>'.'</tr>' ;
  }
  echo  '</tbody>
        </table>';
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


//close the connection
$conn = null;


?>
  </div>
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="genreDropdown" data-bs-toggle="dropdown" aria-expanded="false">
       Casa di sviluppo
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
    
    
    $queryGeneri = 'SELECT Nome FROM sviluppatori;';
        $statementGeneri = $conn->prepare($queryGeneri);
        $statementGeneri->execute();
        $case = $statementGeneri->fetchAll();
        foreach ($case as $casa) {
            echo '<li><a class="dropdown-item" href="Sviluppatori.php?Casa='. $casa['Nome'] .'">' . $casa['Nome'] . '</a></li>';
        }
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>
    </ul>
</div>
</body>
</html>