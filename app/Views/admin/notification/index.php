<?= $this->extend("admin/templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('General.notifications') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.notifications') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="<?= route_to('admin-notf-new') ?>"><?= lang('admin/Notification.addNotification') ?></a>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user"></i>
			<?= lang('General.notifications') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="notification-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.title') ?></th>
							<th><?= lang('General.description') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($notifications as $notf) : ?>
							<tr>
								<td><?= esc($notf->id) ?></td>
								<td><?= esc($notf->title) ?></td>
								<td><?= esc(substr($notf->content, 0, 50)) ?></td>
								<td class="p-1">
									<a href="<?= route_to('admin-notf-show', $notf->id) ?>" class="btn btn-info btn-block">
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

<?= $this->endSection() ?>