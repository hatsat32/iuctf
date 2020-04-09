<?= $this->extend("admin/templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('admin/Log.loginLogs') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Log.logs') ?></li>
		<li class="breadcrumb-item active"><?= lang('admin/Log.loginLogs') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('admin/Log.loginLogs') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('admin/Log.ip') ?></th>
							<th><?= lang('General.email') ?></th>
							<th><?= lang('admin/Log.userId') ?></th>
							<th><?= lang('General.date') ?></th>
							<th><?= lang('admin/Log.success') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($logins as $login) : ?>
							<tr>
								<td><?= esc($login->id) ?></td>
								<td><?= esc($login->ip_address) ?></td>
								<td><?= esc($login->email) ?></td>
								<td>
									<?php if ($login->user_id != null) : ?>
										<a href="<?= route_to('admin-users-show', $login->user_id) ?>">
											<?= esc($login->username) ?>
										</a>
									<?php endif ?>
								</td>
								<td><?= esc($login->date) ?></td>
								<td class="text-center">
									<?php if ($login->success == '0') : ?>
										<i class="fas fa-times text-danger"></i>
									<?php else : ?>
										<i class="fas fa-check text-success"></i>
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>

			<?php echo $pager->links('default', 'admin_pager') ?>
		</div>
	</div>

<?= $this->endSection() ?>