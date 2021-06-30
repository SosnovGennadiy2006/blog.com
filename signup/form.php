<?php 
	//Этот файл предназначен для регистрации пользователей
	require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
	R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

	session_start();

	$_SESSION["content"] = '';
	$_SESSION["name"]    = '';
	$_SESSION['message'] = '';

	$data = $_POST;
	if(isset($data["signup"])){//при нажатии кнопки signup
		//регистрируем

		$errors = array();
		if(trim($data["signUp_login"]) == ""){
			$errors[] = "Введите логин!";
			echo "<script>
				window.onload = () =>{
					var elem = document.querySelector('.signUp_login_name');
					var input = document.querySelector('input[name=signUp_login]');
					elem.classList.remove('yellow');
					elem.classList.add('red');
					elem.innerHTML = 'Введите логин!';
					input.style.borderColor = 'var(--red)';
				}
			</script>";
		}

		if(trim($data["signUp_email"]) == ""){
			$errors[] = "Введите Email!";
			echo "<script>
				window.onload = () =>{
					var elem = document.querySelector('.signUp_email_name');
					var input = document.querySelector('input[name=signUp_email]');
					elem.classList.remove('yellow');
					elem.classList.add('red');
					elem.innerHTML = 'Введите почту!';
					input.style.borderColor = 'var(--red)';
				}
			</script>";
		}

		if($data["signUp_password"] == ""){
			$errors[] = "Введите пароль!";
			echo "<script>
				window.onload = () =>{
					var elem = document.querySelector('.signUp_password_name');
					var input = document.querySelector('input[name=signUp_password]');
					elem.classList.remove('yellow');
					elem.classList.add('red');
					elem.innerHTML = 'Введите пароль!';
					input.style.borderColor = 'var(--red)';
				}
			</script>";
		}

		if(R::count('users', 'login = ?', array($data["signUp_login"])) > 0){
			$errors[] = "Пользователь с таким логином уже существует!";
			echo "<script>
				window.onload = () =>{
					var elem = document.querySelector('.signUp_login_name');
					var input = document.querySelector('input[name=signUp_login]');
					elem.classList.remove('yellow');
					elem.classList.add('red');
					elem.innerHTML = 'Пользователь с таким логином уже существует!';
					input.style.borderColor = 'var(--red)';
				}
			</script>";
		}

		if(R::count('users', 'email = ?', array($data["signUp_email"])) > 0){
			$errors[] = "Пользователь с такой почтой уже существует!";
			echo "<script>
				window.onload = () =>{
					var elem = document.querySelector('.signUp_email_name');
					var input = document.querySelector('input[name=signUp_email]');
					elem.classList.remove('yellow');
					elem.classList.add('red');
					elem.innerHTML = 'Пользователь с такой почтой уже существует!';
					input.style.borderColor = 'var(--red)';
				}
			</script>";
		}

		if($data["signUp_password2"] != $data["signUp_password"]){
			$errors[] = "Повторный пароль введён не верно!";
			echo "<script>
				window.onload = () =>{
					var elem = document.querySelector('.signUp_password2_name');
					var input = document.querySelector('input[name=signUp_password2]');
					elem.classList.remove('yellow');
					elem.classList.add('red');
					elem.innerHTML = 'Повторный пароль введён не верно!';
					input.style.borderColor = 'var(--red)';
				}
			</script>";
		}

		if(empty($errors)){
			//ошибок нет
			$user                      = R::dispense("users");
			$user->login               = $data["signUp_login"];
			$user->email               = $data["signUp_email"];
			$user->password            = password_hash($data["signUp_password"], PASSWORD_DEFAULT);
			$user->phone               = "";
			$user->howManyImgsHasUser  = 0;
			$user->howManyPostsHasUser = 0;
			$user->country             = "";
			$user->town                = "";
			R::store($user);
			$_SESSION['logged_user'] = $user;
			$_SESSION['logged_user']->allImgs = array();
			$_SESSION['logged_user']->allPosts = array();
			$path_for_imgs = $_SERVER['DOCUMENT_ROOT']."/users/user_id".$user->id."/";
			if (!file_exists($_SERVER['DOCUMENT_ROOT']."/users/user_id".$user->id)) {
			    mkdir($path_for_imgs, 0700);
			}
			$path_for_posts = $_SERVER['DOCUMENT_ROOT']."/posts/posts_for_user".$user->id."/";
			if (!file_exists($_SERVER['DOCUMENT_ROOT']."/posts/posts_for_user".$user->id)) {
			    mkdir($path_for_posts, 0700);
			}
			header('Location: /');
		}
	}


	if(isset($data["signin"])){//при нажатии кнопки signin
		//авторизуем

		$user = R::findOne('users', 'login = ?', array($data['signIn_login']));
		if($user){
			//логин существует

			if(password_verify($data['signIn_password'], $user->password)){
				//Всё хорошо

				$_SESSION['logged_user']           = $user;
				$_SESSION['logged_user']->allImgs  = array();
				$_SESSION['logged_user']->allPosts = array();

				$id = $user->id;
				$table_name_for_imgs = 'userimgsid'.$id;

				for ($i=0; $i < $user->howManyImgsHasUser; $i++) { 
					$img = R::load($table_name_for_imgs, $i + 1);
					$_SESSION['logged_user']->allImgs[] = $img;
					R::store($img);
				}

				$table_name_for_posts = 'user'.$id.'posts';

				for ($i=0; $i < $user->howManyPostsHasUser; $i++) { 
					$post = R::load($table_name_for_posts, $i + 1);
					$_SESSION['logged_user']->allPosts[] = $post;
					R::store($post);
				}
				header('Location: /');
			}else{
				echo "<script>
					window.onload = () =>{
						var elem = document.querySelector('.signIn_password_name');
						var input = document.querySelector('input[name=signIn_password]');
						elem.classList.remove('yellow');
						elem.classList.add('red');
						elem.innerHTML = 'Неверно введён пароль!';
						input.style.borderColor = 'var(--red)';
					}
				</script>";
			}
		}else{
			echo "<script>
				window.onload = () =>{
					var elem = document.querySelector('.signIn_login_name');
					var input = document.querySelector('input[name=signIn_login]');
					elem.classList.remove('yellow');
					elem.classList.add('red');
					elem.innerHTML = 'Пользователь с таким логином не найден!';
					input.style.borderColor = 'var(--red)';
				}
			</script>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<meta http-equiv="Cache-Control" content="no-cache">
	<title>Document</title>
	<link href="/fonts/fonts.css" rel="stylesheet">
	<link rel="stylesheet" href="styles/style.css?rnd=<?= time() ?>">
	<script src="/scripts/signup.js?rnd=<?= time() ?>" defer></script>
</head>
<body>
	<div class="container">
		<div class="block">
			<nav class="menu">
				<ol>
					<li class="signIn active">Войти</li>
					<li class="signUp">Зарегистрироваться</li>
				</ol>
				<div class="line"></div>
			</nav>
			<hr>
			<div class="forms">
				<div class="slider">	
					<div class="signInForm">
						<form action="/signup/form.php" method="POST">
							<p>
								<p class="yellow signIn_login_name">Логин</p>
								<input type="text" name="signIn_login" value="<?php echo @$data['signIn_login']?>">
							</p>

							<p>
								<p class="yellow signIn_password_name">Пароль</p>
								<input type="password" name="signIn_password" value="<?php echo @$data['signIn_password']?>">
							</p>


							<div class="buttonBlock">
								<button type="submit" class="submitButton" name="signin">войти</button>	
							</div>
						</form>
					</div>
					<div class="signUpForm">
						<form action="/signup/form.php" method="POST">
							<p>
								<p class="yellow signUp_login_name">Ваш логин</p>
								<input type="text" name="signUp_login" value="<?php echo @$data['signUp_login']?>">
							</p>

							<p>
								<p class="yellow signUp_email_name">Ваш Email</p>
								<input type="email" name="signUp_email" value="<?php echo @$data['signUp_email']?>">
							</p>

							<p>
								<p class="yellow signUp_password_name">Ваш пароль</p>
								<input type="password" name="signUp_password" value="<?php echo @$data['signUp_password']?>">
							</p>

							<p>
								<p class="yellow signUp_password2_name">Введите ваш пороль ещё раз</p>
								<input type="password" name="signUp_password2" value="<?php echo @$data['signUp_password2']?>">
							</p>

							<div class="buttonBlock">
								<button type="submit" class="submitButton signUpSubmit" name="signup">зарегистрироваться</button>	
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>