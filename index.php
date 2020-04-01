<?php
if(!file_exists('./directory')){
	mkdir('./directory', 0777, true);
}

if(isset($_GET['directory'])){
	$directory = $_GET['directory'];
} else {
	$directory = 'directory';
}

$crumbs = explode('/', $directory);
if(isset($_GET['sorted_by'])){
	$sort['name'] = $_GET['sorted_by'];
} else {
	$sort['name'] = 'extension';
}

if(isset($_GET['sort_flag'])){
	$sort['flag'] = (int)$_GET['sort_flag'];
}else {
  $sort['flag'] = 4;
}

require_once ('includes/fileshow.php');
require_once ('includes/pagination.php');

$data['page_url'] = './index.php';
$files = new Fileshow($directory, $sort, $data['page_url']);
$directoryArr = $files->getDirArr()[0];
$searchArr = $files->getDirArr()[1];

?>
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<header>
  <div class="container" align="center">
    <h1>File System - PHP</h1>
  </div>
</header>

<main>
	<div class="container">
		<nav>
			<div class="row">
				<div class="col col-12">
          <?php
          for ($i = 0; $i < count($crumbs); $i++){
            $href = $crumbs[0];
            for ($j = 0; $j < $i; $j++)
              $href .= '/' . $crumbs[$j + 1];
              echo '<h4 id="main-css"><a href="' . $data['page_url'] . '?page=1&directory=' . $href .
	              '&sort_flag=' . $sort['flag'] . '&sorted_by=' . $sort['name'] . '" class="breadcrumb">'
	              . ucfirst($crumbs[$i]) . '</a></h4>';
          }
          ?>
				</div>
			</div>
		</nav>
	</div>

  <div class="container w-50" >
    <div align="center">
      <button type="button" name="create_folder" id="create_folder" class="btn btn-success">Create Folder</button>
    </div>
    <div>
      <br>
	    <form method="post" action="includes/upload.php" enctype="multipart/form-data">
		    <input type="file" name="file">
		    <input type="submit" name="upload_button" class="btn btn-success" value="Upload">
		    <input type="hidden" name="directory" value="<?= $directory ?>">
	    </form>
	    <br>
    </div>
  </div>
	<div class="container w-75">
		<div id="show_all" name="show_all" class="table-responsive">
			<?php
				$count_table_row = $files->count_table_row();
				if($count_table_row){
					$data['total_rec'] = $count_table_row;
					$data['rec_per_page'] = 5;
					$page = new Pagination($directory, $sort);
					$start_rec = $page->start_rec($data);
					$rec_per_page = $data['rec_per_page'];
					$files->showpage($start_rec, $rec_per_page);
					$page->page_display($data);
				} else {
          echo '<h5 class="center">No data available...</h5>';
        }
			?>
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

<div class="modal fade" role="dialog" id="folderModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span>Create Folder</span></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<p>Enter Folder Name <input type="text" id="folder_name" name="folder_name" class="form-control"></p>
				<input type="hidden" id="action" name="action">
				<input type="hidden" name="old_name" id="old_name">
				<input type="hidden" name="path_name" id="path_name" value="<?= $directory ?>">
				<input type="button" id="folder_button" name="folder_button" class="btn btn-success" value="Create">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		$(document).on('click', '#create_folder', function(){
			$('#action').val('create');
			$('#folder_name').val('');
			$('#folder_button').val('Create');
			$('#old_name').val('');
			$('#change_title').text('Create Folder');
			$('#folderModal').modal('show');
		})

		$(document).on('click', '#folder_button', function(){
			var folder_name = $('#folder_name').val();
			var old_name = $('#old_name').val();
			var path_name = $('#path_name').val();
			var action = $('#action').val();
			if(folder_name != ''){
				$.ajax({
					url: 'includes/action.php',
					method: "POST",
					data: {folder_name:folder_name, old_name:old_name, path_name:path_name, action:action},
					success: function (data) {
						$('#folderModal').modal('hide');
						alert(data);
					}
				})
			} else {
				alert('Enter Folder Name Please!!!')
			}
		})

	})
</script>