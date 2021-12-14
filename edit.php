<?php 
	include_once "includes/functions.php";

	check_session_user_id();

	$success = get_session_success();
	$error = get_session_error();

	$get_id = (int)(trim($_GET['id']));

	if(!isset($get_id) && empty($get_id) && $get_id == 0) {
		header('Location: profile.php');
        die;
	}

	if(isset($_POST['long_link']) && !empty($_POST['long_link'])) {
		edit_link($_SESSION['user_id'], $get_id, $_POST['long_link']);
		header('Location: profile.php');
        die;
	}

	$link_info = get_long_link_info($_SESSION['user_id'], $get_id);

	include_once "includes/header.php";
?>

<main class="container">
<?php if(!empty($success)) { ?>
		<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
		<?php echo $success; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php } ?>
	
	<?php if(!empty($error)) { ?>
		<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
			<?php echo $error; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php } ?>

	<div class="row mt-3">
		<div class="col-4 offset-4">
			<form action="" method="post">
				<div class="mb-3">
					<label for="link-input" class="form-label">Ссылка</label>
					<input type="text" class="form-control is-valid" id="link-input" name="long_link" value="<?php echo $link_info['long_link'] ?>" required>
				</div>
				<button type="submit" class="btn btn-primary">Сохранить изменения</button>
			</form>
		</div>
	</div>
</main>

<?php include_once "includes/footer.php"; ?>
