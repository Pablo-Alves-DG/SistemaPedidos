<?php
include("conexao.php");
session_start();
//Linha inicial do Looping
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
$Data_Criacao = date('Y-m-d H:i:s',strtotime($_POST['Data_Criacao'][$ini]));
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
$Status = $_POST['Status'][$ini];
$NF = $_POST['NF'][$ini];
$Data_Expedicao = date('Y-m-d H:i:s',strtotime($_POST['Data_Expedicao'][$ini]));

if($Qtd == 0){
    $ini = $ini + 1;
    continue;
}

/////////////////////////// Denominar Tabela de Saida com base no Status ///
if($Status == 'Barrado'){$table = 'Tab_Pos_Expedicao';}
if($Status == 'Devolvido'){$table = 'Tab_Pos_Expedicao';}
if($Status == 'Expedido'){$table = 'Tab_Pos_Expedicao';}
if($Status == 'Em_Transito'){$table = 'Tab_Pos_Expedicao';}
if($Status == 'Entregue'){$table = 'Tab_Pos_Expedicao';}
if($Status == 'Rollout'){$table = 'Tab_Pos_Expedicao';}
if($Status == 'Ag_Estoque'){$table = 'Tab_Estoque';}
if($Status == 'Ag_Emissao_NF'){$table = 'Tab_Emissao_NF';}
if($Status == 'Ag_Separacao'){$table = 'Tab_Separacao';}
if($Status == 'Ag_Producao'){$table = 'Tab_Producao';}
if($Status == 'Ag_Expedicao'){$table = 'Tab_Expedicao';}
if($Status == 'Ag_Compras'){$table = 'Tab_Compras';}

/////////////////////////// Denominar a Coluna Ultima Data com base no Status
if($Status == 'Ag_Estoque'){$coltable = 'Ultima_Data_Retorno';}
if($Status == 'Barrado'){$coltable = 'Ultima_Data_Expedicao';}
if($Status == 'Devolvido'){$coltable = 'Ultima_Data_Expedicao';}
if($Status == 'Expedido'){$coltable = 'Ultima_Data_Expedicao';}
if($Status == 'Em_Transito'){$coltable = 'Ultima_Data_Expedicao';}
if($Status == 'Entregue'){$coltable = 'Ultima_Data_Expedicao';}
if($Status == 'Rollout'){$coltable = 'Ultima_Data_Expedicao';}
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
    ,{$coltable} = ?

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
    ,$Data_Expedicao
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
$sql = "INSERT INTO [dbo].[{$table}]
([Num_Auto_Remessa]
,[{$coltable}]
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
,[Usuario_Movimento]
,[NF])
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
,{$Qtd}
,{$Qtd}
,?
,?
,?
,?)";

//Inserção das variaveis no SQL
$stmt = sqlsrv_prepare($conexao, $sql, array(
    $Num_Auto_Remessa
    ,$Data_Expedicao
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
    ,$NF
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



/////////////////////////// Atualização de Tabela Expedicao////////////////////////

//SQL de Consulta para Somar QTD_Enviadas
$sqlqe = "Select Quantidade_Saida, Saldo from Tab_Expedicao 
where
Cliente = '{$Cliente}' and 
Cliente_DN4 = '{$Cliente_DN4}' and 
Pedido = '{$Pedido}' and 
Termo = '{$Termo}' and 
Chamado_Comercial = '{$Chamado_Comercial}' and 
Tipo_Item = '{$Tipo_Item}' and 
Num_Auto_Remessa = '{$Num_Auto_Remessa}' and 
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
    $Qtd_Saida = (int)sqlsrv_get_field( $stmtqe, 0);
    $Qtd_Saldo = (int)sqlsrv_get_field( $stmtqe, 1);
}else{
    $Qtd_Saida = 0;
    $Qtd_Saldo = (int)sqlsrv_get_field( $stmtqe, 1);
}


//SQL de Update
$sqlup = "UPDATE [dbo].[Tab_Expedicao]
SET 
   [Quantidade_Saida] = ?
   ,[Saldo] = ?
   where 
Cliente = ? and 
Cliente_DN4 = ? and 
Pedido = ? and 
Termo = ? and 
Chamado_Comercial = ? and 
Tipo_Item = ? and 
Num_Auto_Remessa = ? and 
Item = ?";

$Qtd_Saida_Nova = $Qtd_Saida + $Qtd;
$Qtd_Saldo_Nova = $Qtd_Saldo - $Qtd;

//Inserção das variaveis no SQL
$stmtup = sqlsrv_prepare($conexao, $sqlup, array(
    $Qtd_Saida_Nova
    ,$Qtd_Saldo_Nova
    ,$Cliente
    ,$Cliente_DN4
    ,$Pedido
    ,$Termo
    ,$Chamado_Comercial
    ,$Tipo_Item
    ,$Num_Auto_Remessa
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


header("Location: ../Expedicao.php");
exit();



?>