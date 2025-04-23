<?php
session_start();
unset($_SESSION['cart']);
unset($_SESSION['cartCount']);
echo json_encode(["status" => "ok"]);
?>
