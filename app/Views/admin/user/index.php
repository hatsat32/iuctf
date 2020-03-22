<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.users') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="<?= route_to('admin-users-new') ?>"><?= lang('General.add') ?></a>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user"></i>
			<?= lang('General.users') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="users-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.team') ?></th>
							<th><?= lang('General.username') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('General.email') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user) : ?>
							<tr>
								<td><?= esc($user->id) ?></td>
								<td>
									<?php if (isset($user->team_id)) : ?>
										<a href="<?= route_to('admin-teams-show', $user->team_id) ?>">
											<?= esc($user->team_name) ?>
										</a>
									<?php endif ?>
								</td>
								<td><?= esc($user->username) ?></td>
								<td><?= esc($user->name) ?></td>
								<td><?= esc($user->email) ?></td>
								<td class="p-1">
									<a href="<?= route_to('admin-users-show', $user->id) ?>" class="btn btn-info btn-block">
										<?= lang('General.detail') ?>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<?= $pager->links('default', 'admin_pager') ?>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$("#users-table").DataTable();
		});
	</script>

<?= $this->endSection() ?>