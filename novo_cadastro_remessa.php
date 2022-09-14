<?php
include("conexao.php");

//Linha incial do Looping
$ini = 1;
//Contagem total de Linhas enviadas
$li = count($_POST['chamado_comercial']);
//Início do Looping
while($li >= $ini){

//Cada Campo tem o indicador de Linha / Array (Definido como $ini)
$chamado_comercial = $_POST['chamado_comercial'][$ini];
$cliente = $_POST['cliente'][$ini];
$cliente_dn4 = $_POST['cliente_dn4'][$ini];
$pedido = $_POST['pedido'][$ini];
$termo = $_POST['termo'][$ini];
$tipo_pedido = $_POST['tipo_pedido'][$ini];
$end = $_POST['endereco'][$ini];
$cnpj = $_POST['cnpj'][$ini];
$estrategia = $_POST['estrategia'][$ini];
$data = date('Y-m-d H:i:s',strtotime($_POST['data_criacao'][$ini]));
$tipo_item = $_POST['tipo_item'][$ini];
$item = $_POST['item'][$ini];
$qtd = $_POST['quantidade'][$ini];
$obs = $_POST['obs'][$ini];
$valor = $_POST['valor'][$ini];
$data_atual = date('Y-m-d H:i:s');


if(empty($chamado_comercial) ||
empty($chamado_comercial) ||
empty($cliente) ||
empty($cliente_dn4) ||
empty($pedido) ||
empty($termo) ||
empty($tipo_pedido) ||
empty($end) ||
empty($cnpj) ||
empty($estrategia) ||
empty($data) ||
empty($tipo_item) ||
empty($item) ||
empty($qtd) ||
empty($obs) ||
empty($data_atual)
){
    $ini = $ini + 1;
    continue;
}

/////////////////////////// Inserção das Informações////////////////////////

//SQL Básico
$sql = "INSERT INTO [dbo].[Tab_Pedidos]
([Data_Movimento]
,[Chamado_Comercial]
,[Cliente]
,[Cliente_DN4]
,[Pedido]
,[Termo]
,[Tipo_Pedido]
,[Endereco]
,[Data_Criacao]
,[Tipo_Item]
,[Item]
,[Quantidade_Total]
,[Quantidade_Enviada]
,[Quantidade_Pendente]
,[Observacao]
,[Valor_Unitario])
VALUES
(?
,?
,?
,?
,?
,?
,?
,?
,?
,?
,?
,?
,?
,?
,?
,?)";

//Inserção das variaveis no SQL
$stmt = sqlsrv_prepare($conexao, $sql, array(
    $data_atual,
    $chamado_comercial,
    $cliente,
    $cliente_dn4,
    $pedido,
    $termo,
    $tipo_pedido,
    $end,
    $data,
    $tipo_item,
    $item,
    $qtd,
    0,
    $qtd,
    $obs,
    $valor
)
);

//Rodar o SQL com print_r para possíveis erros
if( !$stmt ) {
    die( print_r( sqlsrv_errors(), true));
} else {
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
  }
}


// Reiniciar o Looping pra cada linha enviada
$ini = $ini + 1;
}

header("Location: ../Pedidos_Remessa.php");
exit();



?>