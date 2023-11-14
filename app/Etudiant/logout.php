<?php
session_start();
unset($_SESSION["id_etud"]);
unset($_SESSION["email"]);
header("Location: login.php");
?>