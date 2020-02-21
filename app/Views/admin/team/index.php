<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.teams') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="<?= route_to('admin-teams-new') ?>"><?= lang('admin/Team.addTeam') ?></a>
	</div>

	<!-- TEAMS TABLE -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('General.teams') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('admin/Team.leader') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('admin/Team.ban') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($teams as $team): ?>
						<tr>
							<td><?= esc($team->id) ?></td>
							<td>
								<a href="<?= route_to('admin-users-show', $team->leader_id) ?>"><?= esc($team->leader_name) ?></a>
							</td>
							<td><?= esc($team->name) ?></td>
							<?php if ($team->is_banned == '1') : ?>
								<td class="text-danger"><b><?= lang('General.banned') ?></b></td>
							<?php else : ?>
								<td></td>
							<?php endif ?>
							<td class="p-1">
								<a class="btn btn-info btn-block" href="<?= route_to('admin-teams-show', $team->id) ?>">
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
			$("#teams-table").DataTable();
		});
	</script>

<?= $this->endSection() ?>