<?php 
	//Этот файл сохраняет данные пользователя, но не его самого
	require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
	R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );
	session_start();

	$id = $_SESSION['logged_user']->id;
	$user = R::load('users', $id);
	if (!empty($_POST['phone'])) {
		$user->phone = $_POST['phone'];
		$_SESSION['logged_user']->phone = $_POST['phone'];
	}

	if (!empty($_POST['town'])) {
		$user->town = $_POST['town'];
		$_SESSION['logged_user']->town = $_POST['town'];
	}

	if (!empty($_POST['town'])) {
		$user->country = $_POST['country'];
		$_SESSION['logged_user']->country = $_POST['country'];
	}

	//Сохраняем фотографии пользователя
	if($_FILES['file']['error'] == 0){
		$path = 'users/user_id'.$_SESSION['logged_user']->id.'/id'.$_SESSION['logged_user']->id.'_photo'.$_SESSION['logged_user']->howManyImgsHasUser.'.jpg';

		$_SESSION['logged_user']->howManyImgsHasUser += 1;
		$user->howManyImgsHasUser += 1;

		$table_name = 'userimgsid'.$id;
		$user_imgs = R::dispense($table_name);
		$user_imgs->path = $path;
		$user_imgs->isDelited = false;
		$user_imgs->description = '';
		$user_imgs->date = date("Y.n.d в H:i:s");
		R::store($user_imgs);

		$_SESSION['logged_user']->allImgs[] = $user_imgs;
		move_uploaded_file($_FILES['file']['tmp_name'], $path);
	}
	R::store($user);
	header('Location: /yourPage.php')
?>