<?php

$i = 0;
$listProdutos = array();


$produtos = array();
array_push($produtos,
  "nome_produto",
  "tipo_produto",
  "valor_produto",
  "inputQuant",
  "valorTotal"
);
$i = 0;
while ($i <= 10) {
  array_push($listProdutos, $produtos);
$i++;
}


$i = 0;
while ($i <= 10) {
  print_r($listProdutos[$i]);
$i++;
}

?>
