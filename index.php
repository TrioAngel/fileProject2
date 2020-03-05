<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>
<body>

<header>
  <div class="container" align="center">
    <h1>File System - PHP</h1>
  </div>
</header>

<main>
  <div class="container w-50" >
    <div align="center">
      <button type="button" name="create_folder" id="create_folder" class="btn btn-success">Create Folder</button>
    </div>
    <div>
      <br>
	    <form method="post" action="includes/upload.php" enctype="multipart/form-data">
		    <input type="file" name="file">
		    <input type="submit" name="upload_button" class="btn btn-success" value="Upload">
	    </form>
	    <br>
    </div>
  </div>
	<div class="container w-75">
		<div id="show_all" name="show_all" class="table-responsive">

		</div>

	</div>
</main>

<footer>
  <div class="container">
    <h5>With love by RedAngel</h5>
  </div>
</footer>


<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

<script>
	$(document).ready(function(){
		load_item_list();
		function load_item_list() {
			var action = "show";
			$.ajax({
				url: "includes/action.php",
				method: "POST",
				data: {action: action},
				success: function (data) {
					$('#show_all').html(data);
				}
			})
		}
	})
</script>