<?= $this->extend("templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('General.team') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<div class="alert alert-warning w-100 my-4" role="alert">
		<?= lang('Home.noTeamMember') ?>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<h3 class="card-header">
					<i class="fas fa-chart-area"></i>
					<?= lang('Home.createTeam') ?></h3>
				<div class="card-body">
					<div class="w-100">
						<?= $this->setData(['name' => 'createteam'])->include('templates/message_block') ?>
					</div>
					<form action="<?= route_to('createteam') ?>" method="post">
						<?= csrf_field() ?>
						<div class="form-group">
							<label for="name"><?= lang('Home.teamName') ?></label>
							<input type="name" name="name" class="form-control form-control-lg" id="name">
						</div>
						<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('Home.createTeam') ?></button>
					</form>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<h3 class="card-header">
					<i class="fas fa-chart-area"></i>
					<?= lang('Home.joinTeam') ?></h3>
				<div class="card-body">
					<div class="w-100">
						<?= $this->setData(['name' => 'jointeam'])->include('templates/message_block') ?>
					</div>
					<form action="<?= route_to('jointeam') ?>" method="post">
						<?= csrf_field() ?>
						<div class="form-group">
							<label for="auth_code"><?= lang('Home.authCode') ?></label>
							<input type="text" name="auth_code" class="form-control form-control-lg" id="auth_code">
						</div>
						<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('Home.joinTeam') ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

<?=$this->endSection()?>