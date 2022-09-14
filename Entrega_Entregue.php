<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrega_Entregue</title>
    <link rel="stylesheet" href="CSS/Pedidos_producao.css">
</head>

<body>
<script src="JS/Menu.js"></script>
    <section>
        <div id="tabela" class="box">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>&emsp;Data Da&emsp;<br>&emsp;Entrega&emsp;</th>
                        <th>&emsp;Limite de&emsp;<br>&emsp;Expedição&emsp;</th>
                        <th>&nbsp;Cliente&nbsp;</th>
                        <th>&nbsp;Cliente DN4&nbsp;</th>
                        <th>&nbsp;Pedido&nbsp;</th>
                        <th>&nbsp;Termo&nbsp;</th>
                        <th>&nbsp;Chamado&nbsp;<br>&nbsp;Comercial&nbsp;</th>
                        <th>&emsp;Número de Autorização&emsp;<br>&emsp;de Remessa&emsp;</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="body21" class="tb-content">
                    <?php
            include('PHP/conexao.php');
            $sql = "Select Distinct Limite_Expedicao, Num_Auto_Remessa, Data_Entrega, Cliente, Cliente_DN4, Pedido, Termo, Chamado_Comercial from Tab_Pos_Expedicao where Saldo <>'0' and Status = 'Entregue' order by Data_Entrega desc";
            
            $cursor = "static";
            $params = array();
            $options = array("Scrollable"=>$cursor);
            $stmt = sqlsrv_query($conexao, $sql, $params, $options);
            $li = 1;
            while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo "<tr>
                    <td style='display: none' id='Data_Ent[" . $li . "]' >" . date_format($row['Data_Entrega'],'Y-m-d H:i:s') . "</td>
                    <td id='Data_Entrega[" . $li . "]' >" . date_format($row['Data_Entrega'],"d/m/Y") . "</td>
                    <td id='Limite_Expedicao[" . $li . "]' >" . $row['Limite_Expedicao'] . "</td>
                    <td id='Cliente[" . $li . "]' >" . $row['Cliente'] . "</td>
                    <td id='Cliente_DN4[" . $li . "]' >" . $row['Cliente_DN4'] . "</td>
                    <td id='Pedido[" . $li . "]' >" . $row['Pedido'] . "</td>
                    <td id='Termo[" . $li . "]' >" . $row['Termo'] . "</td>
                    <td id='Chamado_Comercial[" . $li . "]' >" . $row['Chamado_Comercial'] . "</td>
                    <td id='Num_Auto_Remessa[" . $li . "]' >" . $row['Num_Auto_Remessa'] . "</td>
                    <td><button id='Selecionar[" . $li . "]' onclick='select(" . $li . ")'>Selecionar</button></td>
                </tr>";
                $li = $li +1;
            }
            ?>
                </tbody>
            </table>
        </div>
    </section>
    <form id="formtemp" style="display: none" action="Entrega2_Entregue.php" method="post">
        <input id="Cliente" name="Cliente" type="text">
        <input id="Cliente_DN4" name="Cliente_DN4" type="text">
        <input id="Pedido" name="Pedido" type="text">
        <input id="Termo" name="Termo" type="text">
        <input id="Chamado_Comercial" name="Chamado_Comercial" type="text">
        <input id="Data_Entrega" name="Data_Entrega" type="text">
        <input id="Limite_Expedicao" name="Limite_Expedicao" type="text">
        <input id="Num_Auto_Remessa" name="Num_Auto_Remessa" type="text">
    </form>
    <script>
        function select(li) {
            document.getElementById("Cliente").value = document.getElementById("Cliente[" + li + "]").innerText;
            document.getElementById("Cliente_DN4").value = document.getElementById("Cliente_DN4[" + li + "]").innerText;
            document.getElementById("Pedido").value = document.getElementById("Pedido[" + li + "]").innerText;
            document.getElementById("Termo").value = document.getElementById("Termo[" + li + "]").innerText;
            document.getElementById("Chamado_Comercial").value = document.getElementById("Chamado_Comercial[" + li + "]").innerText;
            document.getElementById("Data_Entrega").value = document.getElementById("Data_Ent[" + li + "]").innerText;
            document.getElementById("Num_Auto_Remessa").value = document.getElementById("Num_Auto_Remessa[" + li + "]").innerText;
            document.getElementById("Limite_Expedicao").value = document.getElementById("Limite_Expedicao[" + li + "]").innerText;
            document.forms["formtemp"].submit();
        }

    </script>
</body>

</html>