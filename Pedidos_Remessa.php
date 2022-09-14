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
    <title>Pedidos_Remessa</title>
    <link rel="stylesheet" href="CSS/Pedidos_Remessa.css">
</head>

<body>
<script src="JS/Menu.js"></script>
    <fieldset>
        <legend></legend>
        <table cellspacing="10">
            <tr>
                <td>
                    <label for="chamado_comercial">Chamado comercial: </label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="chamado_comercial" type="text" name="chamado" size="80">
                </td>

            <tr>
                <td>
                    <label>Cliente: </label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="cliente" type="text" name="cliente" size="80">

                </td>
            </tr>
            <tr>
                <td>
                    <label for="cliente_dn4">Cliente DN4: </label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="cliente_dn4" type="text" name="cliente_dn4" size="80">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Pedido:</label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="pedido" type="text" name="pedido" size="80">
                </td>
            </tr>
        </table>
    </fieldset>

    <br />
    <fieldset>
        <legend></legend>
        <table cellspacing="10">

            <tr>
                <td>
                    <label for="termo">Termo:</label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="termo" type="text" name="termo" size="85">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="Tipo do pedido">Tipo do pedido: </label>
                </td>
                <td align="left">
                    <select onchange="errorem(this)" id="tipo_pedido" name="Tipo do pedido">
                        <option value="venda">Venda</option>
                        <option value="projeto">Projeto</option>
                        <option selected value="locacao">Locação</option>
                        <option value="doação">Doação</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="endereço">Endereço:</label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="endereco" type="text" name="endereço" size="85">

                </td>
            </tr>
            <tr>
                <td>
                    <label for="cidade">CNPJ:</label>
                </td>
                <td align="left">
                    <input onchange="correcnpj(this)" onchange="errorem(this)" id="cnpj" type="text" name="cidade" size="85">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="estrategia">Estrategia: </label>
                </td>
                <td align="left">
                    <select onchange="errorem(this)" id="estrategia" name="estrategia">
                        <option value="longo prazo">Longo prazo</option>
                        <option value="curto prazo">Curto prazo</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="criação">Criação: </label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="data_criacao" type="datetime-local" name="data_criacao">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="obs">Observação: </label>
                </td>
                <td align="left">
                    <textarea name="observação" id="obs" cols="84" rows="5"></textarea>
                </td>
            </tr>
        </table>
    </fieldset>
    <br />


    <fieldset>
        <legend></legend>
        <table cellspacing="10">

            <tr style="display: table;">
                <td>
                    <label for="tipo do item">Tipo do item:</label>
                </td>
                <td>
                    <select  onchange="tinovo(this)" id="tipo_item" name="tipo do item">
                        <option value="Novo">Novo</option>
                        <?php
                        include('PHP/conexao.php');
                        $sql = "Select Tipo_Item from Tab_Pedidos";

                        $cursor = "static";
                        $params = array();
                        $options = array("Scrollable"=>$cursor);
                        $stmt = sqlsrv_query($conexao, $sql, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        echo "<option value='" . $row['Tipo_Item'] . "'>" . $row['Tipo_Item'] . "</option>";
                        }
                        ?>
                        <input style="margin-left: 20px;" onchange="tinovo(document.getElementById('tipo_item'))" id="tipo_item_novo" type="text" name="item_novo">
                </td>
            </tr>
            <tr style="display: table;">
                <td>
                    <label for="item">Item: </label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="item" type="text" name="item" size="89">
                </td>
            </tr>
            <tr style="display: inline;">
                <td>
                    <label for="quantidade">Quantidade: </label>
                </td>
                <td align="left">
                    <input onchange="errorem(this)" id="quantidade" type="number" name="quantidade">
                </td>
                <td>
                    <label for="Valor_Unitario">Valor Unitário: </label>
                </td>
                <td>
                    <label for="Valor_Unitario" id="iconmoney">R$</label>
                    <input step="0.01" type="number" name="Valor_Unitario" id="Valor_Unitario">
                </td>
            </tr>

        </table>
    </fieldset>
    <br />
    <button id="adicionar" onclick="add()">adicionar</button>
    <button id="limpar" onclick="limpar()">Limpar</button>
    </form>
    <button id="enviar" onclick="validar()">Enviar</button>
    <form id="formtemp" action="PHP/novo_cadastro_remessa.php" method="post">
        <table id="dados">
            <thead>
                <th>C. Comercial</th>
                <th>Cli</th>
                <th>Cli. DN4</th>
                <th>Ped</th>
                <th>Ter</th>
                <th>Tipo</th>
                <th>End</th>
                <th>CNPJ</th>
                <th>Esta</th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Item</th>
                <th>Qtd</th>
                <th>Obs</th>
                <th>Val</th>
            </thead>
            <tbody>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tbody>
        </table>
    </form>

    <script type="text/javascript">

        function limpar() {
            document.getElementById("chamado_comercial").value = "";
            document.getElementById("cliente").value = "";
            document.getElementById("cliente_dn4").value = "";
            document.getElementById("pedido").value = "";
            document.getElementById("termo").value = "";
            document.getElementById("tipo_pedido").value = "";
            document.getElementById("endereco").value = "";
            document.getElementById("cnpj").value = "";
            document.getElementById("estrategia").value = "";
            document.getElementById("data_criacao").value = "";
            document.getElementById("tipo_item").value = "Novo";
            document.getElementById("item").value = "";
            document.getElementById("quantidade").value = "";
            document.getElementById("obs").value = "";
        }
        function validar() {
            table = document.getElementById("formtemp");
            document.forms["formtemp"].submit();
        }

        function add() {
            if(document.getElementById("tipo_item").value == "Novo"){var titem = document.getElementById("tipo_item_novo").value}else{var titem = document.getElementById("tipo_item").value}
            if (
                document.getElementById("chamado_comercial").value != "" &&
                document.getElementById("cliente").value != "" &&
                document.getElementById("cliente_dn4").value != "" &&
                document.getElementById("pedido").value != "" &&
                document.getElementById("termo").value != "" &&
                document.getElementById("tipo_pedido").value != "" &&
                document.getElementById("endereco").value != "" &&
                document.getElementById("cnpj").value != "" &&
                document.getElementById("estrategia").value != "" &&
                document.getElementById("data_criacao").value != "" &&
                document.getElementById("tipo_item").value != "" &&
                document.getElementById("item").value != "" &&
                document.getElementById("quantidade").value != ""
            ) {
                var table = document.getElementById("dados");
                var linha = table.insertRow(2);
                var li = table.tBodies[0].rows.length - 1;
                var t1 = linha.insertCell(0);
                var t2 = linha.insertCell(1);
                var t3 = linha.insertCell(2);
                var t4 = linha.insertCell(3);
                var t5 = linha.insertCell(4);
                var t6 = linha.insertCell(5);
                var t7 = linha.insertCell(6);
                var t8 = linha.insertCell(7);
                var t9 = linha.insertCell(8);
                var t10 = linha.insertCell(9);
                var t11 = linha.insertCell(10);
                var t12 = linha.insertCell(11);
                var t13 = linha.insertCell(12);
                var t14 = linha.insertCell(13);
                var t15 = linha.insertCell(14);
                t1.innerHTML = "<input id='chamado_comercial[" + li + "]' type='text' name='chamado_comercial[" + li + "]' value='".concat(document.getElementById("chamado_comercial").value, "'>");
                t2.innerHTML = "<input id='cliente[" + li + "]' type='text' name='cliente[" + li + "]' value='".concat(document.getElementById("cliente").value, "'>");
                t3.innerHTML = "<input id='cliente_dn4[" + li + "]' type='text' name='cliente_dn4[" + li + "]' value='".concat(document.getElementById("cliente_dn4").value, "'>");
                t4.innerHTML = "<input id='pedido[" + li + "]' type='text' name='pedido[" + li + "]' value='".concat(document.getElementById("pedido").value, "'>");
                t5.innerHTML = "<input id='termo[" + li + "]' type='text' name='termo[" + li + "]' value='".concat(document.getElementById("termo").value, "'>");
                t6.innerHTML = "<input id='tipo_pedido[" + li + "]' type='text' name='tipo_pedido[" + li + "]' value='".concat(document.getElementById("tipo_pedido").value, "'>");
                t7.innerHTML = "<input id='endereco[" + li + "]' type='text' name='endereco[" + li + "]' value='".concat(document.getElementById("endereco").value, "'>");
                t8.innerHTML = "<input id='cnpj[" + li + "]' type='text' name='cnpj[" + li + "]' value='".concat(document.getElementById("cnpj").value, "'>");
                t9.innerHTML = "<input id='estrategia[" + li + "]' type='text' name='estrategia[" + li + "]' value='".concat(document.getElementById("estrategia").value, "'>");
                t10.innerHTML = "<input id='data_criacao[" + li + "]' type='datetime-local' name='data_criacao[" + li + "]' value='".concat(document.getElementById("data_criacao").value, "'>");
                t11.innerHTML = "<input id='obs[" + li + "]' type='text' name='obs[" + li + "]' value='".concat(document.getElementById("obs").value, "'>");
                t12.innerHTML = "<input id='tipo_item[" + li + "]' type='text' name='tipo_item[" + li + "]' value='".concat(titem, "'>");
                t13.innerHTML = "<input id='item[" + li + "]' type='text' name='item[" + li + "]' value='".concat(document.getElementById("item").value, "'>");
                t14.innerHTML = "<input id='quantidade[" + li + "]' type='number' name='quantidade[" + li + "]' value='".concat(document.getElementById("quantidade").value, "'>");
                t15.innerHTML = "<input id='valor[" + li + "]' type='number' name='valor[" + li + "]' value='".concat(document.getElementById("Valor_Unitario").value, "'>");
                depadd();
            } else {
                alert("Um dos Campos não está preenchido, verifique todos antes de adicionar a tabela abaixo");
                erroalert();
            }
        }

        function depadd(){
            document.getElementById("tipo_item").value = "Novo";
            document.getElementById("item").value = "";
            document.getElementById("quantidade").value = "";
            document.getElementById("Valor_Unitario").value = "";
        }

        function erroalert(){
            if(document.getElementById("chamado_comercial").value == "") {document.getElementById("chamado_comercial").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("cliente").value == "") {document.getElementById("cliente").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("cliente_dn4").value == "") {document.getElementById("cliente_dn4").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("pedido").value == "") {document.getElementById("pedido").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("termo").value == "") {document.getElementById("termo").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("tipo_pedido").value == "") {document.getElementById("tipo_pedido").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("endereco").value == "") {document.getElementById("endereco").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("cnpj").value == "") {document.getElementById("cnpj").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("estrategia").value == "") {document.getElementById("estrategia").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("data_criacao").value == "") {document.getElementById("data_criacao").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("tipo_item").value == "Novo") {
                if(document.getElementById("tipo_item_novo").value == ""){document.getElementById("tipo_item_novo").setAttribute("style","margin-left: 20px;border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}}
            else{if(document.getElementById("tipo_item").value == ""){document.getElementById("tipo_item").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}}
            
            
            if(document.getElementById("item").value == "") {document.getElementById("item").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
            if(document.getElementById("quantidade").value == "") {document.getElementById("quantidade").setAttribute("style","border-radius: 1px;border-color: rgba(223, 49, 26, 0.644);")}
        }

        function tinovo(rf){
            if(rf.value == "Novo"){document.getElementById("tipo_item_novo").setAttribute("style","margin-left: 20px")}
            if(rf.value != "Novo"){document.getElementById("tipo_item_novo").setAttribute("style","display: none;")}
            if(rf.value != ""){rf.setAttribute("style","border-radius: none;")}
            if(rf.value == "Novo" && document.getElementById("tipo_item_novo").value != ""){document.getElementById("tipo_item_novo").setAttribute("style","border-radius: none;margin-left: 20px")}
        }

        function errorem(rf){
            if(rf.value != ""){rf.setAttribute("style","border-radius: none;")}
        }

        function correcnpj(rf){
            var CNPJOrig = String(rf.value);
            while(CNPJOrig.search(/[ ]/g) != -1) {CNPJOrig = CNPJOrig.replace(' ','');}
            while(CNPJOrig.search(/[.]/g) != -1) {CNPJOrig = CNPJOrig.replace('.','');}
            while(CNPJOrig.search(/[/]/g) != -1) {CNPJOrig = CNPJOrig.replace('/','');}
            while(CNPJOrig.search(/[-]/g) != -1) {CNPJOrig = CNPJOrig.replace('-','');}
            if(CNPJOrig.length != 14){alert("CNPJ Inválido");return;}
            var CNPJCorre = CNPJOrig.substring(0,2) + ".";
            CNPJCorre += CNPJOrig.substring(2,5) + ".";
            CNPJCorre += CNPJOrig.substring(5,8) + "/";
            CNPJCorre += CNPJOrig.substring(8,12) + "-";
            CNPJCorre += CNPJOrig.substring(12,14);
            rf.value = CNPJCorre;
        }
    </script>
</body>

</html>