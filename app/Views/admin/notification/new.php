<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Notification.addNotification') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Notification.addNotification') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-notf') ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="title"><?= lang('General.title') ?></label>
					<input type="text" name="title" class="form-control" id="title" value="<?= old('title') ?>">
				</div>
				<div class="form-group">
					<label for="content"><?= lang('General.description') ?></label>
					<textarea class="form-control" name="content" id="content" rows="5"><?= old('content') ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Notification.addNotification') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>