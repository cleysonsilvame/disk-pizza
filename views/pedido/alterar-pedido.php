<?php
session_start();
date_default_timezone_set('america/sao_paulo');
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

$codPedido = isset($_GET['idPedido']) ? $_GET['idPedido'] : "";
if($codPedido !== ""){
    $_SESSION['idPedido'] = $codPedido;
}

$acao = isset($_GET['idPedido']);

if ($acao == 1) {
    $_SESSION['listProdutosEdit'] = [];

    $sql =  "SELECT * FROM tb_item_pedido AS ip
    INNER JOIN tb_produto AS p ON ip.cod_produto = p.cod_produto
    WHERE ip.cod_pedido = " . $codPedido;

    $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");
    while ($registro = mysqli_fetch_array($resultado)) {
        $produtos = array(
            $registro['cod_produto'],
            $registro['tipo_produto'],
            $registro['nome_produto'],
            $registro['valor_produto'],
            $quantProduto = $registro['quant_item_pedido'],
            $registro['valor_produto'] * $registro['quant_item_pedido']
        );
    }
    $_SESSION['listProdutosEdit'][] = $produtos;
}


if (empty($_SESSION['listProdutosEdit'])) {
    $_SESSION['listProdutosEdit'] = [];
}


if (isset($_POST['form'])) {
    switch ($_POST['form']) {
        case "p":
            $acao = "p";
            break;

        default:
            echo "ERRO AO PROCESSAR OS DADOS!";
    }
}

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
                    <a href="/views/pedido/menu-pedidos.php" class="nav-link text-light active"><i class="fas fa-list"></i> Menu de
                        Pedidos</a>
                </li>
                <li class="nav-item">
                    <a href="/views/cliente/editar-cliente.php" class="nav-link text-light"><i class="fas fa-user-cog"></i> Editar
                        Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="/views/produto/editar-produto.php" class="nav-link text-light"><i class="fas fa-utensils"></i> Editar
                        Produtos</a>
                </li>
            </ul>
        </sidebar>
        <main class="d-block h-100 bg-secondary">
            <header class="d-flex flew-row align-items-center justify-content-center bg-danger text-dark">
                <h1><i class="fas fa-edit"></i> Editar Pedido</h1>
            </header>
            <div class="main-content p-3 w-100">
                <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center">
                    <form class="d-flex flex-row w-100 " method="POST" action="update-pedido.php">
                        <button type="submit" class="btn panel col-12 panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100">Editar Pedido</button>
                    </form>
                </div>
                <div class="container d-flex  align-items-center justify-content-center  w-50">
                    <?php echo isset($_GET['error']) ? " 
              <div class='text-center mt-2 badge badge-pill badge-secondary text-wrap'>
                   " . $_GET['error'] . "
              </div>" : '';
                    ?>
                </div>
                <div class="container-fluid mt-3">
                    <div class='row'>
                        <div class='col-6 p-0 pr-2'>
                            <table class='table table-striped'>
                                <thead class='thead-dark'>
                                    <tr>
                                        <th scope='col'>#</th>
                                        <th scope='col'>Nome Produto</th>
                                        <th scope='col'>Tipo</th>
                                        <th scope='col'>Valor</th>
                                        <th scope='col'>Quantidade</th>
                                        <th scope='col'>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    $sumTotal = 0;

                                    if ($acao === 'p') {
                                        isset($_POST['inputProdutos']) ? $_POST['inputProdutos'] : $_POST['inputProdutos'] = "";

                                        $produtos = array();
                                        $sql = "SELECT * FROM tb_produto WHERE cod_produto = " . $_POST['inputProdutos'];
                                        $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");

                                        while ($registro = mysqli_fetch_array($resultado)) {
                                            $produtos = array(
                                                $registro['cod_produto'],
                                                $registro['nome_produto'],
                                                $registro['tipo_produto'],
                                                $registro['valor_produto'],
                                                $_POST['inputQuant'],
                                                $registro['valor_produto'] * $_POST['inputQuant']
                                            );
                                        }
                                        $_SESSION['listProdutosEdit'][] = $produtos;
                                    }

                                    if (isset($_GET['inputPedido'])) {
                                        unset($_SESSION['listProdutosEdit'][$_GET['inputPedido']]);
                                        array_splice($_SESSION['listProdutosEdit'], sizeof($_SESSION['listProdutosEdit']));
                                    }

                                    while ($contador < sizeof($_SESSION['listProdutosEdit'])) {
                                        echo "<tr>
                              <td>
                                <a href='/views/pedido/alterar-pedido.php?inputPedido=" . $contador . "' class='btn text-dark p-0 m-0'><i class='fas fa-trash '></i></a>
                              </td> 
                              <td>" . $_SESSION['listProdutosEdit'][$contador][1] . "</td>
                              <td>" . $_SESSION['listProdutosEdit'][$contador][2] . "</td>
                              <td>R$ " . number_format($_SESSION['listProdutosEdit'][$contador][3], 2, ',', '.') . "</td>
                              <td>" . $_SESSION['listProdutosEdit'][$contador][4] . "</td>
                              <td>R$ " . number_format($_SESSION['listProdutosEdit'][$contador][5], 2, ',', '.') . "</td>
                            </tr>";
                                        $sumTotal += $_SESSION['listProdutosEdit'][$contador][5];
                                        $contador++;
                                    }

                                    echo "<tr>
                          <td colspan='4'></td>
                          <th>Total do Pedido:</th>
                          <th>R$ " . number_format($sumTotal, 2, ',', '.') . "</th>
                        </tr>";


                                    ?>
                                </tbody>
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
                                            <?php
                                            $sql = "SELECT * FROM tb_pedido AS pe LEFT JOIN tb_cliente AS c ON pe.cod_cliente = c.cod_cliente WHERE pe.cod_pedido = '" . $_SESSION['idPedido'] . "' AND c.cod_cliente IS NOT NULL";

                                            if (mysqli_num_rows(mysqli_query($link, $sql)) !== 0) {
                                                $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores dos clientes do banco de dados");

                                                while ($registro = mysqli_fetch_array($resultado)) {
                                                    $cliente[] = $registro['cod_cliente'];
                                                    $cliente[] = $registro['telefone_cliente'];
                                                    $cliente[] = $registro['cep_cliente'];
                                                    $cliente[] = $registro['endereco_cliente'] . ", " . $registro['num_end_cliente'] . " " . $registro['bairro_cid_est_cliente'];
                                                }
                                                echo "<th scope='row'>" . $cliente[0] . "</th>
                            <td>" . $cliente[1] . "</td>
                            <td>" . $cliente[2] . "</td>
                            <td>" . $cliente[3] . "</td>";
                                            } else {
                                                echo "<th scope='row'></th>
                                  <td></td>
                                  <td></td>
                                  <td></td>";
                                            }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class='row'>
                                <table class='table table-sm table-striped'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th scope='col'>Data/Hora do Pedido</th>
                                            <th scope='col'>Data/Hora de Saída do Pedido</th>
                                            <th scope='col'>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                            $sql = "SELECT * FROM tb_pedido WHERE cod_pedido = '". $_SESSION['idPedido'] . "'";


                                            $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do pedido do banco de dados");

                                            while ($registro = mysqli_fetch_array($resultado)) {
                                                $infoPedido[] = DateTime::createFromFormat('Y-m-d H:i:s', $registro['datahora_pedido']);
                                                $infoPedido[] = $registro['horasaida_pedido'];
                                                $infoPedido[] = $registro['tipo_pedido'];
                                            }
                                            echo "<td scope='row'>" . date_format($infoPedido[0], 'd/m/Y H:i:s') . "</td>
                                                <td scope='row'>" . $infoPedido[1] . "</td>
                                                <td>" . $infoPedido[2] . "</td>";
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="alterar-pedido.php">
                                <div class="form-row justify-content-center">
                                    <div class="form-group col-md-12">
                                        <label for="inputProdutos">Produtos</label>
                                        <select class="custom-select" name="inputProdutos" id="inputProdutos" size="10" required>
                                            <option disabled>Selecione um ou mais produtos...</option>
                                            <?php
                                            $sql = "SELECT * FROM tb_produto";
                                            $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");

                                            while ($registro = mysqli_fetch_array($resultado)) {
                                                $codProduto = $registro['cod_produto'];
                                                $nome = $registro['nome_produto'];
                                                $valor = $registro['valor_produto'];
                                                $tipo = $registro['tipo_produto'];

                                                echo "<option value='" . $codProduto . "'>" . $codProduto . " - " . $nome . " / " . $tipo . " / R$" . number_format($valor, 2, ',', '.') . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 d-flex flex-row m-0 justify-content-end">
                                        <label for="inputQuant" class="mt-1 mr-2">Quantidade</label>
                                        <input type="number" class="form-control" name="inputQuant" id="inputQuant" min="1" value="1" required>
                                    </div>
                                    <input type="hidden" name="form" value="p">
                                    <input type="submit" class="btn text-dark mr-2" value="Inserir Produto"></input>
                                </div>
                            </form>
                        </div>
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