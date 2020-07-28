<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexao.php';

$acao = isset($_GET['acao']);


if ($acao == 'update') {
    $id = $_POST['inputCodigo'];
    $telefone = preg_replace("/[^0-9]/", "", $_POST['inputTelefone']);
    $cep = preg_replace("/[^0-9]/", "", $_POST['inputCEP']);
    $endereco = $_POST['inputEndereco'];
    $numero = preg_replace("/[^0-9]/", "", $_POST['inputNumero']);
    $cidadeEstado = $_POST['inputCidadeEstado'];
    
    $sql = "UPDATE tb_cliente SET telefone_cliente = '" . $telefone . "', cep_cliente = '" . $cep . "', endereco_cliente = '" . $endereco . "', num_end_cliente = '" . $numero . "', bairro_cid_est_cliente = '" . $cidadeEstado . "' WHERE cod_cliente = '" . $id . "'";

    if (!mysqli_query($link, $sql)) {
        die("Erro ao atualizar os dados da tabela: <br>" . mysqli_error($link));
    } else {
        session_start();
        $_SESSION['msg_successes'] = "Dados editados com sucesso";
    }
    mysqli_close($link);
    header("Location:editar-cliente.php");
} else {
    $id = $_GET['inputCodigo'];
    $sql = "SELECT * FROM tb_cliente WHERE cod_cliente ='$id'";

    $resultado = mysqli_query($link, $sql) or die("Erro ao retornar o valor do banco de dados<br>" . mysqli_error($link));

    while ($registro = mysqli_fetch_array($resultado)) {
        $telefone = $registro['telefone_cliente'];
        $cep = $registro['cep_cliente'];
        $endereco = $registro['endereco_cliente'];
        $numero = $registro['num_end_cliente'];
        $cidadeEstado = $registro['bairro_cid_est_cliente'];
    }

    $telefone = isset($telefone) ? $telefone : "";
    $cep = isset($endereco) ? $endereco : "NÃO REGISTRADO";
    $endereco = isset($endereco) ? $endereco : "NÃO REGISTRADO";
    $numero = isset($numero) ? $numero : "";
    $cidadeEstado = isset($cidadeEstado) ? $cidadeEstado : "NÃO REGISTRADO";

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css' integrity='sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk' crossorigin='anonymous'>
    <link rel='stylesheet' href='../../css/all.css'>
    <title>Disk Pizza</title>
</head>

<body>
    <div class='flex-dashboard d-flex flex-row h-100 w-100'>
        <sidebar class='h-100 bg-dark text-light'>
            <div class='sidebar-title d-flex flex-row justify-content-center align-items-center'>
                <a href='/index.html' class='btn text-light'>
                    <h2><i class='fas fa-pizza-slice fa'></i> Disk-Pizza</h2>
                </a>
            </div>
            <ul class='nav nav-pills flex-column p-4'>
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
        <main class='d-block h-100 bg-secondary'>
            <header class='d-flex flew-row align-items-center justify-content-center bg-danger text-dark'>
                <h1><i class='fas fa-user-edit'></i> Editar Cliente</h1>
            </header>
            <div class='main-content'>
                <div class='main-content p-3 w-100'>
                    <div class='panel-row d-flex flex-row align-items-center p-1 justify-content-center w-100'>
                        <form action='update-cliente.php?acao=update' method='POST' class='container'>
                            <div class='form-row mt-5'>
                                <div class='form-group col-2'>
                                    <label for='inputCodigo'>Código</label>
                                    <input type='number' id='inputCodigo' name='inputCodigo' class='form-control' value='<?php echo $id?>' readonly>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label for="inputTelefone">Telefone</label>
                                    <input type="text" class="form-control inputTelefone" id="inputTelefone" name="inputTelefone" placeholder="(DD) 9 9999-9999" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $telefone;?>">
                                </div>
                                <div class="from-group">
                                    <label for="inputCEPverifica">CEP</label>
                                    <input type="text" class="form-control" id="inputCEP" name="inputCEP" value="<?php echo $cep ?>" placeholder="99.999-999" onkeypress="$(this).mask('00.000-000')" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                                <div class='form-group col-md-8'>
                                    <label for="inputEndereco">Endereço</label>
                                    <input type="text" class="form-control" id="inputEndereco" name="inputEndereco" value="<?php echo $endereco; ?>" placeholder=" Bairro - Cidade/Sigla" maxlength="80" required>
                                </div>
                                <div class='form-group col-md-8'>
                                    <label for="inputNumero">Número</label>
                                    <input type="text" class="form-control" id="inputNumero" name="inputNumero" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $numero;?>">
                                </div>
                                <div class='form-group col-md-8'>
                                    <label for="inputCidadeEstado">Bairro / Cidade / Estado</label>
                                    <input type="text" class="form-control" id="inputCidadeEstado" name="inputCidadeEstado" value="<?php echo $cidadeEstado;?>" placeholder="Cidade/Sigla" maxlength="80" required>
                                </div>
                            </div>
                            <button type='submit' class='btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100'>Editar
                                Cliente</button>
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