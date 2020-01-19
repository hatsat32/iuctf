<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>IUCTF</title>

	<link rel="stylesheet" href="/css/bootstrap.darky.min.css">
	<script src="/js/jquery.min.js"></script>
</head>
<body>
	<?= $this->include('templates/header') ?>

	<div class="container">
		<?= $this->renderSection("content") ?>
	</div>

	<style>
		body {
			/* font-family: monospace; */
		}
	</style>

	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/popper.min.js"></script>
</body>
</html>