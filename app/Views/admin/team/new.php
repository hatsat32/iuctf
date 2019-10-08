<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Takım Ekle</li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Takım Ekle</div>
		<div class="card-body">
			<form action="/admin/teams/" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="leader_id">Lider ID</label>
					<input type="number" name="leader_id" class="form-control" id="leader_id" placeholder="Lider ID">
				</div>
				<div class="form-group">
					<label for="name">İsmi Giriniz</label>
					<input type="name" name="name" class="form-control" id="name" placeholder="Takım İsmi">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Takım Oluştur</button>
			</form>
		</div>
	</div>
<?= $this->endSection() ?>