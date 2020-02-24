<?= $this->extend($config->viewLayout) ?>

<?= $this->section('content') ?>

<div class="col-sm-8 offset-sm-2 my-4">
	<div class="card">
		<h2 class="card-header"><?=lang('Auth.register')?></h2>
		<div class="card-body">

			<?= $this->include('templates/message_block') ?>

			<form action="<?= route_to('register') ?>" method="post">
				<?= csrf_field() ?>

				<div class="form-group">
					<label for="email"><?=lang('Auth.email')?></label>
					<input type="email" class="form-control form-control-lg <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
							name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
					<small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
				</div>

				<div class="form-group">
					<label for="username"><?=lang('Auth.username')?></label>
					<input type="text" class="form-control form-control-lg <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>">
				</div>

				<div class="form-group">
					<label for="password"><?=lang('Auth.password')?></label>
					<input type="password" name="password" class="form-control form-control-lg <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
				</div>

				<div class="form-group">
					<label for="pass_confirm"><?=lang('Auth.repeatPassword')?></label>
					<input type="password" name="pass_confirm" class="form-control form-control-lg <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
				</div>

				<br>

				<button type="submit" class="btn btn-primary btn-lg btn-block"><?=lang('Auth.register')?></button>
			</form>

			<hr>

			<p><?=lang('Auth.alreadyRegistered')?> <a href="<?= route_to('login') ?>"><?=lang('Auth.signIn')?></a></p>
		</div>
	</div>
</div>

<?= $this->endSection() ?>