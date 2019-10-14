<?=$this->extend("darky/templates/base")?>

<?=$this->section('content')?>

<?php if (user()->team_id === null): ?>
	<div class="alert alert-danger m-2" role="alert">
		<h3 class="alert-heading"><?= lang('Home.watchOut') ?></h3>
		<p><?= lang('Home.findTeamToComp') ?></p>
		<hr>
		<a class="alert-link" href="/team"><?= lang('Home.visitTeamPage') ?></a>
	</div>
<?php endif ?>

<div class="row">
	<div class="col-md-4 my-2">
		<?php foreach ($categories as $category): ?>
			<?php if (isset($category['challenges']) === true): ?>
				<div class="card border-secondary mb-3">
					<h4 class="card-header"><?=esc($category['name'])?></h4>
					<div class="list-group list-group-flush">
						<?php foreach ($category['challenges'] as $ch): ?>
							<a href="/challenges/<?=$ch['id']?>" class="list-group-item list-group-item-action <?= in_array($ch['id'], $solves)? 'text-success':'text-danger' ?>">
								<?=esc($ch['name'])?> (<?=esc($ch['point'])?>)</a>
						<?php endforeach?>
					</div>
				</div>
			<?php endif?>
		<?php endforeach?>
	</div>


	<div class="col-md-8">
		<?php if(isset($challenge)): ?>
			<div class="card m-2">
				<h3 class="card-header <?= in_array($challenge['id'], $solves)? 'bg-success':'bg-danger' ?>"><?= esc($challenge['name']) ?></h3>
				<div class="card-body">
					<p class="card-text"><?= esc($challenge['description']) ?></p>
				</div>

				<ul class="list-group list-group-flush">
					<li class="list-group-item text-info"><?= esc($challenge['point']) ?> Point</li>
				</ul>

				<?php if(session()->has('result')): ?>
					<?php if (session('result') === true): ?>
						<div class="alert alert-dismissible alert-success m-2">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= lang('Home.rightAnswer') ?>
						</div>
					<?php else: ?>
						<div class="alert alert-dismissible alert-danger m-2">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= lang('Home.wrongAnswer') ?>
						</div>
					<?php endif ?>
				<?php endif ?>

				<div class="card-footer text-muted">
					<div class="w-100">
						<form class="" action="/challenges/<?= esc($challenge['id']) ?>" method="post">
							<?= csrf_field() ?>
							<div class="form-row">
								<div class="col-9">
									<input type="text" name="flag" class="form-control" placeholder="Flag gir">
									<input type="hidden" name="ch-id">
								</div>
								<div class="col-3">
									<button type="submit" class="btn btn-primary btn-block"><?= lang('Home.submit') ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>

<?=$this->endSection()?>