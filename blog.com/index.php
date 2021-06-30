<?php
//Соединяемся с базой данных phpMyAdmin
require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

session_start();
?>

<!--
По всем вопросам обращайтесь по почте gena.06.08@yandex.ru

Это главная страница
Сюда попадает пользователь в первый раз

HTTP - Apache 2.4 PHP 7.2
Версия PHP - 7.4
Версия MySQL - 5.1
Версия phpMyAdmin - 4.0.10
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<title>Document</title>
	<link href="fonts/fonts.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles/main.css?rnd=<?= time() ?>">
	<link rel="shortcut icon" href="imgs/icon.ico" type="image/x-icon">
	<script src="/scripts/scriptForMenu.js" defer></script>
</head>
<body>
	<header>
		<div class="menu">
			<nav class="menu__nav">
				<ol>
	 				<?php if(isset($_SESSION['logged_user'])){
	 					echo '<li><a href="profile.php?id='.$_SESSION['logged_user']->id.'">Профиль</a></li>';

	 					echo '<li><a href="#">Создать пост</a></li>';
	 				}
	 				?>
	 				<li><a href="#">Главная</a></li>
	 				<?php if(isset($_SESSION['logged_user'])){
	 					echo "<a href='logout/logout.php' class='authorize'>";
	 					echo "Выйти";
	 					echo "</a>";
	 				} else {
	 					echo "<a href='signup/form.php' class='authorize'>";
	 					echo "Войти";
	 					echo "</a>";
	 				}?></li></a>
				</ol>
			</nav>
		</div>
		<div class="adaptive__menu">
			<div class="button">
				<div class="line"></div>
			</div>
			<div class="adaptive__container">
				<nav class="adaptive__menu__nav">
					<ol>
		 				<?php if(isset($_SESSION['logged_user'])){
	 						echo '<li><a href="profile.php?id='.$_SESSION['logged_user']->id.'">Профиль</a></li>';

		 					echo '<li><a href="#">Создать пост</a></li>';
		 				}
		 				?>
		 				<li><a href="#">Главная</a></li>
		 				<?php if(isset($_SESSION['logged_user'])){
		 					echo "<a href='logout/logout.php' class='authorize'>";
		 					echo "Выйти";
		 					echo "</a>";
		 				} else {
		 					echo "<a href='signup/form.php' class='authorize'>";
		 					echo "Войти";
		 					echo "</a>";
		 				}?></li></a>
					</ol>
				</nav>
			</div>
		</div>
	</header>

	<div class="container">
		<div class="block"></div><!-- Это будушие посты -->
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
		<div class="block"></div>
	</div>
</body>
</html>
