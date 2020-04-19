<?= $this->extend("templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('Home.scoreboard') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<div class="my-4 text-center">
		<h1><?= lang('Home.scoreboard') ?></h1>
	</div>

	<div class="my-2">
		<canvas id="scoreboard-bar-chart" height="100"></canvas>
	</div>

	<div class="my-2">
		<canvas id="scoreboard-line-chart" height="100"></canvas>
	</div>

	<div class="m-2">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col"><?= lang('Home.teamName') ?></th>
					<th scope="col"><?= lang('General.point') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($scores as $score) : ?>
					<tr class="table-active">
						<td><?= esc($score->name) ?></th>
						<td><?= esc($score->final) ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

	<div id="bar-chart-data" style="display: none"><?= esc($bar_chart_scores) ?></div>
	<div id="line-chart-data" style="display: none"><?= esc($line_chart_scores) ?></div>

	<script src="/lib/moment/moment.min.js"></script>
	<script src="/lib/Chart/Chart.min.js"></script>
	<script src="/js/scoreboard.js"></script>

<?= $this->endSection() ?>