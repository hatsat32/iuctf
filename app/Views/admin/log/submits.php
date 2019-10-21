<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('admin/Log.flagSubmits') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.challenge') ?></th>
							<th><?= lang('General.user') ?></th>
							<th><?= lang('General.team') ?></th>
							<th><?= lang('General.ip') ?></th>
							<th><?= lang('General.provided') ?></th>
							<th><?= lang('General.type') ?></th>
							<th><?= lang('General.createdAt') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($submits as $submit): ?>
						<tr>
							<td><?= esc($submit["id"]) ?></td>
							<td><?= esc($submit["chname"]) ?></td>
							<td><?= esc($submit["username"]) ?></td>
							<td><?= esc($submit["tname"]) ?></td>
							<td><?= esc($submit["ip"]) ?></td>
							<td><?= esc($submit["provided"]) ?></td>
							<td><?= esc($submit["type"]) ?></td>
							<td><?= esc($submit["created_at"]) ?></td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>

			<?php echo $pager->links('default', 'admin_pager') ?>
		</div>
	</div>

<?= $this->endSection() ?>