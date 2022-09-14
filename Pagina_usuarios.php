<?php session_start();
if ($_SESSION['admin'] == null){
   header('Location: Pagina_login.html');   
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina_Usuarios</title>
    <link rel="stylesheet" href="CSS/pagina_usuarios.css">
    
</head>

<body>
<script src="JS/Menu.js"></script>
</body>

<body>
    <a id="table" href="#"></a></li>
    <h1>Usuários</h1>
    <table>
        <thead>
            <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Nome</th>
                <th>Setor</th>
                <th>Acesso Admin</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('PHP/conexao.php');
            $sql = "Select * from Tab_Cadastro_Usuarios";
            
            $cursor = "static";
            $params = array();
            $options = array("Scrollable"=>$cursor);
            $stmt = sqlsrv_query($conexao, $sql, $params, $options);
            while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo "<tr>
                    <td>" . $row['Login'] . "</td>
                    <td>" . $row['Email'] . "</td>
                    <td>" . $row['Nome'] . "</td>
                    <td>" . $row['Setor'] . "</td>
                    <td>" . $row['Admin'] . "</td>
                </tr>";
            }
            ?>
        </tbody>
        </nav>


    </table>






</body>

</html>