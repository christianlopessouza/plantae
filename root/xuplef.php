<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
$lista_cat = array("","Hortaliça","Frutífera","Tempero","Turbéculo","Fruta","Especiaria","Verdura","Legume");


if (isset($_POST['enviar'])){
	$category = $_POST['tpcat']?$_POST['tpcat']:$_POST['categoriar'];

	$query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Categoria','$category')");	
	header("Location: plt.php?tag=".$id_plant."");

	}

if (isset($_POST['editar'])){
  $category = $category = $_POST['tpcat']?$_POST['tpcat']:$_POST['categoriar'];

  $query = mysql_query("UPDATE `votos` SET info='$category' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Categoria'");
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

    echo '<h3>Categoria</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Categoria' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_cat = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Categoria' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

    if ($voted !=0 ){
      $sel = mysql_query("SELECT info FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Categoria' AND id_user='$id_usuario'");
      $named = mysql_result($sel, 0);
      $key_answ = array_search($named, $lista_cat);
       if($key_answ!=false){
          unset($lista_cat[$key_answ]);
      }        
    } 

      $cont_linhas = mysql_num_rows($tp_cat);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_cat)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"];
       $key = array_search($vNome, $lista_cat);
       if($key!=false){
          unset($lista_cat[$key]);
      }    
         if ($vNome != $named){
           echo '
           <input type="radio" name="tpcat" value="' .$vNome. '">' .$vNome .' ('.$vQuantidade.' votos)<br>';
       }
      }
    }
  

if (!isset($_COOKIE['login'])){
    echo '
	<input type="submit" name= "enviar_no" value="Enviar">';

}else{
    if ($voted == 1){

      $tp_cat_2 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Categoria' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_cat_2, 0);

      $tp_cat_3 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Categoria'");     
      $opcao_2 = mysql_result($tp_cat_3, 0);

      echo '<b>'.$opcao.' (' . $opcao_2 . ' votos)</b><br>';



    echo '
  <input type="submit" name= "editar" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar" value="Enviar">';
}
}

  echo '<select name="categoriar">
  <option value="" disabled selected hidden>Categoria...</option>';
    foreach ($lista_cat as $categ) {
        echo '<option value="'.$categ.'">'.$categ.'</option>';
  } 
  echo "</select>";

    ?>
</form>
</body>
</head>
</html>