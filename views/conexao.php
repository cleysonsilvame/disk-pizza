<?php

$link = mysqli_connect("localhost", "root", "admin", "diskpizza", "3307");

if(!$link){
  die("Conexão com o banco de dados falhou!<br>".mysqli_connect_error());
}
?>