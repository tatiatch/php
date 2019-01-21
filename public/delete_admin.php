<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php
	$id = $_GET['id'];
	$query = "DELETE FROM admins WHERE id={$id}";
	$result=mysqli_query($connection, $query);

	if($result&&mysqli_affected_rows($connection)==1){
		$_SESSION["message"]="Admin was deleted";
		redirect_to("manage_admins.php");
	}else{
		$_SESSION["message"]="Admin delition failed";
		redirect_to("manage_admins.php");
	}
?>