<?=$this->extend("darky/templates/base")?>

<?=$this->section('content')?>

	<div class="col-md-4">
		<div class="m-4">
			<ul class="tree">
				<?php foreach ($categories as $category): ?>
					<li><?=esc($category['name'])?>
						<ul>
							<?php if (isset($category['challenges']) === true): ?>
								<?php foreach ($category['challenges'] as $ch): ?>
									<li>
										<a class="text-danger" href="/challenges/<?=$ch['id']?>"><?=esc($ch['name'])?> (<?=esc($ch['point'])?>)</a>
									</li>
								<?php endforeach?>
							<?php endif?>
						</ul>
					</li>
				<?php endforeach?>
			</ul>
		</div>
	</div>


	<div class="col-md-8">
		<?php if(isset($challenge)): ?>
			<div class="card m-4">
				<h3 class="card-header"><?= esc($challenge['name']) ?></h3>
				<div class="card-body">
					<p class="card-text"><?= esc($challenge['description']) ?></p>
				</div>

				<ul class="list-group list-group-flush">
					<li class="list-group-item text-info"><?= esc($challenge['point']) ?> Point</li>
				</ul>

				<div class="card-footer text-muted">
					<div class="w-100">
						<form class="" action="/challenges/<?= esc($challenge['id']) ?>" method="post">
							<div class="form-row">
								<div class="col-9">
									<input type="text" name="flag" class="form-control" placeholder="Flag gir">
									<input type="hidden" name="ch-id" class="ch-id">
								</div>
								<div class="col-3">
									<button type="submit" class="btn btn-primary btn-block">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>

	<style>
		ul.tree, ul.tree ul {
			list-style: none;
			margin: 10px;
			padding: 0;
		}
		ul.tree ul {
			margin-left: 20px;
		}
		ul.tree li {
			margin: 0;
			padding: 0 7px;
			line-height: 20px;
			color: #369;
			font-weight: bold;
			border-left:1px solid rgb(250,250,250);
		}
		ul.tree li:last-child {
			border-left:none;
		}
		ul.tree li:before {
			position:relative;
			top:-0.3em;
			height:2em;
			width:20px;
			color:white;
			border-bottom:1px solid rgb(250,250,250);
			content:"";
			display:inline-block;
			left:-7px;
		}
		ul.tree li:last-child:before {
			border-left:1px solid rgb(250,250,250);
		}
	</style>
<?=$this->endSection()?>