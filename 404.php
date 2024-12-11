<?php require_once 'config.php' ?>
<?php Peplo::Subtitle('404 - Not Found') ?>
<?php require_once 'sidebar.php' ?>
<div class='page-wrapper bg-login'>
	<div class='page-content'>
		<div class='error-404 d-flex align-items-center justify-content-center'>
			<div class='card border-0 shadow-none bg-transparent'>
				<div class='card-body text-center'>
					<h1 class='display-2 mt-5 fw-bold'>404</h1>
					<h1 class='display-6'>NOT FOUND</h1>
					<p>'<?= $_SERVER['REQUEST_URI']?>' not found</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once 'footer.php' ?>