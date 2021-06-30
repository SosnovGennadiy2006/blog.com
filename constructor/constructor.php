<?php
//Соединяемся с базой данных phpMyAdmin
require $_SERVER['DOCUMENT_ROOT'].'/libraries/rb.php';
R::setup( 'mysql:host=db;dbname=project1', 'mysql', 'mysql' );

session_start();
if (empty($_SESSION['logged_user'])) {
	header('Location: /errors/error404.php');
}

$_SESSION['container_content'] = '';


if (!empty($_SESSION['message'])){
	$isUserHasError = true;
}else{
	$isUserHasError = false;
}

$post_id = ($_SESSION['logged_user']->howManyPostsHasUser)+1;
$post_path = $_SERVER['DOCUMENT_ROOT'].'/posts/posts_for_user'.$_SESSION['logged_user']->id.'/post'.$post_id;
$main_file_for_post_path = $_SERVER['DOCUMENT_ROOT'].'/posts/posts_for_user'.$_SESSION['logged_user']->id.'/post'.$post_id.'/main.php';
$main_photo_for_post_path = $_SERVER['DOCUMENT_ROOT'].'/posts/posts_for_user'.$_SESSION['logged_user']->id.'/post'.$post_id.'/main_photo.jpg';

if (file_exists($post_path)) {
	if (!file_exists($main_file_for_post_path)) {
		if (file_exists($main_photo_for_post_path)){
			unlink($main_photo_for_post_path);
		}
		rmdir($post_path);
		$_SESSION['is_user_start_making_post'] = True;
	}
}

if (@$_SESSION['is_user_start_making_post']) {
	$_SESSION['content'] = '';
	$_SESSION['name'] = '';
	$_SESSION['is_user_start_making_post'] = False;
}
?>

<!--
Это конструктор постов
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
	<link href="/fonts/fonts.css" rel="stylesheet">
	<link href="/styles/base_styles.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/styles/constructor_styles.css?rnd=<?= time() ?>">
	<link rel="shortcut icon" href="/imgs/icon.ico" type="image/x-icon">
	<script src="/scripts/scriptForMenu.js" defer></script>
	<script src="/scripts/construct_scripts/script_for_selection.js" defer></script>
	<script src="/scripts/constructor_script.js" defer></script>
	<script src="/scripts/construct_scripts/script_for_dropdown_list.js" defer></script>
	<script src="/scripts/construct_scripts/show_error_message.js" defer></script>
	<script src="/scripts/construct_scripts/onexit_script.js" defer></script>
</head>
<body>
	<script type="text/javascript">
		var mainContent = `<?php echo @$_SESSION["content"]; ?>`;
		var isUserHasError = `<?php echo $isUserHasError; ?>`;
	</script>

	<header>
		<div class="menu">
			<nav class="menu__nav">
				<ol>
	 				<?php if(isset($_SESSION['logged_user'])){
	 					echo '<li><a href="/profile.php?id='.$_SESSION['logged_user']->id.'">Профиль</a></li>';
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
	 						echo '<li><a href="/profile.php?id='.$_SESSION['logged_user']->id.'">Профиль</a></li>';
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
		</div>
	</header>
	<div class="container">
		<div class="message inActiveFlex">
			<div class="cross">
				<div class="cross_line"></div>
			</div>

			<div class='message__text'><?php echo $_SESSION['message']; ?></div>
		</div>
		<form action="/constructor/select_img_for_post.php" method="POST">
			<div class="main">
				<div class="post_name">
					<input type="text" name='post_name' placeholder='имя поста' value=<?php echo @$_SESSION['name']; ?>>
				</div>
				<hr>
				<div class="main_section">
					<div class="grid">
						<div class="grid_fill_row_container"></div>
						<div class="grid_fill_column_container"></div>
						<table>
							<tr data-n='0' class='fill'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='1'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='2'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='3'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='4'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='5'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='6'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='7'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='8'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='9'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='10'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr data-n='11'>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</table>
					</div>
					<div class="selection_block"></div>
					<div class="main_section_container_for_objects">
						
					</div>
				</div>
				<hr>
				<div class="aboutAutor">
					<p>Автор: <?php echo $_SESSION['logged_user']->login; ?></p>
				</div>
			</div>

			<textarea name='content' style='display: none;' class='formContent'></textarea>

			<div class="forSubmitButton">
				<button class="submitButton" type="submit" name='save_post'>
					сохранить
				</button>
			</div>
		</form>
		
		<div class="settings" value='сохранить'>
			<nav class="settings_nav">
				<ol>
					<li class="item active" data-n='0'><img src="/imgs/controls.png" title='Общие настройки' draggable="false"></li>
					<li class="item" data-n='1'><img src="/imgs/add.png" title='Размещение' draggable="false"></li>
					<li class="item" data-n='2'><img src="/imgs/font.png" title='Стилизация' draggable="false"></li>
				</ol>
			</nav>
			<div class="settings_containers">
				<div class="settings_container active" data-n='0'>
					<h3 class='name'>Общие настройки</h3>
					<hr class='hr_line'>
					<fieldset>
						<legend>Сетка</legend>
						<div class="all_fildset_information scroll">
							<div class="flex_line">
								Показывать сетку 
								<div class="switch makeGridActive"></div>
							</div>
							<div class="else_about_grid">
								<div class="flex_line">
									Прилипать к сетке? 
									<div class="switch makeGridSticky"></div>
								</div>	
								<ol class='dropdown_list'>
									<li><div class="color">Состовляющие сетки<span class='arrow'>&#9660;</span></div>
										<ol class='all_information'>
											<ol class='dropdown_list dropdow_list_row'>
												<li><div class="color">Ряды<span class='arrow'>&#9660;</span></div>
													<ol class='all_information scroll'>
														<li class='dropdown_list_information'>
															<div class="flex_line">
																<div class="number">№ ряда</div>
																<div class="function_name_row"></div>
															</div>
														</li>
														<li data-n='1' class='grid_row'>
															<div class="flex_line">
																<div class="number">1</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='2' class='grid_row'>
															<div class="flex_line">
																<div class="number">2</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='3' class='grid_row'>
															<div class="flex_line">
																<div class="number">3</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='4' class='grid_row'>
															<div class="flex_line">
																<div class="number">4</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='5' class='grid_row'>
															<div class="flex_line">
																<div class="number">5</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='6' class='grid_row'>
															<div class="flex_line">
																<div class="number">6</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='7' class='grid_row'>
															<div class="flex_line">
																<div class="number">7</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='8' class='grid_row'>
															<div class="flex_line">
																<div class="number">8</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='9' class='grid_row'>
															<div class="flex_line">
																<div class="number">9</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='10' class='grid_row'>
															<div class="flex_line">
																<div class="number">10</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='11' class='grid_row'>
															<div class="flex_line">
																<div class="number">11</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='12' class='grid_row'>
															<div class="flex_line">
																<div class="number">12</div>
																<div class="functions">
																	<div class="visiblity function_button">
																		<img src="/imgs/visibility.png">
																	</div>
																	<div class="fill_row function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li class='add_row'>
															<div class='flex_line center'>
																<div class="button_color">Добавить</div>
															</div>
														</li>
													</ol>
												</li>
											</ol>
											<ol class='dropdown_list dropdow_list_column'>
												<li><div class="color">Столбцы<span class='arrow'>&#9660;</span></div>
													<ol class='all_information scroll'>
														<li class='dropdown_list_information'>
															<div class="flex_line">
																<div class="number">№ столбца</div>
																<div class="function_name_column"></div>
															</div>
														</li>
														<li data-n='1' class='grid_column'>
															<div class="flex_line">
																<div class="number">1</div>
																<div class="functions">
																	<div class="fill_column function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='2' class='grid_column'>
															<div class="flex_line">
																<div class="number">2</div>
																<div class="functions">
																	<div class="fill_column function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='3' class='grid_column'>
															<div class="flex_line">
																<div class="number">3</div>
																<div class="functions">
																	<div class="fill_column function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='4' class='grid_column'>
															<div class="flex_line">
																<div class="number">4</div>
																<div class="functions">
																	<div class="fill_column function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='5' class='grid_column'>
															<div class="flex_line">
																<div class="number">5</div>
																<div class="functions">
																	<div class="fill_column function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li data-n='6' class='grid_column'>
															<div class="flex_line">
																<div class="number">6</div>
																<div class="functions">
																	<div class="fill_column function_button">
																		<img src="/imgs/fill.png">
																	</div>
																</div>
															</div>
														</li>
														<li class='add_column'>
															<div class='flex_line center'>
																<div class="button_color">Добавить</div>
															</div>
														</li>
													</ol>
												</li>
											</ol>
										</ol>
									</li>
								</ol>
							</div>
						</div>
					</fieldset>
				</div>

				<div class="settings_container" data-n='1'>
					<h3 class='name'>Размещение</h3>
					<hr class='hr_line'>
					<div class="block_for_something">
						<div class="flex_line add_text right">
							<div class="button_color">Добавить текст</div>
						</div>
						<div class="flex_line about_text_selection inActiveBlock">
							Выделите область где будет находится текст
						</div>
						<div class="flex_line font_size_settings inActiveBlock">
							<ol class='dropdown_list'>
								<li><div class="color">Выберите размер шрифта<span class='arrow'>&#9660;</span></div>
									<ol class='all_information'>
										<li data-size='12' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">1.</div>
												<div class="text_for_font_size bold fs12">12px</div>
											</div>
										</li>
										<li data-size='14' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">2.</div>
												<div class="text_for_font_size bold fs14">14px</div>
											</div>
										</li>
										<li data-size='18' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">3.</div>
												<div class="text_for_font_size bold fs18">18px</div>
											</div>
										</li>
										<li data-size='24' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">4.</div>
												<div class="text_for_font_size bold fs24">24px</div>
											</div>
										</li>
										<li data-size='28' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">5.</div>
												<div class="text_for_font_size bold fs28">28px</div>
											</div>
										</li>
										<li data-size='32' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">6.</div>
												<div class="text_for_font_size bold fs32">32px</div>
											</div>
										</li>
										<li class='choose_font_size dropdown_list_last_button inActiveFlex'>
											<div class='flex_line'>
												<div class="button_color">Выбрать</div>
											</div>
										</li>
									</ol>
								</li>
							</ol>
						</div>
						<div class="flex_line font_color_settings inActiveBlock">
							<ol class='dropdown_list'>
								<li><div class="color">Выберите цвет текста<span class='arrow'>&#9660;</span></div>
									<ol class='all_information'>
										<li data-color='black' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">1.</div>
												<div class="text_for_font_color color-black">чёрный</div>
											</div>
										</li>
										<li data-color='dark-grey' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">2.</div>
												<div class="text_for_font_color color-dark-grey">тёмно серый</div>
											</div>
										</li>
										<li data-color='grey' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">3.</div>
												<div class="text_for_font_color color-grey">серый</div>
											</div>
										</li>
										<li data-color='white' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">4.</div>
												<div class="text_for_font_color color-white background-grey">белый</div>
											</div>
										</li>
										<li data-color='orange' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">5.</div>
												<div class="text_for_font_color color-orange">оранжевый</div>
											</div>
										</li>
										<li class='choose_font_color dropdown_list_last_button inActiveFlex'>
											<div class='flex_line'>
													<div class="button_color">Выбрать</div>
											</div>
										</li>
									</ol>
								</li>
							</ol>
						</div>
					</div>

					<div class="block_for_something">
						<div class="flex_line add_header right">
							<div class="button_color">Добавить заголовок</div>
						</div>
						<div class="flex_line about_header_selection inActiveBlock">
							Кликните на область где будет находится заголовок
						</div>
						<div class="flex_line header_size_settings inActiveBlock">
							<ol class='dropdown_list'>
								<li><div class="color">Выберите размер шрифта<span class='arrow'>&#9660;</span></div>
									<ol class='all_information'>
										<li data-size='12' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">1.</div>
												<div class="text_for_header_size bold fs12">12px</div>
											</div>
										</li>
										<li data-size='14' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">2.</div>
												<div class="text_for_header_size bold fs14">14px</div>
											</div>
										</li>
										<li data-size='18' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">3.</div>
												<div class="text_for_header_size bold fs18">18px</div>
											</div>
										</li>
										<li data-size='24' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">4.</div>
												<div class="text_for_header_size bold fs24">24px</div>
											</div>
										</li>
										<li data-size='28' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">5.</div>
												<div class="text_for_header_size bold fs28">28px</div>
											</div>
										</li>
										<li data-size='32' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">6.</div>
												<div class="text_for_header_size bold fs32">32px</div>
											</div>
										</li>
										<li class='choose_header_size dropdown_list_last_button inActiveFlex'>
											<div class='flex_line'>
												<div class="button_color">Выбрать</div>
											</div>
										</li>
									</ol>
								</li>
							</ol>
						</div>
						<div class="flex_line header_color_settings inActiveBlock">
							<ol class='dropdown_list'>
								<li><div class="color">Выберите цвет текста<span class='arrow'>&#9660;</span></div>
									<ol class='all_information'>
										<li data-color='black' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">1.</div>
												<div class="text_for_header_color color-black">чёрный</div>
											</div>
										</li>
										<li data-color='dark-grey' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">2.</div>
												<div class="text_for_header_color color-dark-grey">тёмно серый</div>
											</div>
										</li>
										<li data-color='grey' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">3.</div>
												<div class="text_for_header_color color-grey">серый</div>
											</div>
										</li>
										<li data-color='white' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">4.</div>
												<div class="text_for_header_color color-white background-grey">белый</div>
											</div>
										</li>
										<li data-color='orange' class='dropdown_list_choice'>
											<div class="flex_line">
												<div class="number">5.</div>
												<div class="text_for_header_color color-orange">оранжевый</div>
											</div>
										</li>
										<li class='choose_header_color dropdown_list_last_button inActiveFlex'>
											<div class='flex_line'>
													<div class="button_color">Выбрать</div>
											</div>
										</li>
									</ol>
								</li>
							</ol>
						</div>
					</div>

					<div class="block_for_something">
						<div class="flex_line add_rectangle right">
							<div class="button_color">Добавить прямоугольник</div>
						</div>
						<div class="flex_line about_rectangle_selection inActiveBlock">
							Выделите область где будет находится прямоугольник
						</div>
						<div class="flex_line choose_background_of_rectangle_block inActiveBlock">
							Выберите цвет прямоугольника 
							<input type='color' value='#212121'>
							<div class="button_green choose_background_of_rectangle_button">&#10004;</div>
						</div>
					</div>
				</div>

				<div class="settings_container" data-n='2'>
					<h3 class='name'>Стилизация</h3>
					<hr class='hr_line'>
					<fieldset>
						<legend>Информация</legend>
						<div class="text_about_how_see_all_information">Нажмите на блок информацию о котором вы хотите увидеть</div>
						<div class="main_information_about_block inActiveBlock">
							<hr class="hr_line">
							<nav class='main_information_about_block_nav'>
								<ol class='main_information_about_block__list'>
									<li>
										<div class="flex_line">
											Тип: <span class='node_type color'></span>
										</div>
									</li>
									<li>
										<div class="flex_line">
											Ширина: <span class='node_width'></span>
										</div>
									</li>
									<li>
										<div class="flex_line">
											Высота:	<span class='node_height'></span>
										</div>
									</li>
									<li>
										<div class="flex_line">
											Позиция по X: <span class='node_pos_X'></span>
										</div>
									</li>
									<li>
										<div class="flex_line">
											Позиция по Y: <span class='node_pos_Y'></span>
										</div>
									</li>
									<li class="inActiveBlock node_rectangle" data-span_container='node_backgroundColor' data-span_type='color'>
										<div class="flex_line">
											Задний цвет: <span class='node_backgroundColor'></span>
										</div>
									</li>
									<li class="inActiveBlock node_textarea node_header" data-span_container='node_color' data-span_type='color'>
										<div class="flex_line">
											Цвет текста: <span class='node_color'></span>
										</div>
									</li>
									<li class="inActiveBlock node_textarea node_header" data-span_container='node_fontSize' data-span_type='text'>
										<div class="flex_line">
											Размер текста: <span class='node_fontSize'></span>
										</div>
									</li>
									<li class="inActiveBlock node_rectangle" data-span_container='node_borderRadius' data-span_type='text'>
										<div class="flex_line">
											Скругление краёв: <span class='node_borderRadius'></span>
										</div>
									</li>
								</ol>
							</nav>
						</div>
					</fieldset>
				</div>


				<div class="cross">
					<div class="cross_line"></div>
				</div>
			</div>
		</div>
	</div>

	<?php 
	$_SESSION["content"] = '';
	$_SESSION["name"]    = '';
	$_SESSION['message'] = '';
	 ?>
</body>
</html>