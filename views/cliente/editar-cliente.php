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
            <a href='/views/cliente/update-cliente.php?inputCodigo=$id' class='btn text-dark  m-1'><i class='fas fa-edit'></i></a>
            <a href='/views/cliente/delete-cliente.php?inputCodigo=$id' class='btn text-dark  m-1'><i class='fas fa-trash'></i></a>
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
                            <a href="/views/pedido/menu-pedidos.php" class="nav-link text-light"><i class="fas fa-list"></i>
                                Menu de Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a href="/views/cliente/editar-cliente.php" class="nav-link text-light active"><i
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
                        <h2><i class="fas fa-user-cog"></i> Editar cliente</h2>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <div class="row h-100 bg-dark">
        <sidebar class="h-100 d-none d-md-block m-0 text-light">
            <ul class="nav nav-pills flex-column p-0 pl-4 pt-4">
                <li class="nav-item">
                    <a href="/views/pedido/menu-pedidos.php" class="nav-link text-light"><i class="fas fa-list"></i>
                        Menu de Pedidos</a>
                </li>
                <li class="nav-item">
                    <a href="/views/cliente/editar-cliente.php" class="nav-link text-light active"><i
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
        <main class="col h-100 p-0 pl-1 bg-dark">
            <div class="main-content p-3">
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
                    <div class="table-responsive-sm">
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