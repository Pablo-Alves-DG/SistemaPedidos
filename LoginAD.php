<?php
// Variaveis utilizadas no Connect, Bind e Search
$dntree = 'DC=xx,DC=local'; // Caminho inicial de pesquisa
$dn = 'xx'; // Domain Name
$ldaprdn  = $_POST['email']; // ldap rdn or dn
$ldappass = $_POST['senha']; // associated password
$attr = array("memberof");
$filter="(sAMAccountname=$ldaprdn)";
//--------------------------------------------------------------------

// Variaveis de Grupos
$admin = 'xx';
$pedidosMDF = 'xx';
$perifericosMDF = 'xx';
$pedidosMDF_Estoque = 'xx';
$pedidosMDF_Producao = 'xx';
$pedidosMDF_Transporte = 'xx';
$pedidosRD = 'xx';
$perifericosRD = 'xx';
$infraMDF = 'xx';
//--------------------------------------------------------------------





// Comandos LDAP
$ldapconn = ldap_connect('ldap://IP') or die("Falha na Conexão com o Servidor"); // Conexão com o AD
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3); // Versão de Protocolo mais recente
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

if ($ldapconn) {

    $ldapbind = ldap_bind($ldapconn, "$dn\\$ldaprdn", $ldappass); // Bind para verificar se o Usuário tem conta no AD (Retorno de true e false)

    if ($ldapbind) {

        $result = ldap_search($ldapconn, $dntree, $filter, $attr) or die ("Erro no Search"); // Consulta no AD para retornar os Grupos do Usuário
        $data = ldap_get_entries($ldapconn, $result); // Pegar Resultados como dados
        
        foreach($data[0]['memberof'] as $linhas) {
            if(strpos($linhas, $admin)) { $admin = 'Sim'; break; }
        }
if($admin != 'Sim'){
        foreach($data[0]['memberof'] as $linhas) {
            if(strpos($linhas, $pedidosMDF)) { $pedidosMDF = 'Sim'; }
            if(strpos($linhas, $perifericosMDF)) { $perifericosMDF = 'Sim'; }
            if(strpos($linhas, $infraMDF)) { $infraMDF = 'Sim'; }
            if(strpos($linhas, $pedidosMDF_Estoque)) {$pedidosMDF_Estoque = 'Sim';}
            if(strpos($linhas, $pedidosMDF_Producao)) {$pedidosMDF_Producao = 'Sim';}
            if(strpos($linhas, $pedidosMDF_Transporte)) {$pedidosMDF_Transporte = 'Sim';}
            if(strpos($linhas, $pedidosRD)) {$pedidosRD = 'Sim';}
            if(strpos($linhas, $perifericosRD)) {$perifericosRD = 'Sim';}
        }}

        session_start();
        $_SESSION['user'] =$ldaprdn;
        $_SESSION['admin'] =$admin;
        $_SESSION['pedidosMDF'] =$pedidosMDF;
        $_SESSION['perifericosMDF'] =$perifericosMDF;
        $_SESSION['pedidosMDF_Estoque'] =$pedidosMDF_Estoque;
        $_SESSION['pedidosMDF_Producao'] =$pedidosMDF_Producao;
        $_SESSION['pedidosMDF_Transporte'] =$pedidosMDF_Transporte;
        $_SESSION['pedidosRD'] =$pedidosRD;
        $_SESSION['perifericosRD'] =$perifericosRD;
        $_SESSION['InfraMDF'] =$infraMDF;
        
        header('Location: ../Modulo.php');
        exit();
    } else {
        header('Location: ../Pagina_login.html');
        exit();
    }

}

//-----------------------------------------------------------------------------------------------------------------------------------------------
?>