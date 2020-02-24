<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-notf') ?>"><?= lang('General.notifications') ?></a>
		</li>
		<li class="breadcrumb-item active">
			<a href="<?= route_to('admin-notf-show', $notification->id) ?>"><?= esc($notification->title) ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Notification.editNotification') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Notification.editNotification') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-notf-show', $notification->id) ?>" method="post">
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

			<!-- DELETE THE NOTIFICATION -->
			<div class="mt-4">
				<form action="<?= route_to('admin-notf-delete', $notification->id) ?>" method="post"
						onsubmit="return confirm(this.getAttribute('confirm_message'))"
						confirm_message="<?= lang('admin/Notification.deleteConfirm') ?>">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Notification.deleteNotification') ?></button>
				</form>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>