<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/validation_functions.php");?>

<?php find_selected_page(); ?>
<?php if(!$current_page) redirect_to("manage_content.php") ?>

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
		$page_id=$current_page['id'];

		$query="UPDATE pages SET menu_name='{$menu_name}', position={$position}, visible={$visible}, content='{$content}' WHERE id={$page_id} ";
		$result=mysqli_query($connection, $query);
		confirm_query($result);

		if($result&&mysqli_affected_rows($connection)>=0){
			$_SESSION["message"]="Page edited";
			redirect_to("manage_content.php?page=".urldecode($current_page["id"]));
		}else{
			$_SESSION["message"]="Page edition failed";
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
		<form action="edit_page.php?page=<?php echo urldecode($current_page["id"]);?>" method="post">
			<p>Menu name:
				<input type="text" name="menu_name" value="<?php echo $current_page["menu_name"];?>">
			</p>
			<p>Position:
				<select name="position">
					<?php 
					$page_set=find_pages_for_subjects($current_page["subject_id"], false);
					$page_count=mysqli_num_rows($page_set);
					for($count=1; $count<=$page_count; $count++){
						echo "<option value={$count}";
						if($current_page['position']==$count) {
							echo " selected";
						}	

						echo ">{$count}</option>";
					}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" <?php if($current_page['visible']==0) echo "checked"; ?> > No
				&nbsp;
				<input type="radio" name="visible" value="1" <?php if($current_page['visible']==1) echo "checked"; ?> > Yes 
			</p>
			<p>Content: <br/>
				<textarea name="content" rows="20" cols="80"><?php echo $current_page["content"];?></textarea>
			</p>
			<input type="submit" name="submit" value="Edit Page">
		</form>
		<br />
		<a href="manage_content.php?page=<?php echo urlencode($current_page["id"]);?>">Cancel</a>
		&nbsp;
		&nbsp;
		<a href="delete_page.php?page=<?php echo urldecode($current_page["id"]);?>" onclick="return confirm('are you sure?');">Delete page</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>