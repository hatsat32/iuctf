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

// Chart.defaults.global.elements.point.radius = 0

data = JSON.parse($("#bar-chart-data").text()).slice(0, 20);
if (data.length !== 0) {
	var barChart = new Chart($("#scoreboard-bar-chart"), {
		type: 'bar',
		data: {
			labels: data.map((d) => { return d.name }),
			datasets: [{
				data: data.map((d) => { return d.score }),
				backgroundColor: colors.background,
				borderColor: colors.border,
				borderWidth: 1,
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
} else {
	$("#scoreboard-bar-chart").parent().hide();
}

linechartdata = JSON.parse($("#line-chart-data").text()).slice(0, 20);

if (linechartdata.length !== 0){
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
					lineTension: 0,
					// radius: 3,
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
} else {
	$("#scoreboard-line-chart").parent().hide();
}