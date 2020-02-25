<?= $this->extend("templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('General.challenges') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<?php if (user()->team_id === null) : ?>
		<div class="alert alert-danger m-2" role="alert">
			<h3 class="alert-heading"><?= lang('Home.watchOut') ?></h3>
			<p><?= lang('Home.findTeamToComp') ?></p>
			<hr>
			<a class="alert-link" href="<?= route_to('team') ?>"><?= lang('Home.visitTeamPage') ?></a>
		</div>
	<?php endif ?>

	<?php foreach ($categories as $category) : ?>
		<?php if (isset($category->challenges)) : ?>
			<hr>
			<h2><?= esc($category->name) ?></h2>
			<div class="row">
				<?php foreach ($category->challenges as $ch) : ?>
					<div class="col-md-4 col-lg-3 p-2">
						<a class="card <?= in_array($ch->id, $solves) ? 'bg-success':'bg-danger' ?>" href="<?= route_to('challenge-detail', $ch->id) ?>">
							<div class="card-body">
								<h5 class="card-title text-center text-white"><?= esc($ch->name) ?></h4>
								<h4 class="card-title text-center mb-0 text-white font-weight-bold">
									<?= esc($ch->point) .' '. lang('General.point') ?>
								</h4>
							</div>
						</a>
					</div>
				<?php endforeach ?>
			</div>
		<?php endif ?>
	<?php endforeach ?>

	<style>
		.card:hover {
			text-decoration: none;
		}
	</style>

<?= $this->endSection() ?>