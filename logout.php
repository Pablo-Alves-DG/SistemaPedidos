<?php
session_start();
session_destroy();
header('Location: ../Pagina_login.html');
exit();
?>