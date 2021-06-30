<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css?rnd=<?= time() ?>">
	<title>Document</title>
</head>
<body>
	<style type="text/css">
		*,
		*:before,
		*:after{
			box-sizing: border-box;
			font-family: 'Montserrat', sans-serif;
		}
		
		body{
			display: flex;
			justify-content: center;
			align-items: center;
			margin: 0;
			padding: 0;
			height: 100vh;
		}

		.block{
			width: 600px;
			height: 400px;
			display: flex;
			justify-content: center;
			align-items: center;
			background: #212121;
			box-shadow: 0 50px 0 #313131;
			color: white;	
		}

		.main{
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.text{
			display: inline-block;
			text-align: center;
			font-size: 28px;
		}

		.button{
			margin-top: 50px;
			padding: 10px 20px;
			background: transparent;
			border: 2px solid white;
			display: inline-block;
			cursor: pointer;
			color: white;
		}

		.button a{
			text-decoration: none;
		}

		.button:hover{
			color: #212121;
			background: #fff;
		}
	</style>
	<div class="block">
		<div class="main">
			<div class="text">Вы не вошли в систему!</div>
			<a href="/index.php"><div class="button">Главная</div></a>			
		</div>
	</div>
</body>
</html>