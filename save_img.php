<?php 
//Этот файл сохраняет фотографии пользователей
require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );
session_start();
$userId = $_SESSION['logged_user']->id;
$imgId = $_SESSION['imgId'];
$description = $_POST['description'];
$table_name = 'userimgsid'.$userId;

if ($description != "") {
	$img = R::load($table_name, $imgId + 1);
	$img->description = $description;
	$_SESSION['logged_user']->allImgs[$imgId]->description = $description;
	R::store($img);
}
header('Location: /yourPage.php')
?>