use heroku_4628bef716ade9e;

select * from tb_cliente;create table tb_cliente(
cod_cliente int not null auto_increment primary key,
telefone_cliente varchar(11) not null,
cep_cliente varchar(8) not null,
num_end_cliente varchar(8) not null,
endereco_cliente varchar(80) not null,
bairro_cid_est_cliente varchar(80) not null);

create table tb_pedido(
cod_pedido int not null auto_increment primary key,
datahora_pedido datetime not null,
horasaida_pedido time,
horachegada_pedido time,
tipo_pedido varchar(10) not null,
cod_cliente int,
constraint fk_pedido_cliente
foreign key (cod_cliente) references tb_cliente(cod_cliente) on delete cascade on update cascade);

create table tb_produto(
cod_produto int not null auto_increment primary key,
nome_produto varchar(15) not null,
tipo_produto varchar(10) not null,
valor_produto decimal(7,2) not null);

create table tb_item_pedido(
cod_item_pedido int not null auto_increment primary key,
quant_item_pedido int not null,
cod_produto int not null,
cod_pedido int not null,
constraint fk_item_produto
foreign key (cod_produto) references tb_produto(cod_produto) on delete cascade on update cascade,
constraint fk_item_pedido
foreign key (cod_pedido) references tb_pedido(cod_pedido) on delete cascade on update cascade);