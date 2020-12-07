

<?php
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");
mysql_query("SET charset 'utf8'");
ob_start();
date_default_timezone_set('America/Sao_Paulo');

$id_plant = $_GET["tag"];
if (isset($_COOKIE["login"])){
	$email = $_COOKIE["login"];
	$teste = mysql_query("SELECT id FROM usuario WHERE email = '$email'");
	$id_usuario = mysql_result($teste, 0);	
}
	$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");


#FAVORITO
if (isset($_POST['favorite'])){
	$add = mysql_query("INSERT INTO favoritas VALUES ('$id_usuario','$id_plant')");	
	header("Location: /myplt.php?tag=$id_plant");

}

if (isset($_POST['unfavorite'])){
	$apagar = mysql_query("DELETE FROM favoritas WHERE id_user = '$id_usuario' AND id_planta = '$id_plant'");	
	header("Location: /plt.php?tag=$id_plant");

}
#ADICIONAR

if (isset($_POST['btt-dn'])){
	echo "Hol";
	if (isset($_COOKIE["login"])){
	$info = $_POST['radio'];

	$sql = mysql_query("INSERT INTO denuncia (id_planta,texto) VALUES ('$id_plant','$info')");
	header('Location: /plt.php?tag='.$id_plant.'');
	}
	else{
		header('Location: /login.php');
	}

}


?>


<?php
$yep = ($_SERVER['SCRIPT_NAME']);
if ($yep == '/plt.php'){
	include 'layout_planta.php';
}else{
	include 'layout_myplanta.php';
}

?>

<div class="bg-modal" id="identification">
	<div class="modal-c">
		<div class="close">+</div>
		<div class="info">

		<form method="POST">
		<input type="radio" name="radio" value="Informações Falsas">Informações Falsas
		<br>
		<input type="radio" name="radio" value="Planta Inexistente">Planta Inexistente
		<br>
		<input type="radio" name="radio" value="Utilização de termos">Utilização de termos indigestos
		<br>
		<input type="radio" name="radio" value="Nomes escritos de forma errada">Nomes escritos de forma errada
		<br><br>
		<input type="submit" name="btt-dn" class="submit2" value="ENVIAR">

	</form>
</div>	
</div>
</div>	
	

<div class="bg-modal" id="tama">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_tamanho.php");?>
</div>
</div>
</div>	


<div class="bg-modal" id="colhe">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_colheita.php");?>
</div>
</div>
</div>		

<div class="bg-modal" id="umidader">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_umidade.php");?>
</div>
</div>
</div>	

<div class="bg-modal" id="rega">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_regagem.php");?>
</div>
</div>
</div>	

<div class="bg-modal" id="fertr">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_rec_fert.php");?>
</div>
</div>
</div>	

<div class="bg-modal" id="epc">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_epoca.php");?>
</div>
</div>
</div>	

<div class="bg-modal" id="sol">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_solo.php");?>
</div>
</div>
</div>	

<div class="bg-modal" id="categ">
<div class="modal-c">
<div class="close">+</div>
<div class="info">
<?php include ("/vot_categoria.php");?>
</div>
</div>
</div>	
<?php

while($planta=mysql_fetch_assoc($sql)) {
        echo '<div class="titulo">
          '.$planta['nome'].'
        </div><div class="subtitulo">'.$planta["nome_cient"].'</div>';

        echo'<div class="flex-wrap align-items-center">

          <div class="col-3 center">
            <div style="background-image: url(upload/'.$planta['imagem'].')" class="caixaplanta">
              
            </div>
          </div>';
}
	
######
$array_name = array("Fertilizante Recomendado","Melhor Epoca","Solo","Categoria");
$array_char = array("Fert_Rec","Melhor_Epoca","Solo","Categoria");


$array_name_num = array("Tamanho","Tempo Colheita","Umidade","Regagem");
$array_name_num_b = array("Tamanho","Tempo_Colheita","Umidade","Regagem");

$array_num_loc = array("cm","dia(s)","Cº","dia(s)");


$array_bd_num = array("forma","colheita","umidade","t_agua","t_fert");
$array_bd_char = array("fert","mel_epoca","solo","categoria");


echo '<div class="col-3">';
foreach ($array_name_num as $indice => $value) { ##full##


$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = '$value' AND info > 0 GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1"); 

 $cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		if ($indice==0){
		echo '<div class="progresso">
              <div style="margin-top: 0;" class="text left">
                '. $array_name_num[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$vNome. ' </div> ' .$array_num_loc[$indice]. '
              </div>';
        }else{
  		echo '
               <div class="text left">         
                '. $array_name_num[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$vNome. ' </div> ' .$array_num_loc[$indice]. '
              </div>';      	

        }      
	}
}else{
	$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
	while($planta=mysql_fetch_assoc($sql)){
		if ($indice == 0 or $indice == 4){
		echo '<div class="progresso">
              <div style="margin-top: 0;" class="text left">
                '. $array_name_num[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$planta[$array_bd_num[$indice]]. ' </div> ' .$array_num_loc[$indice]. '
              </div>';
          }else{
 		echo '
                <div class="text left">
            
                '. $array_name_num[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$planta[$array_bd_num[$indice]]. ' </div> ' .$array_num_loc[$indice]. '
              </div>';         	

          }

}
}
}
##full##

	echo '</div>
	</div>
	<div class="col-3">';

foreach ($array_char as $indice => $value) {

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");

$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = '$value' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 1");  

$cont_linhas = mysql_num_rows($busca);
if ($cont_linhas > 0){ 
	while($planta=mysql_fetch_assoc($busca)){
		$vNome = $planta["info"];
		if ($indice==0){
		echo '<div class="progresso">
              <div style="margin-top: 0;" class="text left">
                '. $array_name[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$vNome. ' </div>
              </div>';

		}else{
 			echo '
                <div class="text left">
            
                '. $array_name[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$vNome.  ' </div>
              </div>';    
	}
}

	}else{
	$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
	while($planta=mysql_fetch_assoc($sql)){
		if ($indice==0){

		echo '<div class="progresso">
              <div style="margin-top: 0;" class="text left">
                '. $array_name[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$planta[$array_bd_char[$indice]]. ' </div>
              </div>';
        }else{
 			echo '
                <div class="text left">
            
                '. $array_name[$indice] .'
              </div>
              <div class="numero left">
                <div class="num">' .$planta[$array_bd_char[$indice]]. ' </div>
              </div>'
              ; 
        }
	}	
}

}##full##









	if (isset($_COOKIE["login"])){
	$verify_like_us = mysql_query("SELECT * FROM `LIKE` WHERE id_user = '$id_usuario' AND id_obj = '$id_plant' AND tipo = 'Planta'");
	$count_like_user = mysql_num_rows($verify_like_us);


}
	$verify_like_plt = mysql_query("SELECT * FROM `LIKE` WHERE id_obj = '$id_plant' AND tipo = 'Planta'");

	$count_like_plant = mysql_num_rows($verify_like_plt);

	if (isset($_COOKIE["login"])){

    if ($count_like_user == 0){
			$btt = '<img alt="" src="https://imgur.com/SeYVGmt.png" 
        style="height: 40px; width: 40px" id="PgPLanta" class="like" />';
    }else{
    	$btt = '<img alt="" src="https://imgur.com/k3cRVmA.png" 
        style="height: 40px; width: 40px" id="PgPLanta" class="unlike" />';
    }
	}
    else{
    	$btt = '<img alt="" src="https://imgur.com/SeYVGmt.png" 
        style="height: 40px; width: 40px" id="sub" class="lgn" />';
    }

	echo '</div></div>
          <div class="col-3">
          <div class="progresso2">'. $btt. ' <text id="num">'. $count_like_plant .'</text> 

         
          likes
            </div>';



 	if (isset($_COOKIE["login"])){
		$x = mysql_query("SELECT * FROM favoritas WHERE id_user = '$id_usuario' AND id_planta = '$id_plant'");
		if (mysql_num_rows($x) == 0){
			echo '<form method="post">
			<br><input class="submit3" type="submit" name="favorite" value="Favoritar">
			</form>';
		}else{
			echo '<form method="post">
			<br><input class="submit3" type="submit" name="unfavorite" value="Desfavoritar">
			</form>';
		}
	}     
	echo'      
    <button class="submit" type="submit" id="submiti">
    <i class="fa fa-exclamation-triangle">
    </i> Denunciar</button>
    </div>
    </div>';


############ EXIBIÇÃO DOS 3 PRIMEIROS VOTOS NO CARD
        echo '<div class="titulo" id="menor">
          votos
        </div>';

	echo "<div class='flex-wrap align-items-center'>";
foreach ($array_name_num as $indice => $value){
	$lst = array();
	$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
	$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = '$value' AND info > 0 GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 3");

	$qtt_busca = mysql_query("SELECT COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = '$value' AND info > 0");

	while ($lin = mysql_fetch_array($qtt_busca)){
		$qtt = $lin[0];
	}

	while ($row = mysql_fetch_array($busca,MYSQL_ASSOC)){
		$percent = round(($row["quantidade"]/$qtt),2)*100;
		array_push($lst,array($row["info"],$percent,$row["quantidade"]));

	}
	echo "<br><br>";
	echo "<div class='center votos'>". $array_name_num[$indice]."";


	if (count($lst)!=0){
		if (isset($_COOKIE["login"])){
			$id_user = $_COOKIE["login"];
			$my_vote = mysql_query("SELECT info FROM votos WHERE id_user = '$id_usuario' AND id_planta = '$id_plant' AND '$value' = tipo");
			$rows = mysql_num_rows($my_vote);

			if ($rows == 1){
			$result = mysql_result($my_vote, 0);	
			$cont_linhas = mysql_num_rows($my_vote);
			if ($cont_linhas > 0){
				echo '<br><div class="myvote">✅ '. $result ." " . $array_num_loc[$indice] . "</div>"; 

			}
		}
}
	foreach ($lst as $indice2 => $value2) {
		echo "<div class='loshermanos'><br>◾ $value2[0] $array_num_loc[$indice] [$value2[1]% | $value2[2] vts]</div>";
	}
	}else{
		echo "<div class='loshermanos'><br>Ainda não houveram votos</div>";
	}
	echo '
	<br><br>
	<input class="submit4" type="submit" id="vote'. $array_name_num_b[$indice] .'" value="votar">
	</div>';
}


foreach ($array_char as $indice => $value){
	$lst = array();
	$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
	$busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = '$value' AND info != '' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC LIMIT 3");

	$qtt_busca = mysql_query("SELECT COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND tipo = '$value' AND info != ''");

	while ($lin = mysql_fetch_array($qtt_busca)){
		$qtt = $lin[0];
	}

	while ($row = mysql_fetch_array($busca,MYSQL_ASSOC)){
		$percent = round(($row["quantidade"]/$qtt),2)*100;
		array_push($lst,array($row["info"],$percent,$row["quantidade"]));
	}

	echo "<br><br>";
	echo "<div class='center votos'>". $array_name[$indice] . "";


	if (count($lst)!=0){
		if (isset($_COOKIE["login"])){
			$my_vote = mysql_query("SELECT info FROM votos WHERE id_user = '$id_usuario' AND id_planta = '$id_plant' AND '$value' = tipo");	

			if (mysql_num_rows($my_vote) == 1){
			$result = mysql_result($my_vote, 0);	
			$cont_linhas = mysql_num_rows($my_vote);
			if ($cont_linhas > 0){
				echo '<br><div class="myvote">✅'. $result ."</div>"; 

			}
		}
	}

	foreach ($lst as $indice2 => $value2) {
		echo "<div class='loshermanos'><br>◾ $value2[0] [$value2[1]% | $value2[2] vts]</div>";

	}


	}else{
		echo "<div class='loshermanos'><br>Ainda não houveram votos</div>";
	}
	echo '<br><br>
	<input class="submit4" type="submit" id="'. $array_char[$indice] .'" value="votar">
	</div>';

}

	echo "</div>";



################################# VOTO  NO POPUP
include ("/forum.php");
include ("/dicas.php");
?>
<br><br>



<hr>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript"></script>
<script>


$(document).on("click","#submiti",function(){
	document.querySelector('#identification').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('.bg-modal').style.display = 'none';

});

$(document).on("click","#voteTamanho",function(){
	document.querySelector('#tama').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#tama').style.display = 'none';

});

$(document).on("click","#voteTempo_Colheita",function(){
	document.querySelector('#colhe').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#colhe').style.display = 'none';

});

$(document).on("click","#voteUmidade",function(){
	document.querySelector('#umidader').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#umidader').style.display = 'none';

});

$(document).on("click","#voteRegagem",function(){
	document.querySelector('#rega').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#rega').style.display = 'none';

});

$(document).on("click","#Fert_Rec",function(){
	document.querySelector('#fertr').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#fertr').style.display = 'none';

});

$(document).on("click","#Melhor_Epoca",function(){
	document.querySelector('#epc').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#epc').style.display = 'none';

});

$(document).on("click","#Solo",function(){
	document.querySelector('#sol').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#sol').style.display = 'none';

});

$(document).on("click","#Categoria",function(){
	document.querySelector('#categ').style.display = 'flex';

});

$(document).on("click",".close",function(){
	document.querySelector('#categ').style.display = 'none';

});
		<?php $one_more = $count_like_plant+1?>;
		$(document).on("click",".like",function(){
	    document.getElementById("PgPLanta").src = "https://imgur.com/k3cRVmA.png"; 
		document.getElementById("PgPLanta").className = "unlike";


			var tipo = 'Planta';
			var id_u = <?php echo $id_usuario?>;
			var id_p = <?php echo $id_plant?>;
			var run = $.ajax({
				url: 'likecount.php',
				type: 'post',
				async: false,
				dataType: 'JSON',
				data: {
				'liked': 1,
				'tipo' : tipo,
				'id_user' : id_u,
				'id_planta' : id_p
			}
	   	 });

			run.done(function(response){
				document.getElementById("num").innerHTML=(response.saida);

	});

	});


	$(document).on("click",".unlike",function(){

    document.getElementById("PgPLanta").src = "https://imgur.com/SeYVGmt.png"; 
	document.getElementById("PgPLanta").className = "like";

           		
		var tipo = 'Planta';
		var id_u = <?php echo $id_usuario?>;
		var id_p = <?php echo $id_plant?>;
		var run = $.ajax({
			url: 'dislikecount.php',
			type: 'post',
			async: false,
			dataType: 'JSON',
			data: {
			'liked': 1,
			'tipo' : tipo,
			'id_user' : id_u,
			'id_planta' : id_p
			}
	   	 });

			run.done(function(response){
				document.getElementById("num").innerHTML=(response.saida);

	});

	});




</script>
</body>
</head>
</html>
