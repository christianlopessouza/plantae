
<?php
include ("/layout_main.php");
if (isset($_GET['page'])){
$p = $_GET['page'];
$page = "sub/" . $p .".php";

if(file_exists($page)){
 include ($page);
}else{
 include ("sub/geral.php");
}
}else{
 include ("sub/geral.php");

}






?>





</body>
</html>