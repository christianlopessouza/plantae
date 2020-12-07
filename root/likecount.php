<?php
$connect = mysql_connect('localhost','root','usbw') or die ("Não foi possivel se conectar ao server");
$db = mysql_select_db('amorgan',$connect) or die ("Não é impossível acessar o Banco de Dados");

if (isset($_POST['liked'])){
	$tipo = $_POST['tipo'];
	$id_planta = $_POST['id_planta'];
	$id_user = $_POST['id_user'];

	$sql = mysql_query("INSERT INTO `like` (`id_user`,`tipo`,`id_obj`) VALUES ('$id_user','$tipo','$id_planta')");

	$verify_like_plt = mysql_query("SELECT * FROM `LIKE` WHERE id_obj = '$id_planta' AND tipo = '$tipo'");
	$saida = mysql_num_rows($verify_like_plt);


	echo json_encode(array("saida"=>$saida));


}
?>