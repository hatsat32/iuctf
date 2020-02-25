<?= $this->extend("templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('Home.hash') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<div class="my-4 text-center">
		<h1><?= lang('Home.hash') ?></h1>
	</div>

	<form action="<?= route_to('hash') ?>" method="post">
		<?= csrf_field() ?>
		<div class="form-group">
			<label class="col-form-label col-form-label-lg" for="hash"><?= lang('Home.getHash') ?></label>
			<input type="text" name="hash" class="form-control form-control-lg" id="hash">
		</div>
		<button type="submit" class="btn btn-primary btn-block btn-lg"><?= lang('Home.getHash') ?></button>
	</form>

	<?php if(isset($hash)) : ?>
		<div class="my-4 alert alert-secondary text-lg text-center">
			<code class="text-white lead"><?= esc($hash) ?></code>
		</div>
	<?php endif ?>

<?= $this->endSection() ?>