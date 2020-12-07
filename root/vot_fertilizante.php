<?php
#PARTE DO CABEÇALHO
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");
$cookie_loged = $_COOKIE['login'];
if (!isset($cookie_loged)){
	header("Location: login.php");
}
date_default_timezone_set('America/Sao_Paulo');

$teste = mysql_query("SELECT id FROM usuario WHERE email ='$cookie_loged'");
$id_usuario = mysql_result($teste, 0);	
$id_usuario_int = (int)$id_usuario;


#IDENTIFICAR PAGINA REFERENTE A PLANTA
$id_plant = $_GET["tag"];

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");


#ADICIONAR
	if (isset($_POST['enviar'])){
		$zero = "0";

		if ((int)$_POST['tfert']>10 or (int)$_POST['temp_fert']> 10){
		$tfert = substr($_POST['tfert']?$_POST['tfert']:$_POST['temp_fert'],0,-1) . $zero;
		}else{
		$tfert = $_POST['tfert']?$_POST['tfert']:$_POST['temp_fert'];		
		}

		$query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Fertilizante','$tfert')");	

		header("Location: plt.php?tag=".$id_plant."");
	}

?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
<body>
<form method="POST">

	    <?php

    #-------------------------------------------------------#
    echo '<h3>Tempo Fertilização</h3>' ; 
    $t_fert_busca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Fertilizante' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC");    
    $cont_linhas = mysql_num_rows($t_fert_busca);
    if ($cont_linhas > 0){
    while($linha = mysql_fetch_array($t_fert_busca)){
       $vNome      = $linha["info"];
       $vQuantidade = $linha["quantidade"];
       if ($vNome > 0){
      
       echo '<form>
       <input type="radio" name="tfert" value="' .$vNome. '">' .$vNome .' dias ('.$vQuantidade.' votos)<br>';
   }
  }
}
  echo '
  <input type="number" name= "temp_fert" placeholder="Tempo de Agua"><br>
	<input type="radio" name="tfert" value="0" style="display:none" checked>
  <br>
  <input type="submit" name= "enviar" value="Enviar"><br>';	
	;
	?>
