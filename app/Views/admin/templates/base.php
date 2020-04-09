<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?= $this->renderSection("title") ?> · IUCTF</title>

	<!-- Custom fonts for this template-->
	<link href="/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
	<!-- Page level plugin CSS-->
	<link href="/_admin/css/dataTables.bootstrap4.min.css" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="/_admin/css/sb-admin.min.css" rel="stylesheet">
	<script src="/js/jquery.min.js"></script>
</head>

<body id="page-top">
	<?= $this->include('admin/templates/header') ?>

	<div id="wrapper">
		<!-- Sidebar -->
		<?= $this->include('admin/templates/sidebar') ?>

		<div id="content-wrapper">
			<div class="container-fluid">
				<?= $this->renderSection("content") ?>
			</div>

			<!-- Sticky Footer -->
			<?= $this->include('admin/templates/footer') ?>
		</div>
	</div>
	<!-- /#wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Bootstrap core JavaScript-->
	<script src="/js/popper.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>

	<!-- Core plugin JavaScript-->
	<!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->

	<!-- Page level plugin JavaScript-->
	<script src="/_admin/js/Chart.min.js"></script>
	<script src="/_admin/js/jquery.dataTables.min.js"></script>
	<script src="/_admin/js/dataTables.bootstrap4.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="/_admin/js/sb-admin.min.js"></script>
	<script src="/js/admin.js"></script>

	<style>
		body {
			font-family: monospace;
		}
	</style>
</body>

</html>
