<?php

if (isset($_POST["enviar"])){
	$texto = $_POST["nota"];
	if ($texto != ''){
	$adiciona = mysql_query("INSERT INTO notas VALUES ('$id_plant','$texto','$id_usuario','')");
	header("Location: /myplt.php?tag=$id_plant");
}
}
?>

<!DOCTYPE html>
<html>
<body>
<h3>Notes</h3>
</script>
<br>
<form method="POST">
<textarea rows="4" cols="50" name="nota" placeholder="Escreva uma anotação"></textarea><br>
<input class="submit" name="enviar" type="submit" value="Guardar">

<?php
$notinhas = mysql_query("SELECT * FROM notas WHERE id_user = '$id_usuario' AND id_myplant = '$id_plant'");
while ($anotacao=mysql_fetch_assoc($notinhas)) {
 	$idnota = $anotacao['id_nota'];
	echo "<br>" . $anotacao['texto'] . "<br><input type='submit' name='btt$idnota' value= 'D'/>";

	if (isset($_POST["btt$idnota"])){
	$apagar = mysql_query("DELETE FROM notas WHERE '$idnota' = id_nota");
	header("Location: /myplt.php?tag=$id_plant");
			

	}
}
echo "<hr>";

?>
<hr>
</form>
</body>
</html>
