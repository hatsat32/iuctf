<?= $this->extend("darky/templates/base") ?>

<?= $this->section('content') ?>

	<div class="my-4 text-center">
		<h1><?= lang('Home.scoreboard') ?></h1>
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
				<?php foreach($scores as $score): ?>
				<tr class="table-active">
					<td><?= esc($score['name']) ?></th>
					<td><?= esc($score['final']) ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

<?= $this->endSection() ?>