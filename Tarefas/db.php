<?php
    $host="localhost";
    $user= "root";
    $pass= "";
    $db="gerenciador_tarefas";

    $conn=mysqli_connect($host,$user,$pass,$db);
    if(!$conn){
        die("A conexão com  o banco falhou.".mysqli_connect_error());
    }

?>