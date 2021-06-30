<?php 
//Это ваша страница
require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

session_start();
if (!$_SESSION['logged_user']) {
	header("Location: /errors/youNotInAccount.php");
}

if (isset($_GET['active'])) {
	$isMenuActive = $_GET['active'];
}else{
	$isMenuActive = false;
}

if (isset($_GET['id'])) {
	$imgId = $_GET['id'];
}else{
	$imgId = false;
}

$_SESSION['imgId'] = $imgId;
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<title>Document</title>
	<link rel='stylesheet' type='text/css' href='fonts/fonts.css?rnd=<?= time() ?>'>
	<link rel='stylesheet' type='text/css' href='styles/profile.css?rnd=<?= time() ?>'>
	<link rel="shortcut icon" href="imgs/icon.ico" type="image/x-icon">
	<script src="/scripts/lazy_load.js" defer></script>
	<script src="/scripts/yourPage_script.js" defer></script>
</head>
<body>
	<div class='block'>
		<div class='green name'>
			<?php
				echo 'Это ваша страница!';				
			?>
		</div>
		<div class="photo_description">
			<div class="alert">
				<div class="alert_problem">Сохраните изменения!</div>
				<div class="alert_text">Внимание, если вы закроете это окно введённая информация исчезнет!</div>
				<div class="alert_ask">
					Вы действительно этого хотите?
					<br>
					<span class="no green">нет</span>/<span class="yes">да</span>
				</div>
			</div>
			<form action="/save_img.php" method="POST">
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
								<div class="status_text">Это ваша фотография!</div>
							</div>
						</div>
						<div class="main_description">
							<ol class="options">
									<?php
									if($_SESSION['logged_user']->allImgs[$imgId]->description != ''){
										echo '<li class="li_change_description">';
										echo '<div class="container">';
										echo '<div class="text">';
										echo $_SESSION['logged_user']->allImgs[$imgId]->description;
										echo '</div>';
										echo '<div class="change" id="change_description"><span>Изменить</span></div>';
										echo '</div>';
										echo '<textarea name="description" class="description_textarea" maxlength="120" placeholder="Введите описание"></textarea>';
										echo '</li>';
									}else{
										echo '<li class="li_description">';
										echo '<div class="write_description"><span>Редактировать описание</span></div>';
										echo '<textarea name="description" class="description_textarea" maxlength="120" placeholder="Введите описание"></textarea>';
										echo '</li>';
									}
								?>
								<li class='date'>
									<?php 
									echo '<div class="green">Создано:</div>';
									echo '<div>'.$_SESSION['logged_user']->allImgs[$imgId]->date.'</div>';
									?>
								</li>
							</ol>
							<button class="save_img" type="submit">Сохранить</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<form action='/save_user.php' method='POST' enctype='multipart/form-data'>
			<div class='main'>
				<ol class='list_of_information'>
					<li>
						<div class="block_line">
							<div class='nameOf green'>Логин:</div>
							<div class='information'><?php echo $_SESSION['logged_user']->login; ?></div>
						</div>
					</li>
					<hr>
					<li>
						<div class="block_line">
							<div class='nameOf green'>Почта:</div>
							<div class='information'><?php echo $_SESSION['logged_user']->email; ?></div>
						</div>
					</li>
					<hr>
					<li class="phone">
						<div class="block_line">
							<div class='nameOf green'>Телефон:</div>
							<?php
								if(!empty($_SESSION['logged_user']->phone)){
									echo '<div class=\'information\'>'.$_SESSION['logged_user']->phone.'</div><div class=\'add\' id=\'phone\'>Изменить</div>';
								}else{
									echo '<div class=\'information\'>Вы не указали телефон!</div>
									<div class=\'add\' id=\'phone\'>Добавить</div>';
								}						
							?>
						</div>
						<div class="someElse">
							<div class='nameOf green'>Телефон:</div>
							<input type="tel" class="form_input" name="phone" placeholder="введите телефон" pattern="[0-9]{11}" value=<?php echo $_SESSION['logged_user']->phone;?>>
							<div class="save" id="save_phone">Изменить</div>							
						</div>
					</li>
					<hr>
					<li class="country">
						<div class="block_line">
							<div class='nameOf green'>Страна:</div>
							<?php
								if(!empty($_SESSION['logged_user']->country)){
									echo '<div class=\'information\'>'.$_SESSION['logged_user']->country.'</div><div class=\'add\' id=\'country\'>Изменить</div>';
								}else{
									echo '<div class=\'information\'>Вы не указали страну!</div>
									<div class=\'add\' id=\'country\'>Добавить</div>';
								}						
							?>
						</div>
						<div class="someElse">
							<div class='nameOf green'>Страна:</div>
							<input type="country" class="form_input" name="country" placeholder="введите страну" value=<?php echo $_SESSION['logged_user']->country;?>>
							<div class="save" id="save_country">Изменить</div>							
						</div>
					</li>
					<hr>
					<li class="town">
						<div class="block_line">
							<div class='nameOf green'>Город:</div>
							<?php
								if(!empty($_SESSION['logged_user']->town)){
									echo '<div class=\'information\'>'.$_SESSION['logged_user']->town.'</div><div class=\'add\' id=\'town\'>Изменить</div>';
								}else{
									echo '<div class=\'information\'>Вы не указали город!</div>
									<div class=\'add\' id=\'town\'>Добавить</div>';
								}						
							?>
						</div>
						<div class="someElse">
							<div class='nameOf green'>Город:</div>
							<input type="text" class="form_input" name="town" placeholder="введите город" value=<?php echo $_SESSION['logged_user']->town;?>>
							<div class="save" id="save_town">Изменить</div>							
						</div>
					</li>
				</ol>
			</div>
			<div class='user_imgs'>
				<div class='green name'>Фотографии</div>
				<?php
					if ($_SESSION['logged_user']->howManyImgsHasUser == 0) {
						echo "<div class='info'>У вас нет фотографий!</div>";
					}else{
						echo "<div class='all_photos'>";
						for ($i = 0; $i < count($_SESSION['logged_user']->allImgs); $i++) { 
							echo '<img class=\'user_photo\' data-n='.$i.' src=\'\' data-src=\''.$_SESSION['logged_user']->allImgs[$i]->path.'\'>';
						}
						echo "</div>";
					}
					echo "Вы можете добавить фотографию:";
					echo '<div class=\'line\'><input type=\'file\' name=\'file\' accept=\'image/png,image/jpeq,image/jpg,image/gif\'></div>';
				?>
			</div>
			<?php
				echo '<div class=\'line\'><button type=\'submit\' class=\'save\'>Сохранить</button></div>';
			?>
		</form>
	</div>
	<script type="text/javascript">
		var imgId        = '<?php echo $imgId; ?>',
			isMenuActive = '<?php echo $isMenuActive; ?>';

		var container = document.querySelector(".photo_description"),
			photo     = document.querySelector(".photo img");

		if (imgId&&isMenuActive) {
			var target = document.querySelector(`.user_photo[data-n='${imgId}']`);

			document.querySelector('body').style.overflowY = 'hidden';
			container.classList.add('active');
			photo.src = target.getAttribute('data-src');
			photo.setAttribute('data-n', target.getAttribute('data-n'));
		}
	</script>
</body>
</html>