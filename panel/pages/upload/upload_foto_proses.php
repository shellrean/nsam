<?php

error_reporting(0);
session_start();

$session_id = '1';
define("MAX_SIZE","9000000");

function getExtension($str)
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    return $ext;
}

$valid_formats = array("jpg","gif", "jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") 
{

	foreach ($_FILES['photos']['name'] as $name => $value)
    {
    	$filename = stripslashes($_FILES['photos']['name'][$name]);
        $size=filesize($_FILES['photos']['tmp_name'][$name]);

        $ext = getExtension($filename);
        $ext = strtolower($ext);

        if(in_array($ext,$valid_formats))
        {
        	$uploaddir = "../../../foto_siswa/";

        	if($size<(300000*(1024*1024)))
	       	{

				$image_name=$filename;
		   		$eks = getExtension($image_name);
           		$ext1 = strtolower($eks);
			   	echo "<img src='nsam/".$uploaddir.$image_name."' class='imgList'>";

			   	$newname=$uploaddir.$image_name;

			   	if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname)) 
           		{
           			$time=time();
           		}

           		else
	       		{
	       		 echo '<span class="imgList">Anda telah melampaui batas ukuran! jadi upload tidak berhasil</span>';
           		}

	       }
		   else
		   {
			echo '<span class="imgList">Anda telah melampaui batas ukuran!</span>';
          
	       }
        }
        else {
        	echo '<span class="imgList">Unknown extension!</span>';
        }

    }
}