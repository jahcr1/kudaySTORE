<?php
session_start();
unset($_SESSION['productos']);
header("Location: ../panel.php#listar-productos");
exit();
