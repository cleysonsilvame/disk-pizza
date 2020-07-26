<?php
session_start();
date_default_timezone_set('america/sao_paulo');

if (empty($_SESSION['listProdutos'])) {
  $_SESSION['listProdutos'] = [];
}
if (empty($_SESSION['Cliente'])) {
  $_SESSION['Cliente'][0] = '';
  $_SESSION['Cliente'][1] = '';
  $_SESSION['Cliente'][2] = '';
}

if (empty($_SESSION['tpPedido'])) {
  $_SESSION['tpPedido'] = '';
}
if (empty($_SESSION['dhPedido'])) {
  $_SESSION['dhPedido'] = '';
}

if(sizeof($_SESSION['listProdutos']) == 0 || $_SESSION['tpPedido'] == ''){
  header("Location:cadastrar-pedido.php?error=Insira ao menos um produto e selecione balcão ou cliente!");
}

echo sizeof($_SESSION['listProdutos'])."<br>";
echo sizeof($_SESSION['Cliente'])."<br>";
echo $_SESSION['tpPedido']."<br>";
echo $_SESSION['dhPedido']."<br>.";

?>