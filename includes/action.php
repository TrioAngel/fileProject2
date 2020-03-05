<?php

if(isset($_POST['action'])){
  if($_POST['action'] == 'show'){
    $folder = scandir('../directory');
    $output = '
      <table class="table table-bordered table-striped">
            <tr>
                <th>Folder Name</th>
                <th>Size</th>
                <th>Type </th>
                <th>Date</th>
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
          $output .= '
                    <tr>
                        <td>' . $name . '</td>
                        <td>'. round(filesize("../directory/$name")/1024, 2 ).' Kb</td>
                        <td> '. $type .' </td>
                        <td>'.date ("F d Y", filemtime("../directory/$name"))  .'</td>
                        <td><button type="button" name="delete" data-name="' . $name . '" class="delete btn btn-danger btn-xs">Delete</button></td>
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

}