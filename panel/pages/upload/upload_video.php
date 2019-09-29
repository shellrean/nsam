<?php
include "../../../config/server.php";
$uploaddir = '../../../video/'; 
$namafile = basename($_FILES['uploadfile3']['name']);
$file = $uploaddir . basename($_FILES['uploadfile3']['name']); 
 if (move_uploaded_file($_FILES['uploadfile3']['tmp_name'], $file)) { 
  echo "success"; 
} else {
}

?>