<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>


<?php
	$id=$_GET["page"];

	$query="DELETE FROM pages WHERE id={$id}";
	$result=mysqli_query($connection, $query);

	if($result&&mysqli_affected_rows($connection)==1){
		$_SESSION["message"]="Page was sucessfully deleted";
		redirect_to("manage_content.php");
	}else{
		$_SESSION["message"]="Page delition failed";
		redirect_to("manage_content.php?page={$id}");
	}
?>