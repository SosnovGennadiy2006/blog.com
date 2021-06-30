<?php 
require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

session_start();
unset($_SESSION['logged_user']);
header('Location: /');
?>