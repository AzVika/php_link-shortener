<?php 
	include_once "includes/functions.php";

	if(isset($_SESSION['user_id'])) header('Location: profile.php');
	
	$success = get_session_success();
	$error = get_session_error();

	if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
		login($_POST);

	}

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

	<div class="row mt-5">
		<div class="col">
			<h2 class="text-center">Вход в личный кабинет</h2>
			<p class="text-center">Если вы еще не зарегистрированы, то самое время <a href="<?php echo get_url('register.php'); ?>">зарегистрироваться</a></p>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-sm-8 col-lg-6 offset-sm-2 offset-lg-3">
			<form action="" method="post">
				<div class="mb-3">
					<label for="login-input" class="form-label">Логин</label>
					<input type="text" class="form-control" id="login-input" name="login" required
					value="<?php if(isset($_SESSION['login_temp'])) echo $_SESSION['login_temp']; ?>"
					>
				</div>
				<div class="mb-3">
					<label for="password-input" class="form-label">Пароль</label>
					<input type="password" class="form-control" id="password-input" name="pass" required>
				</div>
				<button type="submit" class="btn btn-primary">Войти</button>
			</form>
		</div>
	</div>
</main>

<?php include_once "includes/footer.php"; ?>
