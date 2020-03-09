<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/settings"><?= lang('admin/Settings.settings') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Settings.general') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Settings.general') ?></div>
		<div class="card-body">
			<?= $this->include('admin/templates/message_block') ?>

			<form action="/admin/settings/general" method="post">
				<?= csrf_field() ?>
				<div class="row">
					<div class="col-md-6">
						<h3><?= lang('admin/Settings.ctfNameTitle') ?></h3>
						<p><?= lang('admin/Settings.ctfNameDesc') ?></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="ctf-name"><?= lang('admin/Settings.ctfName') ?></label>
							<input type="text" name="ctf_name" class="form-control" id="ctf-name"
									value="<?= esc($settings->ctf_name) ?>" required>
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-md-6">
						<h3><?= lang('admin/Settings.teamMemberLimitTitle') ?></h3>
						<p><?= lang('admin/Settings.teamMemberLimitDesc') ?></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="team-member-limit"><?= lang('admin/Settings.memberLimit') ?></label>
							<input type="number" name="team_member_limit" class="form-control" id="team-member-limit"
									value="<?= esc($settings->team_member_limit) ?>" required>
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-md-6">
						<h3><?= lang('admin/Settings.themeTitle') ?></h3>
						<p><?= lang('admin/Settings.themeDesc') ?></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="theme"><?= lang('admin/Settings.theme') ?></label>
							<select name="theme" class="form-control" id="theme">
								<option value="default" <?= ss()->theme === 'default' ? 'selected':'' ?>>
									<?= lang('admin/Settings.default') ?>
								</option>
								<?php foreach ($themes as $theme) : ?>
									<option value="<?= esc($theme, 'attr') ?>" <?= ss()->theme === $theme ? 'selected':'' ?>>
										<?= esc($theme) ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-md-6">
						<h3><?= lang('admin/Settings.allowRegisterTitle') ?></h3>
						<p><?= lang('admin/Settings.allowRegisterDesc') ?></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="allow" name="allow_register" value="true"
										<?= $settings->allow_register === true ? 'checked':'' ?> required>
								<label class="custom-control-label" for="allow"><?= lang('admin/Settings.allowRegister') ?></label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="disallow" name="allow_register" value="false"
										<?= $settings->allow_register === false ? 'checked':'' ?> required>
								<label class="custom-control-label" for="disallow"><?= lang('admin/Settings.disallowRegister') ?></label>
							</div>
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-md-6">
						<h3><?= lang('admin/Settings.needHashTitle') ?></h3>
						<p><?= lang('admin/Settings.needHashDesc') ?></p>
						<p><?= lang('admin/Settings.needHashKeyDesc') ?></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="need-hash" name="need_hash" value="true"
										<?= $settings->need_hash === true ? 'checked':'' ?> required>
								<label class="custom-control-label" for="need-hash"><?= lang('admin/Settings.needHash') ?></label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="no-need-hash" name="need_hash" value="false"
										<?= $settings->need_hash === false ? 'checked':'' ?> required>
								<label class="custom-control-label" for="no-need-hash"><?= lang('admin/Settings.noNeedHash') ?></label>
							</div>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="hash-secret-key" name="hash_secret_key"
									<?= $settings->need_hash === false ? 'disabled':'' ?>>
							<label class="custom-control-label" for="hash-secret-key"><?= lang('admin/Settings.regenHashSecretKey') ?></label>
						</div>
						<div class="form-group">
							<input type="text" id="hash_secret_key" class="form-control" value="<?= esc($settings->hash_secret_key) ?>" disabled>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
			</form>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('input:radio[name=need_hash]').change(function () {
				if ($(this).val() == "false") {
					$("#hash-secret-key").prop("disabled", true);
				} else {
					$("#hash-secret-key").prop("disabled", false);

					if ($("#hash_secret_key").val() === "") {
						$("#hash-secret-key").prop("checked", true);
					}
				}
			});
		});
	</script>

<?= $this->endSection() ?>