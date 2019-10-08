<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Takım Düzenle</li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Takım Ekle</div>
		<div class="card-body">
			<form action="/admin/categories/<?= esc($category['id']) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="id">ID</label>
					<input disabled class="form-control" id="id" value="<?= esc($category['id']) ?>">
				</div>
				<div class="form-group">
					<label for="name">Kategori İsmi</label>
					<input type="text" name="name" class="form-control" id="name" value="<?= esc($category['name']) ?>" placeholder="Kategori İsmi">
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Açıklama" rows="3"><?= esc($category['description']) ?></textarea>
				</div>
				<div class="form-group">
					<label for="created_at">Oluşturulma Tarihi</label>
					<input disabled class="form-control" id="created_at" value="<?= esc($category['created_at']) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at">Son Güncellenme Tarihi</label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($category['updated_at']) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Kategori Güncelle</button>
			</form>

			<div class="mt-4">
				<form action="/admin/categories/<?= esc($category['id']) ?>/delete" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block">Sil</button>
				</form>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>