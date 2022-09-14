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
    <title>Pedidos_Produção2</title>
    <link rel="stylesheet" href="CSS/Pedidos_producao.css">
   
</head>

<body>
<script src="JS/Menu.js"></script>
    <div id="tabela" class="box">
        <table id="dados" class="tabela">
            <thead>
                <tr>
                    <th>Descrição do item </th>
                    <th>Saldo<br> pendente</th>
                    <th>Quantidade para<br> produção</th>
                </tr>
            </thead>
            </tbody>
            <?php
            include('PHP/conexao.php');
            $sql = "Select Observacao, Data_Criacao, Tipo_Item, Item, Quantidade_Pendente from Tab_Pedidos where Cliente = '" . $_POST['Cliente'] . "' and Cliente_DN4 = '" . $_POST['Cliente_DN4'] . "' and Pedido = '" . $_POST['Pedido'] . "' and Termo = '" . $_POST['Termo'] . "' and Chamado_Comercial = '" . $_POST['Chamado_Comercial'] . "' order by Item";
            
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
                foreach(range(0, $row['Quantidade_Pendente']) as $rg){
                    if($rg == $row['Quantidade_Pendente']){
                        $list .= "<option selected value=" . $rg . ">" . $rg . "</option>
                        ";
                    }
                    else{
                        $list .= "<option value=" . $rg . ">" . $rg . "</option>
                        ";}
                    }
                echo "<tr>
                    <td id='item1[" . $li . "]'>" . $row['Item'] . "</td>
                    <td>" . $row['Quantidade_Pendente'] . "</td>
                    <td style='display: none;' id='Data_Criacao1[" . $li . "]' >" . date_format($row['Data_Criacao'], 'Y-m-d H:i:s') . "</td>
                    <td style='display: none;' id='Obs1[" . $li . "]' >" . $row['Observacao'] . "</td>
                    <td style='display: none;' id='Tipo_Item1[" . $li . "]' >" . $row['Tipo_Item'] . "</td>

                    <td>
                        <select id='qtd1[" . $li . "]'>" . $list . 
                        "</select>
                    </td>
                </tr>";
                $li = $li +1;
            }
            ?>
            </tbody>
        </table>
    </div>

    <div>
        <table class="tabela2">
            <tbody>
                <tr>
                    <th>Data Nula: <input onchange="nula()" id="data_nula" type="checkbox" name="item" size="25"></th>
                </tr>
                <tr>
                    <th>Data da Expedição: <input id="data_entrega1" type="date" name="item" size="25"></th>
                </tr>
                <tr>
                    <th>Limite da Expedição: <input id="limite_expedicao1" type="time" name="item" size="25"></th>
                </tr>
                <tr>
                    <th>Número de Autorização <br> da Remessa:</th>
                <tr>
                    <th><input id="remessa1" type="text"></th>
                </tr>
                <tr>
                    <th><button id="enviar" onclick="enviar()">Enviar</button></th>

                </tr>
            </tbody>
        </table>
    </div>
    

    <form style="display: none;" id="formtemp" action="PHP/enviar_p_estoque.php" method="post">
        <table id="tabtemp">
            <tbody>
                <tr></tr>
            </tbody>
        </table>
    </form>

    <script>
        function enviar() {
            if(document.getElementById('data_nula').checked !== true && (document.getElementById('data_entrega1').value == "" || document.getElementById('limite_expedicao1').value == "" || document.getElementById('remessa1').value == "")){alert("Algum dos Campos Não Está Preenchido, Verifique Novamente Antes de Enviar");return;}
            if(document.getElementById('data_nula').checked === true && document.getElementById('remessa1').value == ""){alert("Algum dos Campos Não Está Preenchido, Verifique Novamente Antes de Enviar");return;}
            var dados = document.getElementById("dados");
            var temp = document.getElementById("tabtemp");
            var li = 1;
            for (var ref = 0, linha; linha = dados.rows[ref]; ref++) {
                if (dados.rows.length == temp.rows.length) { break; }
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


                t1.innerHTML = "<input id='Item[" + li + "]' type='text' name='Item[" + li + "]' value='" + document.getElementById("item1[" + li + "]").innerText + "'>";
                t2.innerHTML = "<input id='Qtd[" + li + "]' type='text' name='Qtd[" + li + "]' value='" + document.getElementById("qtd1[" + li + "]").value + "'>";
                t3.innerHTML = "<input id='Data_Entrega[" + li + "]' type='text' name='Data_Entrega[" + li + "]' value='" + document.getElementById("data_entrega1").value + "'>";
                t4.innerHTML = "<input id='Chamado_Comercial[" + li + "]' type='text' name='Chamado_Comercial[" + li + "]' value='" + "<?php print_r($_POST['Chamado_Comercial']); ?>" + "'>";
                t5.innerHTML = "<input id='Cliente[" + li + "]' type='text' name='Cliente[" + li + "]' value='" + "<?php print_r($_POST['Cliente']); ?>" + "'>";
                t6.innerHTML = "<input id='Cliente_DN4[" + li + "]' type='text' name='Cliente_DN4[" + li + "]' value='" + "<?php print_r($_POST['Cliente_DN4']); ?>" + "'>";
                t7.innerHTML = "<input id='Pedido[" + li + "]' type='text' name='Pedido[" + li + "]' value='" + "<?php print_r($_POST['Pedido']); ?>" + "'>";
                t8.innerHTML = "<input id='Termo[" + li + "]' type='text' name='Termo[" + li + "]' value='" + "<?php print_r($_POST['Termo']); ?>" + "'>";
                t9.innerHTML = "<input id='Limite_Expedicao[" + li + "]' type='text' name='Limite_Expedicao[" + li + "]' value='" + document.getElementById("limite_expedicao1").value + "'>";
                t10.innerHTML = "<input id='Data_Criacao[" + li + "]' type='text' name='Data_Criacao[" + li + "]' value='" + document.getElementById("Data_Criacao1[" + li + "]").innerText + "'>";
                t11.innerHTML = "<input id='Obs[" + li + "]' type='text' name='Obs[" + li + "]' value='" + document.getElementById("Obs1[" + li + "]").innerText + "'>";
                t12.innerHTML = "<input id='Tipo_Item[" + li + "]' type='text' name='Tipo_Item[" + li + "]' value='" + document.getElementById("Tipo_Item1[" + li + "]").innerText + "'>";
                t13.innerHTML = "<input id='Num_Auto_Remessa[" + li + "]' type='text' name='Num_Auto_Remessa[" + li + "]' value='" + document.getElementById("remessa1").value + "'>";
                li++;
            }
            document.forms["formtemp"].submit();
        }

        function nula() {
            if (document.getElementById("data_nula").checked == false) {

                document.getElementById("data_entrega1").disabled = false;
                document.getElementById("limite_expedicao1").disabled = false;
            } else {
                document.getElementById("data_entrega1").value = "";
                document.getElementById("data_entrega1").disabled = true;
                document.getElementById("limite_expedicao1").value = "";
                document.getElementById("limite_expedicao1").disabled = true;
            }
        }
    </script>
</body>

</html>