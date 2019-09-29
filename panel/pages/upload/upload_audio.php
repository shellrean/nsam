<?php
include "../../../config/server.php";
$uploaddir = '../../../audio/'; 
$namafile = basename($_FILES['uploadfile2']['name']);
$file = $uploaddir . basename($_FILES['uploadfile2']['name']); 
 if (move_uploaded_file($_FILES['uploadfile2']['tmp_name'], $file)) { 
  echo "success"; 
} else {

}

?>