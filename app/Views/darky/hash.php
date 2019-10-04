<?= $this->extend("darky/templates/base") ?>

<?= $this->section('content') ?>

	<div class="my-4 text-center">
        <h1>Hash</h1>
    </div>

	<form action="/hash" method="post">
		<div class="form-group">
			<label class="col-form-label col-form-label-lg" for="hash">Hash Al</label>
			<input type="text" name="hash" class="form-control form-control-lg" id="hash" placeholder="hash">
		</div>
		<button type="submit" class="btn btn-primary btn-block btn-lg">Hash Al</button>
	</form>

	<?php if(isset($hash)): ?>
		<div class="my-4 alert alert-secondary text-lg">
			<code class="text-white lead"><?= esc($hash) ?></code>
		</div>
	<?php endif ?>

<?= $this->endSection() ?>