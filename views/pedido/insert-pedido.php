<?php
session_start();
date_default_timezone_set('america/sao_paulo');

if (empty($_SESSION['listProdutos'])) {
    $_SESSION['listProdutos'] = [];
}
if (empty($_SESSION['Cliente'])) {
    $_SESSION['Cliente'] = [];
}

if (empty($_SESSION['tpPedido'])) {
    $_SESSION['tpPedido'] = '';
}
if (empty($_SESSION['dhPedido'])) {
    $_SESSION['dhPedido'] = '';
}

if (sizeof($_SESSION['listProdutos']) == 0 || $_SESSION['tpPedido'] == '') {
    header("Location:cadastrar-pedido.php?error=Insira ao menos um produto e selecione balcão ou cliente!");
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';



if ($_SESSION['tpPedido'] == 'Balcão') {
    $sql = "INSERT INTO tb_pedido (cod_pedido, datahora_pedido, tipo_pedido) values (0, '" . $_SESSION['dhPedido'] . "', '" . $_SESSION['tpPedido'] . "');";
} else {
    $sql = "INSERT INTO tb_pedido (cod_pedido, datahora_pedido, tipo_pedido, cod_cliente) values (0, '" . $_SESSION['dhPedido'] . "', '" . $_SESSION['tpPedido'] . "', '" . $_SESSION['Cliente'][0] . "');";
}

if (!mysqli_query($link, $sql)) {
    die("Erro ao inserir as informações do formulário na tabela de pedidos: " . mysqli_error($link));
} else {

    $sql = "SELECT cod_pedido FROM tb_pedido WHERE cod_pedido = (SELECT MAX(cod_pedido) FROM tb_pedido);";

    $resultado = mysqli_query($link, $sql) or die("Erro ao retornar o valor do banco de dados<br>" . mysqli_error($link));

    while ($registro = mysqli_fetch_array($resultado)) {
        $codPedido = $registro['cod_pedido'];
    }

    $tamanhoList = sizeof($_SESSION['listProdutos']);
    $contador = 0;
    while ($contador < $tamanhoList) {
        $sql = "INSERT INTO tb_item_pedido (cod_item_pedido, quant_item_pedido, cod_produto, cod_pedido) values (0, " . $_SESSION['listProdutos'][$contador][4] . ", " . $_SESSION['listProdutos'][$contador][0] . ", " . $codPedido . ");";

        if (!mysqli_query($link, $sql)) {
            // Excluir ultimo registro da tb_pedido
            $sqlDELETE = "DELETE FROM tb_pedido WHERE cod_pedido = '" . $codPedido . "'";

            if (!mysqli_query($link, $sqlDELETE)) {
                die("Erro ao excluir o registro da tabela pedido depois do erro encontado no insert tabela item_pedido<br>" . mysqli_error($link));
            } else {
                echo "<script>alert('Dados deletados tabela pedido com sucesso depois do erro no insert da tabela pedido.');</script>";
            }
            die("Erro ao inserir as informações do formulário na tabela de item_pedidos: <br>" . mysqli_error($link));
            mysqli_close($link);
        } else {
            unset($_SESSION['listProdutos'], $_SESSION['Cliente'], $_SESSION['tpPedido'], $_SESSION['dhPedido']);
            $_SESSION['msg_successes'] = "Pedido realizado com sucesso!";
            $contador++;
        }
    }
    mysqli_close($link);
    header("Location:menu-pedidos.php");
}

?>
