<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';
$view = "";
$sql = "SELECT * FROM tb_pedido AS pe
        LEFT JOIN tb_cliente AS c ON pe.cod_cliente = c.cod_cliente
        WHERE pe.horachegada_pedido IS NOT NULL
        ORDER BY pe.datahora_pedido";

$resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");

while ($registro = mysqli_fetch_array($resultado)) {
    $codPedido = $registro['cod_pedido'];
    $dhPedido = DateTime::createFromFormat('Y-m-d H:i:s', $registro['datahora_pedido']);
    $hsPedido = $registro['horasaida_pedido'];
    $tpPedido = $registro['tipo_pedido'];
    $codCliente = $registro['cod_cliente'];
    $telCliente = $registro['telefone_cliente'];
    $endCliente = isset($registro['endereco_cliente']) ? $registro['endereco_cliente'] . ", " : "";
    $numCliente = $registro['num_end_cliente'];
    $cepCliente = $registro['cep_cliente'];

    $view .= "<div class='row'>
                      <div class='col-6 p-0 pr-2'>
                        <table class='table table-striped'>
                          <thead class='thead-dark'>
                            <tr>
                              <th scope='col'>" . $codPedido . "</th>
                              <th scope='col'>Nome Produto</th>
                              <th scope='col'>Tipo</th>
                              <th scope='col'>Valor</th>
                              <th scope='col'>Quantidade</th>
                              <th scope='col'>Total</th>
                            </tr>
                          </thead>
                          <tbody>";

    $sqlP = "SELECT
                        p.nome_produto,
                        p.valor_produto,
                        ip.quant_item_pedido,
                        p.tipo_produto,
                        ip.cod_pedido
                        FROM tb_item_pedido AS ip
                        INNER JOIN tb_produto AS p ON ip.cod_produto = p.cod_produto
                        WHERE ip.cod_pedido = " . $codPedido;

    $resultadoP = mysqli_query($link, $sqlP) or die("Erro ao retornar os valores do banco de dados");
    while ($registroP = mysqli_fetch_array($resultadoP)) {
        $nomeProduto = $registroP['nome_produto'];
        $tpProduto = $registroP['tipo_produto'];
        $valorProduto = $registroP['valor_produto'];
        $quantProduto = $registroP['quant_item_pedido'];
        $totalPedido = $valorProduto * $quantProduto;

        $view .= "<tr>
                        <td></td>
                        <td>" . $nomeProduto . "</td>
                        <td>" . $tpProduto . "</td>
                        <td>R$ " . number_format($valorProduto, 2, ',', '.') . "</td>
                        <td>" . $quantProduto . "</td>
                        <td>R$ " . number_format($totalPedido, 2, ',', '.') . "</td>
                      </tr>";
    }

    $view .= "  </tbody>
                    </table>
                    </div>
                    <div class='col-6 pl-4'>
                      <div class='row'>
                        <table class='table table-sm table-striped'>
                          <thead class='thead-dark'>
                            <tr>
                              <th scope='col'>#</th>
                              <th scope='col'>Telefone Cliente</th>
                              <th scope='col'>CEP</th>
                              <th scope='col'>Endereço</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope='row'>" . $codCliente . "</th>
                              <td>" . $telCliente . "</td>
                              <td>" . $cepCliente . "</td>
                              <td>" . $endCliente . $numCliente . "</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class='row'>
                        <table class='table table-sm table-striped'>
                          <thead class='thead-dark'>
                            <tr>
                              <th scope='col'>Data/Hora do Pedido</th>
                              <th scope='col'>Data/Hora da Saída</th>
                              <th scope='col'>Tipo do Pedido</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>" . date_format($dhPedido, 'd/m/Y H:i:s') . "</td>
                              <td>" . $hsPedido . "</td>
                              <td>" . $tpPedido . "</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <hr>";
}
mysqli_close($link);
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/all.css">
    <title>Disk Pizza</title>
</head>

<body>
    <div class="flex-dashboard d-flex flex-row h-100 w-100">
        <sidebar class="h-100 bg-dark text-light">
            <div class="sidebar-title d-flex flex-row justify-content-center align-items-center">
                <a href="/index.html" class="btn text-light">
                    <h2><i class="fas fa-pizza-slice fa"></i> Disk-Pizza</h2>
                </a>
            </div>
            <ul class="nav nav-pills flex-column p-4">
                <li class="nav-item ">
                    <a href="/views/pedido/menu-pedidos.php" class="nav-link text-light active"><i class="fas fa-list"></i> Menu de Pedidos</a>
                </li>
                <li class="nav-item">
                    <a href="/views/cliente/editar-cliente.php" class="nav-link text-light"><i class="fas fa-user-cog"></i> Editar Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="/views/produto/editar-produto.php" class="nav-link text-light"><i class="fas fa-utensils"></i> Editar Produtos</a>
                </li>
            </ul>
        </sidebar>
        <main class="d-block h-100 bg-secondary">
            <header class="d-flex flew-row align-items-center justify-content-center bg-danger text-dark">
                <h1><i class="fas fa-utensils"></i> Pedidos Realizados</h1>
            </header>
            <div class="main-content p-3 w-100">
                <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center">
                </div>
                <div class="container-fluid mt-3">
                    <?php
                    echo $view;
                    ?>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a31af2c148.js" crossorigin="anonymous"></script>
</body>

</html>