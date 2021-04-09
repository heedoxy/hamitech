<?
// delete all session
session_start();
session_destroy();

// bye bye :)
header('location:index.php');
?>