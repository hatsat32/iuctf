<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<div class="container">
		<a class="navbar-brand" href="/">IUCTF</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-header" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbar-header">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/challenges"><?= lang('General.challenges') ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/scoreboard"><?= lang('Home.scoreboard') ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/notifications"><?= lang('General.notifications') ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/hash"><?= lang('Home.hash') ?></a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if(logged_in()): ?>
					<li class="nav-item">
						<a class="nav-link" href="/team"><?= lang('General.team') ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile"><?= lang('Home.profile') ?></a>
					</li>
					<?php if(in_groups('admin')): ?>
						<li class="nav-item">
							<a class="nav-link" href="/admin"><?= lang('Home.admin') ?></a>
						</li>
					<?php endif ?>
					<li class="nav-item">
						<a class="nav-link" href="/logout"><?= lang('Home.logout') ?></a>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<a class="nav-link" href="/login"><?= lang('Home.login') ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/register"><?= lang('Home.register') ?></a>
					</li>
				<?php endif ?>
				<form action="/language" method="get" id="language-form">
					<div class="input-group">
						<div class="input-group-prepend">
							<label class="input-group-text" for="language"><?= lang('General.language') ?></label>
						</div>
						<select class="custom-select" id="language" name="language">
							<?php foreach(config('Iuctf')->locales as $lang => $language): ?>
								<option <?= session('language')==$lang ? 'selected':'' ?> value="<?= $lang ?>"><?= $language ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<script>
						$("#language").change(function() {
							$("#language-form").submit();
						});
					</script>
				</form>
            </ul>
		</div>
	</div>
</nav>
