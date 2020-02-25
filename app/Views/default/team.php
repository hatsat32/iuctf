<?= $this->extend("templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('General.team') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<div class="m-2">
		<?= $this->include('templates/message_block') ?>
	</div>

	<div class="card my-2">
		<h3 class="card-header"><?= lang('Home.teamMembers') ?></h3>
		<div class="table-responsive p-2">
			<table class="table table-sm table-borderless">
				<thead>
					<tr>
						<th><?= lang('General.username') ?></th>
						<th><?= lang('General.name') ?></th>
						<th><?= lang('General.email') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($team_members as $member) : ?>
						<tr>
							<td><?= esc($member->username) ?></td>
							<td><?= esc($member->name) ?></td>
							<td><?= esc($member->email) ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>

	<hr>

	<h3><?= lang('Home.teamInfo') ?></h3>

	<div class="table-responsive">
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
	</div>

<?=$this->endSection()?>