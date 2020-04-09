<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin') ?>"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-settings') ?>"><?= lang('admin/Settings.settings') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Settings.theme') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Settings.theme') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-settings-theme') ?>" method="post">
				<?= csrf_field() ?>
				<div class="row">
					<div class="col-md-6">
						<h3><?= lang('admin/Settings.themeTitle') ?></h3>
						<p><?= lang('admin/Settings.themeDesc') ?></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="theme"><?= lang('admin/Settings.theme') ?></label>
							<select name="theme" class="form-control" id="theme">
								<option value="default" <?= ss()->theme === 'default' ? 'selected':'' ?>>
									<?= lang('admin/Settings.default') ?>
								</option>
								<?php foreach ($themes as $theme) : ?>
									<option value="<?= esc($theme, 'attr') ?>" <?= ss()->theme === $theme ? 'selected':'' ?>>
										<?= esc($theme) ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
			</form>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Settings.themes') ?></div>
		<div class="card-body">
			<?= $this->setData(['name' => 'theme'])->include('admin/templates/message_block') ?>
			<div class="row">
				<div class="col-md-6">
					<form action="<?= route_to('admin-theme-delete') ?>" method="post">
						<?= csrf_field() ?>
						<h3><?= lang('admin/Settings.deleteTheme') ?></h3>
						<div class="form-group">
							<select name="theme" class="form-control" id="theme">
								<?php foreach ($themes as $theme) : ?>
									<option value="<?= esc($theme, 'attr') ?>">
										<?= esc($theme) ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
						<button type="submit" class="btn btn-danger btn-block"><?= lang('General.delete') ?></button>
					</form>
				</div>
				<div class="col-md-6">
					<form action="<?= route_to('admin-theme-import') ?>" method="post" enctype="multipart/form-data">
						<?= csrf_field() ?>
						<h3><?= lang('admin/Settings.importTheme') ?></h3>
						<div class="form-group">
							<div class="custom-file">
								<label class="custom-file-label form-control" for="file"><?= lang('admin/Challenge.browse') ?></label>
								<input type="file" class="custom-file-input" id="file" name="file" required>
							</div>
						</div>
						<button type="submit" class="btn btn-primary btn-block"><?= lang('General.upload') ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			// name of the file appear on select
			$(".custom-file-input").on("change", function() {
				var fileName = $(this).val().split("\\").pop();
				$(this).siblings(".custom-file-label").addClass("selected").text(fileName);
			});
		});
	</script>

<?= $this->endSection() ?>
