<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>

<?php
	$current_subject=find_subjects_by_id($_GET["subject"]);
	if(!$current_subject){
		//failed to find current subject
		redirect_to("manage_content.php");
	}

	$id=$current_subject["id"];
	
	$page_set=find_pages_for_subjects($id);
	if(mysqli_num_rows($page_set)>0){
		$_SESSION["message"]="Can't delete a subject with pages";
		redirect_to("manage_content.php?subject={$id}");
	}

	
	$query="DELETE FROM subjects WHERE id={$id}";
	$result=mysqli_query($connection, $query);

	if($result&&mysqli_affected_rows($connection)==1){
		$_SESSION["message"]="Subject was sucessfully deleted";
		redirect_to("manage_content.php");
	}else{
		$_SESSION["message"]="Subject delition failed";
		redirect_to("manage_content.php?subject={$current_subject["id"]}");
	}

?>