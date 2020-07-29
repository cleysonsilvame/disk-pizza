<?php
session_start();
date_default_timezone_set('america/sao_paulo');
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

if (empty($_SESSION['listProdutos'])) {
    $_SESSION['listProdutos'] = [];
}

if (sizeof($_SESSION['listProdutosEdit']) == 0) {
    header("Location:alterar-pedido.php?error=Insira ao menos um produto");
}

$codPedido = $_SESSION['idPedido'];
$tamanhoList = sizeof ($_SESSION['listProdutosEdit']);
$contador = 0;

while ($contador < $tamanhoList ) {
    $sql = "UPDATE tb_item_pedido SET quant_item_pedido = '".$_SESSION['listProdutosEdit'][$contador][0]."', cod_produto = '".$_SESSION['listProdutosEdit'][$contador][4]."' WHERE cod_pedido = '$codPedido'";

    if (!mysqli_query($link, $sql)) {
        die("Erro ao alterar o registro da tabela tb_item_pedido<br>" . mysqli_error($link));
    }else{
        unset($_SESSION['listProdutosEdit']);
        unset($_SESSION['idPedido']);
        $_SESSION['msg_successes'] = "Pedido alterado com sucesso!";
        $contador++;
    }
}
mysqli_close($link);
header("Location:menu-pedidos.php");
?>
