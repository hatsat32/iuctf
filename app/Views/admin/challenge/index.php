<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.challenges') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="/admin/challenges/new"><?= lang('General.add') ?></a>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			Sorular</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="challenges-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.category') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('General.point') ?></th>
							<th><?= lang('admin/Challenge.status') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($challenges as $challenge): ?>
						<tr>
							<td><?= esc($challenge->id) ?></td>
							<td><?= esc($challenge->category_id) ?></td>
							<td><?= esc($challenge->name) ?></td>
							<td><?= esc($challenge->point) ?></td>
							<td><?= esc($challenge->is_active) ?></td>
							<td>
								<a class="btn btn-info btn-block" href="/admin/challenges/<?= esc($challenge->id) ?>">
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
			$("#challenges-table").DataTable();
		});
	</script>
<?= $this->endSection() ?>