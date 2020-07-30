<?php
session_start();
$acao = isset($_GET['acao']) ? $_GET['acao'] : "";


if ($acao == 'verificarCEP') {
    unset($_SESSION['cep']);

    $cep = isset($_POST['inputCEPverifica']) ? $_POST['inputCEPverifica'] : "";
    $cep = strval(preg_replace("/[^0-9]/", "", $cep));

    if(strlen($cep) === 8){   
        $url = "http://viacep.com.br/ws/$cep/xml/";
    
        $xml = simplexml_load_file($url);
    
        $_SESSION['cep'][] = $cep;
        $_SESSION['cep'][] = strval($xml->logradouro);
        $_SESSION['cep'][] = strval($xml->bairro);
        $_SESSION['cep'][] = strval($xml->localidade);
        $_SESSION['cep'][] = strval($xml->uf);
    }

} else if ($acao == 'insert') {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

    $telefone = preg_replace("/[^0-9]/", "", $_POST['inputTelefone']);
    $cep = preg_replace("/[^0-9]/", "", $_POST['inputCEP']);
    $numero = preg_replace("/[^0-9]/", "", $_POST['inputNumero']);
    $endereco = $_POST['inputEndereco'];
    $cidadeEstado = $_POST['inputCidadeEstado'];

    $sql = "INSERT INTO tb_cliente (telefone_cliente, cep_cliente, num_end_cliente, endereco_cliente, bairro_cid_est_cliente )values('$telefone', '$cep', '$numero', '$endereco' , '$cidadeEstado')";

    if (!mysqli_query($link, $sql)) {
        die("Erro ao inserir as informações do formulário na tabela de clientes: " . mysqli_error($link));
    } else {
        $_SESSION['msg_successes'] = "Dados inseridos com sucesso.";
    }
    mysqli_close($link);
    header("Location:editar-cliente.php");
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
                        <h2><i class="fas fa-user-plus"></i> Cadastrar Cliente</h2>
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
                <form method="POST" action="cadastrar-cliente.php?acao=verificarCEP" class="container">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputCEPverifica">CEP</label>
                                <input type="text" class="form-control" id="inputCEPverifica" name="inputCEPverifica" value="<?php echo isset($_SESSION['cep'][0]) ? $_SESSION['cep'][0] : ""; ?>" placeholder="99.999-999" onkeypress="$(this).mask('00.000-000')" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                            <div class="form-group col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0">Verificar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center">
                    <form method="POST" action="cadastrar-cliente.php?acao=insert" class="container">
                        <div class="form-row">
                            <div class="from-group col-md-2">
                                <label for="inputCEPverifica">CEP</label>
                                <input type="text" class="form-control" id="inputCEP" name="inputCEP" value="<?php echo isset($_SESSION['cep'][0]) ? $_SESSION['cep'][0] : ""; ?>" placeholder="99.999-999" onkeypress="$(this).mask('00.000-000')" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputTelefone">Telefone</label>
                                <input type="text" class="form-control inputTelefone" id="inputTelefone" name="inputTelefone" placeholder="(DD) 9 9999-9999" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="inputEndereco">Endereço</label>
                                <input type="text" class="form-control" id="inputEndereco" name="inputEndereco" value="<?php echo isset($_SESSION['cep'][1]) ? $_SESSION['cep'][1] : ""; ?>" placeholder=" Bairro - Cidade/Sigla" maxlength="80" required>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="inputNumero">Número</label>
                                <input type="text" class="form-control" id="inputNumero" name="inputNumero" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCidadeEstado">Bairro / Cidade / Estado</label>
                                <input type="text" class="form-control" id="inputCidadeEstado" name="inputCidadeEstado" value="<?php
                                    $bairro = isset($_SESSION['cep'][2]) ? $_SESSION['cep'][2] : "";
                                    $cidade =  isset($_SESSION['cep'][3]) ? $_SESSION['cep'][3] : "";
                                    $estado = isset($_SESSION['cep'][4]) ? $_SESSION['cep'][4] : "";
                                    echo $bairro . " " . $cidade . "/" . $estado;
                                    unset($_SESSION['cep']);
                                    ?>" placeholder="Cidade/Sigla" maxlength="80" required>
                            </div>
                        </div>
                        <button type="submit" class="btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100">Cadastrar Cliente</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a31af2c148.js" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript">
        jQuery("input.inputTelefone")
            .mask("(99) 9999-99999")
            .focusout(function(event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-9999");
                } else {
                    element.mask("(99) 9999-99999");
                }
            });
    </script>
</body>

</html>