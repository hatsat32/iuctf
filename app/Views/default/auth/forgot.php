<?= $this->extend($config->viewLayout) ?>


<?= $this->section('title') ?>
	<?= lang('Auth.forgotPassword') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<div class="col-sm-8 offset-sm-2 my-4">
		<div class="card">
			<h2 class="card-header"><?= lang('Auth.forgotPassword') ?></h2>
			<div class="card-body">

				<?= $this->include('templates/message_block') ?>

				<p><?= lang('Auth.enterEmailForInstructions') ?></p>

				<form action="<?= route_to('forgot') ?>" method="post">
					<?= csrf_field() ?>

					<div class="form-group">
						<label for="email"><?= lang('Auth.emailAddress') ?></label>
						<input type="email" class="form-control form-control-lg <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
								name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
						<div class="invalid-feedback">
							<?= session('errors.email') ?>
						</div>
					</div>

					<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('Auth.sendInstructions') ?></button>
				</form>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>
