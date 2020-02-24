<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Log.logs') ?></li>
		<li class="breadcrumb-item active"><?= lang('admin/Log.flagSubmissions') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('admin/Log.flagSubmissions') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.challenge') ?></th>
							<th><?= lang('General.user') ?></th>
							<th><?= lang('General.team') ?></th>
							<th><?= lang('admin/Log.ip') ?></th>
							<th><?= lang('admin/Log.provided') ?></th>
							<th><?= lang('admin/Log.type') ?></th>
							<th><?= lang('General.createdAt') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($submissions as $submission): ?>
							<tr>
								<td><?= esc($submission->id) ?></td>
								<td>
									<a href="<?= route_to('admin-challenges-show', $submission->ch_id) ?>">
										<?= esc($submission->ch_name) ?>
									</a>
								</td>
								<td>
									<a href="<?= route_to('admin-users-show', $submission->user_id) ?>">
										<?= esc($submission->username) ?>
									</a>
								</td>
								<td>
									<a href="<?= route_to('admin-teams-show', $submission->team_id) ?>">
										<?= esc($submission->team_name) ?>
									</a>
								</td>
								<td><?= esc($submission->ip) ?></td>
								<td><?= esc($submission->provided) ?></td>
								<td class="text-center">
									<?php if ($submission->type == '0') : ?>
										<i class="fas fa-times text-danger"></i>
									<?php else : ?>
										<i class="fas fa-check text-success"></i>
									<?php endif ?>
								</td>
								<td><?= esc($submission->created_at) ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>

			<?php echo $pager->links('default', 'admin_pager') ?>
		</div>
	</div>

<?= $this->endSection() ?>