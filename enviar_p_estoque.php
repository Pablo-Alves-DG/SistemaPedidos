<?php
include("conexao.php");
session_start();
//Linha incial do Looping
$ini = 1;
//Contagem total de Linhas enviadas
$li = count($_POST['Item']);
$cursor = "static";
$params = array();
$options = array("Scrollable"=>$cursor);
//Início do Looping
while($li >= $ini){

//Cada Campo tem o indicador de Linha / Array (Definido como $ini)
$Num_Auto_Remessa = $_POST['Num_Auto_Remessa'][$ini];
$Data_atual = date('Y-m-d H:i:s');
$Data_Criacao = $_POST['Data_Criacao'][$ini];
$Chamado_Comercial = $_POST['Chamado_Comercial'][$ini];
$Cliente = $_POST['Cliente'][$ini];
$Cliente_DN4 = $_POST['Cliente_DN4'][$ini];
$Pedido = $_POST['Pedido'][$ini];
$Termo = $_POST['Termo'][$ini];
$Tipo_Item = $_POST['Tipo_Item'][$ini];
$Item = $_POST['Item'][$ini];
$Qtd = (int)$_POST['Qtd'][$ini];
$Obs = $_POST['Obs'][$ini];
$Data_Entrega = date('Y-m-d H:i:s',strtotime($_POST['Data_Entrega'][$ini]));
$Limite_Expedicao = $_POST['Limite_Expedicao'][$ini];
$Usuario = $_SESSION['user'];
$Status = 'Aguardando Estoque';

if($Qtd == 0){
    $ini = $ini + 1;
    continue;
}

/////////////////////////// Denominar Tabela de Saida com base no Status ///
if($Status == 'Ag_Estoque'){$table = 'Tab_Estoque';}
if($Status == 'Ag_Emissao_NF'){$table = 'Tab_Emissao_NF';}
if($Status == 'Ag_Separacao'){$table = 'Tab_Separacao';}
if($Status == 'Ag_Producao'){$table = 'Tab_Producao';}
if($Status == 'Ag_Expedicao'){$table = 'Tab_Expedicao';}
if($Status == 'Ag_Compras'){$table = 'Tab_Compras';}

/////////////////////////// Denominar a Coluna Ultima Data com base no Status
if($Status == 'Ag_Estoque'){$coltable = 'Ultima_Data_Retorno';}
if($Status == 'Ag_Emissao_NF'){$coltable = 'Ultima_Data_Producao';}
if($Status == 'Ag_Separacao'){$coltable = 'Ultima_Data_Estoque';}
if($Status == 'Ag_Producao'){$coltable = 'Ultima_Data_Estoque';}
if($Status == 'Ag_Expedicao'){$coltable = 'Ultima_Data_Producao';}
if($Status == 'Ag_Compras'){$coltable = 'Ultima_Data_Estoque';}

/////////////////////////// Inserção das Informações ///////////////////////


// Validar se Já Existe Linha
$sqlcon = "Select Item, Quantidade_Entrada, Saldo  From {$table} where
Num_Auto_Remessa = '{$Num_Auto_Remessa}' and 
Cliente = '{$Cliente}' and 
Cliente_DN4 = '{$Cliente_DN4}' and 
Pedido = '{$Pedido}' and 
Termo = '{$Termo}' and 
Tipo_Item = '{$Tipo_Item}' and 
Item = '{$Item}' and
Status = '{$Status}'
";
$stmtcon = sqlsrv_query($conexao, $sqlcon, $params, $options);
if( $stmtcon === false ) {
    die( print_r( sqlsrv_errors(), true));
}

if( sqlsrv_fetch( $stmtcon ) === false) {
    die( print_r( sqlsrv_errors(), true));
}

//Se Já Existir dar Update na Linha ao invés de Criar uma Nova
if(sqlsrv_num_rows($stmtcon) == 1){
$Qtd_Entrada = (int)sqlsrv_get_field($stmtcon, 1);
$Qtd_Saldo = (int)sqlsrv_get_field($stmtcon, 2);
$Qtd_Entrada_Nova = $Qtd_Entrada + $Qtd;
$Qtd_Saldo_Nova = $Qtd_Saldo + $Qtd;

$sql2 = "Update {$table}
Set
    Quantidade_Entrada = ?
    ,Saldo = ?
    ,Data_Entrega = ?
    ,Limite_Expedicao = ?
    ,Data_Ultimo_Movimento = ?
    ,Usuario_Movimento = ?

where
    Num_Auto_Remessa = '{$Num_Auto_Remessa}' and 
    Cliente = '{$Cliente}' and 
    Cliente_DN4 = '{$Cliente_DN4}' and 
    Pedido = '{$Pedido}' and 
    Termo = '{$Termo}' and 
    Tipo_Item = '{$Tipo_Item}' and 
    Item = '{$Item}'and
    Status = '{$Status}'
";

$stmt2 = sqlsrv_prepare($conexao, $sql2, array(
    $Qtd_Entrada_Nova
    ,$Qtd_Saldo_Nova
    ,$Data_Entrega
    ,$Limite_Expedicao
    ,$Data_atual
    ,$Usuario
));

//Rodar o SQL com print_r para possíveis erros
if( !$stmt2 ) {
    die( print_r( sqlsrv_errors(), true));
} else {
    if( sqlsrv_execute( $stmt2 ) === false ) {
        die( print_r( sqlsrv_errors(), true));
  }
}





}else //Caso Não Exista uma Linha ele Irá Criar
{







//SQL Básico
$sql = "INSERT INTO [dbo].[Tab_Estoque]
([Num_Auto_Remessa]
,[Data_Ultimo_Movimento]
,[Data_Criacao]
,[Data_Entrega]
,[Limite_Expedicao]
,[Chamado_Comercial]
,[Cliente]
,[Cliente_DN4]
,[Pedido]
,[Termo]
,[Tipo_Item]
,[Item]
,[Quantidade_Entrada]
,[Saldo]
,[Quantidade_Saida]
,[Status]
,[Observacao]
,[Usuario_Movimento])
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
,{$Qtd}
,{$Qtd}
,?
,?
,?
,?)";

//Inserção das variaveis no SQL
$stmt = sqlsrv_prepare($conexao, $sql, array(
    $Num_Auto_Remessa
    ,$Data_atual
    ,$Data_Criacao
    ,$Data_Entrega
    ,$Limite_Expedicao
    ,$Chamado_Comercial
    ,$Cliente
    ,$Cliente_DN4
    ,$Pedido
    ,$Termo
    ,$Tipo_Item
    ,$Item
    ,0
    ,$Status
    ,$Obs
    ,$Usuario
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
}



/////////////////////////// Atualização de Tabela Pedidos////////////////////////

//SQL de Consulta para Somar QTD_Enviadas
$sqlqe = "Select Quantidade_Enviada, Quantidade_Total from Tab_Pedidos 
where
Cliente = '{$Cliente}' and 
Cliente_DN4 = '{$Cliente_DN4}' and 
Pedido = '{$Pedido}' and 
Termo = '{$Termo}' and 
Chamado_Comercial = '{$Chamado_Comercial}' and 
Tipo_Item = '{$Tipo_Item}' and 
Item = '{$Item}'";



$stmtqe = sqlsrv_query($conexao, $sqlqe, $params, $options);


//Rodar o SQL com print_r para possíveis erros
if( $stmtqe === false ) {
    die( print_r( sqlsrv_errors(), true));
}

if( sqlsrv_fetch( $stmtqe ) === false) {
    die( print_r( sqlsrv_errors(), true));
}

if(sqlsrv_num_rows($stmtqe) == 1){
    $Qtd_Enviada = (int)sqlsrv_get_field( $stmtqe, 0);
    $Qtd_Total = (int)sqlsrv_get_field( $stmtqe, 1);
}else{
    $Qtd_Enviada = 0;
    $Qtd_Total = (int)sqlsrv_get_field( $stmtqe, 1);
}


//SQL de Update
$sqlup = "UPDATE [dbo].[Tab_Pedidos]
SET 
   [Quantidade_Enviada] = ?
   ,[Quantidade_Pendente] = ?
   where 
Cliente = ? and 
Cliente_DN4 = ? and 
Pedido = ? and 
Termo = ? and 
Chamado_Comercial = ? and 
Tipo_Item = ? and 
Item = ?";

$Qtd_Enviada_Nova = $Qtd_Enviada + $Qtd;
$Qtd_Pendente_Nova = $Qtd_Total - $Qtd_Enviada_Nova;

//Inserção das variaveis no SQL
$stmtup = sqlsrv_prepare($conexao, $sqlup, array(
    $Qtd_Enviada_Nova
    ,$Qtd_Pendente_Nova
    ,$Cliente
    ,$Cliente_DN4
    ,$Pedido
    ,$Termo
    ,$Chamado_Comercial
    ,$Tipo_Item
    ,$Item
)
);

//Rodar o SQL com print_r para possíveis erros
if( !$stmtup ) {
    die( print_r( sqlsrv_errors(), true));
} else {
    if( sqlsrv_execute( $stmtup ) === false ) {
        die( print_r( sqlsrv_errors(), true));
  }
}




// Reiniciar o Looping pra cada linha enviada
$ini = $ini + 1;
}

header("Location: ../Pedidos_Producao.php");
exit();



?>