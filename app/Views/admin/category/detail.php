<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Category.editCategory') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Category.editCategory') ?></div>
		<div class="card-body">
			<form action="/admin/categories/<?= esc($category['id']) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="id"><?= lang('General.id') ?></label>
					<input disabled class="form-control" id="id" value="<?= esc($category['id']) ?>">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('admin/Category.categoryName') ?></label>
					<input type="text" name="name" class="form-control" id="name" value="<?= esc($category['name']) ?>">
				</div>
				<div class="form-group">
					<label for="description"><?= lang('General.description') ?></label>
					<textarea class="form-control" id="description" name="description" rows="3"><?= esc($category['description']) ?></textarea>
				</div>
				<div class="form-group">
					<label for="created_at"><?= lang('General.createdAt') ?></label>
					<input disabled class="form-control" id="created_at" value="<?= esc($category['created_at']) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at"><?= lang('General.updatedAt') ?></label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($category['updated_at']) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Category.updateCategory') ?></button>
			</form>

			<div class="mt-4">
				<form action="/admin/categories/<?= esc($category['id']) ?>/delete" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Category.deleteCategory') ?></button>
				</form>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>