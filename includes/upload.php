<?php
if (isset($_POST['upload_button'])) {
  $file = $_FILES['file'];

  $fileName = $_FILES['file']['name'];

  $checkName = [];
  $rename = '';
  $checkName['fileName'] = $fileName;
  $extention = explode('.', $checkName['fileName']);
  $checkName['actExt'] = strtolower(end($extention));
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