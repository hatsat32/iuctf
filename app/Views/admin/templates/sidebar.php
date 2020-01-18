<ul class="sidebar navbar-nav">
	<li class="nav-item active">
		<a class="nav-link" href="/admin">
			<i class="fas fa-chart-line"></i>
			<span><?= lang('admin/Templates.summary') ?></span>
		</a>
	</li>
	<li class="nav-item active">
		<a class="nav-link" href="/admin/categories">
			<i class="fas fa-bookmark"></i>
			<span><?= lang('admin/Templates.categories') ?></span>
		</a>
	</li>
	<li class="nav-item active">
		<a class="nav-link" href="/admin/challenges">
			<i class="fas fa-question-circle"></i>
			<span><?= lang('admin/Templates.challenges') ?></span>
		</a>
	</li>
	<li class="nav-item active">
		<a class="nav-link" href="/admin/teams">
			<i class="fas fa-user-friends"></i>
			<span><?= lang('admin/Templates.teams') ?></span>
		</a>
	</li>
	<li class="nav-item active">
		<a class="nav-link" href="/admin/users">
			<i class="fas fa-user"></i>
			<span><?= lang('admin/Templates.users') ?></span>
		</a>
	</li>
	<li class="nav-item active">
		<a class="nav-link" href="/admin/notifications">
			<i class="fas fa-bell"></i>
			<span><?= lang('admin/Templates.notifications') ?></span>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-file-alt"></i>
			<span><?= lang('admin/Templates.logs') ?></span>
		</a>
		<div class="dropdown-menu" aria-labelledby="pagesDropdown">
			<a class="dropdown-item" href="/admin/logs/submission"><?= lang('admin/Templates.flagSubmissions') ?></a>
			<a class="dropdown-item" href="/admin/logs/login"><?= lang('admin/Templates.loginLogs') ?></a>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="sidebar-settings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-cog"></i>
			<span><?= lang('admin/Templates.settings') ?></span>
		</a>
		<div class="dropdown-menu" aria-labelledby="sidebar-settings">
			<a class="dropdown-item" href="/admin/settings/general"><?= lang('admin/Settings.general') ?></a>
			<a class="dropdown-item" href="/admin/settings/timer"><?= lang('admin/Settings.timer') ?></a>
			<a class="dropdown-item" href="/admin/settings/data"><?= lang('admin/Settings.data') ?></a>
		</div>
	</li>
</ul>
