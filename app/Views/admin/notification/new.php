<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Duyuru Ekle</li>
    </ol>

    <div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Duyuru Ekle</div>
		<div class="card-body">
		
			<?php if (session()->has('errors')) : ?>
				<ul class="alert alert-danger">
				<?php foreach (session('errors') as $error) : ?>
					<li><?= $error ?></li>
				<?php endforeach ?>
				</ul>
			<?php endif ?>

			<form action="/admin/notifications" method="post">
				<?= csrf_field() ?>
                <div class="form-group">
					<label for="title">Başlık</label>
					<input type="text" name="title" class="form-control" id="title" placeholder="Başlık" value="<?= old('title') ?>">
				</div>
                <div class="form-group">
					<label for="content">Açıklama</label>
					<textarea class="form-control" name="content" id="content" rows="5" placeholder="Açıklama giriniz"><?= old('content') ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Ekle</button>
			</form>
		</div>
	</div>
<?= $this->endSection() ?>