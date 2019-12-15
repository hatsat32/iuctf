<?= $this->extend("install/base") ?>

<?= $this->section('content') ?>

	<div class="jumbotron">
		<?php if (session()->has('message')) : ?>
			<h1 class="display-3"><?= session('message') ?></h1>
		<?php endif ?>

			<p class="lead mt-4"><?= lang('Install.redirectMessage') ?></p>
		</div>

	<script>
		// redirect admin panel in 5 secounds
		$(document).ready(function () {
			window.setTimeout(function () {
				location.href = "/admin";
			}, 5000);
		});
	</script>

<?= $this->endSection() ?>
