<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';
$view = "";
$sql = "SELECT * FROM tb_cliente";
$resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");

while ($registro = mysqli_fetch_array($resultado)) {
    $id = $registro['cod_cliente'];
    $telefone = $registro['telefone_cliente'];
    $cep = $registro['cep_cliente'];
    $endereco = $registro['endereco_cliente'];
    $numero = $registro['num_end_cliente'];
    $bce = $registro['bairro_cid_est_cliente'];
    $view .= "
            <tr>
            <th scope='row'>" . $id . "</th>
            <td>" . $telefone . "</td>
            <td>" . $cep . "</td>
            <td>" . $endereco . ", " . $numero . " - " . $bce . "</td>
            <td>
            <a href='/views/cliente/update-cliente.php?inputCodigo=$id' class='btn text-dark'><i class='fas fa-edit'></i></a>
            <a href='/views/cliente/delete-cliente.php?inputCodigo=$id' class='btn text-dark'><i class='fas fa-trash'></i></a>
            </td>
            </tr>
            ";
}
mysqli_close($link);
session_start();
$msg = isset($_SESSION['msg_successes']) ? $_SESSION['msg_successes'] : "";
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
                    <a href="/views/pedido/menu-pedidos.php" class="nav-link text-light"><i class="fas fa-list"></i> Menu de Pedidos</a>
                </li>
                <li class="nav-item">
                    <a href="/views/cliente/editar-cliente.php" class="nav-link text-light active"><i class="fas fa-user-cog"></i> Editar Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="/views/produto/editar-produto.php" class="nav-link text-light"><i class="fas fa-utensils"></i> Editar Produtos</a>
                </li>
            </ul>
        </sidebar>
        <main class="d-block h-100 bg-secondary">
            <header class="d-flex flew-row align-items-center justify-content-center bg-danger text-dark">
                <h1><i class="fas fa-user-cog"></i> Editar Clientes</h1>
            </header>
            <div class="main-content p-3 w-100">
            <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center">
                    <?php
                    if ($msg != "") {
                        echo "
                        <div class='text-center badge badge-pill badge-success text-wrap'>
                            " . $msg . "
                        </div>
                        ";
                        unset($_SESSION['msg_successes']);
                    }
                    ?>
                </div>
                <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center">
                    <a class="btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100" href="cadastrar-cliente.php">Cadastrar Cliente</a>
                </div>
                <div class="panel-row d-flex flex-row align-items-center mt-3 p-1 justify-content-center">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Número cliente</th>
                                <th scope="col">CEP cliente</th>
                                <th scope="col">Endereço cliente</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            echo $view;
                            ?>
                        </tbody>
                    </table>

                </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a31af2c148.js" crossorigin="anonymous"></script>
</body>

</html>