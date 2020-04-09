<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item"><?= esc($category->name) ?></li>
		<li class="breadcrumb-item active"><?= lang('admin/Category.editCategory') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-bookmark"></i>
			<?= lang('admin/Category.editCategory') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-categories-show', $category->id) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="id"><?= lang('General.id') ?></label>
					<input disabled class="form-control" id="id" value="<?= esc($category->id) ?>">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('admin/Category.categoryName') ?></label>
					<input type="text" name="name" class="form-control" id="name" value="<?= esc($category->name) ?>">
				</div>
				<div class="form-group">
					<label for="description"><?= lang('General.description') ?></label>
					<textarea class="form-control" id="description" name="description" rows="3"><?= esc($category->description) ?></textarea>
				</div>
				<div class="form-group">
					<label for="created_at"><?= lang('General.createdAt') ?></label>
					<input disabled class="form-control" id="created_at" value="<?= esc($category->created_at) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at"><?= lang('General.updatedAt') ?></label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($category->updated_at) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Category.updateCategory') ?></button>
			</form>

			<div class="mt-4">
				<form action="<?= route_to('admin-categories-delete', $category->id) ?>" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Category.deleteCategory') ?></button>
				</form>
			</div>
		</div>
	</div>

	<!-- CHALLENGES BELONGS TO THIS CATEGORY -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-question-circle"></i>
			<?= lang('General.challenges') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('General.description') ?></th>
							<th><?= lang('General.point') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($challenges as $challenge) : ?>
						<tr>
							<td><?= esc($challenge->id) ?></td>
							<td><?= esc($challenge->name) ?></td>
							<td><?= esc($challenge->description) ?></td>
							<td><?= esc($challenge->point) ?></td>
							<td class="p-1">
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

<?= $this->endSection() ?>
