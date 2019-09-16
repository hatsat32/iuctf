<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Takımlar</li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="/admin/teams/new">Ekle</a>
	</div>

<!-- DataTables Example -->
<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			Takımlar</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Lider</th>
							<th>name</th>
							<th>Auth Code</th>
							<th>Ban</th>
							<th>Oluşturuldu</th>
							<th>Güncellendi</th>
							<th>Detay</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($teams as $team): ?>
						<tr>
							<td><?= esc($team["id"]) ?></td>
							<td><?= esc($team["leader_id"]) ?></td>
							<td><?= esc($team["name"]) ?></td>
							<td><?= esc($team["auth_code"]) ?></td>
							<td><?= esc($team["is_banned"]) ?></td>
							<td><?= esc($team["created_at"]) ?></td>
							<td><?= esc($team["updated_at"]) ?></td>
							<td><a class="btn btn-info btn-block" href="/admin/teams/<?= esc($team["id"]) ?>">Detay</a></td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
	</div>

	<script>
        $(document).ready(function() {
            $("#teams-table").DataTable();
        });
    </script>
<?= $this->endSection() ?>