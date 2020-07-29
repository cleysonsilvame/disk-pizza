<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

$id = $_GET['idPedido'];
$sql = "DELETE FROM tb_pedido WHERE cod_pedido = '" . $id . "'";

if (!mysqli_query($link, $sql)) {
    die("Erro ao excluir o registro da tabela pedido e item_pedido<br>" . mysqli_error($link));
} else {
    session_start();
    $_SESSION['msg_successes'] = "Pedido deletado com sucesso!";
}
mysqli_close($link);
header("Location:menu-pedidos.php");
?>