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
    <title>Modulo</title>
    <link rel="stylesheet" href="CSS/Modulos.css">
</head>

<body>
    <nav class="dp-menu">
        <ul>
        <ul>
        </ul>
        <ul>
        </ul>
        <li id="lisair"><a id="sair" href="PHP/logout.php">Sair</a></li>
        </ul>
    </nav>
    <main class="cards">
    <section onclick="redirect('periferico')" <?php if($_SESSION['admin']!='Sim' &&
            $_SESSION['perifericosMDF']!='Sim' && $_SESSION['perifericosRD']!='Sim' ){echo 'style="display: none;"' ;}?>
            class="card about">
            <div class="perifericos">
                <img src="Imagens/Perifericos.png" alt="Perifericos.">
            </div>
            <h3>Perifericos</h3>
            <span>Controle do estoque de Periféricos</span>
        </section>
<?phpprint_r($_SESSION['pedidosMDF']);?>
        <section onclick="redirect('pedidos')" <?php if($_SESSION['admin']!='Sim' && $_SESSION['pedidosMDF']!='Sim'
            && $_SESSION['pedidosRD']!='Sim' && $_SESSION['pedidosMDF_Estoque']!='Sim' &&
            $_SESSION['pedidosMDF_Producao']!='Sim' && $_SESSION['pedidosMDF_Transporte']!='Sim'
            ){echo 'style="display: none;"' ;}?> class="card about"> 
            <div class="pedidos">
                <img src="Imagens/icons8-finalizar-pedido-48.png" alt="Shop here.">
            </div>
            <h3>Pedidos</h3>
            <span>Sistema interno de Pedidos e Acompanhamento</span>
        </section>

        <section type="button" class="card about">
            <div class="powerbi">
                <img src="Imagens/PowerBi (2).png" alt="powerbi.">
            </div>
            <h3>Power Bi</h3>
            <span>Visualize e analise dados com maior velocidade e eficiência </span>
        </section>

        <section type="button" class="card about">
            <div class="rh">
                <img src="Imagens/recursos-humanos.png" alt="About us.">
            </div>
            <h3>Fale com o RH</h3>
            <span>Qualquer duvida ou sugestão segue os contatos do time de recursos humanos</span>
        </section>

        <section type="button" class="card about">
            <div class="fale">
                <img src="Imagens/contexto.png" alt="About us.">
            </div>
            <h3>Fale conosco</h3>
            <span>Qualquer duvida ou sugestão segue os contatos do time de sistemas</span>
        </section>

        <section onclick="redirect('infra')" <?php if($_SESSION['admin']!='Sim' &&
            $_SESSION['InfraMDF']!='Sim'){echo 'style="display: none;"' ;}?> class="card about">
            <div class="infra">
                <img src="Imagens/a-infraestrutura.png" alt="Perifericos.">
            </div>
            <h3>infraestrutura</h3>
            <span>Gerenciamento dos clientes</span>
        </section>

        <section onclick="redirect('cerv')" type="button" class="card about">
            <div class="plasma">
                <img src="Imagens/Plasma.png" alt="Shop here.">
            </div>
            <h3>Cervello</h3>
            <span> Acesso ao ITSM</span>

        </section>
        <section onclick="redirect('docu')" type="button" class="card about">
            <div class="docusign">
                <img src="Imagens/Docusign.png" alt="powerbi.">
            </div>
            <h3>Docusign</h3>
            <span>Controle de documentos para assinatura</span>

        </section>
        <section onclick="redirect('go')" type="button" class="card about">
            <div class="go-on">
                <img src="Imagens/go.on.png" alt="About us.">
            </div>
            <h3>Go On</h3>
            <span>Sistema de Roteirização</span>
        </section>

        <section onclick="redirect('time')" type="button" class="card about">
            <div class="relogio">
               <img src="Imagens/relogio.png" alt="About us.">
            </div>
            <h3>Timesheet</h3>
            <span>Controle de horas por implantação e suporte</span>
        </section>

        <section onclick="redirect('time')" type="button" class="card about">
            <div class="relogio">
               <img src="Imagens/relogio.png" alt="About us.">
            </div>
            <h3>Timesheet</h3>
            <span>Controle de horas por implantação e suporte</span>
        </section>

        <script>

             function redirect(ref) {
                if (ref == 'periferico') { window.location.href = "Pagina_inicial_perifericos.html"; }
                if (ref == 'pedidos') { window.location.href = "Pagina_inicial_pedidos.html"; }
                if (ref == 'infra') { window.location.href = "infra.html"; }
                if (ref == 'sair') { window.location.href = "PHP/logout.php"; }
                if (ref == 'cerv') { window.open('https://www.cervelloesm.com.br/Arklok/?page=aHR0cHM6Ly93d3cuY2VydmVsbG9lc20uY29tLmJyL0Fya2xvay9Qb3J0YWwvSG9tZQ%3D%3D').focus; }
                if (ref == 'docu') { window.open('https://account.docusign.com/oauth/auth?response_type=code&scope=all%20click.manage%20me_profile%20room_forms%20room_fields%20inproductcommunication_read%20data_explorer_signing_insights%20notary_read%20notary_write%20search_read%20search_write%20webforms_manage&client_id=2CC56DC9-4BCD-4B55-8AB0-8BA60BAE1065&redirect_uri=https%3A%2F%2Fapp.docusign.com%2Foauth%2Fcallback&state=%7B%22dscj_ft%22%3A%2212586%2Chttps%253A%252F%252Ftrial.docusign.com%252F%2C1662060353%2Chttps%253A%252F%252Fgo.docusign.com.br%252Fo%252Ftrial%252F%22%2C%22dscj_lt%22%3A%2212586%2Chttps%253A%252F%252Ftrial.docusign.com%252F%2C1662060353%2Chttps%253A%252F%252Fgo.docusign.com.br%252Fo%252Ftrial%252F%22%2C%22dscj_m%22%3A%22elqCampaignId%2CreferringUrl%2Cts%2Ccu%22%2C%22_ga%22%3A%222.62658412.1131286537.1662060356-1168290358.1662060356%22%2C%22_gl%22%3A%221*1gd6358*_ga*MTE2ODI5MDM1OC4xNjYyMDYwMzU2*_ga_1TZ7S9D6BQ*MTY2MjA2MDM1NS4xLjAuMTY2MjA2MDM1NS42MC4wLjA.%22%2C%22authTxnId%22%3A%22ac2c5dac-b20e-4222-8c60-f69c81268d72%22%7D').focus; }
                if (ref == 'go') { window.open('https://app.goon.mobi/login').focus; }
                if (ref == 'time') { window.open('https://timesheet.arklok.com.br/login').focus; }
            }
        </script>

</body>
</html>