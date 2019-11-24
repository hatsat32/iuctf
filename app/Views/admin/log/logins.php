<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('admin/Log.loginLogs') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="teams-table" width="100%" cellspacing="0">
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
					<?php foreach($logins as $login): ?>
						<tr>
							<td><?= esc($login['id']) ?></td>
							<td><?= esc($login['ip_address']) ?></td>
							<td><?= esc($login['email']) ?></td>
							<td><?= esc($login['user_id']) ?></td>
							<td><?= esc($login['date']) ?></td>
							<td><?= esc($login['success']) ?></td>
							
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>

			<?php echo $pager->links('default', 'admin_pager') ?>
		</div>
	</div>

<?= $this->endSection() ?>