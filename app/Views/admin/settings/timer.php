<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/settings"><?= lang('admin/Settings.settings') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Settings.timer') ?></li>
	</ol>

	<div class="m-2">

		<?= $this->include('admin/templates/message_block') ?>

		<form action="/admin/settings/timer" method="post">
			<?= csrf_field() ?>
			<div class="row">
				<div class="col-6">
					<h3><?= lang('admin/Settings.timerTitle') ?></h3>
					<p><?= lang('admin/Settings.timerDesc') ?></p>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="col-form-label" for="competition_timer"><?= lang('admin/Settings.ctfTimer') ?></label>
						<select class="custom-select " id="competition_timer" name="timer">
							<?php if($settings->competition_timer === 'on') : ?>
								<option selected value="on"><?= lang('General.on') ?></option>
								<option value="off"><?= lang('General.off') ?></option>
							<?php else : ?>
								<option value="on"><?= lang('General.on') ?></option>
								<option selected value="off"><?= lang('General.off') ?></option>
							<?php endif ?>
						</select>
					</div>
				</div>
			</div>

			<hr>

			<fieldset id="timer-box" <?= $settings->competition_timer === 'off' ? 'disabled' : '' ?>>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="start_time"><?= lang('admin/Settings.startTime') ?></label>
						<input type="datetime-local" class="form-control" id="start_time" name="start_time" value="<?= $settings->competition_start_time ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="end_time"><?= lang('admin/Settings.endTime') ?></label>
						<input type="datetime-local" class="form-control" id="end_time" name="end_time" value="<?= $settings->competition_end_time ?>">
					</div>
				</div>
			</fieldset>
			<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
		</form>
	</div>

	<script>
		$("#competition_timer").change(function() {
			console.log(this);

			if ($(this).val() === "on")
			{
				$("#timer-box").prop("disabled", false);
			}
			else if ($(this).val() === "off")
			{
				$("#timer-box").prop("disabled", true);
			}
		});
	</script>

<?= $this->endSection() ?>
