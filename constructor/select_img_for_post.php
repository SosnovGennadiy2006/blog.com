<?php 
	//Пользователь может выбрать фотографию для поста
	require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
	R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

	require $_SERVER['DOCUMENT_ROOT'].'/constructor/make_page.php';

	session_start();

	$_SESSION['message'] = '';

	$data = $_POST;

	$post_id = ($_SESSION['logged_user']->howManyPostsHasUser)+1;

	if(isset($data["save_post"])){//при нажатии кнопки сохранить
		//сохраняем пост

		$_SESSION['name']    = $data['post_name'];
		$_SESSION['content'] = $data['content'];

		$name = $data['post_name'];
		$content = $data['content'];

		$errors = array();

		if (empty($name)) {
			$errors[] = 'Введите название поста!';

		}

		if (empty($content)) {
			$errors[] = 'Вы не можете сохранить пустой пост!';
		}

		if(!empty($errors)){
			$_SESSION['message'] = $errors[0];
			header('Location: /constructor/constructor.php');
		}else{
			$table_name = 'user'.$_SESSION['logged_user']->id.'posts';
			$post_id = ($_SESSION['logged_user']->howManyPostsHasUser)+1;

			$path_for_post = $_SERVER['DOCUMENT_ROOT']."/posts/posts_for_user".$_SESSION['logged_user']->id."/post".$post_id."/";
			if (!file_exists($_SERVER['DOCUMENT_ROOT']."/posts/posts_for_user".$_SESSION['logged_user']->id."/post".$post_id)) {
			    mkdir($path_for_post, 0700);
			}
		}
	}else if(isset($data["save_img_for_post"])){
		if($_FILES['img']['error'] == 0){
			$path = $_SERVER['DOCUMENT_ROOT'].'/posts/posts_for_user'.$_SESSION['logged_user']->id.'/post'.$post_id.'/main_photo.jpg';

			if (!file_exists($path)) {
				move_uploaded_file($_FILES['img']['tmp_name'], $path);
			}else{
				unlink($path);
				move_uploaded_file($_FILES['img']['tmp_name'], $path);
			}
		}else{
			$path = $_SERVER['DOCUMENT_ROOT'].substr($data['new_path'], 15);
			$post_id = ($_SESSION['logged_user']->howManyPostsHasUser)+1;

			$new_path = $_SERVER['DOCUMENT_ROOT'].'/posts/posts_for_user'.$_SESSION['logged_user']->id.'/post'.$post_id.'/main_photo.jpg';

			if (!file_exists($new_path)) {
				copy($path, $new_path);
			}else{
				unlink($new_path);
				copy($path, $new_path);
			}
		}
	}else if(isset($data["save_whole_post"])){
		$table_name = 'user'.$_SESSION['logged_user']->id.'posts';
		$post_id = ($_SESSION['logged_user']->howManyPostsHasUser)+1;
		$description = $data["description"];
		$date = date("Y:n:d в H:i:s");

		$user_posts = R::dispense($table_name);
		$user_posts->name = $_SESSION['name'];
		$user_posts->description = $description;
		$user_posts->date = $date;
		$user_posts->author_id = $_SESSION['logged_user']->id;
		$user_posts->path = "/posts/posts_for_user".$_SESSION["logged_user"]->id."/post".$post_id."/";
		$_SESSION['logged_user']->allPosts[] = $user_posts;
		R::store($user_posts);

		$all_posts = R::dispense('allposts');
		$all_posts->name = $_SESSION['name'];
		$all_posts->description = $description;
		$all_posts->date = $date;
		$all_posts->author_id = $_SESSION['logged_user']->id;
		$all_posts->path = "/posts/posts_for_user".$_SESSION["logged_user"]->id."/post".$post_id."/";
		R::store($all_posts);

		make_page($_SESSION['logged_user']->id, $_SESSION['logged_user']->login, $_SESSION['name'], $_SESSION['content'], $post_id);

		$user = R::load('users', $_SESSION['logged_user']->id);
		$user->howManyPostsHasUser++;
		$_SESSION['logged_user']->howManyPostsHasUser++;
		R::store($user);
		$_SESSION['logged_user']->allposts[] = $user_posts;

		$_SESSION["content"] = '';
		$_SESSION["name"]    = '';
		$_SESSION['is_user_start_making_post'] = True;

		header('Location: '."/posts/posts_for_user".$_SESSION["logged_user"]->id."/post".$post_id."/main.php");
	}else{
		header('Location: /errors/error404.php');
	}

	$is_post_has_image = file_exists($_SERVER["DOCUMENT_ROOT"]."/posts/posts_for_user".$_SESSION["logged_user"]->id."/post".$post_id."/main_photo.jpg");
?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="/styles/save_img.css?rnd=<?= time() ?>">
	<link rel='stylesheet' type='text/css' href='/fonts/fonts.css?rnd=<?= time() ?>'>
	<script src="/scripts/lazy_load.js" defer></script>
	<script src="/scripts/construct_scripts/save_img_script.js" defer></script>
	<script src="/scripts/construct_scripts/onexit_script.js" defer></script>
	<script src="/scripts/construct_scripts/select_img_for_post_script.js" defer></script>
</head>
<body>
	<script>
		var isUserHasError = false,
			howManyImgsHasUser = '<?php echo $_SESSION['logged_user']->howManyImgsHasUser; ?>';

		if (howManyImgsHasUser == 0) {
			isUserHasError = true;
		}

		var is_post_has_image = '<?php echo $is_post_has_image; ?>';

		isUserHasChanges = true;
	</script>

	<div class="message">
		<div class="cross">
			<div class="cross_line"></div>
		</div>

		<div class='message__text'>У вас нет фотографий!</div>
	</div>

	<div class="background">
		<div class="profile_imgs">
			<div class="cross_profile_imgs">
				<div class="cross_line"></div>
			</div>
			<div class="imgs">
				<?php
					for ($i = 0; $i < count($_SESSION['logged_user']->allImgs); $i++) {
						echo '<div class=\'img_wrapper\'>
						<img class=\'user_photo\' data-n='.$i.' src=\'\' data-src=\'/'.$_SESSION['logged_user']->allImgs[$i]->path.'\'>
						</div>
						';
					}
				?>
			</div>
			<div class="choose_img_line">
				<div class="save_profile_img">Сохранить</div>
			</div>
		</div>
	</div>


	<div class="container">
		<div class="block">
			<form action="/constructor/select_img_for_post.php" method="POST" enctype='multipart/form-data'>
				<div class="select_img_block">
					<div class="img_settings">
						<div class="text">
							Выберите фотографию для поста.
						</div>

						<div class="select_how">
							<div class="line">
								<div class="select_description">
								Выберите как:</div> 
								<select>
									<option class='from_computer'>С компьютера</option>
									<option class='from_profile'>Из профиля</option>
								</select>
							</div>
						</div>
					</div>
					<hr class='adaptive_line'>
					<div class="choose_img_block">
						<div class="img_block">
							<?php 
							$post_id = ($_SESSION['logged_user']->howManyPostsHasUser)+1;
							$path = "/posts/posts_for_user".$_SESSION['logged_user']->id."/post".$post_id.'/main_photo.jpg';
							if (!file_exists($_SERVER['DOCUMENT_ROOT'].$path)) {
								echo '<div class="message_red">Фотография не выбрана!</div>';
							}else{
								echo '<img src='.$path.'>';
							}
							 ?>
							
						</div>
						<hr>
						<div class="button_block for_computer">
							<div class="input__wrapper">
								<input name="img" type="file" id="input__file" class="input input__file" accept='image/*'>
								<label for="input__file" class="input__file-button">
									<span class="input__file-icon-wrapper"><img class="input__file-icon" src="/imgs/download.png" width="25"></span>
									<span class="input__file-button-text">Выберите файл</span>
								</label>
							</div>
						</div>
						<input class='profile_img_path' name='new_path' type="text" style='display: none;position: absolute;'>
						<div class="button_block for_profile">
							<div class="show_user_imgs">Показать мои фотографии</div>
						</div>
					</div>
				</div>

				<div class="save_changes_block disabled">
					<button type="submit" class='save_changes' name='save_img_for_post'>Сохранить фото</button>
				</div>
			</form>
			<div class="gap"></div>
			<form action="/constructor/select_img_for_post.php" method="POST" enctype='multipart/form-data'>
				<div class="main">
					<div class="main_text">
						Вот так люди будут видеть ваш пост:
					</div>

					<div class="post_view">
						<div class="post_wrapper">
							<div class="post_img">
								<?php 
								$post_id = ($_SESSION['logged_user']->howManyPostsHasUser)+1;
								$path = "/posts/posts_for_user".$_SESSION['logged_user']->id."/post".$post_id.'/main_photo.jpg';
								if (!file_exists($_SERVER['DOCUMENT_ROOT'].$path)) {
									echo '<div class="message_red">Фотография не выбрана!</div>';
								}else{
									echo '<img src='.$path.'>';
								}
								 ?>
							</div>
							<hr class='vertical'>
							<div class="post_info">
								<div class="post_name">
									<?php
									echo $_SESSION['name'];
									?>
								</div>
								<hr class='gorizontal'>
								<div class="else_info">
									<div class="post_description">
										<textarea name="description" class='post_description_textarea' placeholder='Введите описание'></textarea>
									</div>
									<div class="author">
										Автор: 
			 							<?php echo '<a href="/profile.php?id='.$_SESSION['logged_user']->id.'">'.$_SESSION['logged_user']->login.'</a>'; ?>
									</div>
									<div class="flex_line">
										<div class="button_view">Подробнее</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="center">
						<button type="submit" class='save_post' name='save_whole_post'>Сохранить пост</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="/scripts/construct_scripts/save_img_script.js"></script>
</body>
</html>