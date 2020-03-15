<?php

if(isset($_POST['action'])){
  if($_POST['action'] == 'show'){
    $folder = scandir('../directory');
    $output = '
      <table class="table table-bordered table-striped">
            <tr>
                <th><a href="includes/action.php?sort=name">Name</a></th>
                <th><a href="includes/action.php?sort=size">Size</a></th>
                <th><a href="includes/action.php?sort=type">Type</a></th>
                <th><a href="includes/action.php?sort=date">Date</a></th>
                <th>Delete</th>
            </tr>
    ';
    if (count($folder) > 0 ) {
      foreach ($folder as $name) {
        $data = explode('.',$name);
        if(is_array($data)){
          $extention = end($data);
          if($extention == $name){
            $type = 'Folder';
          } else {
            $type = $extention;
          }
        }

        if($name !== '.' && $name !== '..') {
          $ext = explode('.', $name);
          $fileName = $ext[0];
          $output .= '
                    <tr >
                        <td width="35%"><form action="includes/action?cmd=rename" method="post" >
                          <input type="hidden" name="old_name" value="'.$fileName.'">
                          <input type="hidden" name="extention" value="'.$type.'">
                          <input type="text" name="new_name" value="'.$fileName.'">
                          <button type="submit" class="btn btn-warning">Rename</button>
                        </form></td>
                        <td>'. folderSize("../directory/$name") .'</td>
                        <td> '. $type .' </td>
                        <td>'.date ("d.m.Y", filemtime("../directory/$name"))  .'</td>
                        <td> <form action="includes/action.php?cmd=delete" method="post">
                               <input type="hidden" name="deletedName" value="directory/'.$name.'">
                               <button type="submit" data-name="' . $name . '" class="delete btn btn-danger btn-xs">Delete</button>
                          </form>
                        </td>
                    </tr>
                ';
        }
      }
    }
    else {
      $output .= '
                <tr>
                    <td colspan="6">No Folder Found</td>
                </tr>
            ';
    }
    $output .= '</table>';
    echo $output;

  }

  if ($_POST['action'] == 'create') {
    $path = '../directory/' . $_POST['folder_name'];
    if (!file_exists($path)) {
      mkdir($path, 0777, true);
      echo 'Folder Created';
    } else {
      echo 'Folder Already Created!!!';
    }
  }

}

/*----------delete------------*/
if(isset($_GET['cmd'])){
  if($_GET['cmd'] == 'delete'){
    $fileName = $_POST['deletedName'];
    if(is_dir('../'.$fileName)){
      $items = scandir('../'.$fileName);
      foreach ($items as $item) {
        if ($item == '.' && $item == '..'){
          rmdir('../'.$fileName.'/'.$item);
        } else {
          unlink('../'.$fileName.'/'.$item);
        }
      }
      rmdir('../'.$fileName);
      header('location: ../index.php');
    }else {
      unlink('../' . $fileName);
      header('location: ../index.php');
    }

  }elseif($_GET['cmd'] == 'rename'){
    $old_name = $_POST['old_name'];
    $new_name = $_POST['new_name'];
    if ($old_name == $new_name) {
      header('location: ../index.php?old');
    }
    $extention = $_POST['extention'];
    if($extention == 'Folder'){
      $inc = '';
      while(is_dir('../directory/' . $new_name . $inc) || is_dir('../directory/' . $new_name . '(' . $inc . ')')){
        $inc++;
      }
      if($inc != ''){
        $new_name = '../directory/' . $new_name . '(' . $inc . ')';
      } else {
        $new_name = '../directory/' . $new_name;
      }
      $old_name = '../directory/' . $old_name;
    } else {
      $inc = '';
      while(is_dir('../directory/' . $new_name . $inc . '.' . $extention) || is_dir('../directory/' . $new_name . '(' . $inc . ').' . $extention)){
        $inc++;
      }
      if($inc != ''){
        $new_name = '../directory/' . $new_name . '(' . $inc . ').' . $extention;
      } else {
        $new_name = '../directory/' . $new_name . '.' . $extention;
      }
      $old_name = '../directory/' . $old_name . '.' . $extention;
    }
    rename($old_name, $new_name);
    header('location: ../index.php?ok');
  }
}



/*------folder size function------*/

function folderSize ($dir)
{
  $size = 0;
  if(is_dir($dir)) {
    foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
      $size += is_file($each) ? filesize($each) : folderSize($each);
    }
  } else {
    $size += filesize($dir);
  }
  return round($size/1024 , 2) . ' kb';
}
