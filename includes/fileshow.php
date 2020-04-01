<?php


class Fileshow {
  public $directory;
  public $sort = [];
  public $searchArr = [];
  public $page_url;

  public function __construct($directory, $sort, $page_url) {
    $this->directory = $directory;
    $this->sort = $sort;
    $this->page_url = $page_url;
  }

  public function showpage($start_rec, $rec_per_page){
    $output = '
      <table class="table table-bordered table-striped">
        <tr>
          <th><a href="includes/action.php?directory=' .$this->directory. '&sorted_by=name&sort_flag=' .$this->sort['flag']. '&cmd=sorting">Name</a></th>
          <th><a href="includes/action.php?directory=' .$this->directory. '&sorted_by=extension&sort_flag=' .$this->sort['flag']. '&cmd=sorting">Type</a></th>
          <th><a href="includes/action.php?directory=' .$this->directory. '&sorted_by=size&sort_flag=' .$this->sort['flag']. '&cmd=sorting">Size</a></th>
          <th><a href="includes/action.php?directory=' .$this->directory. '&sorted_by=date&sort_flag=' .$this->sort['flag']. '&cmd=sorting">Date</a></th>
          <th>Open</th>
          <th>Delete</th>
        </tr>
    ';
    if($this->count_table_row()){
      $new_array = Fileshow::arrayOrderBy($this->getDirArr()[0], $this->sort['name'], $this->sort['flag']);
      foreach (array_slice($new_array, $start_rec, $rec_per_page) as $row){
        $output .= '
          <tr>
            <td width="35%"><form method="POST" action="includes/action.php?&directory=' . $this->directory .
          '&sort_flag=' . $this->sort['flag'] . '&sorted_by=' . $this->sort['name'] . '&cmd=rename" method="post" >
                          <input type="hidden" name="old_name" value="'.$row['name'].'">
                          <input type="hidden" name="extension" value="'.$row['extension'].'">
                          <input type="text" name="new_name" value="'.$row['name'].'">
                          <button type="submit" class="btn btn-warning">Rename</button>
            </form></td>
            <td>' . $row['extension'] . '</td>
					  <td>' . $row['size'] . ' kb</td>
					  <td>' . $row['date'] . '</td>
					  <td>
        ';
        if($row['extension'] == 'folder'){
          $output .= '
            <a href="' .$this->page_url. '?page=1&directory=' .$row['directory']. '&sort_flag=' .$this->sort['flag']. '
            &sorted_by=' .$this->sort['name']. '"><i class="' . $row['icon'] . '"></i> Open</a> 
          ';
        }else {
          $output .= '<a class="disabled"><i class="' . $row['icon'] . '"></i> Open</a>';
        }
        $output .= '
          </td>
          <td><form method="post" action="includes/action.php?page=1&directory=' . $this->directory . '
          &sort_flag=' .$this->sort['flag']. '&sorted_by=' .$this->sort['name']. '&cmd=delete">
            <input type="hidden" name="deleteName" value="' .$row['directory']. '">
            <button type="submit" class="btn btn-warning">Delete</button>
          </form></td>
          </tr>
        ';
      }
    }
    $output .= '
      </table>
    ';
    echo $output;
  }

  public function count_table_row(){
    return count($this->getDirArr()[0]);
  }

  public function getDirArr(){
    if (is_dir($this->directory)) {
      $arrDirectory = [];
      $searchArr = [];
      $files = scandir($this->directory);
      for ($i = 0, $j = 0; $i < count($files); $i++) {
        if ($files[$i] != '.' && $files[$i] != '..') {
          $file = pathinfo($files[$i]);
          if (isset($file['extension'])) {
            $searchArr[$j] = $arrDirectory[$j]['directory'] = $this->directory . '/' . $files[$i];
            $arrDirectory[$j]['extension'] = $extension = $file['extension'];
            $arrDirectory[$j]['size'] = round(filesize($arrDirectory[$j]['directory'])/1024, 2);
            $pos = strpos($files[$i], $extension);
            $arrDirectory[$j]['name'] = substr($files[$i], 0, $pos - 1);
            $arrDirectory[$j]['date'] = date("Y/m/d H:i:s", filemtime($arrDirectory[$j]['directory']));
          } else {
            $arrDirectory[$j]['name'] = $files[$i];
            $searchArr[$j] = $arrDirectory[$j]['directory'] = $this->directory . '/' . $arrDirectory[$j]['name'];
            $arrDirectory[$j]['extension'] = $extension = 'folder';
            $arrDirectory[$j]['size'] = $this->DirectorySize($searchArr[$j]);
            $stat = stat($arrDirectory[$j]['directory']);
            $arrDirectory[$j]['date'] = date("Y/m/d H:i:s", $stat['mtime']);
          }
          switch ($arrDirectory[$j]['extension']) {
            case 'folder':
              $arrDirectory[$j]['icon'] = 'fa fa-folder';
              break;
            case 'jpg':
              $arrDirectory[$j]['icon'] = 'fa fa-file-image-o';
              break;
            case 'png':
              $arrDirectory[$j]['icon'] = 'fa fa-file-image-o';
              break;
            case 'gif':
              $arrDirectory[$j]['icon'] = 'fa fa-file-image-o';
              break;
            case 'mp4':
              $arrDirectory[$j]['icon'] = 'fa fa-file-movie-o';
              break;
            case 'pdf':
              $arrDirectory[$j]['icon'] = 'fa fa-file-pdf-o';
              break;
            case 'mp3':
              $arrDirectory[$j]['icon'] = 'fa fa-file-audio-o';
              break;
            default:
              $arrDirectory[$j]['icon'] = 'fa fa-file-text-o';
              break;
          };
          $j++;
        }
      }
    }
    return array($arrDirectory, $searchArr);
  }

  public function DirectorySize($dir) {
    $size = 0;

    foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
      $size += is_file($each) ? filesize($each) : folderSize($each);
    }

    return round($size / 1024 , 2) ;
  }

  static public function arrayOrderBy()
  {
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
      if (is_string($field)) {
        $tmp = array();
        foreach ($data as $key => $row)
          $tmp[$key] = $row[$field];
        $args[$n] = $tmp;
      }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
  }


}