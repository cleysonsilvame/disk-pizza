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

echo sizeof ($_SESSION['listProdutosEdit']);

//delete dos produtos atuais da lista
$sqlDELETE = "DELETE FROM tb_item_pedido WHERE cod_pedido = '" . $codPedido . "'";

if (!mysqli_query($link, $sqlDELETE)) {
    die("Erro ao excluir os registros de produtos do pedido<br>" . mysqli_error($link));
} else {
    while ($contador < $tamanhoList ) {
        $sql = "INSERT INTO tb_item_pedido (cod_item_pedido, quant_item_pedido, cod_produto, cod_pedido) values (0, " . $_SESSION['listProdutosEdit'][$contador][4] . ", " . $_SESSION['listProdutosEdit'][$contador][0] . ", " . $codPedido . ");";
    
        if (!mysqli_query($link, $sql)) {
            die("Erro ao inserir os novos produtos neste pedido<br>" . mysqli_error($link));
        }else{            
            $contador++;
            $_SESSION['msg_successes'] = "Pedido alterado com sucesso!";
        }
    }
}
unset($_SESSION['listProdutosEdit']);
unset($_SESSION['idPedido']);
mysqli_close($link);
header("Location:menu-pedidos.php");
?>
