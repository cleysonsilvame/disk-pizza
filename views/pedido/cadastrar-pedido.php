<?php
session_start();
date_default_timezone_set('america/sao_paulo');
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';
$acao = "";


if (empty($_SESSION['listProdutos'])) {
    $_SESSION['listProdutos'] = [];
}
if (empty($_SESSION['Cliente'])) {
    $_SESSION['Cliente'] = [];
}

if (empty($_SESSION['tpPedido'])) {
    $_SESSION['tpPedido'] = '';
}

if (isset($_POST['form'])) {
    switch ($_POST['form']) {
        case "c":
            $acao = "c";
            break;

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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/all.css">
    <title>Disk Pizza</title>
</head>

<body>
    <header>
        <div class="fixed-top w-100">
            <div class="collapse" id="navbarToggleExternalContent">
                <div class="bg-dark p-4">
                    <ul class="nav nav-pills flex-column p-0">
                        <li class="nav-item ">
                            <a href="/views/pedido/menu-pedidos.php" class="nav-link text-light active"><i class="fas fa-list"></i>
                                Menu de Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a href="/views/cliente/editar-cliente.php" class="nav-link text-light"><i
                                    class="fas fa-user-cog"></i>
                                Editar Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a href="/views/produto/editar-produto.php" class="nav-link text-light"><i
                                    class="fas fa-utensils"></i>
                                Editar Produtos</a>
                        </li>
                    </ul>
                </div>
            </div>
            <nav class="navbar navbar-dark bg-danger m-0 p-0">
                <div class="w-25 d-md-none m-0 bg-dark justify-content-center">
                    <div class="my-2 py-1 text-center">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                </div>
                <div class="w-fix d-none d-md-block m-0 bg-dark justify-content-center">
                    <div class="mt-2">
                        <div class="d-flex justify-content-center">
                            <a href="/index.html" class="btn text-light justify-content-center p-0">
                                <h3><i class="fas fa-pizza-slice"></i> Disk-Pizza</h3>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="m-0 p-0 flex-fill">
                    <div class="d-flex align-items-center justify-content-center bg-danger text-dark">
                        <h3><i class="fas fa-plus-square"></i> Cadastrar Pedido</h3>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <div class="row h-100 bg-dark">
        <sidebar class="h-100 d-none d-md-block m-0 text-light">
            <ul class="nav nav-pills flex-column p-0 pl-4 pt-4">
                <li class="nav-item">
                    <a href="/views/pedido/menu-pedidos.php" class="nav-link text-light active"><i class="fas fa-list"></i>
                        Menu de Pedidos</a>
                </li>
                <li class="nav-item">
                    <a href="/views/cliente/editar-cliente.php" class="nav-link text-light"><i
                            class="fas fa-user-cog"></i>
                        Editar Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="/views/produto/editar-produto.php" class="nav-link text-light"><i
                            class="fas fa-utensils"></i>
                        Editar Produtos</a>
                </li>
            </ul>
        </sidebar>
        <main class="col h-100 p-0 pl-1 pr-3 bg-dark">
            <div class="main-content p-3">
            <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center">
                    <form class="d-flex flex-row w-100 " method="POST" action="insert-pedido.php">
                        <button type="submit" class="btn panel col-12 panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100">Cadastrar Pedido</button>
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
                        <div class='col-12 col-xl-12 px-2'>
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

                                    if ($acao == 'p') {

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
                                        $_SESSION['listProdutos'][] = $produtos;
                                    }

                                    if (isset($_GET['inputPedido'])) {
                                        unset($_SESSION['listProdutos'][$_GET['inputPedido']]);
                                        array_splice($_SESSION['listProdutos'], sizeof($_SESSION['listProdutos']));
                                    }

                                    while ($contador < sizeof($_SESSION['listProdutos'])) {
                                        echo "<tr>
                              <td>
                                <a href='/views/pedido/cadastrar-pedido.php?inputPedido=" . $contador . "' class='btn text-dark p-0 m-0'><i class='fas fa-trash '></i></a>
                              </td> 
                              <td>" . $_SESSION['listProdutos'][$contador][1] . "</td>
                              <td>" . $_SESSION['listProdutos'][$contador][2] . "</td>
                              <td>R$ " . number_format($_SESSION['listProdutos'][$contador][3], 2, ',', '.') . "</td>
                              <td>" . $_SESSION['listProdutos'][$contador][4] . "</td>
                              <td>R$ " . number_format($_SESSION['listProdutos'][$contador][5], 2, ',', '.') . "</td>
                            </tr>";
                                        $sumTotal += $_SESSION['listProdutos'][$contador][5];
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
                        <div class='col-12 col-xl-6 px-4'>
                            <div class='row'>
                                <table class='table table-sm table-striped'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th scope='col'>#</th>
                                            <th scope='col'>Telefone Cliente</th>
                                            <th scope='col'>Endereço</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php

                                            if ($acao == 'c') {
                                                if ($_POST['inputClientes'] == 0) {
                                                    $_SESSION['tpPedido'] = 'Balcão';
                                                    $_SESSION['Cliente'] = [];
                                                } else {
                                                    $_SESSION['tpPedido'] = 'Delivery';
                                                    $_SESSION['Cliente'][0] = $_POST['inputClientes'];
                                                    $sql = "SELECT * FROM tb_cliente WHERE cod_cliente = " . $_SESSION['Cliente'][0];
                                                    $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores dos clientes do banco de dados");

                                                    while ($registro = mysqli_fetch_array($resultado)) {
                                                        $_SESSION['Cliente'][0] = $registro['cod_cliente'];
                                                        $_SESSION['Cliente'][1] = $registro['telefone_cliente'];
                                                        $_SESSION['Cliente'][2] = $registro['endereco_cliente'];
                                                    }
                                                }
                                            }

                                            if (sizeof($_SESSION['Cliente']) == 0) {
                                                echo "<th scope='row'></th>
                            <td></td>
                            <td></td>";
                                            } else {
                                                echo "<th scope='row'>" . $_SESSION['Cliente'][0] . "</th>
                        <td>" . $_SESSION['Cliente'][1] . "</td>
                        <td>" . $_SESSION['Cliente'][2] . "</td>";
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
                                            <th scope='col'>Tipo do Pedido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo date('d/m/y H:i:s');
                                                $_SESSION['dhPedido'] = date('Y/m/d H:i:s'); ?></td>
                                            <td>
                                                <?php
                                                echo isset($_SESSION['tpPedido']) ? $_SESSION['tpPedido'] : '';
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="cadastrar-pedido.php">
                                <div class="form-row justify-content-end">
                                    <div class="form-group col-md-12">
                                        <label for="inputProdutos">Produtos</label>
                                        <select class="custom-select" name="inputProdutos" id="inputProdutos" size="10" required>
                                            <option disabled>Selecione um ou mais produtos...</option>
                                            <?php
                                            $sql = "SELECT * FROM tb_produto";
                                            $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");

                                            while ($registro = mysqli_fetch_array($resultado)) {
                                                $id = $registro['cod_produto'];
                                                $nome = $registro['nome_produto'];
                                                $valor = $registro['valor_produto'];
                                                $tipo = $registro['tipo_produto'];

                                                echo "<option value='" . $id . "'>" . $id . " - " . $nome . " / " . $tipo . " / R$" . number_format($valor, 2, ',', '.') . "</option>";
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
                        <div class="col-md-6">
                            <form method="POST" action="cadastrar-pedido.php">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputClientes">Clientes</label>
                                        <select class="custom-select" name="inputClientes" id="inputClientes" size="10" required>
                                            <?php
                                            echo "<option value='0'>Selecione um cliente ou clique aqui para balcão...</option>";
                                            $sql = "SELECT * FROM tb_cliente";
                                            $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");

                                            while ($registro = mysqli_fetch_array($resultado)) {
                                                $id = $registro['cod_cliente'];
                                                $telefone = $registro['telefone_cliente'];
                                                $endereco = $registro['endereco_cliente'];

                                                echo "<option value='" . $id . "'>" . $id . " - " . $telefone . " / " . $endereco . "</option>";
                                            }
                                            mysqli_close($link);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="form" value="c">
                                <input type="submit" class="btn text-dark ml-1" value="Inserir opção"></input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a31af2c148.js" crossorigin="anonymous"></script>
</body>

</html>