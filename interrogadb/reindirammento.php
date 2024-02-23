<?php
session_start();
if($_SESSION["UTENTE"]==""){    
    echo "accesso non consentito";
    header("location:login.html");
}
if(isset($_GET['selezionato'])){
    if($_GET['selezionato']== 'Sviluppatori'){
    header("location:Sviluppatori.php");
    }
}
if(isset($_GET['selezionato'])){
    if($_GET['selezionato']== 'Commenti'){
    header("location:Commenti.php");
    }
}
if(isset($_GET['selezionato'])){
    if($_GET['selezionato']== 'vista'){
    header("location:vista.php");
    }
}
?>