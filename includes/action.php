<?php

if (isset($_POST['action'])){

// get directory path
  if (isset($_GET['directory'])){
    $directory = $_GET['directory'];
  } else{
    $directory = 'directory/';
  }

// create folder
  if($_POST['action'] == 'create'){
    $path = '../' . $_POST['path_name'] . '/' . $_POST['folder_name'];
    if(!file_exists($path)){
      mkdir($path, 0777, true);
      echo 'Folder Created';
    } else {
      echo 'Folder Already Created';
    }
  }
}

//////Sorting, Delete, Rename
if(isset($_GET['cmd'])){
  $sort['name'] = $_GET['sorted_by'];
  //// Sorting part
  if($_GET['cmd'] == 'sorting'){
    $sort['flag'] = $_GET['sort_flag'] == 3 ? 4 : 3;
    $directory = $_GET['directory'];
    if(is_dir('../' . $directory)){
      header('location: ../index.php?directory=' . $directory . '&sorted_by=' . $sort['name'] . '&sort_flag=' . $sort['flag']);
    } else {
      header('location: ../index.php');
    }
  } elseif($_GET['cmd'] == 'delete'){
// delete part
    $directory = $_GET['directory'];
    $sort['flag'] = $_GET['sort_flag'];
    $deleteName = $_POST['deleteName'];
    if(is_dir('../' . $deleteName)){
      rmdir('../' . $deleteName);
      header('location: ../index.php?directory=' . $directory);
    } else {
      unlink('../' . $deleteName);
      header('location: ../index.php?directory=' . $directory);
    }
  } elseif($_GET['cmd'] == 'rename'){
//rename part
    $old_name = $_POST['old_name'];
    $new_name = $_POST['new_name'];
    $directory = $_GET['directory'];
    if($old_name == $new_name){
      header('location: ../index.php?directory=' . $directory . '&sorted_by=' . $sort['name'] . '&sort_flag=' . $sort['flag']);
    }
    $extension = $_POST['extension'];
    if($extension == 'folder'){
      $inc = '';
      while(is_dir('../' . $directory . '/' . $new_name . $inc) || is_dir('../' . $directory . '/' . $new_name . '(' . $inc . ')')) {
        $inc++;
      }

      if($inc != ''){
        $new_name = '../' . $directory . '/' . $new_name . '(' . $inc . ')';
      } else {
        $new_name = '../' . $directory . '/' . $new_name;
      }
      $old_name = '../' . $directory . '/' . $old_name;
    } else {
      $inc = '';
      while(file_exists('../' . $directory . '/' . $new_name . $inc . '.' . $extension) ||
        file_exists('../' . $directory . '/' . $new_name . '(' . $inc . ').' . $extension)){
        $inc++;
      }
      if ($inc != ''){
        $new_name = '../' . $directory . '/' . $new_name . '(' . $inc . ').' . $extension;
      } else {
        $new_name = '../' . $directory . '/' .$new_name . '.' . $extension;
      }
      $old_name = '../' . $directory . '/' . $old_name . '.' . $extension;
    }
    rename($old_name, $new_name);
    header('location: ../index.php?directory=' . $directory . '&sorted_by=' . $sort['name'] . '&sort_flag=' . $sort['flag']);
  }


}