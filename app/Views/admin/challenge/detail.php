<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/challenges"><?= lang('General.challenges') ?></a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/challenges/<?= $challenge['id'] ?>"/><?= $challenge['name'] ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.edit') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Challenge.editChallenge') ?></div>
		<div class="card-body">
			<form action="/admin/challenges/<?= $challenge['id'] ?>" method="post">
				<div class="form-group">
					<label for="id">ID</label>
					<input disabled class="form-control" id="id" value="<?= esc($challenge['id']) ?>">
				</div>
				<div class="form-group">
					<label for="category_id"><?= lang('admin/Challenge.selectCategory') ?></label>
					<select name="category_id" class="form-control" id="category_id">
						<?php foreach($categories as $category): ?>
							<option <?= $challenge['id']===$category['id'] ? 'selected':'' ?> value="<?= esc($category['id']) ?>">
								<?= esc($category['name']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="name"><?= lang('admin/Challenge.challengeName') ?></label>
					<input type="name" name="name" class="form-control" id="name" value="<?= esc($challenge['name']) ?>">
				</div>
				<div class="form-group">
					<label for="description"><?= lang('General.description') ?></label>
					<textarea class="form-control" name="description" id="description" rows="3"><?= esc($challenge['description']) ?></textarea>
				</div>
				<div class="form-group">
					<label for="point"><?= lang('General.point') ?></label>
					<input type="number" name="point" class="form-control" id="point" value="<?= esc($challenge['point']) ?>">
				</div>
				<div class="form-group">
					<label for="max_attempts"><?= lang('admin/Challenge.maxAttempt') ?></label>
					<input type="number" name="max_attempts" class="form-control" id="max_attempts" value="<?= esc($challenge['max_attempts']) ?>">
				</div>
				<div class="form-group">
					<label for="type"><?= lang('admin/Challenge.type') ?></label>
					<select name="type" class="form-control" id="type">
						<?php if($challenge['type'] === 'static'): ?>
							<option selected value="static"><?= lang('admin/Challenge.static') ?></option>
							<option value="dynamic"><?= lang('admin/Challenge.dynamic') ?></option>
						<?php else: ?>
							<option value="static"><?= lang('admin/Challenge.static') ?></option>
							<option selected value="dynamic"><?= lang('admin/Challenge.dynamic') ?></option>
						<?php endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="is_active"><?= lang('admin/Challenge.status') ?></label>
					<select name="is_active" class="form-control" id="is_active">
						<?php if($challenge['is_active'] === '0'): ?>
							<option selected value="0"><?= lang('admin/Challenge.passive') ?></option>
							<option value="1"><?= lang('admin/Challenge.active') ?></option>
						<?php else: ?>
							<option value="0"><?= lang('admin/Challenge.passive') ?></option>
							<option selected value="1"><?= lang('admin/Challenge.active') ?></option>
						<?php endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="created_at"><?= lang('General.createdAt') ?></label>
					<input disabled class="form-control" id="created_at" value="<?= esc($challenge['created_at']) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at"><?= lang('General.updatedAt') ?></label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($challenge['updated_at']) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Challenge.updateChallenge') ?></button>
			</form>

			<div class="mt-4">
				<form action="/admin/challenges/<?= esc($challenge['id']) ?>/delete" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Challenge.deleteChallenge') ?></button>
				</form>
			</div>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Challenge.flags') ?></div>
		<div class="card-body">
			<form action="/admin/challenges/<?= $challenge['id'] ?>/flags" method="post">
				<?= csrf_field() ?>
				<div class="form-row">
					<div class="col-3">
						<select name="type" class="form-control" id="is_active">
							<option value="static"><?= lang('admin/Challenge.static') ?></option>
							<option value="regex"><?= lang('admin/Challenge.regex') ?></option>
						</select>
					</div>
					<div class="col-6">
						<div class="col">
							<input type="text" class="form-control" name="content" placeholder="Flag">
						</div>
					</div>
					<div class="col-3">
						<div class="col">
							<button type="submit" class="btn btn-primary btn-block"><?= lang('General.add') ?></button>
						</div>
					</div>
				</div>
			</form>

			<div class="table-responsive mt-4">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('admin/Challenge.type') ?></th>
							<th><?= lang('admin/Challenge.content') ?></th>
							<th><?= lang('General.delete') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($flags as $flag): ?>
						<tr>
							<td><?= lang("admin/Challenge.{$flag['type']}") ?></td>
							<td><?= esc($flag["content"]) ?></td>
							<td>
								<form action="/admin/challenges/<?= $challenge['id'] ?>/flags/<?= esc($flag['id']) ?>/delete" method="post">
									<?= csrf_field() ?>
									<input type="hidden" name="flag" value=" <?= esc($flag['id']) ?>">
									<button class="btn btn-danger btn-block" type="submit"><?= lang('General.delete') ?></button>
								</form>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>
