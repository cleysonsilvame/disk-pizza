<?php
  include_once 'conexao.php';

  $id = $_GET['inputCodigo'];
  $sql = "DELETE FROM tb_produto WHERE cod_produto = '".$id."'";

  if(!mysqli_query($link, $sql)){
    die("Erro ao excluído o registro<br>". mysqli_error($link));
  }
  else{
    echo "<script>alert('Dados deletados com sucesso.');</script>";          
  }
  mysqli_close($link);
  header("Location:editar-produto.php");
?>