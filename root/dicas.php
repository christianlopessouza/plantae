<?php
if(isset($_POST['enviar2'])){
		if (!isset($_COOKIE["login"])){
			header("Location: login.php");
		}else{
		$texto = $_POST['texto'];
		if ($texto != ''){

		$query = mysql_query("INSERT INTO dicas_post (id_user,id_planta,texto) VALUES ('$id_usuario','$id_plant','$texto')");


}
}
}

?>

<!DOCTYPE html>
<html>
<body>
<hr>
<h3>Dicas</h3>
<br>
<form method="POST">
<textarea rows="4" cols="50" name="texto" placeholder="Ajude com Dicas"></textarea><br>
<input class="submit" name="enviar2" type="submit" value="Postar">
</form>
<?php
	$id_post = 0;
	$postagem = mysql_query("SELECT * FROM dicas_post WHERE id_planta = $id_plant");


	while($pub=mysql_fetch_assoc($postagem)){
		$id_user_post = $pub['id_user'];
		$teste = mysql_query("SELECT username FROM usuario WHERE id ='$id_user_post'");
		$nome_usuario = mysql_result($teste, 0);
		$id_post = $pub['id_post_dica'];

		if (isset($_COOKIE["login"]) AND ($id_user_post == $id_usuario)){
		echo 
		'<div class="loscaipiras" id=""'.$id_post.'">
		<b>'.$nome_usuario.'</b><br><br>
		<span>'.$pub['texto'].'</span>
		<form method="POST"><br>
		<input type="submit" class="submit5" name="delete'.$id_post.'" value="Deletar Dica"><br>		
		</form>
		</div>';
		}else{
		echo
		'<div class="posta" id=""'.$id_post.'"> 
		<b><p>'.$nome_usuario.'</b></p>
		<span>'.$pub['texto'].'</span>

		</form>
		</div>';
		}

	
		if (isset($_POST["delete$id_post"])){
			$query = "DELETE FROM `dicas_post` WHERE id_post_dica = '$id_post'";
			$data = mysql_query($query) or die();
			$sub = ($_SERVER["SCRIPT_NAME"]);
			header ("Location: $sub?tag=$id_plant");

		}
}
		
		if (isset($_POST["botao$id_post"])){
		if (!isset($_COOKIE["login"])){
			header("Location: login.php");
		}else{
		$texto = $_POST['texto'];
		if ($texto != ''){

		$query = "INSERT INTO comentario (id_user,id_post,texto) VALUES ('$id_usuario','$id_post','$texto')";
		$data = mysql_query($query) or die();

		if (!$data){
			echo "<p>Parece que aconteceu algum erro, tente novamente mais tarde</p>";
		}else{
			$sub = ($_SERVER["SCRIPT_NAME"]);
			header ("Location: $sub?tag=$id_plant");
		}
	}
	}



}



?>

</form>
</body>
</html>
