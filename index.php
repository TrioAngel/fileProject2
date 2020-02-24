<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet"
	      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
	<script
		src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script
		src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<script src="js/main.js"></script>
</head>
<body>

<header>
	<div class="container">
		<h1 class="text-center">File System PHP</h1>
	</div>
</header>

<main>
	<div class="container">
		<div align="right">
			<button class="btn btn-success" id="create_folder">Create Folder</button>
			<div class="input-group mb-3 brows-file">
				<div class="custom-file">
					<input type="file" class="custom-file-input ">
					<label class="custom-file-label">Choose file</label>
				</div>
				<div class="input-group-append">
					<button type="button" class="btn btn-success" id="upload-file">Upload</button>
				</div>
			</div>
		</div>
	</div>
</main>

<footer>
	<div class="container">
		<h5>With love by RedAngel</h5>
	</div>
</footer>

<script>
	$(document).ready(function(){
		$(document).on('click', '#create_folder', function(){
			$('#folderModal').modal('show');
		})
	})
</script>

</body>
</html>

<div id="folderModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="change_title">Create Folder</span>
				</h4>
				<button type="button" class="close" data-dismiss="modal">&times;
				</button>
			</div>
			<div class="modal-body">
				<p>Enter Folder Name <input type="text" name="folder_name"
				                            id="folder_name" class="form-control"></p>
				<br>
				<input type="hidden" name="action" id="action">
				<input type="hidden" name="old_name" id="old_name">
				<input type="button" name="create_button" id="create_button"
				       class="btn btn-info" value="Create">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					Close
				</button>
			</div>
		</div>
	</div>
</div>