<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

$id = isset($_GET['idPedido']) ? $_GET['idPedido'] : "";

$sql = "UPDATE tb_pedido SET horasaida_pedido = now() WHERE cod_pedido = '" . $id . "'";


if (!mysqli_query($link, $sql)) {
    die("Erro ao alterar as informações do formulário na tabela de pedidos: " . mysqli_error($link));
} else {
    mysqli_close($link);
    session_start();
    $_SESSION['msg_successes'] = "Horario de saída registrado!";
    header("Location:menu-pedidos.php");
}
?>