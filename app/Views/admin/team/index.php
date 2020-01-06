<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.teams') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="/admin/teams/new"><?= lang('admin/Team.addTeam') ?></a>
	</div>

<!-- DataTables Example -->
<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('General.teams') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('admin/Team.leader') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('admin/Team.ban') ?></th>
							<th><?= lang('General.createdAt') ?></th>
							<th><?= lang('General.updatedAt') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($teams as $team): ?>
						<tr>
							<td><?= esc($team->id) ?></td>
							<td><?= esc($team->leader_id) ?></td>
							<td><?= esc($team->name) ?></td>
							<td><?= esc($team->is_banned) ?></td>
							<td><?= esc($team->created_at) ?></td>
							<td><?= esc($team->updated_at) ?></td>
							<td>
								<a class="btn btn-info btn-block" href="/admin/teams/<?= esc($team->id) ?>">
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