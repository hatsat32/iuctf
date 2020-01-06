<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
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
						<table class="table table-bordered" id="teams-table" width="100%" cellspacing="0">
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
										<td>
											<a class="btn btn-info btn-block" href="/admin/settings/data/backup/<?= esc(str_replace('.zip', '', $backup)) ?>">
												<?= lang('admin/Settings.download') ?>
											</a>
										</td>
										<td>
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
			<?php if (session()->has('reset-error')) : ?>
				<div class="alert alert-danger">
					<?= session('reset-error') ?>
				</div>
			<?php endif ?>
			<div class="row">
				<div class="col">
					<h1><?= lang('admin/Settings.reset') ?></h1>

					<form action="/admin/settings/data/reset" method="post">
						<?= csrf_field() ?>
						<button class="btn btn-danger btn-block"><?= lang('admin/Settings.reset') ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>
