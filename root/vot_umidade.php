<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");

if (isset($_POST['enviar_u'])){
    $zero = "0";

    if ((int)$_POST['tumidade']>10 or (int)$_POST['temp_umidade']> 10){
    $tumidade = substr($_POST['tumidade']?$_POST['tumidade']:$_POST['temp_umidade'],0,-1) . $zero;
    }else{
    $tumidade = $_POST['tumidade']?$_POST['tumidade']:$_POST['temp_umidade'];   
    }

    $query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Umidade','$tumidade')"); 

    header("Location: plt.php?tag=".$id_plant."");
  }

if (isset($_POST['editar_u'])){
  $zero = "0";

  if ((int)$_POST['tumidade']>10 or (int)$_POST['temp_umidade']> 10){
  $tumidade = substr($_POST['tumidade']?$_POST['tumidade']:$_POST['temp_umidade'],0,-1) . $zero;
  }else{
  $tumidade = $_POST['tumidade']?$_POST['tumidade']:$_POST['temp_umidade'];   
  }

  $query = mysql_query("UPDATE `votos` SET info='$tumidade' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Umidade'");

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

    echo '<h3>Umidade</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Umidade' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_umi = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Umidade' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

      $cont_linhas = mysql_num_rows($tp_umi);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_umi)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"]; 
      $tp_umi_umi = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Umidade' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_umi_umi, 0);            
         if ($vNome != $opcao){
           echo '
           <input type="radio" name="tumidade" value="' .$vNome. '">' .$vNome .' Cº ('.$vQuantidade.' votos)<br>';
       }
      }
    }
  

if (!isset($_COOKIE['login'])){
    echo '
  <input type="submit" name= "enviar_no" value="Enviar">';

}else{
    if ($voted == 1){

      $tp_umi_2 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Umidade' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_umi_2, 0);

      $tp_umi_3 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Umidade'");     
      $opcao_2 = mysql_result($tp_umi_3, 0);

      echo '<br><br><div class="myvote">✅<b>'.$opcao.' Cº (' . $opcao_2 . ' votos)</div></b><br><br>';



    echo '
  <input type="submit" name= "editar_u" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar_u" value="Enviar">';
}
}
  echo '
  <input type="number" name= "temp_umidade" placeholder="Umidade"><br>
  <input type="radio" name="tumidade" value="0" style="display:none" checked>
  <br>'; 

    ?>
</form>
</body>
</head>
</html>