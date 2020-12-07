<?php
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");



date_default_timezone_set('America/Sao_Paulo');

$postagem = mysql_query("SELECT * FROM planta ORDER BY id DESC");


if (isset($_POST['out'])){
	setcookie("login", null, -1);
}


?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<?php
		if (!isset($_COOKIE["login"])){
			echo "<h4>USUARIO: Phanthom User <h4>";
		}else{
		$cookie_loged = $_COOKIE["login"];
		$teste = mysql_query("SELECT username FROM usuario WHERE email ='$cookie_loged'");
		$nome_usuario = mysql_result($teste, 0);	
		echo "<h4>USUARIO: $nome_usuario <h4>";

		}




	?>
	<title>
		AMORGAN PRIN
	</title>
</head>
<body>

	<form method="POST">
		<?php
		if (!isset($_COOKIE["login"])){
			echo '<input type="submit" formaction="login.php" name="log" value= "LogIn"/>';
			echo '<input type="submit" formaction="registrar.php" name="cad" value= "Cadastrar"/>';

		}else{
			echo '<input type="submit" name="out" value= "LogOut"/>';
		}
		?>
		<?php
		echo '<input type="submit" formaction="post.php" name="add" value= "Adicionar Planta"/>';
		?>
	</form>	

	<?php
	while($planta=mysql_fetch_assoc($postagem)){
		$id = $planta['id'];
		echo 
		'
		<a style="display:block" href="plt.php?tag='.$id.'">
		<div class="posta" id="'.$id.'">
		<p>'.$planta['nome']. ' - ' .$planta["nome_cient"].'</p>		
		<img src="upload/'.$planta['imagem'].'" width="250px"/>



		</div></a>';
}


?>
</body>
</html>