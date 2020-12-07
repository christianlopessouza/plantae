<?php
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");


if (isset($_POST['enviar'])){
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$verificar = mysql_query("SELECT * FROM usuario WHERE email = '$email' AND senha='$senha'");
	if (mysql_num_rows($verificar)<=0){
		echo "<h2>SENHA OU email ERRADOS<h2>"; 
	}
	else{
    setcookie("login", $email);
		header("location: ./");
	}
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>plantae</title>
    <link href="style_login.css" rel="stylesheet" type="text/css" />
    <link href="kiki.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:700&display=swap" rel="stylesheet">
  </head>
  <body>

    <div class="flex-wrap">

      <div class="col-12 col-5-md col-3-lg center h100vh hide-sm hide-xs cadastro-bg">
        
      </div>

      <div class="col-12 col-7-md col-9-lg center h100vh hide-sm hide-xs login-bg">
        
      </div>

    </div>

    <div class="container">

      <div class="flex-wrap align-items-center">

        <div class="col-12 col-5-md col-3-lg center login">
            
          <h2>Entre no</h2>

          <h1>plantae</h1>

          <form method="POST">
            <input type="email" name="email" placeholder="E-mail ou usuário">
            <input type="password" name="senha" placeholder="Senha">
            <input class="submit" name="enviar" type="submit" value="Entrar">
          </form>

          <h3>Novo aqui?<a href="registrar.php"> Inscreva-se agora!</a></h3>

          <h3><a href=""> Esqueceu sua senha?</a></h3>

        </div>

        <div class="col-12 col-7-md col-3-lg banner">
          
          <h1><div class="hide-lg">Faça parte do plantae!</div>
          O jeito<br>mais moderno<br> de cuidar<br>da sua horta.</h1>

        </div>

        <div class="col-12 hide-xs hide-sm hide-md col-6-lg safari">
          <img src="https://i.imgur.com/tgWwEXc.png">
        </div>

      </div>

    </div>

    <script src="script.js"></script>
  </body>
</html>


