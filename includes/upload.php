<?php
if (isset($_POST['upload_button'])){
  if(isset($_POST['directory']) && is_dir($_POST['diectory'])) {
    $directory = $_POST['directory'];
  } else {
    $directory = 'directory';
  }

  if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
    header('location: ../index.php?directory=' . $directory);
  }

  $file = $_FILES['file'];


  $fileName = $_FILES['file']['name'];

  $checkName = [];
  $rename = '';
  $checkName['fileName'] = $fileName;
  $extension = explode('.', $checkName['fileName']);
  $checkName['actExt'] = strtolower(end($extension));
  $pos = strpos($checkName['fileName'], '.' . $checkName['actExt']);
  $checkName['name'] = substr($checkName['fileName'], 0, $pos);

  while (file_exists('../directory/' . $checkName['name'] . $rename . '.' . $checkName['actExt']) ||
    file_exists('../directory/' . $checkName['name'] . '(' . $rename . ').' . $checkName['actExt'])) {
    $rename++;
  }

  if ($rename != '') {
    $checkName['fileName'] = $checkName['name'] . '(' . $rename . ').' . $checkName['actExt'];
  }
  else {
    $checkName['fileName'] = $checkName['name'] . $rename . '.' . $checkName['actExt'];
  }


  $pos = strpos($checkName['fileName'], '.' . $checkName['actExt']);
  $checkName['name'] = substr($checkName['fileName'], 0, $pos);
  $checkName['tmpName'] = $file['tmp_name'];
  $checkName['fileSize'] = $file['size'];
  $checkName['fileError'] = $file['error'];

  if ($checkName['fileError'] === 0) {
    $fileDestination = '../directory/' . $checkName['fileName'];
    move_uploaded_file($checkName['tmpName'], $fileDestination);
    header('Location: ../index.php');
    exit();
  }
  else {
    echo "There was an error !!!";
    exit();
  }
}