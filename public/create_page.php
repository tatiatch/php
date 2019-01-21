<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>

<?php find_selected_page(); ?>
<?php if(!$current_subject) redirect_to("manage_content.php"); ?>

<?php
if(isset($_POST['submit'])){
	$menu_name=mysqli_real_escape_string($connection, $_POST["menu_name"]);
	$position=(int) $_POST["position"];
	$visible=(int) $_POST["visible"];
	$content=mysqli_real_escape_string($connection, $_POST["content"]);
	$subject_id=$current_subject["id"];

	//validations
	$fields_required=array("menu_name", "position", "visible", "content");
	validate_presence($fields_required);

	$fields_with_max_length=array("menu_name"=>30);
	validate_max_length($fields_with_max_length);

	if(!empty($errors)){
		$_SESSION["errors"]=$errors;
		redirect_to("new_page.php?subject=".urldecode($current_subject["id"]));
	}

	$query  = "INSERT INTO pages ";
	$query .= "(subject_id, menu_name, position, visible, content) ";
	$query .= "VALUES ";
	$query .= "({$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}') ";

	$result=mysqli_query($connection, $query);
	confirm_query($result);
	if($result){
		$_SESSION["message"] = "Subject created.";
		redirect_to("manage_content.php");
	}else{
		$_SESSION["message"]="Subject creation failed.";
		redirect_to("new_subject.php?subject=".urldecode($current_subject["id"]));
	}

}else{
	//probably it's a $_GET request
	redirect_to("new_subject.php");
}
?>

<?php if(isset($connection)) {mysqli_close($connection);} ?>