<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php");?>

<?php find_selected_page(); ?>
<div id="main">
	<div id="navigation">
		<br />
		<a href="admin.php">&laquo; Main menu</a>
		<?php echo navigation($current_subject, $current_page);?>
		<a href="new_subject.php">+ Add new subject</a> <br />
	</div>

	<div id="page">	
	<?php echo message();?>	
		<?php if($current_subject) {?>
			<h2>Manage Subjects</h2>
			Menu name: <?php echo htmlentities($current_subject["menu_name"]); ?> <br />
			Position: <?php echo $current_subject["position"]; ?> <br />
			Visible: <?php echo $current_subject["visible"] == 1 ? "Yes" : "No"; ?> <br />
			<br /> 
			<a href="edit_subject.php?subject=<?php echo urldecode($current_subject["id"]);?>">Edit Subject</a>
			<br /> <br />
			<hr />
			<h3>Pages in this subject:</h3>
			<ul>
				<?php
					$id=$current_subject["id"];
					$page_set=find_pages_for_subjects($id);
					while($page=mysqli_fetch_assoc($page_set)){
				?>
				<li> 
				<a href="manage_content.php?page=<?php echo urldecode($page["id"]); ?>"><?php echo htmlentities($page["menu_name"]); ?></a>
				</li>
				 <?php } ?>
			</ul>
			<br /> <br />
			<a href="new_page.php?subject=<?php echo urldecode($current_subject["id"]);?>">+ Add new page to this subject</a>
		
		<?php } elseif ($current_page) { ?>
			<h2>Manage Pages</h2>
			Menu Name: <?php echo htmlentities($current_page["menu_name"]); ?> <br />
			Position: <?php echo $current_page["position"]; ?> <br />
			Visible: <?php echo $current_page["visible"] == 1 ? "Yes" : "No"; ?> <br />
			Content: <br />
			<div class="view-content"> 
				<?php echo nl2br(htmlentities($current_page["content"])); ?> 
			</div>
			<br />
			<a href="edit_page.php?page=<?php echo urldecode($current_page["id"]);?>">Edit page</a>

		<?php } else { ?>
			<h2>Manage Content</h2>
			Please select a subject or a page
		<?php } ?> 
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>