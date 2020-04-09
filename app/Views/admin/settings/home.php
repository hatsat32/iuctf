<?= $this->extend("admin/templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('admin/Settings.settings') .' - '. lang('admin/Settings.home') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin') ?>"><?= lang('General.dashboard') ?></a>
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
			<div class="alert alert-info" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="alert-heading"><?= lang('admin/Settings.note') ?></h4>
				<p class="mb-0"><?= lang('admin/Settings.noteContent') ?></p>
			</div>
			<div class="alert alert-warning" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="alert-heading"><?= lang('admin/Settings.warning') ?></h4>
				<p class="mb-0"><?= lang('admin/Settings.jsWarning') ?></p>
			</div>
			<form action="<?= route_to('admin-settings-home') ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<textarea class="form-control" name="content" id="content" rows="20" style="tab-size: 2;"><?= esc($content) ?? old('description') ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>
