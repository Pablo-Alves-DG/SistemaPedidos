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
    <title>Entrega2_Expedido</title>
    <link rel="stylesheet" href="CSS/Pedidos_producao.css">
</head>

<body onload="datenow()">
<script src="JS/Menu.js"></script>
    <div id="tabela" class="box">
        <table id="dados" class="tabela">
            <thead>
                <tr>
                    <th>Descrição do item </th>
                    <th>Saldo<br> pendente</th>
                    <th>Quantidade à<br> Movimentar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
            include('PHP/conexao.php');
            $sql = "Select Num_Auto_Remessa, Observacao, Data_Criacao, Tipo_Item, Item, Saldo from Tab_Pos_Expedicao where Cliente = '" . $_POST['Cliente'] . "' and Cliente_DN4 = '" . $_POST['Cliente_DN4'] . "' and Pedido = '" . $_POST['Pedido'] . "' and Termo = '" . $_POST['Termo'] . "' and Chamado_Comercial = '" . $_POST['Chamado_Comercial'] . "' and Num_Auto_Remessa = '" . $_POST['Num_Auto_Remessa'] . "' and Data_Entrega = '" . $_POST['Data_Entrega'] . "' and Status = 'Expedido' order by Item";
            
            $cursor = "static";
            $params = array();
            $options = array("Scrollable"=>$cursor);
            $stmt = sqlsrv_query($conexao, $sql, $params, $options);
            if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
           }
            $li = 1;
            while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                $list = "";
                foreach(range(0, $row['Saldo']) as $rg){
                    if($rg == $row['Saldo']){
                        $list .= "<option selected value=" . $rg . ">" . $rg . "</option>
                        ";
                    }
                    else{
                        $list .= "<option value=" . $rg . ">" . $rg . "</option>
                        ";}
                    }
                echo "<tr>
                    <td id='item1[" . $li . "]'>" . $row['Item'] . "</td>
                    <td>" . $row['Saldo'] . "</td>
                    <td style='display: none;' id='Data_Criacao1[" . $li . "]' >" . date_format($row['Data_Criacao'], 'Y-m-d H:i:s') . "</td>
                    <td style='display: none;' id='Obs1[" . $li . "]' >" . $row['Observacao'] . "</td>
                    <td style='display: none;' id='Tipo_Item1[" . $li . "]' >" . $row['Tipo_Item'] . "</td>
                    <td>
                        <select id='qtd1[" . $li . "]'>" . $list . 
                        "</select>
                    </td>
                    <td>
                    <select class='Status_Unico' id='Status[" . $li . "]'>" . "
                                                          <option value='Entregue'>Entregue</option>
                                                          <option value='Rollout'>Rollout</option>
                                                          <option value='Devolucao'>Devolução</option>
                                                          <option value='Barrado'>Barrado</option>" . 
                    "</select>
                </td>
                </tr>";
                $li = $li +1;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="tabela2" class="box">
        <table class="tabela2">
            <tbody>
                <tr>
                    <th>Selecionar todos: <input onchange="check()" id="checkbox" type="checkbox" name="checkbox"></th>
                </tr>
                <tr>
                    <th>Data do Status: <input id="data_status" type="datetime-local" name="item" size="25"></th>
                </tr>
                <tr>
                    <th>Status Todos:</th>
                </tr>
                <th>
                    <select disabled="true" id="status_todos" name="estrategia">
                        <option value='Entregue'>Entregue</option>
                        <option value='Rollout'>Rollout</option>
                        <option value='Devolucao'>Devolução</option>
                        <option value='Barrado'>Barrado</option>
                    </select>
                </th>
                <tr>
                    <th><button id="enviar" onclick="enviar()">Enviar</button></th>
                </tr>
            </tbody>
        </table>
    </div>
    <form style="display: none;" id="formtemp" action="PHP/saida_pos_expedicao.php" method="post">
        <table id="tabtemp">
            <tbody>
                <tr></tr>
            </tbody>
        </table>
    </form>
    <script>
        function enviar() {
            var dados = document.getElementById("dados");
            var temp = document.getElementById("tabtemp");
            var li = 1;
            for (var ref = 0, linha; linha = dados.rows[ref]; ref++) {
                if (dados.rows.length == temp.rows.length) { break; }
                if(document.getElementById('checkbox').checked === true){var status = document.getElementById('status_todos').value}else{var status = document.getElementById("Status[" + li + "]").value}
                var add = temp.insertRow(0);
                var t1 = add.insertCell(0);
                var t2 = add.insertCell(1);
                var t3 = add.insertCell(2);
                var t4 = add.insertCell(3);
                var t5 = add.insertCell(4);
                var t6 = add.insertCell(5);
                var t7 = add.insertCell(6);
                var t8 = add.insertCell(7);
                var t9 = add.insertCell(8);
                var t10 = add.insertCell(9);
                var t11 = add.insertCell(10);
                var t12 = add.insertCell(11);
                var t13 = add.insertCell(12);
                var t14 = add.insertCell(13);
                var t15 = add.insertCell(14);
                var t16 = add.insertCell(15);
                t1.innerHTML = "<input id='Item[" + li + "]' type='text' name='Item[" + li + "]' value='" + document.getElementById("item1[" + li + "]").innerText + "'>";
                t2.innerHTML = "<input id='Qtd[" + li + "]' type='text' name='Qtd[" + li + "]' value='" + document.getElementById("qtd1[" + li + "]").value + "'>";
                t3.innerHTML = "<input id='Cliente[" + li + "]' type='text' name='Cliente[" + li + "]' value='" + "<?php print_r($_POST['Cliente']);?>" + "'>";
                t4.innerHTML = "<input id='Cliente_DN4[" + li + "]' type='text' name='Cliente_DN4[" + li + "]' value='" + "<?php print_r($_POST['Cliente_DN4']);?>" + "'>";
                t5.innerHTML = "<input id='Pedido[" + li + "]' type='text' name='Pedido[" + li + "]' value='" + "<?php print_r($_POST['Pedido']);?>" + "'>";
                t6.innerHTML = "<input id='Termo[" + li + "]' type='text' name='Termo[" + li + "]' value='" + "<?php print_r($_POST['Termo']);?>" + "'>";
                t7.innerHTML = "<input id='Chamado_Comercial[" + li + "]' type='text' name='Chamado_Comercial[" + li + "]' value='" + "<?php print_r($_POST['Chamado_Comercial']);?>" + "'>";
                t8.innerHTML = "<input id='Num_Auto_Remessa[" + li + "]' type='text' name='Num_Auto_Remessa[" + li + "]' value='" + "<?php print_r($_POST['Num_Auto_Remessa']);?>" + "'>";
                t9.innerHTML = "<input id='Data_Status[" + li + "]' type='text' name='Data_Status[" + li + "]' value='" + document.getElementById('data_status').value + "'>";
                t10.innerHTML = "<input id='Status[" + li + "]' type='text' name='Status[" + li + "]' value='" + status + "'>";
                t11.innerHTML = "<input id='Data_Criacao[" + li + "]' type='text' name='Data_Criacao[" + li + "]' value='" + document.getElementById("Data_Criacao1[" + li + "]").innerText + "'>";
                t12.innerHTML = "<input id='Tipo_Item[" + li + "]' type='text' name='Tipo_Item[" + li + "]' value='" + document.getElementById("Tipo_Item1[" + li + "]").innerText + "'>";
                t13.innerHTML = "<input id='Obs[" + li + "]' type='text' name='Obs[" + li + "]' value='" + document.getElementById("Obs1[" + li + "]").innerText + "'>";
                t14.innerHTML = "<input id='Data_Entrega[" + li + "]' type='text' name='Data_Entrega[" + li + "]' value='" + "<?php print_r(date('Y-m-d H:i:s',strtotime($_POST['Data_Entrega'])));  ?>" + "'>";
                t15.innerHTML = "<input id='Limite_Expedicao[" + li + "]' type='text' name='Limite_Expedicao[" + li + "]' value='" + "<?php print_r($_POST['Limite_Expedicao']);?>" + "'>";
                t16.innerHTML = "<input id='Status_Antigo[" + li + "]' type='text' name='Status_Antigo[" + li + "]' value='" + "Expedido" + "'>";
                li++;
            }
            document.forms["formtemp"].submit();
        }
        function check(){
            var dados = document.getElementById("dados");
            
            if(document.getElementById('checkbox').checked === true){
                document.getElementById('status_todos').disabled = false;
                for (var ref = 0, linha; linha = dados.rows[ref]; ref++){
                    var li = ref + 1;
                    document.getElementById("Status[" + li + "]").disabled = true;
                }
            }else{
                
                }
                document.getElementById('status_todos').disabled = true;
                for (var ref = 0, linha; linha = dados.rows[ref]; ref++){
                    var li = ref + 1;
                    document.getElementById("Status[" + li + "]").disabled = false;
            }
        }
        function datenow() {
            var data = new Date();
            document.getElementById('data_status').value = data.getFullYear() + '-' + ('0' + (data.getMonth() + 1)).slice(-2) + '-' + ('0' + data.getDate()).slice(-2) + 'T' + ('0' + data.getHours()).slice(-2) + ':' + ('0' + data.getMinutes()).slice(-2);
        }
    </script>
</body>

</html>