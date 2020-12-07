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
$id_plant_int = (int)$id_plant;

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");


#LISTA DE ATRIBUTOS DA PLANTA PHP
    $lista_mel_epoca = array("","Verão","Inverno","Outono","Primavera","1º Semestre","2º Semestre","Anual");
    $lista_sol = array("","Arenoso","Terra Preta","Terra Roxa","Terra Normal","Argiloso");
    $lista_cat = array("","Hortaliça","Frutífera","Tempero","Turbéculo");
	$lista_fert = array("","Orgânico","Mineral","Químico");

#ADICIONAR
	if (isset($_POST['enviar'])){
		$zero = "0";

		if ($_POST['forma'] > 10){
		$forma = substr($_POST['forma']?$_POST['forma']:$_POST['tamanho'],0,-1) . $zero;
		}else{
		$forma = $_POST['forma']?$_POST['forma']:$_POST['tamanho'];		
		}

		if ($_POST['agua'] > 10){
		$agua = substr($_POST['agua']?$_POST['agua']:$_POST['temp_agua'],0,-1) . $zero;
		}else{
		$agua = $_POST['agua']?$_POST['agua']:$_POST['temp_agua'];	
		}		

		if ($_POST['tfert'] > 10){
		$t_fert = substr($_POST['tfert']?$_POST['tfert']:$_POST['temp_fert'],0,-1) . $zero;
		}else{
		$t_fert = $_POST['tfert']?$_POST['tfert']:$_POST['temp_fert'];	
		}

		if ($_POST['tcolheita'] > 10){
		$tempo_col = substr($_POST['tcolheita']?$_POST['tcolheita']:$_POST['temp_colheita'],0,-1) . $zero;
		}else{
		$tempo_col = $_POST['tcolheita']?$_POST['tcolheita']:$_POST['temp_colheita'];	
		}

		if ($_POST['tumidade'] > 10){
		$tempo_umid = substr($_POST['tumidade']?$_POST['tumidade']:$_POST['temp_umidade'],0,-1) . $zero;
		}else{
		$tempo_umid = $_POST['tumidade']?$_POST['tumidade']:$_POST['temp_umidade'];	
		}





		$mel_epca = $_POST['mepoca']?$_POST['mepoca']:$_POST['melhor_epoca'];
		$fertilian = $_POST['tpfert']?$_POST['tpfert']:$_POST['fertilizati'];
		$category = $_POST['tpcat']?$_POST['tpcat']:$_POST['categoriar'];
		$solin = $_POST['tpsol']?$_POST['tpsol']:$_POST['solor'];

    echo $_POST['forma'];



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
    echo '<h3>Formato</h3>' ; 
    $forma_busca = mysql_query("SELECT forma,COUNT(forma) AS quantidade FROM voto WHERE id_planta='$id_plant' AND forma > 0 GROUP BY forma HAVING COUNT(forma) > 0 ORDER BY quantidade DESC LIMIT 5");    
    $cont_linhas = mysql_num_rows($forma_busca);
    if ($cont_linhas > 0){
    while($linha = mysql_fetch_array($forma_busca)){
       $vNome      = $linha["forma"];
       $vQuantidade = $linha["quantidade"];
       if ($vNome > 0){
       echo '<form>
       <input type="radio" name="forma" value="' .$vNome. '">' .$vNome .'cm ('.$vQuantidade.' votos)<br>';
   }
  }
 }

	echo '<input type="radio" name="forma" value=""><input type="number" name="tamanho" placeholder="Formato (tamanho)"><br>
	<input type="radio" name="forma" value="0" style="display:none" checked>
	<br>';



    #-------------------------------------------------------#

    echo '<h3>Tempo de Água</h3>' ; 
    $agua_busca = mysql_query("SELECT t_agua,COUNT(t_agua) AS quantidade FROM voto WHERE id_planta='$id_plant' AND t_agua > 0 GROUP BY t_agua HAVING COUNT(t_agua) > 0 ORDER BY quantidade DESC LIMIT 5");    
    $cont_linhas = mysql_num_rows($agua_busca);
    if ($cont_linhas > 0){
    while($linha = mysql_fetch_array($agua_busca)){
       $vNome      = $linha["t_agua"];
       $vQuantidade = $linha["quantidade"];
       if ($vNome > 0){
      
       echo '<form>
       <input type="radio" name="agua" value="' .$vNome. '">' .$vNome .' dias ('.$vQuantidade.' votos)<br>';
   }
  }
}
  echo '<input type="radio" name="agua" value="">
  <input type="number" name= "temp_agua" placeholder="Tempo de Agua"><br>
	<input type="radio" name="agua" value="0" style="display:none" checked>
  <br>';
    #-------------------------------------------------------#

    echo '<h3>Tempo de Fertilizante</h3>' ; 
    $t_fert_busca = mysql_query("SELECT t_fert,COUNT(t_fert) AS quantidade FROM voto WHERE id_planta='$id_plant' AND t_fert > 0 GROUP BY t_fert HAVING COUNT(t_fert) > 0 ORDER BY quantidade DESC LIMIT 5");    
    $cont_linhas = mysql_num_rows($t_fert_busca);
    if ($cont_linhas > 0){
    while($linha = mysql_fetch_array($t_fert_busca)){
       $vNome      = $linha["t_fert"];
       $vQuantidade = $linha["quantidade"];
       if ($vNome > 0){       
       echo '<form>
       <input type="radio" name="tfert" value="' .$vNome. '">' .$vNome .' dias ('.$vQuantidade.' votos)<br>';
   }
  }
}
  echo '<input type="radio" name="tfert" value="">
  <input type="number" name= "temp_fert" placeholder="Tempo de Fertilizante"><br>
	<input type="radio" name="tfert" value="0" style="display:none" checked>
  <br>';
    #-------------------------------------------------------#

    echo '<h3>Tempo de Colheita</h3>' ; 
    $t_colheita = mysql_query("SELECT colheita,COUNT(colheita) AS quantidade FROM voto WHERE id_planta='$id_plant' AND colheita > 0 GROUP BY colheita HAVING COUNT(colheita) > 0 ORDER BY quantidade DESC LIMIT 5");    
    $cont_linhas = mysql_num_rows($t_colheita);
    if ($cont_linhas > 0){
    while($linha = mysql_fetch_array($t_colheita)){
       $vNome      = $linha["colheita"];
       $vQuantidade = $linha["quantidade"];
       if ($vNome > 0){       
       echo '<form>
       <input type="radio" name="tcolheita" value="' .$vNome. '">' .$vNome .' dias ('.$vQuantidade.' votos)<br>';
   }
  }
}
  echo '<input type="radio" name="tcolheita" value="">
  <input type="number" name= "temp_colheita" placeholder="Tempo de Colheita"><br>
	<input type="radio" name="tcolheita" value="0" style="display:none" checked>
  <br>';
    #-------------------------------------------------------#

    echo '<h3>Tempo de Umidade</h3>' ; 
    $t_umidade = mysql_query("SELECT umidade,COUNT(umidade) AS quantidade FROM voto WHERE id_planta='$id_plant' AND umidade > 0 GROUP BY umidade HAVING COUNT(umidade) > 0 ORDER BY quantidade DESC LIMIT 5");    
    $cont_linhas = mysql_num_rows($t_umidade);
    if ($cont_linhas > 0){
    while($linha = mysql_fetch_array($t_umidade)){
       $vNome      = $linha["umidade"];
       $vQuantidade = $linha["quantidade"];
       if ($vNome > 0){
       echo '<form>
       <input type="radio" name="tumidade" value="' .$vNome. '">' .$vNome .' dias ('.$vQuantidade.' votos)<br>';
   }
  }
}
  echo '<input type="radio" name="tumidade" value="">
  <input type="number" name= "temp_umidade" placeholder="Tempo de Umidade"><br>
	<input type="radio" name="tumidade" value="0" style="display:none" checked>
  <br>';

    #-------------------------------------------------------#

    echo '<h3>Melhor Época</h3>' ; 
    $mel_epc = mysql_query("SELECT mel_epoca,COUNT(mel_epoca) AS quantidade FROM voto WHERE id_planta='$id_plant' AND mel_epoca != '' GROUP BY mel_epoca HAVING COUNT(mel_epoca) > 0 ORDER BY quantidade DESC LIMIT 5"); 

      $cont_linhas = mysql_num_rows($mel_epc);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($mel_epc)){
           $vNome      = $linha["mel_epoca"];
           $vQuantidade = $linha["quantidade"];
	 	   $key = array_search($vNome, $lista_mel_epoca);
		   if($key!==false){
			    unset($lista_mel_epoca[$key]);
			}
       	   if ($vNome > 0){
           echo '<form>
           <input type="radio" name="mepoca" value="' .$vNome. '">' .$vNome .' ('.$vQuantidade.' votos)<br>';
       }
     }
    }


      echo '<input type="radio" name="mepoca" value=""><select name="melhor_epoca">
            <option value="" disabled selected hidden>Melhor Época...</option>';
      foreach ($lista_mel_epoca as $epoca) {
        echo '<option value="'.$epoca.'">'.$epoca.'</option>';
      }
    echo '<input type="radio" name="mepoca" value="0" style="display:none" checked><input type="text" name= "melhor_epoca" style="display:none"></select><br>';

    #-------------------------------------------------------#

    echo '<h3>Tipo de Fertilizante</h3>' ; 
    $tp_fert = mysql_query("SELECT fert,COUNT(fert) AS quantidade FROM voto WHERE id_planta='$id_plant' AND fert != '' GROUP BY fert HAVING COUNT(fert) > 0 ORDER BY quantidade DESC LIMIT 5"); 

      $cont_linhas = mysql_num_rows($tp_fert);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_fert)){
           $vNome      = $linha["fert"];
           $vQuantidade = $linha["quantidade"];
	 	   $key = array_search($vNome, $lista_fert);
		   if($key!==false){
			    unset($lista_fert[$key]);
			}        
       	   if ($vNome > 0){
           echo '<form>
           <input type="radio" name="mepoca" tpfert="' .$vNome. '">' .$vNome .' ('.$vQuantidade.' votos)<br>';
       }
     }
  }
    	echo '<input type="radio" name="tpfert" value=""><select name="fertilizati">
    	<option value="" disabled selected hidden>Fertilizante...</option>';
        foreach ($lista_fert as $fertilizate) {
            echo '<option value="'.$fertilizate.'">'.$fertilizate.'</option>';
        }    
    echo '<input type="radio" name="tpfert" value="0" style="display:none" checked>
    <input type="text" name= "fertilizati" style="display:none">

    </select><br>';

    #-------------------------------------------------------#

    echo '<h3>Categoria</h3>' ; 
    $tp_cat = mysql_query("SELECT categoria,COUNT(categoria) AS quantidade FROM voto WHERE id_planta='$id_plant' AND categoria != '' GROUP BY categoria HAVING COUNT(categoria) > 0 ORDER BY quantidade DESC LIMIT 5"); 

      $cont_linhas = mysql_num_rows($tp_cat);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_cat)){
           $vNome      = $linha["categoria"];
           $vQuantidade = $linha["quantidade"];
	 	   $key = array_search($vNome, $lista_cat);
		   if($key!==false){
			    unset($lista_cat[$key]);
			}    
	       if ($vNome > 0){

           echo '<form>
           <input type="radio" name="tpcat" tpfert="' .$vNome. '">' .$vNome .' ('.$vQuantidade.' votos)<br>';
       }
      }
    }
	echo '<input type="radio" name="tpcat" value="0"><select name="categoriar">
	<option value="" disabled selected hidden>Categoria...</option>';
    foreach ($lista_cat as $categ) {
        echo '<option value="'.$categ.'">'.$categ.'</option>';
    }    
    echo '<input type="radio" name="tpcat" value="" style="display:none" checked>
    <input type="text" name= "categoriar" style="display:none">
    </select><br>';

    #-------------------------------------------------------#

    echo '<h3>Tipo de Solo</h3>' ; 
    $tp_sol = mysql_query("SELECT solo,COUNT(solo) AS quantidade FROM voto WHERE id_planta='$id_plant' AND solo != '' GROUP BY solo HAVING COUNT(solo) > 0 ORDER BY quantidade DESC LIMIT 5"); 

      $cont_linhas = mysql_num_rows($tp_sol);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_sol)){
           $vNome      = $linha["solo"];
           $vQuantidade = $linha["quantidade"];
	 	   $key = array_search($vNome, $lista_sol);
		   if($key!==false){
			    unset($lista_sol[$key]);
			}    
	       if ($vNome > 0){

           echo '<form>
           <input type="radio" name="tpsol" value="' .$vNome. '">' .$vNome .' ('.$vQuantidade.' votos)<br>';
       }
      }
    }
	echo '<input type="radio" name="tpsol" value="0"><select name="solor">
	<option value="" disabled selected hidden>Solo...</option>';
    foreach ($lista_sol as $sol) {
        echo '<option value="'.$sol.'">'.$sol.'</option>';
    }    
    echo '<input type="radio" name="tpsol" value="" style="display:none" checked>
    <input type="text" name= "solor" style="display:none">
    </select><br>    
	<input type="submit" name= "enviar" value="Enviar"><br>';
    ?>
</form>
</body>
</head>
</html>