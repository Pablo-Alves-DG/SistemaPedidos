<?php session_start();
if ($_SESSION['admin'] == null){
   header('Location: Pagina_login.html');   
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos_produção</title>
    <link rel="stylesheet" href="CSS/Pedidos_producao.css">
    
</head>

<body>
<script src="JS/Menu.js"></script>

    <div id="tabela" class="box">
        <table class="tabela">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Cliente DN4</th>
                    <th>Pedido</th>
                    <th>Termo</th>
                    <th>Chamado Comercial</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody class="tb-content">
            <?php
            include('PHP/conexao.php');
            $sql = "Select Distinct Cliente, Cliente_DN4, Pedido, Termo, Chamado_Comercial, Data_Criacao from Tab_Pedidos where Quantidade_Pendente <>'0'";
            
            $cursor = "static";
            $params = array();
            $options = array("Scrollable"=>$cursor);
            $stmt = sqlsrv_query($conexao, $sql, $params, $options);
            $li = 1;
            while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo "<tr>
                    <td id='Cliente[" . $li . "]' >" . $row['Cliente'] . "</td>
                    <td id='Cliente_DN4[" . $li . "]' >" . $row['Cliente_DN4'] . "</td>
                    <td id='Pedido[" . $li . "]' >" . $row['Pedido'] . "</td>
                    <td id='Termo[" . $li . "]' >" . $row['Termo'] . "</td>
                    <td id='Chamado_Comercial[" . $li . "]' >" . $row['Chamado_Comercial'] . "</td>
                    <td><button id='Selecionar[" . $li . "]' onclick='select(" . $li . ")'>Selecionar</button></td>
                </tr>";
                $li = $li +1;
            }
            ?>
            </tbody>
        </table>
    </div>
    <form id="formtemp" style="display: none" action="Pedidos_Producao2.php" method="post">
        <input id="Cliente" name="Cliente" type="text">
        <input id="Cliente_DN4" name="Cliente_DN4" type="text">
        <input id="Pedido" name="Pedido" type="text">
        <input id="Termo" name="Termo" type="text">
        <input id="Chamado_Comercial" name="Chamado_Comercial" type="text">
        <input id="Data_Criacao" name="Data_Criacao" type="datetime">
    </form>
<script>
    function select(li){
        document.getElementById("Cliente").value = document.getElementById("Cliente["+li+"]").innerText;
        document.getElementById("Cliente_DN4").value = document.getElementById("Cliente_DN4["+li+"]").innerText;
        document.getElementById("Pedido").value = document.getElementById("Pedido["+li+"]").innerText;
        document.getElementById("Termo").value = document.getElementById("Termo["+li+"]").innerText;
        document.getElementById("Chamado_Comercial").value = document.getElementById("Chamado_Comercial["+li+"]").innerText;
        document.forms["formtemp"].submit();
    }


</script>

</body>
</html>