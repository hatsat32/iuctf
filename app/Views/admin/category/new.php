<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Category.addCategory') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Category.addCategory') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="/admin/categories" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="name"><?= lang('admin/Category.categoryName') ?></label>
					<input type="text" name="name" class="form-control" id="name" value="<?= old('name') ?>">
				</div>
				<div class="form-group">
					<label for="description"><?= lang('General.description') ?></label>
					<textarea class="form-control" id="description" name="description" rows="5"><?= old('description') ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Category.addCategory') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>
