<?php
include ("layout_add.php");
ini_set('default_charset','UTF-8');
mysql_query("SET NAMES utf8");
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");
date_default_timezone_set('America/Sao_Paulo');
$cookie_loged = $_COOKIE['login'];
if (!isset($cookie_loged)){
	echo "beijos";
	header("Location: login.php");
}
if (isset($_POST['add'])){
	$nome = $_POST['nome'];
	if ($nome == ''){
		echo '<p>Preencha o Nome</p>';	
	}else{	
		$nome_sct = $_POST['nome_cientifico'];
		$mel_epoca = $_POST['mel_epoca'];
		$forma = $_POST['forma'];
		$colheita = $_POST['colheita'];
		$t_agua = $_POST['t_agua'];
		$t_fert = $_POST['t_fert'];
		$solo = $_POST['solo'];
		$categoria = $_POST['categoria'];
		$fertilizacao = $_POST['fert'];
		$umidade = $_POST['umidade'];

		if ($_FILES["foto"]["error"] > 0){
			$imagem = "padrao.png";
		}else{
		$imagem = $x.$_FILES["foto"]["name"];
		move_uploaded_file($_FILES["foto"]["tmp_name"],"upload/".$imagem);
		}

		$verificar_quantidade = mysql_query("SELECT * FROM planta");
		$cont_linhas = mysql_num_rows($verificar_quantidade);

		$query = "INSERT INTO planta (id,nome,nome_cient,mel_epoca,likes,forma,solo,imagem,t_agua,colheita,umidade,categoria,fert,t_fert,denuncia) VALUES ('$cont_linhas','$nome','$nome_sct','$mel_epoca',0,'$forma','$solo','$imagem','$t_agua','$colheita','$umidade','$categoria','$fertilizacao','$t_fert',0)";
		$data = mysql_query($query) or die();
		if ($data){
			header ("Location: ./");
		}else{
			echo "<p>Parece que aconteceu algum erro, tente novamente mais tarde</p>";
			}	
		}
	}



?>

<!DOCTYPE html>
<meta charset="UTF-8">

<html>
<head>



	</style>
	<title>
	Beta v32
		</title>
</head>
<body>
      <div class="titulo">
          adicionar
        </div>

      <div class="col-12 col-8-md col-10-lg center menu">

        <div class="flex-wrap" id="adicionar">

          <form method="POST" enctype="multipart/form-data"><br>
          <input class="input" type="text" name= "nome" placeholder="Nome" ><br>
          <input class="input" type="text" name= "nome_cientifico" placeholder="Nome Científico" >	

          <br><div class="myvote">Informações</div><br>
          <select class="input" name="mel_epoca">
            <option value="Verão">Verão</option>
            <option value="Inverno">Inverno</option>
            <option value="Outono">Outono</option>
            <option value="Primavera">Primavera</option>	
          </select><br>

          <input class="input" type="number" name= "forma" placeholder="Formato (tamanho)"><br>
          <input class="input" type="number" name= "colheita" placeholder="Tempo de Colheita" ><br>	
          <input class="input" type="number" name= "t_agua" placeholder="Ciclo da Água" ><br>
          <input class="input" type="text" name= "fert" placeholder="Fertilizante Recomendado"><br>			
          <input class="input" type="number" name= "t_fert" placeholder="Ciclo Fertilizante" ><br>
          <input class="input" type="number" name= "umidade" placeholder="Média Umidade" ><br>

          <select class="input" name="solo">
            <option value="Arenoso">Arenoso</option>
            <option value="Terra Preta">Terra Preta</option>
            <option value="Terra Roxa">Terra Roxa</option>
            <option value="Terra">Terra</option>	
            <option value="Argiloso">Argiloso</option>	
          </select><br>

          <select class="input" name="categoria">
            <option value="Hortaliça">Hortaliça</option>
            <option value="Frutífera">Frutífera</option>
            <option value="Tempero">Tempero</option>	
          </select><br>

          
          <label for="file-input">
            <img src ="https://cdn0.iconfinder.com/data/icons/super-mono-sticker/icons/camera_sticker.png" title="Upload de Imagem"/>
          </label>
          <input class="btn" type = "submit" value = "Adicionar" name= "add" />
          <input type = "file" id = "file-input" name= "foto" hidden />			
          </form>

        </div>

      </div>

    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


</body>
</html>