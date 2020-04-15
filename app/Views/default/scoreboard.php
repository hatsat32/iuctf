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

	<script>

		colors = {
			background: [
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 99, 132, 0.2)',
			],
			border: [
				'rgba(54, 162, 235, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 99, 132, 1)',
			]
		}

		data = JSON.parse($("#bar-chart-data").text()).slice(0, 20);
		team_names  = data.map((d) => { return d.name });
		team_scores = data.map((d) => { return d.score });

		var barChart = new Chart($("#scoreboard-bar-chart"), {
			type: 'bar',
			data: {
				labels: team_names,
				datasets: [{
					data: team_scores,
					backgroundColor: colors.background,
					borderColor: colors.border,
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				},
				legend: {
					display: false
				},
			}
		});

		linechartdata = JSON.parse($("#line-chart-data").text());
		linechartdata.map( (team, i) => {
			return {
				label: team.name,
				borderColor: colors.border[i],
				fill: false,
				data: team.solves.map(solve => {
					console.log({t: new moment(solve.date), y: solve.sub_point});
					return {t: new moment(solve.date), y: solve.sub_point}
				}),
			}
		})

		config = {
			type: 'line',
			data: {
				datasets: linechartdata.map( (team, i) => {
					return {
						label: team.name,
						borderColor: colors.border[i],
						fill: false,
						data: team.solves.map(solve => {
							console.log({t: new moment(solve.date), y: solve.sub_point});
							return {t: new moment(solve.date), y: solve.sub_point}
						}),
					}
				})
			},
			options: {
				responsive: true,
				scales: {
					xAxes: [{
						type: 'time',
					}],
				}
			}
		}

		var lineChart = new Chart($("#scoreboard-line-chart"), config);

	</script>

<?= $this->endSection() ?>