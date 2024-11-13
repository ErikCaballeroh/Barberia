<?php
session_start();
session_unset();
session_destroy();

header( 'Location:/barberia/index.php');
exit;
?>