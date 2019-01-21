<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/validation_functions.php");?>

<?php find_selected_page(); ?>
<?php if(!$current_subject) redirect_to("manage_content.php") ?>

<?php 
if(isset($_POST['submit'])){
	//validation
	$fields_required=array("menu_name", "position", "content"); //visible is not working ???
	validate_presence($fields_required);

	$fields_with_max_length=array("menu_name"=>30);
	validate_max_length($fields_with_max_length);


	if(empty($errors)){
		$menu_name=mysqli_real_escape_string($connection, $_POST['menu_name']);
		$content=mysqli_real_escape_string($connection, $_POST['content']);
		$position=(int) $_POST['position'];
		$visible=(int) $_POST['visible'];
		$subject_id=$current_subject['id'];

		$query="INSERT INTO pages (subject_id, menu_name, position, visible, content) VALUES ({$current_subject['id']}, '{$menu_name}', {$position}, {$visible}, '{$content}' )";
		$result=mysqli_query($connection, $query);

		if($result){
			$_SESSION["message"]="Page created";
			redirect_to("manage_content.php?subject=".urldecode($current_subject["id"]));
		}else{
			$_SESSION["message"]="Page creation failed";
		}
	}

}else{

}

?>

<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php");?>

<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject, $current_page);?>
	</div>

	<div id="page">
	<?php echo message();?>	
	<?php 
		echo display_errors($errors);
	?>
		
		<h2>Create Page</h2>
		<form action="new_page.php?subject=<?php echo urldecode($current_subject["id"]);?>" method="post">
			<p>Menu name:
				<input type="text" name="menu_name" value="">
			</p>
			<p>Position:
				<select name="position">
					<?php 
					$page_set=find_pages_for_subjects($current_subject["id"]);
					$page_count=mysqli_num_rows($page_set);
					for ($count=1; $count<=($page_count+1); $count++) { 
						echo "<option value=\"{$count}\">{$count}</option>";
					}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0"> No
				&nbsp;
				<input type="radio" name="visible" value="1"> Yes 
			</p>
			<p>Content: <br/>
				<textarea name="content" rows="20" cols="80"></textarea>
			</p>
			<input type="submit" name="submit" value="Create Page">
		</form>
		<br />
		<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]);?>">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>