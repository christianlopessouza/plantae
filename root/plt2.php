<?php
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");

date_default_timezone_set('America/Sao_Paulo');

$id_plant = $_GET["tag"];

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");


#ADICIONAR
	if (isset($_POST['enviar'])){
		$zero = "0";

		if ((int)$_POST['forma']>10 or (int)$_POST['tamanho']> 10){
		$forma = substr($_POST['forma']?$_POST['forma']:$_POST['tamanho'],0,-1) . $zero;
		}else{
		$forma = $_POST['forma']?$_POST['forma']:$_POST['tamanho'];		
		}

		$query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Tamanho','$forma')");	

		header("Location: plt.php?tag=".$id_plant."");
	}

?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
<body>



	
<?php

while($planta=mysql_fetch_assoc($sql)){
	echo '

		<p>'.$planta['nome']. ' - ' .$planta["nome_cient"].'</p>	
		<img src="upload/'.$planta['imagem'].'" width="250px"/>	';
}

######

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Tamanho' AND info > 0 GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Tamanho:</b> ' .$vNome.' cm</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Tamanho:</b> ' .$planta["forma"].' cm</p>';}
}
echo '<a href="vot_tamanho.php?tag='.$id_plant.'">VOTAR</a>';

######

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Solo' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Tipo de Solo:</b> ' .$vNome.'</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Tipo de Solo:</b> ' .$planta["solo"].'</p>';}
}
echo '<a href="vot_solo.php?tag='.$id_plant.'">VOTAR</a>';

######

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Fert_Rec' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Fertilização Recomendada:</b> ' .$vNome.'</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Fertilização Recomendada:</b> ' .$planta["fert"].'</p>';}
}
echo '<a href="vot_rec_fert.php?tag='.$id_plant.'">VOTAR</a>';

######

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Colheita' AND info > 0 GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Tempo de Colheita:</b> ' .$vNome.' dias</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Tempo de Colheita:</b> ' .$planta["colheita"].' dias </p>';}
}
echo '<a href="vot_colheita.php?tag='.$id_plant.'">VOTAR</a>		';

######

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Categoria'  GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Categoria:</b> ' .$vNome.'</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Categoria:</b> ' .$planta["categoria"].'</p>';}
}
echo '<a href="vot_categoria.php?tag='.$id_plant.'">VOTAR</a>		';

######

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Umidade' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Umidade:</b> ' .$vNome.'Cº</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Umidade:</b> ' .$planta["umidade"].'Cº</p>';}
}
echo '<a href="vot_umidade.php?tag='.$id_plant.'">VOTAR</a>';

######

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Agua' AND info > 0 GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Ciclo Regagem:</b> ' .$vNome.' dias</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Ciclo Regagem:</b> ' .$planta["t_agua"].' dias</p>';}
}
echo '<a href="vot_regagem.php?tag='.$id_plant.'">VOTAR</a>	';

######


$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Fertilizante' AND info > 0 GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Ciclo Fertilização:</b> ' .$vNome.' dias</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Ciclo Fertilização:</b> ' .$planta["t_fert"].' dias</p>';}
}
echo '<a href="vot_fertilizante.php?tag='.$id_plant.'">VOTAR</a>';

######


$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = 'Epoca' AND info > 0 GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  
$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		echo '<p> <b>Melhor Epoca:</b> ' .$vNome.'</p>';}
	}else{
	while($planta=mysql_fetch_assoc($sql)){
		echo '<p> <b>Melhor Epoca:</b> ' .$planta["mel_epoca"].'</p>';}
}
echo '<a href="vot_epoca.php?tag='.$id_plant.'">VOTAR</a>';

######

	while($planta=mysql_fetch_assoc($busca)){
	echo '		
		<p> ' .$planta["likes"].' <b>Likes</b> </p>
';
}


?>
<hr>

<form method="POST">

	    <?php

    #-------------------------------------------------------#
    echo '<h3>Formato</h3>' ; 
    $forma_busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Tamanho' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC");    
    $cont_linhas = mysql_num_rows($forma_busca);
    if ($cont_linhas > 0){
    while($linha = mysql_fetch_array($forma_busca)){
       $vNome      = $linha["info"];
       $vQuantidade = $linha["quantidade"];
       if ($vNome > 0){
       echo '<form>
       <input type="radio" name="forma" value="' .$vNome. '">' .$vNome .'cm ('.$vQuantidade.' votos)<br>';
   }
  }
 }

	echo '
	<input type="number" name="tamanho" placeholder="Formato (tamanho)"><br>

	<input type="radio" name="forma" value="0" style="display:none" checked>
	<br>
	<input type="submit" name= "enviar" value="Enviar"><br>';
	;
	?>



</body>
</head>
</html>