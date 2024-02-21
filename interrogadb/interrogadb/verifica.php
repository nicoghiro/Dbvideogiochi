<?php
session_start();
$utente=$_REQUEST["utente"];
$password=hash('sha512',$_REQUEST["password"]);

try {
    $servername = "localhost";
    $usernamedb = "utente";
    $passworddb = "12345";
    $conn = new PDO("mysql:host=$servername;dbname=videogamesdb", $usernamedb, $passworddb);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $sql = 'select Count(*) from utenti WHERE username = :type AND password= :type2;';
    $statement = $conn->prepare($sql);
    $statement->bindParam(':type', $utente, PDO::PARAM_STR);
    $statement->bindParam(':type2', $password, PDO::PARAM_STR);
    $statement->execute();
    $data = $statement->fetchAll();
  foreach ($data as $row) {
    if($row['Count(*)']==1){
    $_SESSION["UTENTE"]=$utente;
    header("location:vista.php");
    exit();
    }
  }
  header("location:login.html");
  exit();
} 
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>
