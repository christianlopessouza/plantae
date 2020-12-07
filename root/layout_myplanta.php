<?php
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");

date_default_timezone_set('America/Sao_Paulo');

$postagem = mysql_query("SELECT * FROM planta ORDER BY id DESC");


if (isset($_POST['out'])){
	setcookie("login", null, -1);
	header("Location: index.php");
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>plantae</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="css/planta.css" rel="stylesheet" type="text/css" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <link href="css/kiki.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bitter&display=swap" rel="stylesheet">
	<title>
			PROJECT PLANTAE!
	</title>
</head>
<body>


    <div class="flex-wrap">

      <div class="col-12 col-4-md col-2-lg center barra">

        <div class="plantae">
          plantae
        </div>

        <div> 
          <ul>
            <li><a href="index.php">Início</a></li>            
            <li><a href="fav.php" class="active descubra">Favoritas</a></li>
            <li><a href="post.php">Adicionar Plantas</a></li>
       
            <?php 
            if(isset($_COOKIE['login'])){
                  $email = $_COOKIE["login"];
      $teste = mysql_query("SELECT id FROM usuario WHERE email = '$email'");
      $id_usuario = mysql_result($teste, 0);  
            $type = mysql_query("SELECT tipo FROM usuario WHERE $id_usuario = id");    
            $type = mysql_query("SELECT tipo FROM usuario WHERE $id_usuario = id");

            if($type == 'a'){
                echo '<li><a href="adm_p.php">Perfil</a></li>';
		
        	}
        }
				if (!isset($_COOKIE["login"])){
					echo '<li><form method="POST"><input type="submit" formaction="login.php" name="log" value="LogIn" class="btt_menu"></form></li>';
					echo '<li><form method="POST"><input type="submit" formaction="registrar.php" name="cad" value="Cadastro" class="btt_menu"></a></form></li>';
				}else{

					echo '
					<li>
					<form method="POST">
					<input type="submit" name="out" value="LogOut" class="btt_menu"></a></form></li>
					';

				}
		         ?>
				
	<?php
		if (!isset($_COOKIE["login"])){
			echo "<br><br><p style='font-family:arial'> Ghast090 </p>";
		}else{
		$cookie_loged = $_COOKIE["login"];
		$teste = mysql_query("SELECT username FROM usuario WHERE email ='$cookie_loged'");
		$nome_usuario = mysql_result($teste, 0);	
		echo "<br><br><p style='font-family:arial'> $nome_usuario </p>";

		}
	?>

          </ul>
        </div>

      </div>

      <div class="col-12 col-4-md col-2-lg"></div>

      <div class="col-12 col-8-md col-10-lg center menu">
 












	
	</form>	


<br>
