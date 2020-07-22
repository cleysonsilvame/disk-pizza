<?php

$acao = isset($_GET['acao']);

if($acao == 'insert'){
  include_once 'conexao.php';
  
  $nome = $_POST['inputNome'];
  $valor = $_POST['inputValor'];
  $tipo = $_POST['inputTipo'];

  $sql = "INSERT INTO tb_produto (nome_produto, tipo_produto, valor_produto)values('$nome', '$tipo', '$valor')";

  if(!mysqli_query($link, $sql)){
    die("Erro ao inserir as informações do formulário na tabela de clientes: ". mysqli_error($link));
  }
  else{
    echo "<script>alert('Dados inseridos com sucesso.');</script>";          
  }
  mysqli_close($link);
  header("Location:editar-produto.php");
}
else{
  echo "<!DOCTYPE html>
  <html lang='pt-br'>
  
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'
      integrity='sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk' crossorigin='anonymous'>
      <link rel='stylesheet' href='../css/all.css'>
    <title>Disk Pizza</title>
  </head>
  
  <body>
    <div class='flex-dashboard d-flex flex-row h-100 w-100'>
      <sidebar class='h-100 bg-dark text-light'>
        <div class='sidebar-title d-flex flex-row justify-content-center align-items-center'>
          <a href='/index.html' class='btn text-light'><h2><i class='fas fa-pizza-slice fa'></i> Disk-Pizza</h2></a>
        </div>
        <ul class='nav nav-pills flex-column p-4'>
          <li class='nav-item '>
            <a href='/views/menu-pedidos.php' class='nav-link text-light'><i class='fas fa-list'></i> Menu de Pedidos</a>
          </li>
          <li class='nav-item'>
            <a href='/views/editar-cliente.php' class='nav-link text-light'><i class='fas fa-user-cog'></i> Editar Clientes</a>
          </li>
          <li class='nav-item'>
            <a href='/views/editar-produto.php' class='nav-link text-light'><i class='fas fa-utensils'></i> Editar Produtos</a>
          </li>
        </ul>
      </sidebar>
      <main class='d-block h-100 bg-secondary'>
        <header class='d-flex flew-row align-items-center justify-content-center bg-danger text-dark'>
          <h1><i class='fas fa-plus-square'></i> Cadastrar Produto</h1>
        </header>
        <div class='main-content'>
          <div class='main-content p-3 w-100'>
            <div class='panel-row d-flex flex-row align-items-center p-1 justify-content-center w-100'>
            <form action='cadastrar-produto.php?acao=insert' method='POST' class='container'>
            <div class='form-row mt-5'>
              <div class='form-group col-md-4'>
                <label for='inputNome'>Nome</label>
                <input type='text' class='form-control' id='inputNome' name='inputNome' placeholder='Nome do produto cadastrado' maxlength='15' required>
              </div>
              <div class='form-group col-md-4'>
                <label for='inputValor'>Valor</label>
                <input type='number' class='form-control' id='inputValor' name='inputValor' placeholder='R$ 99999,99' min='0' max='9999999' required>
              </div>
              <div class='form-group col-md-4'>
                <label for='inputTipo'>Tipo</label>
                <input type='text' class='form-control' id='inputTipo' name='inputTipo' placeholder='Tipo do produto cadastrado' maxlength='10' required>
              </div>
            </div>
            <button type='submit' class='btn panel panel-50 d-flex flex-column align-items-center justify-content-center p-2 mt-1 mr-0 w-100'>Cadastrar Produto</button>
          </form>
            </div>
      </main>
    </div>
  
    <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'
      integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj'
      crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'
      integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo'
      crossorigin='anonymous'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'
      integrity='sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI'
      crossorigin='anonymous'></script>
    <script src='https://kit.fontawesome.com/a31af2c148.js' crossorigin='anonymous'></script>
  </body>
  
  </html>";
}