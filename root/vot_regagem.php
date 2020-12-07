<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");

if (isset($_POST['enviar_r'])){
    $zero = "0";

    if ((int)$_POST['agua']>10 or (int)$_POST['temp_agua']> 10){
    $agua = substr($_POST['agua']?$_POST['agua']:$_POST['temp_agua'],0,-1) . $zero;
    }else{
    $agua = $_POST['agua']?$_POST['agua']:$_POST['temp_agua'];    
    }

    $query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Regagem','$agua')");  

    header("Location: plt.php?tag=".$id_plant."");
  }

if (isset($_POST['editar_r'])){
  $zero = "0";

  if ((int)$_POST['agua']>10 or (int)$_POST['temp_agua']> 10){
  $agua = substr($_POST['agua']?$_POST['agua']:$_POST['temp_agua'],0,-1) . $zero;
  }else{
  $agua = $_POST['agua']?$_POST['agua']:$_POST['temp_agua'];    
  }

  $query = mysql_query("UPDATE `votos` SET info='$agua' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Regagem'");

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

    echo '<h3>Regagem</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Regagem' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_agu = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Regagem' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

      $cont_linhas = mysql_num_rows($tp_agu);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_agu)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"];   

      $tp_agu_agu = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Regagem' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_agu_agu, 0);           
         if ($vNome != $opcao){
           echo '
           <input type="radio" name="agua" value="' .$vNome. '">' .$vNome .' dias ('.$vQuantidade.' votos)<br>';
       }
      }
    }
  

if (!isset($_COOKIE['login'])){
    echo '
  <input type="submit" name= "enviar_no" value="Enviar">';

}else{
    if ($voted == 1){

      $tp_agu_1 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Regagem' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_agu_1, 0);

      $tp_agu_2 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Regagem'");     
      $opcao_2 = mysql_result($tp_agu_2, 0);

      echo '<br><br><div class="myvote">✅<b>'.$opcao.' dia(s) (' . $opcao_2 . ' votos)</div></b><br><br>';




    echo '
  <input type="submit" name= "editar_r" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar_r" value="Enviar">';
}
}
  echo '
  <input type="number" name= "temp_agua" placeholder="Regagem"><br>
  <input type="radio" name="agua" value="0" style="display:none" checked>
  <br>'; 

    ?>
</form>
</body>
</head>
</html>