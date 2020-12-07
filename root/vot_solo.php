<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
$lista_sol = array("","Arenoso","Terra Preta","Terra Roxa","Terra Normal","Argiloso");


if (isset($_POST['enviar_s'])){
  $solin = $_POST['tpsol']?$_POST['tpsol']:$_POST['solor'];

  $query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Solo','$solin')"); 
  header("Location: plt.php?tag=".$id_plant."");

  }

if (isset($_POST['editar_s'])){
  $solin = $_POST['tpsol']?$_POST['tpsol']:$_POST['solor'];

  $query = mysql_query("UPDATE `votos` SET info='$solin' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Solo'");
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

    echo '<h3>Solo</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Solo' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_sol = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Solo' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

    if ($voted !=0 ){
      $sel = mysql_query("SELECT info FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Solo' AND id_user='$id_usuario'");
      $named = mysql_result($sel, 0);
      $key_answ = array_search($named, $lista_sol);
       if($key_answ!=false){
          unset($lista_sol[$key_answ]);
      }        
    } 

      $cont_linhas = mysql_num_rows($tp_sol);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_sol)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"];
      $tp_sol_sol = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Solo' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_sol_sol, 0);  
         if ($vNome != $opcao){
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

      $tp_sol_2 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Solo' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_sol_2, 0);

      $tp_sol_3 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Solo'");     
      $opcao_2 = mysql_result($tp_sol_3, 0);

      echo '<br><br><div class="myvote">✅<b>'.$opcao.' (' . $opcao_2 . ' votos)</div></b><br><br>';



    echo '
  <input type="submit" name= "editar_s" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar_s" value="Enviar">';
}
}

  echo '<select name="solor">
  <option value="" disabled selected hidden>Solo...</option>';
    foreach ($lista_sol as $sol) {
        echo '<option value="'.$sol.'">'.$sol.'</option>';
  } 
  echo "</select>";

    ?>
</form>
</body>
</head>
</html>