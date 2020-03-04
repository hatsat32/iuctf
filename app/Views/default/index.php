<?=$this->extend("templates/base")?>


<?= $this->section('title') ?>
	<?= esc(ss()->ctf_name) ?>
<?= $this->endSection() ?>


<?=$this->section('content')?>

<?=$this->endSection()?>