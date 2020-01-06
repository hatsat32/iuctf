<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Notification.editNotification') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Notification.editNotification') ?></div>
		<div class="card-body">
		
			<?php if (session()->has('errors')) : ?>
				<ul class="alert alert-danger">
				<?php foreach (session('errors') as $error) : ?>
					<li><?= $error ?></li>
				<?php endforeach ?>
				</ul>
			<?php endif ?>

			<form action="/admin/notifications/<?= $notification->id ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="title"><?= lang('General.title') ?></label>
					<input type="text" name="title" class="form-control" id="title" value="<?= $notification->title ?>">
				</div>
				<div class="form-group">
					<label for="content"><?= lang('General.description') ?></label>
					<textarea class="form-control" name="content" id="content" rows="5"><?= $notification->content ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Notification.updateNotification') ?></button>
			</form>
			
			<div class="mt-4">
				<form action="/admin/notifications/<?= esc($notification->id) ?>/delete" method="post"
							onsubmit="return confirm('Duyuruyu silmek istediğine eminmisin??')">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Notification.deleteNotification') ?></button>
				</form>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>