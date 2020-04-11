<?php

if (isset($_FILES['file'])) {
  if (isset($_POST['directory']) && is_dir('../' . $_POST['directory'])) {
    $directory = $_POST['directory'];
  } else {
    $directory = 'directory';
  }
  require_once('fileshow.php');
  $sort['name'] = 'name';
  $sort['flag'] = 4;
  $files = new Fileshow('../' .$directory, './includes/action.php', $sort);
  $arraySearch = $files->getDirArr()[1];

  if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
    header('location: ../index.php?directory=' . $directory);
  }

  $checkArr = [];
  $file = $_FILES['file'];
  $checkArr['fileName'] = $file['name'];
  $fileExt = explode('.', $checkArr['fileName']);
  $checkArr['fileActualExt'] = strtolower(end($fileExt));
  $inc = '';
  $pos = strpos($checkArr['fileName'], '.' . $checkArr['fileActualExt']);
  $checkArr['name'] = substr($checkArr['fileName'], 0, $pos);
  while(file_exists('../' . $directory . '/' . $checkArr['name'] . $inc . '.' . $checkArr['fileActualExt']) ||
    file_exists('../' . $directory . '/' . $checkArr['name'] . '(' . $inc . ').' . $checkArr['fileActualExt'])) {
    $inc++;
  }
  if ($inc != '') {
    $checkArr['fileName'] = $checkArr['name'] . '(' . $inc . ').' . $checkArr['fileActualExt'];
  } else {
    $checkArr['fileName'] = $checkArr['name'] . $inc . '.' . $checkArr['fileActualExt'];
  }
  $checkArr['path'] = '../' . $directory . '/' . $checkArr['fileName'];
  // end of RENAME
  $pos = strpos($checkArr['fileName'], '.' . $checkArr['fileActualExt']);
  $checkArr['name'] = substr($checkArr['fileName'], 0, $pos);
  $checkArr['tmpName'] = $file['tmp_name'];
  $checkArr['fileSize'] = $file['size'];
  $checkArr['fileError'] = $file['error'];

  if ($checkArr['fileError'] === 0) {
    move_uploaded_file($checkArr['tmpName'], $checkArr['path']);
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