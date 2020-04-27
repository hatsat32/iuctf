<?= $this->extend("admin/templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('General.dashboard') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item active"></li>
	</ol>

	<div class="row mb-2">
		<div class="col-xl-3 col-sm-6 mb-1">
			<div class="card text-white bg-primary o-hidden h-100">
				<div class="card-body">
					<h5 class="mb-0"><?= esc($user_count) ?> <?= lang('General.user') ?></h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 mb-1">
			<div class="card text-white bg-success o-hidden h-100">
				<div class="card-body">
					<h5 class="mb-0"><?= esc($team_count) ?> <?= lang('General.team') ?></h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 mb-1">
			<div class="card text-white bg-warning o-hidden h-100">
				<div class="card-body">
					<h5 class="mb-0"><?= esc($submission_count) ?> <?= lang('General.submission') ?></h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 mb-1">
			<div class="card text-white bg-danger o-hidden h-100">
				<div class="card-body">
					<h5 class="mb-0"><?= esc($solve_count) ?> <?= lang('General.solve') ?></h5>
				</div>
			</div>
		</div>
	</div>

	<div id="submissions" style="display:none"><?= json_encode($submission_chart_data) ?></div>
	<div id="challenges" style="display:none"><?= json_encode($challenge_chart_data) ?></div>

	<div class="row">
		<div class="col-lg-8">
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-chart-bar"></i>
					<?= lang('General.challenges') ?></div>
				<div class="card-body">
					<canvas id="challenge-chart" width="100%" height="50"></canvas>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-chart-pie"></i>
					<?= lang('General.submissions') ?></div>
				<div class="card-body">
					<canvas id="submission-chart" width="100%" height="100"></canvas>
				</div>
			</div>
		</div>
	</div>

	<script src="/lib/Chart/Chart.min.js"></script>

	<script>

		let challenges = JSON.parse($("#challenges").text());
		var challenges_chart = new Chart($("#challenge-chart"), {
			type: 'bar',
			data: {
				labels: challenges.map(x => {return x.name}),
				datasets: [ {
						label: "Challenges",
						backgroundColor: "rgba(2,117,216,1)",
						borderColor: "rgba(2,117,216,1)",
						data: challenges.map(x => {return x.solve_count})
					}
				],
			},
			options: {
				scales: {
					xAxes: [{
						gridLines: {
							display: false
						},
						ticks: {
							maxTicksLimit: 6
						}
					}],
					yAxes: [{
						ticks: {
							min: 0,
							maxTicksLimit: 5,
							stepSize: 1
						},
						gridLines: {
							display: true
						}
					}],
				},
				legend: {
					display: false
				}
			}
		});

		let subs = JSON.parse($("#submissions").text());
		var submissions_chart = new Chart($("#submission-chart"), {
			type: 'pie',
			data: {
					labels: ["Correct", 'Wrong'],
					datasets: [{
					data: [subs.correct, subs.wrong],
					backgroundColor: ['#28a745', '#dc3545'],
				}],
			},
		});

	</script>

<?= $this->endSection() ?>