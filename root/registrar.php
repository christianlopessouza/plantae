<?php
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");

if (isset($_POST['enviar'])){
	$username = $_POST['username'];
	$senha = $_POST['senha'];
	$email = $_POST['email'];
	$confirmsenha = $_POST['senha2'];
	$verificar_email = mysql_query("SELECT email FROM usuario WHERE email = '$email' ");
	$cont_linhas_email = mysql_num_rows($verificar_email);
	if ($cont_linhas_email > 0){
		echo "<p>Email já Cadastrado<p>";
	}elseif ($username > 0){
		echo "<h2>Nome de Usuario já Cadastrado</h2>"	;		
	}elseif($senha == '' OR $username == '' OR $email == '' OR $confirmsenha == '') {
		echo '<p>Preencha todos os campos</p>';	
	}elseif (strlen($senha) < 6){
		echo 'Senha com mais de 6 digitos!<p';
	}elseif ($confirmsenha != $senha){
		echo '<p>As senhas não coincidem<p>';
	}else{
		$verificar_quantidade = mysql_query("SELECT * FROM usuario");

		$cont_linhas = mysql_num_rows($verificar_quantidade);

		$query = "INSERT INTO usuario (`id`,`username`,`senha`,`email`,`tipo`) VALUES ('$cont_linhas','$username','$senha','$email','c')";
		$data = mysql_query($query) or die (mysql_error());
		if ($data){
			setcookie("login", $email);
			header("Location: ./");
		}else{
			echo "<h3> Houve problema ao add<br>";
		}
	}
}



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">s
    <meta name="viewport" content="width=device-width">
    <title>plantae</title>
    <link href="style_reg.css" rel="stylesheet" type="text/css" />
    <link href="kiki.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:700&display=swap" rel="stylesheet">
  </head>
  <body>

    <div class="container">

      <div class="flex-wrap">

        <div class="col-12 center login">
            
          <h2>Inscreva-se no</h2>

          <h1>plantae</h1>

          <form method="POST">
            <input type="text" name="email" placeholder="E-mail">
            <input type="text" name="username" placeholder="Nome de Usuário">
            <input type="password" name="senha" placeholder="Senha">
            <input type="password" name="senha2" placeholder="Confirmar Senha">
            <input class="submit" type="submit" name="enviar" value="Inscrever-se">
          </form>

          <h3>Já tem conta?<a href="login.php"> Faça login!</a></h3>
        
        </div>

      </div>
    
    </div>

    <script src="script.js"></script>
  </body>
</html>