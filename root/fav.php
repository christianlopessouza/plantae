
<?php
include ("/layout_myplanta.php");

echo '<div class="titulo">
          favoritas
        </div>';
if (!isset($_COOKIE['login'])){
	echo '<h1 style="font-family:Comfortaa">Não é possível entrar sem estar logado, por favor faça login para vizualizar sua plantação</h1>
		<form>
		<input type="submit" formaction="login.php" value="Fazer Login"></form>';
}else{
$cookie_loged = $_COOKIE["login"];
$teste = mysql_query("SELECT id FROM usuario WHERE email ='$cookie_loged'");
$id_usuario = mysql_result($teste, 0);
$plantas_fav = mysql_query("SELECT * FROM favoritas WHERE id_user = '$id_usuario'");
if (mysql_num_rows($plantas_fav) < 1){
	echo '<h1 style="font-family:Comfortaa">Nenhuma Planta foi adicionada ainda como favorita</h1>';
}else{
	echo '<div class="flex-wrap">';	

	while($planta=mysql_fetch_assoc($plantas_fav)){
		  $id = $planta['id_planta'];
		  $info_planta = mysql_query("SELECT * FROM planta WHERE '$id' = id");
		  while($planta_copy = mysql_fetch_assoc($info_planta)){
          echo '<a style="display:block;text-decoration:none;color:black;"   href="plt.php?tag='.$id.'">
          		<div class="col-3 center">
            	<div style="background-image: url(upload/'.$planta_copy['imagem'].')" class="caixaplanta">

            </div>
            <p class="nomes">'.$planta_copy['nome']. '</p><p class="nomes_c">' .$planta_copy["nome_cient"].'<p></a>	
          </div>';
		      }
			}
	}
}

	?>



