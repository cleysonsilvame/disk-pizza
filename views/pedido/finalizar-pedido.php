<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

$id = isset($_GET['idPedido']) ? $_GET['idPedido'] : "";

$sql = "SELECT horasaida_pedido FROM tb_pedido WHERE cod_pedido = '" . $id . "' AND horasaida_pedido IS NOT NULL";


if (!mysqli_query($link, $sql)) {
    die("Erro ao encontrar as informações do formulário na tabela de pedidos: " . mysqli_error($link));
} else {
    if (mysqli_num_rows(mysqli_query($link, $sql)) === 0) {
        $sql = "UPDATE tb_pedido SET horasaida_pedido = now(), horachegada_pedido = now() WHERE cod_pedido = '" . $id . "'";
    } else {
        $sql = "UPDATE tb_pedido SET horachegada_pedido = now() WHERE cod_pedido = '" . $id . "'";
    }
    if (!mysqli_query($link, $sql)) {
        die("Erro ao alterar as informações do formulário na tabela de pedidos: " . mysqli_error($link));
    } else {
        mysqli_close($link);
        session_start();
        $_SESSION['msg_successes'] = "Pedido finalizado";
        header("Location:menu-pedidos.php");
    }
}
?>