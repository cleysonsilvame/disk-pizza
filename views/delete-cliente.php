<?php
  include_once 'conexao.php';

  $id = $_GET['inputCodigo'];
  $sql = "DELETE FROM tb_cliente WHERE cod_cliente = '".$id."'";

  if(!mysqli_query($link, $sql)){
    die("Erro ao excluído o registro<br>". mysqli_error($link));
  }
  else{
    echo "<script>alert('Dados deletados com sucesso.');</script>";          
  }
  mysqli_close($link);
  header("Location:editar-cliente.php");
?>