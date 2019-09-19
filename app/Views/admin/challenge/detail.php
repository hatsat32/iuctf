<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/challenges">Sorular</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/challenges/<?= $challenge['id'] ?>"/><?= $challenge['name'] ?></a>
		</li>
		<li class="breadcrumb-item active">Düzenle</li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Soru Düzenle</div>
		<div class="card-body">
			<form action="/admin/challenges/<?= $challenge['id'] ?>" method="post">
				<div class="form-group">
					<label for="id">ID</label>
					<input disabled class="form-control" id="id" value="<?= esc($challenge['id']) ?>">
				</div>
				<div class="form-group">
					<label for="category_id">Kategori Seçiniz</label>
					<select name="category_id" class="form-control" id="category_id">
						<?php foreach($categories as $category): ?>
							<option <?= $challenge['id']===$category['id'] ? 'selected':'' ?> value="<?= esc($category['id']) ?>">
								<?= esc($category['name']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="name">Soru İsmi Giriniz</label>
					<input type="name" name="name" class="form-control" id="name" placeholder="İsim giriniz" value="<?= esc($challenge['name']) ?>">
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
					<textarea class="form-control" name="description" id="description" rows="3" placeholder="Açıklama giriniz"><?= esc($challenge['description']) ?></textarea>
				</div>
				<div class="form-group">
					<label for="point">Puan</label>
					<input type="number" name="point" class="form-control" id="point" placeholder="Puan" value="<?= esc($challenge['point']) ?>">
				</div>
				<div class="form-group">
					<label for="max_attempts">Max Deneme Sayısı</label>
					<input type="number" name="max_attempts" class="form-control" id="max_attempts" placeholder="Max deneme sayısı" value="<?= esc($challenge['max_attempts']) ?>">
				</div>
				<div class="form-group">
					<label for="type">Tip</label>
					<select name="type" class="form-control" id="type">
						<?php if($challenge['type'] === 'static'): ?>
							<option selected value="static">Statik</option>
							<option value="dynamic">Dinamik</option>
						<?php else: ?>
							<option value="static">Statik</option>
							<option selected value="dynamic">Dinamik</option>
						<?php endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="is_active">Tip</label>
					<select name="is_active" class="form-control" id="is_active">
						<?php if($challenge['is_active'] === '0'): ?>
							<option selected value="0">Pasif</option>
							<option value="1">Aktif</option>
						<?php else: ?>
							<option value="0">Pasif</option>
							<option selected value="1">Aktif</option>
						<?php endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="created_at">Eklendi</label>
					<input disabled class="form-control" id="created_at" value="<?= esc($challenge['created_at']) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at">Güncellendi</label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($challenge['updated_at']) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Güncelle</button>
			</form>

			<div class="mt-4">
				<form action="/admin/challenges/<?= esc($challenge['id']) ?>/delete" method="post">
					<button type="submit" class="btn btn-danger btn-block">Sil</button>
				</form>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>
