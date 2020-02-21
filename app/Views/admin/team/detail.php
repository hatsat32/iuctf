<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Team.editTeam') ?></li>
	</ol>

	<!-- TEAM UPDATE FORM -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Team.editTeam') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-teams-show', $team->id) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="team_id"><?= lang('General.team')." ".lang('General.id') ?></label>
					<input disabled class="form-control" id="team_id" value="<?= esc($team->id) ?>">
				</div>
				<div class="form-group">
					<label for="auth_code"><?= lang('admin/Team.authCode') ?></label>
					<input disabled class="form-control" id="auth_code" value="<?= esc($team->auth_code) ?>">
				</div>
				<div class="form-group">
					<label for="leader_id"><?= lang('admin/Team.leaderUsername') ?></label>
					<select name="leader_id" class="form-control" id="leader_id">
						<?php foreach($teamMembers as $member) : ?>
							<option <?= $member->id === $team->leader_id ? "selected":"" ?> value="<?= esc($member->id) ?>"><?= esc($member->username) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="name"><?= lang('General.name') ?></label>
					<input type="name" name="name" class="form-control" id="name" value="<?= esc($team->name) ?>">
				</div>
				<div class="form-group">
					<label for="created_at"><?= lang('General.createdAt') ?></label>
					<input disabled class="form-control" id="created_at" value="<?= esc($team->created_at) ?>">
				</div>
				<div class="form-group">
					<label for="updated_at"><?= lang('General.updatedAt') ?></label>
					<input disabled class="form-control" id="updated_at" value="<?= esc($team->updated_at) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Team.updateTeam') ?></button>
			</form>

			<!-- DELETE THE CODE -->
			<div class="mt-4">
				<form action="<?= route_to('admin-teams-delete', $team->id) ?>" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Team.deleteTeam') ?></button>
				</form>
			</div>

			<!-- CHANGE AUTH CODE -->
			<div class="mt-4">
				<form action="<?= route_to('admin-teams-authcode', $team->id) ?>" method="post">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-info btn-block"><?= lang('admin/Team.changeAuthCode') ?></button>
				</form>
			</div>

			<!-- BAN/UNBAN THE TEAM -->
			<div class="mt-4">
				<?php if ($team->is_banned == '0') : ?>
					<form action="<?= route_to('admin-teams-ban', $team->id) ?>" method="post">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/Team.doBan') ?></button>
					</form>
				<?php else : ?>
					<form action="<?= route_to('admin-teams-unban', $team->id) ?>" method="post">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/Team.doUnban') ?></button>
					</form>
				<?php endif ?>
			</div>
		</div>
	</div>

	<!-- USERS MEMBER OF THE TEAM -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Team.teamMembers') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.username') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('General.email') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($teamMembers as $member) : ?>
							<tr>
								<td><?= esc($member->id) ?></td>
								<td><?= esc($member->username) ?></td>
								<td><?= esc($member->name) ?></td>
								<td><?= esc($member->email) ?></td>
								<td class="p-1">
									<a href="<?= route_to('admin-users-show', $member->id) ?>" class="btn btn-primary btn-block">
										<?= lang('General.detail') ?>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- SOLVES AND MARK AS SOLVED -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Team.markAsSolved') ?></div>
		<div class="card-body">
			<?= $this->setData(['name' => 'mark-solved'])->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-teams-solves', $team->id) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-row">
					<div class="col-md-4">
						<div class="form-group">
							<select name="user_id" class="form-control" id="user_id" required>
								<option disabled selected value><?= lang('admin/Team.selectUser') ?></option>
								<?php foreach($teamMembers as $member) : ?>
									<option value="<?= esc($member->id) ?>"><?= esc($member->username) ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<select name="challenge_id" class="form-control" id="challenge_id" required>
								<option disabled selected value><?= lang('admin/Team.selectChallenge') ?></option>
								<?php foreach($challenges as $challenge) : ?>
									<?php if ($challenge->solves_id === null) : ?>
										<option value="<?= esc($challenge->id) ?>"><?= esc($challenge->name) ?></option>
									<?php endif ?>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Team.markAsSolved') ?></button>
					</div>
				</div>
			</form>
			<hr>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('General.username') ?></th>
							<th><?= lang('admin/Team.solvedAt') ?></th>
							<th><?= lang('General.delete') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($challenges as $challenge) : ?>
							<?php if ($challenge->solves_id !== null) : ?>
								<tr>
									<td><?= esc($challenge->solves_id) ?></td>
									<td><?= esc($challenge->name) ?></td>
									<td><?= esc($challenge->solves_username) ?></td>
									<td><?= esc($challenge->solves_at) ?></td>
									<td class="p-1">
										<form action="<?= route_to('admin-teams-solves-delete', $team->id, $challenge->solves_id) ?>" method="post">
											<?= csrf_field() ?>
											<button class="btn btn-danger btn-block"><?= lang('General.delete') ?></button>
										</form>
									</td>
								</tr>
							<?php endif ?>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>