<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
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
          <a href="/views/menu-pedidos.php" class="nav-link text-light active"><i class="fas fa-list"></i> Menu de
            Pedidos</a>
        </li>
        <li class="nav-item">
          <a href="/views/editar-cliente.php" class="nav-link text-light"><i class="fas fa-user-cog"></i> Editar
            Clientes</a>
        </li>
        <li class="nav-item">
          <a href="/views/editar-produto.php" class="nav-link text-light"><i class="fas fa-utensils"></i> Editar
            Produtos</a>
        </li>
      </ul>
    </sidebar>
    <main class="d-block h-100 bg-secondary">
      <header class="d-flex flew-row align-items-center justify-content-center bg-danger text-dark">
        <h1><i class="fas fa-utensils"></i> Menu pedidos</h1>
      </header>
      <div class="main-content p-3 w-100">
        <div class="panel-row d-flex flex-row align-items-center p-1 justify-content-center">
          <a class="btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mr-2 mt-1 w-100"
            href="#">Novo Pedido</a>
          <a class="btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 ml-2 mt-1 w-100"
            href="#">Pedidos Realizados</a>
        </div>
          <div class="container-fluid mt-3">
            <h2 class="text-center display-4">Pedidos Ativos</h2>
            <?php
              include_once 'conexao.php';

              $sql = "SELECT 
              pe.cod_pedido,
              pe.datahora_pedido,
              pe.horasaida_pedido,
              pe.tipo_pedido,
              c.cod_cliente,
              c.telefone_cliente,
              c.endereco_cliente
              FROM tb_pedido AS pe
              LEFT JOIN tb_cliente AS c ON pe.cod_cliente = c.cod_cliente";

              $resultado = mysqli_query($link, $sql) or die("Erro ao retornar os valores do banco de dados");

              while($registro = mysqli_fetch_array($resultado)){
                $codPedido = $registro['cod_pedido'];
                $dhPedido = $registro['datahora_pedido'];
                $hsPedido = $registro['horasaida_pedido'];
                $tpPedido = $registro['tipo_pedido'];
                $codCliente = $registro['cod_cliente'];
                $telCliente = $registro['telefone_cliente'];
                $endCliente = $registro['endereco_cliente'];


                echo "<div class='row'>
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
                    <tr>
                      <th scope='row'>".$codPedido."</th>
                      <td>"."</td>
                      <td>"."</td>
                      <td>"."</td>
                      <td>"."</td>
                      <td></td>
                    </tr>
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
                        <th scope='col'>Endereço</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope='row'>".$codCliente."</th>
                        <td>".$telCliente."</td>
                        <td>".$endCliente."</td>
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
                        <td>".$dhPedido."</td>
                        <td>".$hsPedido."</td>
                        <td>".$tpPedido."</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div> 
            </div>           
            <div class='panel-row d-flex flex-row align-items-center mb-4 justify-content-center'>
              <div class='col-6 pl-0'>
                  <a a href='#' class='btn text-dark w-100'><i class='fas fa-edit'></i></a>
                </div>
                <div class='col-6 pr-0'>
                  <a href='#' class='btn text-dark w-100'><i class='fas fa-trash'></i></a>
                </div>
            </div>";
              }    
?>
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