<?= $this->extend("templates/base") ?>

<?= $this->section('content') ?>

	<?php if(isset($no_team) && $no_team): ?>

		<div class="alert alert-warning w-100 m-2" role="alert">
			<?= lang('Home.noTeamMember') ?>
		</div>

		<div class="w-100 m-2">
			<?= $this->include('templates/message_block') ?>
		</div>

		<div class="card w-100 m-2">
			<div class="card-header">
				<i class="fas fa-chart-area"></i>
				<?= lang('Home.createTeam') ?></div>
			<div class="card-body">
				<form action="/createteam" method="post">
					<?= csrf_field() ?>
					<div class="form-group">
						<label for="name"><?= lang('Home.teamName') ?></label>
						<input type="name" name="name" class="form-control form-control-lg" id="name">
					</div>
					<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('Home.createTeam') ?></button>
				</form>
			</div>
		</div>

		<div class="card w-100 m-2">
			<div class="card-header">
				<i class="fas fa-chart-area"></i>
				<?= lang('Home.joinTeam') ?></div>
			<div class="card-body">
				<form action="/jointeam" method="post">
					<?= csrf_field() ?>
					<div class="form-group">
						<label for="auth_code"><?= lang('Home.authCode') ?></label>
						<input type="text" name="auth_code" class="form-control form-control-lg" id="auth_code">
					</div>
					<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('Home.joinTeam') ?></button>
				</form>
			</div>
		</div>

	<?php else: ?>

		<div class="m-2">
			<?= $this->include('templates/message_block') ?>
		</div>

		<div class="card m-2">
			<h3 class="card-header"><?= lang('Home.teamMembers') ?></h3>
			<ul class="list-group list-group-flush">
				<?php foreach($team_members as $member): ?>
					<li class="list-group-item"><?= esc($member->username) ?></li>
				<?php endforeach ?>
			</ul>
		</div>

		<hr>

		<h3><?= lang('Home.teamInfo') ?></h3>

		<hr>

		<table class="table table-hover">
			<tbody>
				<tr>
					<th><?= lang('Home.teamLeader') ?></th>
					<td><?= esc($team->leader()->username) ?></td>
				</tr>
				<tr>
					<th><?= lang('Home.teamName') ?></th>
					<td><?= esc($team->name) ?></td>
				</tr>
				<tr>
					<th><?= lang('Home.authCode') ?></th>
					<td><?= esc($team->auth_code) ?></td>
				</tr>
			</tbody>
		</table>

	<?php endif ?>

<?=$this->endSection()?>