<?php
session_start();
session_unset();
unset($_SESSION['access_token']);
session_destroy();
header("Location: index.php");
?>