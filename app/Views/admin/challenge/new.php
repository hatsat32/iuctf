<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/challenges">Sorular</a>
		</li>
		<li class="breadcrumb-item active">Soru Ekle</li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Soru Ekle</div>
		<div class="card-body">
			<?php if(! empty($errors)): ?>
				<?php foreach($errors as $key => $message): ?>
				<div class="alert alert-danger" role="alert">
					<?= $message ?>
				</div>
				<?php endforeach ?>
			<?php endif; ?>

			<form action="/admin/challenges" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="category_id">Kategori Seçiniz</label>
					<select name="category_id" class="form-control" id="category_id">
						<?php foreach($categories as $category): ?>
							<option value="<?= esc($category['id']) ?>"><?= esc($category['name']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="name">Soru İsmi Giriniz</label>
					<input type="name" name="name" class="form-control" id="name" placeholder="İsim giriniz" value="<?= old('name') ?>">
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
					<textarea class="form-control" name="description" id="description" rows="3" placeholder="Açıklama giriniz"><?= old('description') ?></textarea>
				</div>
				<div class="form-group">
					<label for="point">Puan</label>
					<input type="number" name="point" class="form-control" id="point" placeholder="Puan" value="<?= old('point') ?>">
				</div>
				<div class="form-group">
					<label for="max_attempts">Max Deneme Sayısı</label>
					<input type="number" name="max_attempts" class="form-control" id="max_attempts" placeholder="Max deneme sayısı" value="<?= old('max_attempts') ?>">
				</div>
				<div class="form-group">
					<label for="type">Tip</label>
					<select name="type" class="form-control" id="type">
						<option value="static">Statik</option>
						<option value="dynamic">Dinamik</option>
					</select>
				</div>
				<div class="form-group">
					<label for="is_active">Tip</label>
					<select name="is_active" class="form-control" id="is_active">
						<option value="0">Pasif</option>
						<option value="1">Aktif</option>
					</select>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Submit</button>
			</form>
		</div>
	</div>
<?= $this->endSection() ?>
