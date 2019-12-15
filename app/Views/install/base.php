<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?= lang('Install.installationManager') ?></title>

		<link rel="stylesheet" href="/css/bootstrap.darky.min.css">
		<script src="/js/jquery.min.js"></script>
	</head>
	<body>

		<nav class="navbar navbar-light bg-primary">
			<a class="navbar-brand" href="#"><?= lang('Install.installationManager') ?></a>
		</nav>

		<div class="container col-8 my-4">
			<?= $this->renderSection("content") ?>
		</div>

		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/popper.min.js"></script>
	</body>
</html>
