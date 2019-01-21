<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php");?>

<?php
if(isset($_POST['submit'])){

	$fields_required=array("username", "password");
	validate_presence($fields_required);

	$fields_with_max_length=array("username"=>50, "password"=>60);
	validate_max_length($fields_with_max_length);

	if(empty($errors)){
		$username=mysqli_real_escape_string($connection, $_POST["username"]);
		$password=password_encrypt($_POST["password"]);

		$query = "INSERT INTO admins (username, hashed_password) VALUES ('{$username}', '{$password}')";
		$result=mysqli_query($connection, $query);
	
		if($result){
			$_SESSION["message"] = "Admin is added";
			redirect_to("manage_admins.php");
		}else{
			$_SESSION["message"] = "Admin addition failed";
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
		<h2>Add admin</h2>
		<form action="new_admin.php" method="post">
			Username: <input type="text" name="username" value=""> <br /> <br />
			Password: <input type="password" name="password" value=""> <br />
			<br />
			<input type="submit" name="submit" value="Add admin">
		</form>
		<br />
		<a href="manage_admins.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>