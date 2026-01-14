<?php
// actions/logout_admin.php
session_start();
unset($_SESSION['admin']);
header("Location: index.php?page=admin_login");
exit;
?>
