<?php

#IDENTIFICAR PAGINA REFERENTE A PLANTA

$sql = mysql_query("SELECT * FROM planta WHERE id = '$id_plant'");

if (isset($_POST['enviar_t'])){
    $zero = "0";

    if ((int)$_POST['forma']>10 or (int)$_POST['tamanho']> 10){
    $forma = substr($_POST['forma']?$_POST['forma']:$_POST['tamanho'],0,-1) . $zero;
    }else{
    $forma = $_POST['forma']?$_POST['forma']:$_POST['tamanho'];   
    }

    $query = mysql_query("INSERT INTO votos (id_planta,id_user,tipo,info) VALUES ('$id_plant','$id_usuario','Tamanho','$forma')");  

    header("Location: plt.php?tag=".$id_plant."");
  }

if (isset($_POST['editar_t'])){
    $zero = "0";

    if ((int)$_POST['forma']>10 or (int)$_POST['tamanho']> 10){
    $forma = substr($_POST['forma']?$_POST['forma']:$_POST['tamanho'],0,-1) . $zero;
    }else{
    $forma = $_POST['forma']?$_POST['forma']:$_POST['tamanho'];   
    }

  $query = mysql_query("UPDATE `votos` SET info='$forma' WHERE id_user = '$id_usuario' AND id_planta='$id_plant' AND tipo='Tamanho'");

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

    echo '<h3>Tamanho</h3>' ; 

    if (isset($_COOKIE['login'])){
    $vot_run = mysql_query("SELECT * FROM votos where id_user='$id_usuario' AND tipo='Tamanho' AND id_planta = '$id_plant'");
    $voted = mysql_num_rows($vot_run);
    }else{
      $voted = 0;
    }

    $named = '';
    $tp_tam = mysql_query("SELECT info,COUNT(info) AS quantidade FROM votos WHERE id_planta='$id_plant' AND info != '' AND tipo = 'Tamanho' GROUP BY info HAVING COUNT(info) > 0 ORDER BY quantidade DESC"); 

      $cont_linhas = mysql_num_rows($tp_tam);
      if ($cont_linhas > 0){
      while($linha = mysql_fetch_array($tp_tam)){
           $vNome      = $linha["info"];
           $vQuantidade = $linha["quantidade"];
      $tp_tam_tam = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Tamanho' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_tam_tam, 0);
         if ($vNome != $opcao){
           echo '
           <input type="radio" name="forma" value="' .$vNome. '">' .$vNome .'cm ('.$vQuantidade.' votos)<br>';

       }
      }
    }
  

if (!isset($_COOKIE['login'])){
    echo '
  <input type="submit" name= "enviar_no" value="Enviar">';

}else{
    if ($voted == 1){

      $tp_tam_2 = mysql_query("SELECT info,count(info) FROM votos WHERE id_planta='$id_plant' AND info > 0 AND tipo = 'Tamanho' AND $id_usuario = id_user"); 
      $opcao = mysql_result($tp_tam_2, 0);

      $tp_tam_3 = mysql_query("SELECT count(info) FROM votos WHERE id_planta='$id_plant' AND info = '$opcao' AND tipo = 'Tamanho'");     
      $opcao_2 = mysql_result($tp_tam_3, 0);

      echo '<br><br><div class="myvote">✅<b>'.$opcao.'cm (' . $opcao_2 . ' votos)</div></b><br><br>';



    echo '
  <input type="submit" name= "editar_t" value="Editar">';
}else{
    echo '
  <input type="submit" name= "enviar_t" value="Enviar">';
}
}
  echo '
  <input type="number" name= "tamanho" placeholder="Tamanho"><br>
  <input type="radio" name="forma" value="0" style="display:none" checked>
  <br><br><br><br>'; 

    ?>
</form>
</body>
</head>
</html>