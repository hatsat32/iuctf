<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $this->renderSection("title") ?></title>

	<link rel="stylesheet" href="/lib/bootswatch/darkly/bootstrap.min.css">
	<script src="/lib/jquery/jquery-3.4.1.min.js"></script>
</head>
<body>
	<?= $this->include('templates/header') ?>

	<div class="container">
		<?= $this->renderSection("content") ?>
	</div>

	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="/lib/popper/popper.min.js"></script>
</body>
</html>