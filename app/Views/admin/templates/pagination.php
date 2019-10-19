<?php $pager->setSurroundCount(3) ?>

<div>
	<ul class="pagination justify-content-center pagination-lg">
		<?php if ($pager->hasPrevious()) : ?>
			<li class="page-item">
				<a class="page-link" href="<?= $pager->getFirst() ?>">First</a>
			</li>

			<li class="page-item">
				<a class="page-link" href="<?= $pager->getPrevious() ?>">&laquo;</a>
			</li>
		<?php endif ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li class="page-item <?= $link['active'] ? 'active' : '' ?>">
				<a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
			<li class="page-item">
				<a class="page-link" href="<?= $pager->getNext() ?>">&raquo;</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="<?= $pager->getLast() ?>">Last</a>
			</li>
		<?php endif ?>
	</ul>
</div>