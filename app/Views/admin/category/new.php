<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Kategori Ekle</li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Kategori Ekle</div>
		<div class="card-body">
			<form action="/admin/categories" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="name">Kategori İsmi</label>
					<input type="text" name="name" class="form-control" id="name" placeholder="Kategori İsmi">
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Açıklama" rows="3"></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Kategori Oluştur</button>
			</form>
		</div>
	</div>
<?= $this->endSection() ?>