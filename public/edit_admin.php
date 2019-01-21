<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php");?>

<?php $current_admin=find_admin_by_id($_GET["id"]); ?>
<?php if(!$current_admin) redirect_to("manage_admins.php"); ?>

<?php
if(isset($_POST['submit'])){

	$fields_required=array("username", "password");
	validate_presence($fields_required);

	$fields_with_max_length=array("username"=>50, "password"=>60);
	validate_max_length($fields_with_max_length);

	if(empty($errors)){
		$username=mysqli_real_escape_string($connection, $_POST["username"]);
		$password=password_encrypt($_POST["password"]);
		$id=$current_admin["id"];

		$query = "UPDATE admins SET username='{$username}', hashed_password='{$password}' WHERE id={$id}";
		$result=mysqli_query($connection, $query);
	
		if($result&&mysqli_affected_rows($connection)>=0){
			$_SESSION["message"] = "Admin is updated";
			redirect_to("manage_admins.php");
		}else{
			$_SESSION["message"] = "Admin updation failed";
		}
	}


}else{

}
?>

<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
	<div id="page">
		<?php echo message(); ?>
		<?php if(!empty($errors)) echo display_errors($errors); ?>
		<?php $id=$_GET['id'];?>
		<h2>Add admin</h2>
		<form action="edit_admin.php?id=<?php echo urldecode($id);?>" method="post">
			Username: <input type="text" name="username" value="<?php echo $current_admin["username"]; ?>"> <br /> <br />
			Password: <input type="password" name="password" value=""> <br />
			<br />
			<input type="submit" name="submit" value="Edit admin">
		</form>
		<br />
		<a href="manage_admins.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>