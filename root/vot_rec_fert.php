<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
$lista_fert = array("","Orgânico","Mineral","Químico");


if (isset($_POST['enviar_f'])){
  $fert_rec = $_POST['tpfert']?$_POST['tpfert']:$_POST['fertilizati'];

  $query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Fert_Rec','$fert_rec')"); 
  header("Location: plt.php?tag=".$id_plant."");

  }

if (isset($_POST['editar_f'])){
  $fert_rec = $_POST['tpfert']?$_POST['tpfert']:$_POST['fertilizati'];

  $query = mysql_query("UPDATE `votos` SET info='$fert_rec' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Fert_Rec'");
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

    echo '<h3>Fert Rec</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Fert_Rec' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_fert = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Fert_Rec' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

      $cont_linhas = mysql_num_rows($tp_fert);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_fert)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"];
       $key = array_search($vNome, $lista_fert);
       $tp_fert_fert = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Fert_Rec' AND $id_usuario = id_user");
       $opcao = mysql_result($tp_fert_fert, 0);
      
         if ($vNome != $opcao){
           echo '
           <input type="radio" name="tpfert" value="' .$vNome. '">' .$vNome .' ('.$vQuantidade.' votos)<br>';
       }
      }
    }
  

if (!isset($_COOKIE['login'])){
    echo '
  <input type="submit" name= "enviar_no" value="Enviar">';

}else{
    if ($voted == 1){

      $tp_fert_2 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Fert_Rec' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_fert_2, 0);

      $tp_fert_3 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Fert_Rec'");     
      $opcao_2 = mysql_result($tp_fert_3, 0);

      echo '<br><br><div class="myvote">✅<b>'.$opcao.' (' . $opcao_2 . ' votos)</div></b><br><br>';




    echo '
  <input type="submit" name= "editar_f" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar_f" value="Enviar">';
}
}

  echo '
  <input type="text" name="fertilizati">'
    ?>
</form>
</body>
</head>
</html>