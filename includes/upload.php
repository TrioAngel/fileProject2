<?php

if (isset($_FILES['file'])) {
  if (isset($_POST['directory']) && is_dir('../' . $_POST['directory'])) {
    $directory = $_POST['directory'];
  } else {
    $directory = 'directory';
  }
  print_r($_POST);
  require_once('fileshow.php');
  $sort['name'] = 'name';
  $sort['flag'] = 4;
  $files = new Fileshow('../' .$directory, './includes/action.php', $sort);
  $arraySearch = $files->getDirArr()[1];

  if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
    header('location: ../index.php?directory=' . $directory);
  }

  $arrayOne = [];
  $file = $_FILES['file'];
  $arrayOne['fileName'] = $file['name'];
  $fileExt = explode('.', $arrayOne['fileName']);
  $arrayOne['fileActualExt'] = strtolower(end($fileExt));
  $inc = '';
  $pos = strpos($arrayOne['fileName'], '.' . $arrayOne['fileActualExt']);
  $arrayOne['name'] = substr($arrayOne['fileName'], 0, $pos);
  while(file_exists('../' . $directory . '/' . $arrayOne['name'] . $inc . '.' . $arrayOne['fileActualExt']) ||
    file_exists('../' . $directory . '/' . $arrayOne['name'] . '(' . $inc . ').' . $arrayOne['fileActualExt'])) {
    $inc++;
  }
  if ($inc != '') {
    $arrayOne['fileName'] = $arrayOne['name'] . '(' . $inc . ').' . $arrayOne['fileActualExt'];
  } else {
    $arrayOne['fileName'] = $arrayOne['name'] . $inc . '.' . $arrayOne['fileActualExt'];
  }
  $arrayOne['path'] = '../' . $directory . '/' . $arrayOne['fileName'];
  // end of RENAME
  $pos = strpos($arrayOne['fileName'], '.' . $arrayOne['fileActualExt']);
  $arrayOne['name'] = substr($arrayOne['fileName'], 0, $pos);
  $arrayOne['tmpName'] = $file['tmp_name'];
  $arrayOne['fileSize'] = $file['size'];
  $arrayOne['fileError'] = $file['error'];

  if ($arrayOne['fileError'] === 0) {
    move_uploaded_file($arrayOne['tmpName'], $arrayOne['path']);
    header('Location: ../index.php?directory=' . $directory);
  } else {
    echo "There was an error uploading your file!";
  }
}



//if (isset($_POST['upload_button'])){
//  if(isset($_GET['directory'])) {
//    $directory = $_GET['directory'];
//  } else {
//    $directory = 'directory';
//  }
//
//  if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
//    header('location: ../index.php?directory=' . $directory);
//  }
//
//  $file = $_FILES['file'];
//
//
//  $fileName = $_FILES['file']['name'];
//
//  $checkName = [];
//  $rename = '';
//  $checkName['fileName'] = $fileName;
//  $extension = explode('.', $checkName['fileName']);
//  $checkName['actExt'] = strtolower(end($extension));
//  $pos = strpos($checkName['fileName'], '.' . $checkName['actExt']);
//  $checkName['name'] = substr($checkName['fileName'], 0, $pos);
//
//  while (file_exists('../' . $directory . '/' . $checkName['name'] . $rename . '.' . $checkName['actExt']) ||
//    file_exists('../' . $directory . '/' . $checkName['name'] . '(' . $rename . ').' . $checkName['actExt'])) {
//    $rename++;
//  }
//
//  if ($rename != '') {
//    $checkName['fileName'] = $checkName['name'] . '(' . $rename . ').' . $checkName['actExt'];
//  }
//  else {
//    $checkName['fileName'] = $checkName['name'] . $rename . '.' . $checkName['actExt'];
//  }
//
//
//  $pos = strpos($checkName['fileName'], '.' . $checkName['actExt']);
//  $checkName['name'] = substr($checkName['fileName'], 0, $pos);
//  $checkName['tmpName'] = $file['tmp_name'];
//  $checkName['fileSize'] = $file['size'];
//  $checkName['fileError'] = $file['error'];
//  $checkName['path'] = '../' . $directory . '/' . $checkName['fileName'];
//
//
//  if ($checkName['fileError'] === 0) {
//    move_uploaded_file($checkName['tmpName'], $checkName['path']);
//    header('Location: ../index.php?direction=' . $directory);
//    exit();
//  }
//  else {
//    echo "There was an error !!!";
//    exit();
//  }
//}