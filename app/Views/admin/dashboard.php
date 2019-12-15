<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="#">Dashboard</a>
	</li>
	<li class="breadcrumb-item active"></li>
</ol>

<div class="row mb-2">
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-primary o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($status['users']->Rows) ?> <?= lang('General.user') ?></h5>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-success o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($status['teams']->Rows) ?> <?= lang('General.team') ?></h5>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-warning o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($status['submits']->Rows) ?> <?= lang('General.submit') ?></h5>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-danger o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($status['solves']->Rows) ?> <?= lang('General.solve') ?></h5>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>