<?php

if(isset($_POST['enviar'])){
		if (!isset($_COOKIE["login"])){
			header("Location: login.php");
		}else{
		$texto = $_POST['texto'];
		if ($texto != ''){

		$query = mysql_query("INSERT INTO post (id_user,id_planta,texto) VALUES ('$id_usuario','$id_plant','$texto')");


}
}
}

?>

<!DOCTYPE html>
<html>
<body>
<hr>
<div class="titulo" id="menor">
  Forum
</div>';
<div class="flex-wrap align-items-center">
<div class="forum">
<form method="POST">
<textarea cols="75" rows="7" name="texto" placeholder="Digite algo..."></textarea><br>
<input class="submit3" name="enviar" type="submit" value="Postar">
</form>

<?php
	$postagem = mysql_query("SELECT * FROM post WHERE id_planta = $id_plant");


	while($pub=mysql_fetch_assoc($postagem)){
		$id_user_post = $pub['id_user'];
		$teste = mysql_query("SELECT username FROM usuario WHERE id ='$id_user_post'");
		$nome_usuario = mysql_result($teste, 0);
		$id_post = $pub['id_post'];
		$comentario = mysql_query("SELECT * FROM comentario WHERE id_post = '$id_post' ORDER BY likes DESC");

	if (isset($_COOKIE["login"])){
	$verify_like_us = mysql_query("SELECT * FROM `LIKE` WHERE id_user = '$id_usuario' AND id_obj = '$id_plant' AND tipo = 'Planta'");
	$count_like_user = mysql_num_rows($verify_like_us);


}



		if (isset($_COOKIE["login"]) AND ($id_user_post == $id_usuario)){

		echo 
		'<div class="loscaipiras" id=""'.$id_post.'">
		<b><p>'.$nome_usuario.'</a><br> <text id="num_p"></text></b>
		<span>'.$pub['texto'].'</span>
		<form method="POST"><hr>
		<input type="text" name="texto" placeholder="Escreva o Comentário">
		<input type="submit" class="submit4" name="botao'.$id_post.'" value="Enviar comentario">
		<input type="submit" class="submit5" name="delete'.$id_post.'" value="Deletar Post"><br>		
		</form>
		';
		}else{
		echo
		'<div class="loscaipiras" id=""'.$id_post.'">
		<b><p>'.$nome_usuario.'</b></p>
		<span>'.$pub['texto'].'</span>
		<hr>
		<form method="POST">
		<input type="text" name="texto" placeholder="Escreva o Comentário">
		<input type="submit" class="submit5" name="botao'.$id_post.'" value="Enviar comentario">
		</form>
		';
		}






		while($com=mysql_fetch_assoc($comentario)){
			$id_c= $com['id_post'];	
			if ($id_c == $id_post){
				$id_user_c = $com['id_user'];
				$texto_c = $com['texto'];
				$id_coment = $com['id_coment'];

				$teste_c = mysql_query("SELECT username FROM usuario WHERE '$id_user_c' = id");
				$nome_usuario_c = mysql_result($teste_c, 0);

				if (isset($_COOKIE["login"]) AND $id_user_c == $id_usuario){				
				echo
				'<br><br><div class="loshermanos">'.$nome_usuario_c.'</div>
				<p>'.$texto_c.'</p>
				<form method="POST"><input type="submit" class="submit5" name="deletec'.$id_coment.'" value="Deletar Comentario"><br></form>';
				}else{
				echo
				'<p><b>'.$nome_usuario_c.'</b></p>
				<p>'.$texto_c.'</p>';
				}
				echo '<hr>';
				


		if (isset($_POST["deletec$id_coment"])){
			$query = "DELETE FROM `comentario` WHERE id_coment =$id_coment";
			$data = mysql_query($query) or die();
			$sub = ($_SERVER["SCRIPT_NAME"]);
			header ("Location: $sub?tag=$id_plant");
			ob_end_flush();
		}
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
			echo $sub;
			header ("Location: $sub?tag=$id_plant");
		}
	}
	}
	}

		if (isset($_POST["delete$id_post"])){
			$query = "DELETE FROM `post` WHERE id_post = '$id_post'";
			$query2 = "DELETE FROM `comentario` WHERE id_post = '$id_post'";
			$data = mysql_query($query) or die();
			$data2 = mysql_query($query2) or die();
			$sub = ($_SERVER["SCRIPT_NAME"]);
			header ("Location: $sub?tag=$id_plant");

		}
		echo '</div>';
}



?>

</form>
</body>
</html>
