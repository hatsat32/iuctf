<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.challenges') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="<?= route_to('admin-challenges-new') ?>"><?= lang('General.add') ?></a>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('General.challenges') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
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
								<td>
									<a href="<?= route_to('admin-categories-show', $challenge->cat_id) ?>">
										<?= esc($challenge->cat_name) ?>
									</a>
								</td>
								<td><?= esc($challenge->name) ?></td>
								<td><?= esc($challenge->point) ?></td>
								<td>
									<?php if ($challenge->is_active == '1') : ?>
										<?= lang('General.active') ?>
									<?php else : ?>
										<?= lang('General.passive') ?>
									<?php endif ?>
								</td>
								<td>
									<a class="btn btn-info btn-block" href="<?= route_to('admin-challenges-show', $challenge->id) ?>">
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