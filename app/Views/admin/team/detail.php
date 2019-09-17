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
			<form action="/admin/teams/<?= esc($team['id']) ?>" method="post">
				<div class="form-group">
					<label for="team_id">Takım ID</label>
					<input disabled class="form-control" id="team_id" value="<?= esc($team['id']) ?>">
				</div>
				<div class="form-group">
					<label for="auth_code">Takım Doğrulama Kodu</label>
					<input disabled class="form-control" id="auth_code" value="<?= esc($team['auth_code']) ?>">
				</div>
				<div class="form-group">
					<label for="leader_id">Lider ID</label>
					<input type="number" disabled class="form-control" id="leader_id" placeholder="Lider ID" value="<?= esc($team['leader_id']) ?>">
				</div>
				<div class="form-group">
					<label for="name">İsmi Giriniz</label>
					<input type="name" name="name" class="form-control" id="name" placeholder="Takım İsmi" value="<?= esc($team['name']) ?>">
				</div>
				<div class="form-group">
					<label for="created_at">Oluşturulma Tarihi</label>
					<input disabled class="form-control" id="created_at" value="<?= esc($team['created_at']) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at">Son Güncellenme Tarihi</label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($team['updated_at']) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Takım Güncelle</button>
			</form>

			<div class="mt-4">
				<form action="/admin/teams/<?= esc($team['id']) ?>/delete" method="post">
					<button type="submit" class="btn btn-danger btn-block">Sil</button>
				</form>
			</div>

			<div class="mt-4">
				<form action="/admin/teams/<?= esc($team['id']) ?>/authcode" method="post">
					<button type="submit" class="btn btn-info btn-block">Auth Kod Değiştir</button>
				</form>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>