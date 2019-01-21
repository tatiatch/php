<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $layout_context="public"; ?>
<?php include("../includes/layouts/header.php");?>

<?php find_selected_page(true); ?>
<div id="main">
	<div id="navigation">
		<?php echo public_navigation($current_subject, $current_page);?>
	</div>

	<div id="page">	
	<?php echo message();?>	
		<?php if ($current_page) { ?> 
			<h2><?php echo $current_page['menu_name']; ?></h2>
			<?php echo nl2br(htmlentities($current_page["content"])); ?> 
			<br />

		<?php } else { ?>
			<h2>Welcome!</h2>
		<?php } ?> 
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>