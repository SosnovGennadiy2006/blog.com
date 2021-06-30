<?php
//Соединяемся с базой данных phpMyAdmin
require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

$posts = R::getAll('SELECT * FROM allposts');
$number_of_posts = count($posts);

session_start();

//Количество постов, которые сможет увидеть пользователь на странице
if (isset($_GET['n'])) {
	$posts_which_you_can_see = $_GET['n'];
}else{
	$posts_which_you_can_see = 1;
}

if (isset($_GET['pageY'])) {
	$page_pos_y = $_GET['pageY'];
}else{
	$page_pos_y = NULL;
}
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

<!--
##################

 Главная страница

##################
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
	<link href="/styles/base_styles.css" rel="stylesheet">
	<link href="fonts/fonts.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/styles/main.css?rnd=<?= time() ?>">
	<link rel="shortcut icon" href="/imgs/icon.ico" type="image/x-icon">
	<script src="/scripts/scriptForMenu.js" defer></script>
	<script src="/scripts/main.js" defer></script>
</head>
<body>
	<script>
		//Читаем значения переменных php, чтобы потом использовать их в JavaScript
		var n = '<?php echo $posts_which_you_can_see; ?>';
		var page_y = '<?php echo $page_pos_y; ?>';
	</script>

	<!-- Здесь и далее в тэге header будет меню -->
	<header>
		<div class="menu">
			<nav class="menu__nav">
				<ol>
	 				<?php if(isset($_SESSION['logged_user'])){
	 					echo '<li><a href="/profile.php?id='.$_SESSION['logged_user']->id.'">Профиль</a></li>';

	 					echo '<li><a href="/constructor/constructor.php">Создать пост</a></li>';
	 				}
	 				?>
	 				<li><a href="/">Главная</a></li>
	 				<?php if(isset($_SESSION['logged_user'])){
	 					echo "<a href='/logout/logout.php' class='authorize'>";
	 					echo "Выйти";
	 					echo "</a>";
	 				} else {
	 					echo "<a href='/signup/form.php' class='authorize'>";
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

		 					echo '<li><a href="/constructor/constructor.php">Создать пост</a></li>';
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

		<!-- Далее отображаем посты -->
		<?php

		if ($number_of_posts != 0) {
			echo "<div class='all_posts'>";
			$count = 0;
			for ($i = 0; $i < $number_of_posts&&$i < $posts_which_you_can_see*10; $i++) {
				$post = $posts[$i];
				$path = $post['path'];
				$name = $post['name'];
				$post_author = R::load('users', $post['author_id']);
				echo '
					<div class="post_view">
						<div class="post_wrapper">
							<div class="post_img">
								<img data-src="'.$path.'main_photo.jpg" class="lazy_load_img" src="">
							</div>
							<hr class=\'vertical\'>
							<div class="post_info">
								<div class="post_name">
									'.$name.'
								</div>
								<hr class=\'gorizontal\'>
								<div class="else_info">
									<div class="post_description">
										'.$description.'
									</div>
									<div class="author">
										Автор: 
										<a href="/profile.php?id='.$post_author->id.'">'.$post_author->login.'</a>
									</div>
									<div class="flex_line">
										<a href="'.$path.'main.php">
											<div class="button_view">Подробнее</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>';
				R::store($post_author);
				$count += 1;
			}
			echo "</div>";

			if ($count != $number_of_posts) {
				echo '
				<div class="flexContainer">
					<div class="show_more">Показать ещё</div>
				</div>
				';
			}
		}else {
			if (!empty($_SESSION['logged_user']))
			{
				echo '
				<div class="container">
					<div class="message">
						На данный момент не было создано никаких постов, но вы можете изменить это:
					</div>
					<a href="/constructor/constructor.php">
						<div class="to_constructor">
							Создать пост
						</div>
					</a>
				</div>
				';
			}else {
				echo '
				<div class="container">
					<div class="message">
						На данный момент не было создано никаких постов, но вы можете изменить это зарегистрировавшись!
					</div>
				</div>
				';
			}
		}
		?>
</body>
</html>