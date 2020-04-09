<?= $this->extend("admin/templates/base") ?>


<?= $this->section('title') ?>
	<?= esc($user->username) ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= route_to('admin-dashboard') ?>"><?= lang('General.dashboard') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/User.userDetail') ?></li>
	</ol>

	<!-- UPDATE USER -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/User.userDetail') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-users-show', $user->id) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="username"><?= lang('admin/User.enterUsername') ?></label>
					<input type="text" name="username" class="form-control" id="username" value="<?= esc($user->username) ?>">
				</div>
				<div class="form-group">
					<label for="email"><?= lang('admin/User.enterEmail') ?></label>
					<input type="email" name="email" class="form-control" id="email" value="<?= esc($user->email) ?>">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('General.name') ?></label>
					<input type="text" name="name" class="form-control" id="name" value="<?= esc($user->name) ?>">
				</div>
				<div class="form-group">
					<label for="team_id"><?= lang('admin/User.selectTeam') ?></label>
					<select name="team_id" class="form-control" id="team_id">
						<option disabled selected value>--- <?= lang('admin/User.pickATeam') ?> ---</option>
						<?php foreach($teams as $team) : ?>
							<option <?= $user->team_id === $team->id ? "selected":"" ?> value="<?= esc($team->id) ?>"><?= esc($team->name) ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/User.updateUser') ?></button>
			</form>

			<!-- DELETE THE USER -->
			<div class="mt-4">
				<form action="<?= route_to('admin-users-delete', $user->id) ?>" method="post"
						onsubmit="return confirm(this.getAttribute('confirm_message'))"
						confirm_message="<?= lang('admin/User.deleteUserConfirm', [$user->username]) ?>">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/User.deleteUser') ?></button>
				</form>
			</div>

			<!-- REMOVE USER FROM TEAM -->
			<?php if ($user->team_id !== null) : ?>
				<div class="mt-4">
					<form action="<?= route_to('admin-users-rmfromteam', $user->id) ?>" method="post"
							onsubmit="return confirm(this.getAttribute('confirm_message'))"
							confirm_message="<?= lang('admin/User.removeFromTeamConfirm', [$user->username]) ?>">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/User.removeFromTeam') ?></button>
					</form>
				</div>
			<?php endif ?>

			<!-- ADD/REMOVE USER TO/FROM ADMIN GROUP -->
			<?php if(Config\Services::authorization()->inGroup('admin', $user->id)) : ?>
				<div class="mt-4">
					<form action="<?= route_to('admin-users-rmadmin', $user->id) ?>" method="post"
							onsubmit="return confirm(this.getAttribute('confirm_message'))"
							confirm_message="<?= lang('admin/User.removeFromAdminConfirm', [$user->username]) ?>">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/User.unmakeAdmin') ?></button>
					</form>
				</div>
			<?php else : ?>
				<div class="mt-4">
					<form action="<?= route_to('admin-users-addadmin', $user->id) ?>" method="post"
							onsubmit="return confirm(this.getAttribute('confirm_message'))"
							confirm_message="<?= lang('admin/User.addToAdminConfirm', [$user->username]) ?>">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/User.makeAdmin') ?></button>
					</form>
				</div>
			<?php endif ?>

			<!-- ACTIVATE THE USER IF NOT YET -->
			<?php if ($user->active !== '1') : ?>
				<div class="mt-4">
					<form action="<?= route_to('admin-users-activate', $user->id) ?>" method="post"
							onsubmit="return confirm(this.getAttribute('confirm_message'))"
							confirm_message="<?= lang('admin/User.activateUserConfirm', [$user->username]) ?>">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/User.activateUser') ?></button>
					</form>
				</div>
			<?php endif ?>

			<!-- BAN/UNBAN THE USER -->
			<div class="mt-4">
				<?php if ($user->status == 'banned') : ?>
					<form action="<?= route_to('admin-users-unban', $user->id) ?>" method="post"
							onsubmit="return confirm(this.getAttribute('confirm_message'))"
							confirm_message="<?= lang('admin/User.unbanUserConfirm', [$user->username]) ?>">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/User.doUnBan') ?></button>
					</form>
				<?php else : ?>
					<form action="<?= route_to('admin-users-ban', $user->id) ?>" method="post"
							onsubmit="return confirm(this.getAttribute('confirm_message'))"
							confirm_message="<?= lang('admin/User.banUserConfirm', [$user->username]) ?>">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/User.doBan') ?></button>
					</form>
				<?php endif ?>
			</div>
		</div>
	</div>

	<!-- CHANGE USER'S PASSWORD -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('Home.updatePassword') ?></div>
		<div class="card-body">
			<?= $this->setData(['name' => 'chpass'])->include('admin/templates/message_block') ?>
			<form action="<?= route_to('admin-users-chpass', $user->id) ?>" method="post">
				<?= csrf_field() ?>
				<input type="hidden" name="email" value="<?= esc($user->email) ?>">
				<div class="form-group">
					<label for="password"><?= lang('admin/User.enterPassword') ?></label>
					<input type="password" name="password" class="form-control" id="password">
				</div>
				<div class="form-group">
					<label for="password-confirm"><?= lang('admin/User.confirmPassword') ?></label>
					<input type="password" name="password-confirm" class="form-control" id="password-confirm">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('Home.updatePassword') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>
