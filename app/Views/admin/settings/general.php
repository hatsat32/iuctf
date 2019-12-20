<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="#">Config</a>
		</li>
		<li class="breadcrumb-item active">Genel</li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Config.general') ?></div>
		<div class="card-body">

			<div class="row">
				<div class="col-md-6">
					<h3>Ctf Name</h3>
					<p>The name of the Competition. Or the name of the "ctf".</p>
				</div>
				<div class="col-md-6">
					<form action="/admin/config/update" method="post">
						<?= csrf_field() ?>
						<div class="form-group">
							<label for="competition-name"><?= lang('admin/Config.name') ?></label>
							<input type="text" name="competition_name" class="form-control" id="competition-name" required>
						</div>
						<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
					</form>
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="col-md-6">
					<h3>Team Member Limit</h3>
					<p>Max team member.</p>
				</div>
				<div class="col-md-6">
					<form action="/admin/config/update" method="post">
						<?= csrf_field() ?>
						<div class="form-group">
							<label for="team-member-limit"><?= lang('admin/Config.memberLimit') ?></label>
							<input type="number" name="team_member_limit" class="form-control" id="team-member-limit">
						</div>
						<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
					</form>
				</div>
			</div>

			<hr>

			
			<div class="row">
				<div class="col-md-6">
					<h3>Theme</h3>
					<p>The theme of the ctf</p>
				</div>
				<div class="col-md-6">
					<form action="/admin/config/update" method="post">
						<?= csrf_field() ?>
						<div class="form-group">
							<label for="theme"><?= lang('admin/Config.theme') ?></label>
							<select name="theme" class="form-control" id="theme">
								<option value="default"><?= lang('admin/Config.default') ?></option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
					</form>
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="col-md-6">
					<h3>Allow Register</h3>
					<p>New user register allow or dissallow</p>
				</div>
				<div class="col-md-6">
					<form action="/admin/config/update" method="post">
						<?= csrf_field() ?>
						<div class="form-group">
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="allow" name="allow_register" required>
								<label class="custom-control-label" for="allow">Allow Register</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="disallow" name="allow_register" required>
								<label class="custom-control-label" for="disallow">Disallow Register</label>
							</div>
						</div>
						<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
					</form>
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="col-md-6">
					<h3>Need hash for falgs</h3>
					<p>New user register allow or dissallow</p>
				</div>
				<div class="col-md-6">
					<form action="/admin/config/update" method="post">
						<?= csrf_field() ?>
						<div class="form-group">
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="need-hash" name="need_hash" required>
								<label class="custom-control-label" for="need-hash">Need hash for flags</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="no-need-hash" name="need_hash" required>
								<label class="custom-control-label" for="no-need-hash">No need hash for flags</label>
							</div>
						</div>
						<div class="form-group">
							<label for="competition-name"><?= lang('admin/Config.hashSecretKey') ?></label>
							<input type="text" name="competition-name" class="form-control" id="competition-name">
						</div>
						<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
					</form>
				</div>
			</div>

		</div>
	</div>

<?= $this->endSection() ?>