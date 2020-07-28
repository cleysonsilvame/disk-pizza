<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

$id = $_GET['inputCodigo'];
$sql = "DELETE FROM tb_produto WHERE cod_produto = '" . $id . "'";

if (!mysqli_query($link, $sql)) {
    die("Erro ao excluído o registro<br>" . mysqli_error($link));
} else {
    session_start();
    $_SESSION['msg_successes'] = "Dados deletados com sucesso.";
}
mysqli_close($link);
header("Location:editar-produto.php");
