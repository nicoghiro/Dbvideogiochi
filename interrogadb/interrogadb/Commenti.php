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
    <?php
session_start();
if($_SESSION["UTENTE"]==""){    
    echo "accesso non consentito";
    header("location:login.html");
}
?>
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
          <a class="nav-link active" aria-current="page" href="reindirammento.php?selezionato=vista">Videgames</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="mt-5 text-center">
  <h1 class="h1pers">Commenti</h1>
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
    
    
    $sql ='SELECT Giochi.Titolo, Recensioni.Voto, Recensioni.Commento FROM  Giochi INNER JOIN Recensioni ON Giochi.IdGioco = Recensioni.IdGioco;';
    $statement = $conn->prepare($sql);
    $statement->execute();
    $data = $statement->fetchAll();
    echo '<table class="table table-dark table-striped">
    <thead>
    <tr>
      <th scope="col">Titolo</th>
      <th scope="col">Voto</th>
      <th scope="col">Commento</th>
    </tr>
  </thead>
         <tbody>';
  foreach ($data as $row) {
    echo '<tr>'.'<td>'.$row['Titolo'].'</td>'.'<td>'. $row['Voto'].'</td>'.'<td>'. $row['Commento'].'</td>'.'</tr>' ;
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
</body>
</html>