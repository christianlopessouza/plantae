<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");
$lista_mel_epoca = array("","Verão","Inverno","Outono","Primavera","1º Semestre","2º Semestre","Anual");

if (isset($_POST['enviar_e'])){
  $epoca = $_POST['mepoca']?$_POST['mepoca']:$_POST['melhor_epoca'];

  $query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Melhor_Epoca','$epoca')"); 
  header("Location: plt.php?tag=".$id_plant."");

  }

if (isset($_POST['editar_e'])){
  $epoca = $_POST['mepoca']?$_POST['mepoca']:$_POST['melhor_epoca'];

  $query = mysql_query("UPDATE `votos` SET info='$epoca' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Melhor_Epoca'");
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

    echo '<h3>Melhor Epoca</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Melhor_Epoca' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_epoca = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Melhor_Epoca' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

      $cont_linhas = mysql_num_rows($tp_epoca);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_epoca)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"];

      $tp_epoca_epoca = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Melhor_Epoca' AND $id_usuario = id_user"); 

      $opcao = mysql_result($tp_epoca_epoca, 0);   
         if ($vNome != $opcao){
           echo '
           <input type="radio" name="mepoca" value="' .$vNome. '">' .$vNome .' ('.$vQuantidade.' votos)<br>';
       }
      }
    }
  

if (!isset($_COOKIE['login'])){
    echo '
  <input type="submit" name= "enviar_no" value="Enviar">';

}else{
    if ($voted == 1){

      $tp_epoca_2 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Melhor_Epoca' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_epoca_2, 0);

      $tp_epoca_3 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Melhor_Epoca'");     
      $opcao_2 = mysql_result($tp_epoca_3, 0);

      echo '<br><br><div class="myvote">✅<b>'.$opcao.' (' . $opcao_2 . ' votos)</div></b><br><br>';



    echo '
  <input type="submit" name= "editar_e" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar_e" value="Enviar">';
}
}

  echo '<select name="melhor_epoca">
  <option value="" disabled selected hidden>Fert Recomendado...</option>';
    foreach ($lista_mel_epoca as $epc) {
        echo '<option value="'.$epc.'">'.$epc.'</option>';
  } 
  echo "</select>";

    ?>
</form>
</body>
</head>
</html>