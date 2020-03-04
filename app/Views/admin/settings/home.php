<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/settings"><?= lang('admin/Settings.settings') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Settings.home') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Settings.settings') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-settings-home') ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="content"><?= lang('General.edit') ?></label>
					<textarea class="form-control" name="content" id="content" rows="20"><?= esc($content) ?? old('description') ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>
