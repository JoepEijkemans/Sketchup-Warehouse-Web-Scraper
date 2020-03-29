<?php

Require_Once($_SERVER['DOCUMENT_ROOT'].'/config.php');


$Likes = $_POST['Likes'];
$Views = $_POST['Views'];
$Downloads = $_POST['Downloads'];
$URL = $_POST['URL'];



$sql = "UPDATE SketchupWarehouseModels SET Likes = ?, Views = ?, Downloads = ? WHERE URL = ?";
$stmtselect = $db->prepare($sql);
$result = $stmtselect->execute([$Likes, $Views, $Downloads, $URL]);

if($result){
	//$user = $stmtselect->fetch(PDO::FETCH_ASSOC);
	if($stmtselect->rowCount() > 0){
		echo '1';
	}
	else{
		echo $result;
	}	
}
else {
	echo 'Sorry, encountered an error whilst tying to connect to the database';
}

?>