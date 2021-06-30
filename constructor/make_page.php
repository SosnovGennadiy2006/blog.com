<?php
//Файл создаёт посты
function make_page($author_id, $author_name, $name, $content, $post_id)
{
    $link = '/profile.php?id='.$author_id;

    $content = str_replace('textarea', 'div', $content);

    $text = '<?php
//Соединяемся с базой данных phpMyAdmin
require $_SERVER["DOCUMENT_ROOT"]."/libraries/rb.php";
R::setup( "mysql:host=db;dbname=project1", "mysql", "mysql" );

session_start();
?>

<!DOCTYPE html>
<html lang=\'en\'>
<head>
    <meta charset=\'UTF-8\'>
    <meta name=\'viewport\' content=\'width=device-width, initial-scale=1\'>
    <meta content=\'true\' name=\'HandheldFriendly\'/>
    <meta content=\'width\' name=\'MobileOptimized\'/>
    <meta content=\'yes\' name=\'apple-mobile-web-app-capable\'/>
    <title>'.$name.'</title>
    <link href=\'/fonts/fonts.css\' rel=\'stylesheet\'>
    <link href=\'/styles/base_styles.css\' rel=\'stylesheet\'>
    <link rel=\'stylesheet\' type=\'text/css\' href=\'/styles/post_styles.css?rnd=<?= time() ?>\'>
    <link rel=\'shortcut icon\' href=\'/imgs/icon.ico\' type=\'image/x-icon\'>
    <script src=\'/scripts/scriptForMenu.js\' defer></script>
</head>
<body>
    <header>
        <div class="menu">
            <nav class="menu__nav">
                <ol>
                    <?php if(isset($_SESSION[\'logged_user\'])){
                        echo \'<li><a href="/profile.php?id=\'.$_SESSION[\'logged_user\']->id.\'">Профиль</a></li>\';

                        echo \'<li><a href="/constructor/constructor.php">Создать пост</a></li>\';
                    }
                    ?>
                    <li><a href="/">Главная</a></li>
                    <?php if(isset($_SESSION[\'logged_user\'])){
                        echo "<a href=\'/logout/logout.php\' class=\'authorize\'>";
                        echo "Выйти";
                        echo "</a>";
                    } else {
                        echo "<a href=\'/signup/form.php\' class=\'authorize\'>";
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
                        <?php if(isset($_SESSION[\'logged_user\'])){
                            echo \'<li><a href="profile.php?id=\'.$_SESSION[\'logged_user\']->id.\'">Профиль</a></li>\';

                            echo \'<li><a href="/constructor/constructor.php">Создать пост</a></li>\';
                        }
                        ?>
                        <li><a href="#">Главная</a></li>
                        <?php if(isset($_SESSION[\'logged_user\'])){
                            echo "<a href=\'logout/logout.php\' class=\'authorize\'>";
                            echo "Выйти";
                            echo "</a>";
                        } else {
                            echo "<a href=\'signup/form.php\' class=\'authorize\'>";
                            echo "Войти";
                            echo "</a>";
                        }?></li></a>
                    </ol>
                </nav>
            </div>
        </div>
	</header>

    <div class=\'container\'>
        <div class=\'main\'>
            <div class=\'post_name\'>
                '.$name.'
            </div>
            <hr>
            <div class=\'main_section\'>
                <div class=\'main_section_container_for_objects\'>
                    '.$content.'
                </div>
            </div>
            <hr>
            <div class=\'aboutAutor\'>
                <p>Автор: <a href=\''.$link.'\'>'.$author_name.'</a></p>
            </div>
        </div>
        </div>
    </div>
</body>
</html>
';

    $file = fopen($_SERVER["DOCUMENT_ROOT"]."/posts/posts_for_user".$author_id."/post".$post_id."/main.php", "w");
	fwrite($file, $text);
	fclose($file);
}
?>