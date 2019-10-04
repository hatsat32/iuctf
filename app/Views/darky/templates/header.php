<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<div class="container">
		<a class="navbar-brand" href="/">IUCTF</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-header" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbar-header">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/challenges">challenges</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/scoreboard">Puan Tablosu</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/notifications">Duyurular</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/hash">Hash</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if(logged_in()): ?>
					<li class="nav-item">
						<a class="nav-link" href="/team">Takım</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile">Profil</a>
					</li>
					<?php if(in_groups('admin')): ?>
						<li class="nav-item">
							<a class="nav-link" href="/admin">Admin</a>
						</li>
					<?php endif ?>
					<li class="nav-item">
						<a class="nav-link" href="/logout">Çıkış yap</a>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<a class="nav-link" href="/login">Giriş</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/register">Kaydol</a>
					</li>
				<?php endif ?>
            </ul>
		</div>
	</div>
</nav>
