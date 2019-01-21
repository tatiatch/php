<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php");?>

<?php
$username="";
if(isset($_POST['submit'])){

	$fields_required=array("username", "password");
	validate_presence($fields_required);

	if(empty($errors)){
		$username=$_POST['username'];
		$password=$_POST['password'];

		$found_admin=attempt_login($username, $password);
		
		if($found_admin){
			$_SESSION["admin_id"]=$found_admin["id"];
			$_SESSION["username"] =$found_admin["username"];
			redirect_to("admin.php");
		}else{
			$_SESSION["message"] = "username/password do not match";
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
		<h2>Please log in</h2>
		<form action="login.php" method="post">
			Username: <input type="text" name="username" value="<?php echo $username; ?>"> <br /> <br />
			Password: <input type="password" name="password" value=""> <br />
			<br />
			<input type="submit" name="submit" value="Login">
		</form>		
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>