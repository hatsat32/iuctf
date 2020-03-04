<?=$this->extend("templates/base")?>


<?= $this->section('title') ?>
	<?= esc(ss()->ctf_name) ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

	<!-- DO NOT ESCAPE -->
	<?= $content ?>

<?= $this->endSection() ?>