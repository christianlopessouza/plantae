<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");

if (isset($_POST['enviar_co'])){
  $zero = "0";

  if ((int)$_POST['tcolheita']>10 or (int)$_POST['temp_colheita']> 10){
  $tcolheita = substr($_POST['tcolheita']?$_POST['tcolheita']:$_POST['temp_colheita'],0,-1) . $zero;
  }else{
  $tcolheita = $_POST['tcolheita']?$_POST['tcolheita']:$_POST['temp_colheita'];   
  }

  $query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Tempo Colheita','$tcolheita')"); 

  header("Location: plt.php?tag=".$id_plant."");
}

if (isset($_POST['editar_co'])){
  $zero = "0";

  if ((int)$_POST['tcolheita']>10 or (int)$_POST['temp_colheita']> 10){
  $tcolheita = substr($_POST['tcolheita']?$_POST['tcolheita']:$_POST['temp_colheita'],0,-1) . $zero;
  }else{
  $tcolheita = $_POST['tcolheita']?$_POST['tcolheita']:$_POST['temp_colheita'];   
  }

  $query = mysql_query("UPDATE `votos` SET info='$tcolheita' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Tempo Colheita'");

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

    echo '<h3>Tempo de Colheita</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Tempo Colheita' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_col = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Tempo Colheita' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

      $cont_linhas = mysql_num_rows($tp_col);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_col)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"];

      $tp_col_col = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Tempo Colheita' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_col_col, 0);

         if ($vNome != $opcao){
           echo '
           <input type="radio" name="tcolheita" value="' .$vNome. '">' .$vNome .' cm ('.$vQuantidade.' votos)<br>';
       }
      }
    }
  

if (!isset($_COOKIE['login'])){
    echo '
  <input type="submit" name= "enviar_no" value="Enviar">';

}else{
    if ($voted == 1){

      $tp_col_2 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Tempo Colheita' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_col_2, 0);

      $tp_col_3 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Tempo Colheita'");     
      $opcao_2 = mysql_result($tp_col_3, 0);

      echo '<br><br><div class="myvote">✅<b>'.$opcao.' dia(s) (' . $opcao_2 . ' votos)</div></b><br><br>';



    echo '
  <input type="submit" name= "editar_co" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar_co" value="Enviar">';
}
}
  echo '
  <input type="number" name= "temp_colheita" placeholder="Tempo de Colheita"><br>
  <input type="radio" name="tcolheita" value="0" style="display:none" checked>
  <br>'; 

    ?>
</form>
</body>
</head>
</html>