<?php 
require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

session_start();

//Узнаём существует ли страница пользователя
if(isset($_GET['id'])) {
	//находим пользователя с id
	$user = R::findOne('users', 'id = ?', array($_GET['id']));
	if (! $user) {
		header('Location: /errors/userNotInSystem.php');
	}
	if($user->id == $_SESSION['logged_user']->id&&$user->id){
		header('Location: /yourPage.php');
	}
}else{
	header('Location: /yourPage.php');
}

$userId = $user->id; //id пользователь
$table_name_for_imgs = 'userimgsid'.$userId;
$table_name_for_posts = 'user'.$userId.'posts';

if (isset($_GET['active'])) {
	$isMenuActive = $_GET['active'];
}else{
	$isMenuActive = false;
}

//id фотографии на которую кликнул пользователь
if (isset($_GET['n'])) {
	$imgId = $_GET['n'];
}else{
	$imgId = false;
}

if ($imgId and $isMenuActive) {
	$img = R::load($table_name_for_imgs, $imgId);
	$description = $img->description;
	$date = $img->date;
	R::store($img);
}
?>

<!--
######################

 Профиль пользователя

######################
-->

<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<title>Document</title>
	<link rel='stylesheet' type='text/css' href='/fonts/fonts.css?rnd=<?= time() ?>'>
	<link rel='stylesheet' type='text/css' href='/styles/profile.css?rnd=<?= time() ?>'>
	<link rel="shortcut icon" href="/imgs/icon.ico" type="image/x-icon">
	<script src="/scripts/lazy_load.js" defer></script>
</head>
<body>
	<!-- Здесь собрана основная информация об открытой фотографии -->
	<div class="photo_description">
		<div class="photo_block">
			<div class="cross">
				<div class="line"></div>
			</div>
			<div class="photo">
				<img src="" data-n="1" id="photo">
			</div>
			<div class="description">
				<div class="status">
					<div class="status_block green">
						<div class="status_text">Фотография!</div>
					</div>
				</div>
				<div class="main_description">
					<ol class="options">
						<?php
							if($description != ''){
								echo '<li class="li_change_description">';
								echo '<div class="container">';
								echo '<div class="text">';
								echo $description;
								echo '</div>';
								echo '</div>';
								echo '</li>';
							}else{
								echo '<li class="li_change_description">';
								echo '<div class="container">';
								echo '<div class="text">';
								echo 'Описания нет';
								echo '</div>';
								echo '</div>';
								echo '</li>';
							}
						?>
						<li class='date'>
							<?php 
								echo '<div class="green">Создано:</div>';
								echo '<div>'.$date.'</div>';
							?>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	
	<div class='block'>
		<div class='green name'>
			Эта страница принадлежит другому пользователю!
		</div>
		<div class='main'>
			<ol class='list_of_information'>
				<li>
					<div class='block_line'>
						<div class='nameOf green'>Логин:</div>
						<div class='information'><?php echo $user->login; ?></div>
					</div>
				</li>
				<hr>
				<li>
					<div class='block_line'>
						<div class='nameOf green'>Почта:</div>
						<div class='information'><?php echo $user->email; ?></div>
					</div>
				</li>
				<hr>
				<li>
					<div class='block_line'>
						<div class='nameOf green'>Телефон:</div>
						<?php
							if(!empty($user->phone)){
								echo '<div class=\'information\'>'.$user->phone.'</div>';
							}else{
								echo '<div class=\'information\'>Пользователь не указал телефон!</div>';
							}						
						?>
					</div>
				</li>
				<hr>
				<li>
					<div class='block_line'>
						<div class='nameOf green'>Страна:</div>
						<?php
							if(!empty($user->country)){
								echo '<div class=\'information\'>'.$user->country.'</div>';
							}else{
								echo '<div class=\'information\'>Пользователь не указал страну!</div>';
							}						
						?>
					</div>
				</li>
				<hr>
				<li>
					<div class='block_line'>
						<div class='nameOf green'>Город:</div>
						<?php
							if(!empty($user->town)){
								echo '<div class=\'information\'>'.$user->town.'</div>';
							}else{
								echo '<div class=\'information\'>Пользователь не указал город!</div>';
							}						
						?>
					</div>
				</li>
			</ol>
		</div>

		<!-- Фотографии пользователя -->
		<div class='user_imgs'>
			<div class='green name'>Фотографии</div>
			<?php
				if ($user->howManyImgsHasUser == 0) {
					echo "<div class='info'>У пользователя нет фотографий!</div>";
				}else{
					echo "<div class='all_photos'>";
					for ($i = 0; $i < $user->howManyImgsHasUser; $i++) {
						$img = R::load($table_name_for_imgs, $i + 1);
						$path = $img->path;
						$n = $i + 1;
						echo '<img class=\'user_photo\' data-n='.$n.' src="" data-src=\'/'.$path.'\'>';
						R::store($img);
					}
					echo "</div>";
				}
			?>
		</div>

		<!-- Посты пользователя -->
		<div class='user_posts'>
			<div class='green name'>Посты</div>
			<!-- Отображаем посты пользователя -->
			<?php
				if ($user->howManyPostsHasUser == 0) {
					echo "<div class='info'>У пользователя нет постов!</div>";
				}else{
					echo "<div class='all_posts'>";
					for ($i = 0; $i < $user->howManyPostsHasUser; $i++) {
						$post = R::load($table_name_for_posts, $i + 1);
						$path = $post->path;
						$name = $post->name;
						echo '
							<div class="post_view">
								<div class="post_wrapper">
									<div class="post_img">
									<img src='.$path.'main_photo.jpg>
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
												<a href="/profile.php?id='.$user->id.'">'.$user->login.'</a>
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
						R::store($post);
					}
					echo "</div>";
				}
			?>
		</div>
	</div>

	<!-- Если фотография активна, то отображаем её -->
	<script type="text/javascript">
		var imgId        = '<?php echo $imgId; ?>',
			isMenuActive = '<?php echo $isMenuActive; ?>';

		var container = document.querySelector(".photo_description"),
			photo     = document.querySelector(".photo img");

		try{
			if (imgId&&isMenuActive) {
				var target = document.querySelector(`.user_photo[data-n='${imgId}']`);

				document.querySelector('body').style.overflowY = 'hidden';
				container.classList.add('active');
				photo.src = target.getAttribute('data-src');
				photo.setAttribute('data-n', target.getAttribute('data-n'));
			}
		}catch{

		}

		var userId = '<?php echo $userId; ?>';

		window.addEventListener('keydown', e => {
			if(e.keyCode == 116){
				e.preventDefault();
				document.location.href = 'http://blog.com/profile.php?id='+userId;
			}
		})

		function clickFunc(e){
			document.location.href = 'http://blog.com/profile.php?id='+userId+'&n='+e.target.getAttribute('data-n')+'&active=true';
		}

		var imgs      = document.querySelectorAll(".user_photo"),
			container = document.querySelector(".photo_description"),
			photo     = document.querySelector(".photo img"),
			cross     = document.querySelector(".cross");


		imgs.forEach(img => {
			img.addEventListener('click', clickFunc);
		})

		function sleep(sec){
			return new Promise((resolve, reject) => {
				setInterval(() => resolve(), sec);
			});
		}

		cross.onclick = () => {
			container.classList.add('notActive');
			document.querySelector('body').style.overflowY = 'scroll';
			sleep(1000).then(result => {
				container.classList.remove('notActive');
				container.classList.remove('active');
			});
		}
	</script>
</body>
</html>