<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Team.editTeam') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Team.editTeam') ?></div>
		<div class="card-body">
			<form action="/admin/teams/<?= esc($team['id']) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="team_id"><?= lang('General.team')." ".lang('General.id') ?></label>
					<input disabled class="form-control" id="team_id" value="<?= esc($team['id']) ?>">
				</div>
				<div class="form-group">
					<label for="auth_code"><?= lang('admin/Team.authCode') ?></label>
					<input disabled class="form-control" id="auth_code" value="<?= esc($team['auth_code']) ?>">
				</div>
				<div class="form-group">
					<label for="leader_id"><?= lang('admin/Team.leaderId') ?></label>
					<select name="leader_id" class="form-control" id="leader_id">
						<?php foreach($teamMembers as $member) : ?>
							<option <?= $member['id']===$team['leader_id'] ? "selected":"" ?> value="<?= esc($member["id"]) ?>"><?= esc($member["username"]) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="name"><?= lang('General.name') ?></label>
					<input type="name" name="name" class="form-control" id="name" value="<?= esc($team['name']) ?>">
				</div>
				<div class="form-group">
					<label for="created_at"><?= lang('General.createdAt') ?></label>
					<input disabled class="form-control" id="created_at" value="<?= esc($team['created_at']) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at"><?= lang('General.updatedAt') ?></label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($team['updated_at']) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Team.updateTeam') ?></button>
			</form>

			<div class="mt-4">
				<form action="/admin/teams/<?= esc($team['id']) ?>/delete" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Team.deleteTeam') ?></button>
				</form>
			</div>

			<div class="mt-4">
				<form action="/admin/teams/<?= esc($team['id']) ?>/authcode" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-info btn-block"><?= lang('admin/Team.changeAuthCode') ?></button>
				</form>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>