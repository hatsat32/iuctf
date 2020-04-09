<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/settings"><?= lang('admin/Settings.settings') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Settings.data') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Settings.settings') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<div class="row">
				<div class="col">
					<h1><?= lang('admin/Settings.backup') ?></h1>
					<p><?= lang('admin/Settings.backupDesc') ?></p>
					<form action="/admin/settings/data/backup" method="post">
						<?= csrf_field() ?>
						<button class="btn btn-primary btn-block"><?= lang('admin/Settings.backup') ?></button>
					</form>

					<div class="table-responsive mt-4">
						<table class="table table-bordered table-striped" id="teams-table" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th><?= lang('General.name') ?></th>
									<th><?= lang('General.download') ?></th>
									<th><?= lang('General.delete') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($backups as $backup) : ?>
									<tr>
										<td><?= esc($backup) ?></td>
										<td class="p-1">
											<a class="btn btn-info btn-block" href="/admin/settings/data/backup/<?= esc(str_replace('.zip', '', $backup)) ?>">
												<?= lang('admin/Settings.download') ?>
											</a>
										</td>
										<td class="p-1">
											<form action="/admin/settings/data/backup/<?= esc(str_replace('.zip', '', $backup)) ?>" method="post">
												<?= csrf_field() ?>
												<button class="btn btn-danger btn-block"><?= lang('General.delete') ?></button>
											</form>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Settings.settings') ?></div>
		<div class="card-body">
			<div class="row">
				<div class="col">
					<div class="alert alert-danger" role="alert">
						<h1 class="alert-heading"><?= lang('admin/Settings.reset') ?></h1>
						<p><?= lang('admin/Settings.resetWarningTitle') ?></p>
						<ul>
							<?php foreach(lang('admin/Settings.resetWarningList') as $warn) : ?>
								<li><?= esc($warn) ?></li>
							<?php endforeach ?>
						</ul>
						<hr>
						<p class="mb-0"><?= lang('admin/Settings.resetWarning2') ?></p>
					</div>
					<?= $this->setData(['name' => 'reset'])->include('admin/templates/message_block') ?>
					<form action="/admin/settings/data/reset" method="post"
							onsubmit="return confirm(this.getAttribute('confirm_message'))"
							confirm_message="<?= lang('admin/Settings.resetConfirm') ?>">
						<?= csrf_field() ?>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="reset-checkbox" name="reset-checkbox">
								<label class="custom-control-label" for="reset-checkbox"><?= lang('admin/Settings.confirmCheckbox') ?></label>
							</div>
						</div>
						<button class="btn btn-danger btn-block" id="reset-btn" disabled><?= lang('admin/Settings.reset') ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$("#reset-checkbox").click(function() {
			$("#reset-btn").prop("disabled", !$(this).is(":checked"));
		});
	</script>

<?= $this->endSection() ?>
