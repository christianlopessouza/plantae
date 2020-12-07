<?php
$cookie_loged = $_COOKIE['login'];

if (!isset($cookie_loged)){
	header("Location: login.php");
}

include ("/layout_main.php");

$plantas_own = mysql_query("SELECT * FROM planta ORDER BY id DESC");

while($planta=mysql_fetch_assoc($postagem)){
	$id = $planta['id'];
	echo 
	'
	<a style="display:block" href="plt.php?tag='.$id.'">
	<div class="posta" id="'.$id.'">
	<p>'.$planta['nome']. ' - ' .$planta["nome_cient"].'</p>		
	<img src="upload/'.$planta['imagem'].'" width="250px"/>



	</div></a>';
?>
