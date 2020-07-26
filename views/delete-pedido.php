<?php
  include_once 'conexao.php';

  $id = $_GET['idPedido'];
  $sql = "DELETE FROM tb_pedido WHERE cod_pedido = '".$id."'";

  if(!mysqli_query($link, $sql)){
    die("Erro ao excluir o registro da tabela pedido e item_pedido<br>". mysqli_error($link));
  }
  else{
    echo "<script>alert('Dados deletados da tabela pedido e tabela item_pedido.');</script>";          
  }
  mysqli_close($link);
  header("Location:menu-pedidos.php");


?>