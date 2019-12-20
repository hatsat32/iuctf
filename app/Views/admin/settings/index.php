<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Config</a>
		</li>
		<li class="breadcrumb-item active">Genel</li>
	</ol>

	<div class="m-2">
		<form action="/admin/config/competition-timer" method="post">
			<?= csrf_field() ?>
			<fieldset>
				<div class="form-row">
					<div class="col-4">
						<label class="col-form-label" for="competition_timer">Competition Timer</label>
					</div>
					<div class="col-6">
						<select class="custom-select " id="competition_timer" name="timer">
							<?php if($config['competition_timer'] === 'on'): ?>
								<option selected value="on">Açık</option>
								<option value="off">Kapalı</option>
							<?php else: ?>
								<option value="on">Açık</option>
								<option selected value="off">Kapalı</option>
							<?php endif ?>
						</select>
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-primary btn-block">Kaydet</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>

	<div class="m-2">
		<form action="/admin/config/competition-times" method="post">
			<?= csrf_field() ?>
			<fieldset <?= $config['competition_timer']=='off' ? 'disabled':'' ?>>
				<div class="form-row">
					<div class="form-group col-md-5">
						<label for="start_time">Başlangıç Zamanı</label>
						<input type="datetime-local" class="form-control" id="start_time" name="start_time" placeholder="">
					</div>
					<div class="form-group col-md-5">
						<label for="end_time">Bitiş Zamanı</label>
						<input type="datetime-local" class="form-control" id="end_time" name="end_time" placeholder="">
					</div>
					<div class="form-group col-md-2 d-flex align-self-end">
						<button type="submit" class="btn btn-primary btn-block">Zamanla</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>

	<div class="m-2">
		<form action="" class="">
			<div class="form-row">
				<div class="col-4">
					<label class="col-form-label" for="competition_start_time">Competition Timer</label>
				</div>
				<div class="col-6">
					<input type="text" class="form-control" name="competition_start_time" id="competition_start_time">
				</div>
				<div class="col-2">
					<button type="submit" class="btn btn-primary btn-block">Kaydet</button>
				</div>
			</div>
		</form>
	</div>

	<div class="m-2">
		<form action="" class="">
			<div class="form-row">
				<div class="col-4">
					<label class="col-form-label" for="competition_end_time">Competition Timer</label>
				</div>
				<div class="col-6">
					<input type="text" class="form-control" name="competition_end_time" id="competition_end_time">
				</div>
				<div class="col-2">
					<button type="submit" class="btn btn-primary btn-block">Kaydet</button>
				</div>
			</div>
		</form>
	</div>
	
	
<?= $this->endSection() ?>