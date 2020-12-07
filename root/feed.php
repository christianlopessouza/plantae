<?php
$cookie_loged = $_COOKIE['login'];
if (!isset($login_cookie)){
	header("Location: login.php");
}

$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");

if (isset($_POST['publish'])){
	if ($_FILES["foto"]["error"] > 0){
		echo "<p> Você precisa adicionar uma foto!</p>";
	}else{
		$legenda = $_POST['legenda'];
		$dia = date("Y-m-d");			
		$x = rand(0,1000000);
		$imagem = $x.$_FILES["foto"]["name"];
		move_uploaded_file($_FILES["foto"]["name"],"upload/".$imagem);
		$query = "INSERT INTO post (usuario,imagem,legenda,data) VALUES ('$login_cookie','$imagem','$legenda',$dia)";
		$data = mysql_query($query) or die();
		if ($data){
			header ("Location: ./");
		}else{
			echo "<p>Parece que aconteceu algum erro, tente mais novamente mais tarde</p>";
		}	
		}
	}

?>

<!DOCTYPE html>
<meta charset="UTF-8">

<html>
<head>
	<style type="text/css">
		div#publicar{
			width: 400px;
			height: 200px;
			display: block;
			margin: auto;
			border: none;
			border-radius: 5px;
			background: #e2e2e2;
			margin-top: 30px;
		}

		div#publicar textarea{
			width: 360px;
			height: 100px;
			display: block;
			margin: auto;
			border-radius: 5px;
			padding-left: 5px;
			padding-top: 5px;
			border-width: 1px;
			border-color: #A1A1A1; 
		}

		div#publicar img {
			margin-top:0px;
			margin-left: 10px;
			width: 30px;
			height: : 30px;			
			cursor: pointer;
		}

		div#publicar input[type="submit"]{
			width: 70px;
			height: 25px;
			border-radius: 3px;
			font: right;
			margin-right: 15px;
			border:none;
			margin-top: 5px;
			background: #e23e22;
			color:#fff;
			cursor: pointer;
			float:right;
		}
		div#publicar input[type="submit"]:hover{
			background: #001f3f;

		}


	</style>
	<title>
		AMORGAN FEED
	</title>
</head>
<body>
	<div id="publicar">
		<form method="POST" enctype="multipart/form-data"><br>
			<textarea placeholder="Escreva uma legenda para sua foto..." name="legenda"></textarea>
			<label for="file-input">
				<img src ="https://cdn0.iconfinder.com/data/icons/super-mono-sticker/icons/camera_sticker.png" title="Upload de Imagem"/>
			</label>
			<input type = "submit" value = "Publicar" name= "publish" />
			<input type = "file" id = "file-input" name= "foto" hidden />

			

 		</form>


	</div>	



</body>
</html>