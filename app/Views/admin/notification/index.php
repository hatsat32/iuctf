<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.notifications') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="/admin/notifications/new"><?= lang('admin/Notification.addNotification') ?></a>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user"></i>
			<?= lang('General.notifications') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="notification-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.title') ?></th>
							<th><?= lang('General.createdAt') ?></th>
							<th><?= lang('General.updatedAt') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($notifications as $notf): ?>
						<tr>
							<td><?= esc($notf->id) ?></td>
							<td><?= esc($notf->title) ?></td>
							<td><?= esc($notf->created_at) ?></td>
							<td><?= esc($notf->updated_at) ?></td>
							<td>
								<a href="/admin/notifications/<?= esc($notf->id) ?>" class="btn btn-info btn-block">
									<?= lang('General.detail') ?>
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$("#notification-table").DataTable();
		});
	</script>

<?= $this->endSection() ?>