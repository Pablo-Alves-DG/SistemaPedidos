///////////////////////////Estrutura do Menu Principal Superior////////////////////////////////////
mn = "<section>";
mn += "<nav>";
mn += "    <ul>";
mn += "        <li><a href='Modulo.php'>Módulos</a></li>";
mn += "        <li style='user-select: none;'><a>Pedidos</a>    ";
mn += "            <ul>";
mn += "                <li><a href='Pedidos_Remessa.php'>Adicionar Pedido</a></li>";
mn += "                <li><a href='Pedidos_Producao.php'>Enviar para o Estoque</a></li>";
mn += "            </ul>";
mn += "        <li><a href='user-select: none;'>Estoque</a>";
mn += "            <ul>";
mn += "                <li><a href='Estoque.php'>Pedidos</a></li>";
mn += "                <li><a href='separacao.php'>Separação</a></li>";
mn += "            </ul>";
mn += "        <li><a href='Producao.php'>Produção</a></li>";
mn += "        <li style='user-select: none;'><a>Transporte</a>";
mn += "            <ul>";
mn += "                <li><a href='Emissao_NF.php'>Emissão de NF</a></li>";
mn += "                <li><a href='Expedicao.php'>Expedição</a></li>";
mn += "                <li><a href='Entrega_Expedido.php'>Entrega</a>";
mn += "               ";
mn += "            <ul>";
mn += "                <li><a href='Entrega_Expedido.php'>Expedido</a></li>";
mn += "                <li><a href='Entrega_Em_transito.php'>Em Trânsito</a></li>";
mn += "                <li><a href='Entrega_Entregue.php'>Entregue</a></li>";
mn += "                <li><a href='Entrega_Rollout.php'>Rollout</a></li>";
mn += "                <li><a href='Entrega_Devolucao.php'>Devolução</a></li>";
mn += "                <li><a href='Entrega_Barrado.php'>Barrado</a></li>";
mn += "          </ul>";
mn += "           </li>";
mn += "       </li>";
mn += "   </ul>";
mn += "   </li>";
mn += "    <li><a href='#'>Ativação</a></li>";
mn += "   <li><a href='#'>Relatórios</a></li>";
mn += "   <li><a href='#'>Acompanhamento</a></li>";
mn += "    <li id='lisair'><a id='sair' href='PHP/logout.php'>Sair</a></li>";
mn += "    </ul>";
mn += "</nav>";
mn += "</section>";
///////////////////////////Estrutura do Menu Principal Superior////////////////////////////////////
document.write(mn);