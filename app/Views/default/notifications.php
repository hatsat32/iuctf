<?= $this->extend("templates/base") ?>

<?= $this->section('content') ?>

	<div class="my-4 text-center">
		<h2><?= lang('General.notifications') ?></h2>
	</div>

	<?php foreach($notifications as $notf): ?>
		<div class="card m-2">
			<div class="card-body">
				<h3 class="card-title"><?= esc($notf->title) ?></h3>
				<h6 class="card-subtitle mb-2 text-muted"><?= esc($notf->created_at) ?></h6>
				<p class="card-text"><?= esc($notf->content) ?></p>
			</div>
		</div>
	<?php endforeach ?>

<?= $this->endSection() ?>