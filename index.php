<?php 
	if(isset($_GET['url']) && !empty($_GET['url'])) {
		include_once "includes/functions.php";

		$url = strtolower(trim($_GET['url']));
		$link = get_link_info($url);
		if(empty($link)) {
			header('Location: 404.php');
			die;
		} 
		
		update_views($url);
		header('Location: ' . $link['long_link']);
		die;
	}

	include_once "includes/header.php";
?>

<main class="container main-bg">
	<?php if(!isset($_SESSION['user_id'])) { ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Необходимо <a href="<?php echo get_url('register.php'); ?>">зарегистрироваться</a> или <a href="<?php echo get_url('login.php'); ?>">войти</a> под своей учетной записью</h2>
			</div>
		</div>
	<?php } ?>
	<div class="row mt-5">
		<div class="col-sm-12 col-md-6 col-lg-4 mb-5 d-flex flex-column justify-content-between main-block">
			<h2 class="text-center">Пользователей в системе:</h2>
			<div class="text-center">
				<span class="info-count"><?php echo get_users_count(); ?></span>
				<i class="bi bi-people main-link"></i>
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 mb-5 d-flex flex-column justify-content-between main-block">
			<h2 class="text-center">Ссылок в системе:</h2>
			<div class="text-center">
				<span class="info-count"><?php echo get_links_count(); ?></span>
				<i class="bi bi-link-45deg main-link"></i>
			</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-4 mb-5 d-flex flex-column justify-content-between main-block">
			<h2 class="text-center">Всего переходов по ссылкам:</h2>
			<div class="text-center">
				<span class="info-count"><?php echo get_views_count(); ?></span>
				<i class="bi bi-share main-link"></i>
			</div>
		</div>
	</div>
</main>
<?php include_once "includes/footer.php"; ?>
