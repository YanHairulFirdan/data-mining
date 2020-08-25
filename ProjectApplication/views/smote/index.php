<div class="container">
	<div class="row table-wrapper" style="margin-left: 4em">
		<div class="col-md-12 ">
			<table class="table table-bordered mb-5">
				<thead>
					<tr>
						<th scope="col" class="text-center">no</th>
						<th scope="col" class="text-center">sex</th>
						<th scope="col" class="text-center">age</th>
						<th scope="col" class="text-center">time</th>
						<th scope="col" class="text-center">number of warts</th>
						<th scope="col" class="text-center">type</th>
						<th scope="col" class="text-center">area</th>
						<th scope="col" class="text-center">induration diameter</th>
						<th scope="col" class="text-center">result of treatment</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataset as $key => $value) : ?>
						<tr>
							<td class="text-center"><?= $key + 1 ?></td>
							<td class="text-center"><?= $value[0] ?></td>
							<td class="text-center"><?= $value[1] ?></td>
							<td class="text-center"><?= $value[2] ?></td>
							<td class="text-center"><?= $value[3] ?></td>
							<td class="text-center"><?= $value[4] ?></td>
							<td class="text-center"><?= $value[5] ?></td>
							<td class="text-center"><?= $value[6] ?></td>
							<td class="text-center"><?= $value[7] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>

		</div>


		<br>
		<br>
		<br>
		<br>
	</div>
	<div class="btn-collections">
		<button class="btn btn-success" id="tgl-btn">Tampilkan semua</button>
	</div>
	<div class="row mt-5">
		<div class="col-md-12">
			<canvas id="canvas" width="500" height="200"></canvas>
			<script type="text/javascript" src="<?= base_url(); ?>asset/js/Chart.js"></script>
		</div>
	</div>
</div>
<script>
	var ctx = document.getElementById("canvas").getContext('2d');
	let labels = ['minoritas', 'mayoritas'];
	var tglbutton = document.querySelector("#tgl-button");
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: <?php echo json_encode($labels); ?>,
			datasets: [{
				label: 'perbandingan jumlah sample kelas minoritas dan mayoritas',
				data: <?php echo json_encode($count); ?>,
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
				],
				borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
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
			}
		}
	});
</script>