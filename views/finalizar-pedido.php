<?php
include_once 'conexao.php';

$id = isset($_GET['idPedido']) ? $_GET['idPedido'] : "";  

$sql = "SELECT horasaida_pedido FROM tb_pedido WHERE cod_pedido = '".$id."' AND horasaida_pedido IS NOT NULL";


if(!mysqli_query($link, $sql)){
  die("Erro ao encontrar as informações do formulário na tabela de pedidos: ". mysqli_error($link));
}
else{
  if(mysqli_num_rows(mysqli_query($link, $sql)) === 0){
    $sql = "UPDATE tb_pedido SET horasaida_pedido = now(), horachegada_pedido = now() WHERE cod_pedido = '".$id."'";
  }else{
    $sql = "UPDATE tb_pedido SET horachegada_pedido = now() WHERE cod_pedido = '".$id."'";
  }
  if(!mysqli_query($link, $sql)){
    die("Erro ao alterar as informações do formulário na tabela de pedidos: ". mysqli_error($link));
  }else{
    mysqli_close($link);
    header("Location:menu-pedidos.php");  
  }
}

?>


<a href="menu-pedidos.php" class="btn panel col-12 panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100">Menu Pedidos</a>