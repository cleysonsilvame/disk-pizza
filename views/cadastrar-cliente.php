<?php
session_start();
$acao = isset($_GET['acao'])? $_GET['acao'] : "";



if ($acao == 'verificarCEP') {
  $cep = "07193-270";
  $cep = preg_replace("/[^0-9]/", "", $cep);
  $url = "http://viacep.com.br/ws/$cep/xml/";
  
  $xml = simplexml_load_file($url);
  
  $_SESSION['cep'][] = strval($xml -> cep);
  $_SESSION['cep'][] = strval($xml -> logradouro);
  $_SESSION['cep'][] = strval($xml -> bairro);
  $_SESSION['cep'][] = strval($xml -> localidade);
  $_SESSION['cep'][] = strval($xml -> uf);

} else if ($acao == 'insert'){
  include_once 'conexao.php';
  
  $telefone = preg_replace("/[^0-9]/", "", $_POST['inputTelefone']);
  $cep = preg_replace("/[^0-9]/", "", $_POST['inputCEP']);
  $numero = preg_replace("/[^0-9]/", "", $_POST['inputNumero']);
  $endereco = $_POST['inputEndereco'];
  $cidadeEstado = $_POST['inputCidadeEstado'];

  echo $telefone."<br>".$cep."<br>".$numero."<br>".$endereco."<br>".$cidadeEstado;

  $sql = "INSERT INTO tb_cliente (telefone_cliente, cep_cliente, num_end_cliente, endereco_cliente, bairro_cid_est_cliente )values('$telefone', '$cep', '$numero', '$endereco' , '$cidadeEstado')";

  if (!mysqli_query($link, $sql)) {
    die("Erro ao inserir as informações do formulário na tabela de clientes: " . mysqli_error($link));
  } else {
    echo "<script>alert('Dados inseridos com sucesso.');</script>";
  }
  mysqli_close($link);
  session_destroy();
  header("Location:editar-cliente.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/all.css">
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
          <a href="/views/menu-pedidos.php" class="nav-link text-light"><i class="fas fa-list"></i> Menu de Pedidos</a>
        </li>
        <li class="nav-item">
          <a href="/views/editar-cliente.php" class="nav-link text-light"><i class="fas fa-user-cog"></i> Editar Clientes</a>
        </li>
        <li class="nav-item">
          <a href="/views/editar-produto.php" class="nav-link text-light"><i class="fas fa-utensils"></i> Editar Produtos</a>
        </li>
      </ul>
    </sidebar>
    <main class="d-block h-100 bg-secondary">
      <header class="d-flex flew-row align-items-center justify-content-center bg-danger text-dark">
        <h1><i class="fas fa-user-plus"></i> Cadastrar Cliente</h1>
      </header>
      <div class="main-content">
        <div class="main-content p-3 w-100">
          <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center w-100">
            <form method="POST" action="cadastrar-cliente.php?acao=insert" class="container">
              <div class="form-row mt-5">
                <div class="form-group col-md-2">
                  <label for="inputCEP">CEP</label>
                  <input type="text" class="form-control" id="inputCEP" name="inputCEP" value="<?php echo isset($_SESSION['cep'][0])? $_SESSION['cep'][0] : "";?>" placeholder="99.999-999" onkeypress="$(this).mask('00.000-000')" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
                <div class="form-group col-md-3 d-flex flex-row align-items-end">
                  <a href="cadastrar-cliente.php?acao=verificarCEP" class="btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0">Verificar</a>
                </div>
                <div class="form-group col-md-4">
                  <label for="inputTelefone">Telefone</label>
                  <input type="text" class="form-control inputTelefone" id="inputTelefone" name="inputTelefone" placeholder="(DD) 9 9999-9999" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="inputEndereco">Endereço</label>
                  <input type="text" class="form-control" id="inputEndereco" name="inputEndereco" value="<?php echo isset($_SESSION['cep'][1])? $_SESSION['cep'][1] : "";?>" placeholder="Av. Fulando de tal, 999 - Bairro - Cidade/Sigla" maxlength="80" required>
                </div>
                <div class="form-group col-md-1">
                  <label for="inputNumero">Número</label>
                  <input type="text" class="form-control" id="inputNumero" name="inputNumero" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputCidadeEstado">Cidade / Estado</label>
                  <input type="text" class="form-control" id="inputCidadeEstado" name="inputCidadeEstado" value="<?php                   
                  $bairro = isset($_SESSION['cep'][2]) ? $_SESSION['cep'][2] : "";
                  $cidade =  isset($_SESSION['cep'][3]) ? $_SESSION['cep'][3] : "";
                  $estado = isset($_SESSION['cep'][4]) ? $_SESSION['cep'][4] : "";
                  echo $bairro." ".$cidade."/".$estado;
                  ?>" placeholder="Cidade/Sigla" maxlength="80" required>
                </div>
              </div>
              <button type="submit" class="btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100">Cadastrar Cliente</button>
            </form>
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