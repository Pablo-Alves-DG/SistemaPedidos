<?php
$IP = "xxx";
$login = "xx";
$senha = "xxxxx";
$banco ="xxxxxxx";

$conexaoinfo = array("Database"=>$banco, "UID"=>$login, "PWD"=>$senha);

$conexao = sqlsrv_connect($IP, $conexaoinfo);

?>