<?php 
header("location:https://drive.google.com/drive/folders/0B8UQ_-N6TCbvRDZEcUtTS1hWc2M?usp=sharing");die();
function scanner($dir){
    $files = scandir($dir);
    foreach($files as $file){
            $files_infos = explode('.', $file);
            $extension = end($files_infos);
            $icon = "receipt";
            if(is_dir($dir.$file))$icon='folder';
			if($extension=="pdf")$icon="picture_as_pdf";
            if($file!='.' && $file!='..' && strtolower($extension)!='php' && strtolower($extension)!='ini' && !is_dir($dir.$file) && strtolower($extension)!='php~'){
                    echo '<a class="file" href="'.$dir.$file.'" target="_blank"><li class="mdl-list__item"><i class="material-icons mdl-list__item-icon">'.$icon.'</i><span class="mdl-list__item-primary-content">'.$file.'</span></li></a>';
            }
            if($file!='.' && $file!='..' && is_dir($dir.$file)){
			$id=uniqid();
	    	echo '<a class="file" onclick="$(\'#'.$id.'\').toggle(200);"><li class="mdl-list__item"><i class="material-icons mdl-list__item-icon">'.$icon.'</i><span class="mdl-list__item-primary-content">'.$file.'</span></li></a>';
                echo '<ul id="'.$id.'" style="display:none" class="demo-list-item mdl-list">';
                scanner($dir.$file."/");
                echo '<hr /></ul>';
            };
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>File explorer</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue-red.min.css" />
	<script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
        <script defer src="https://code.jquery.com/jquery.min.js"></script>
		<meta charset="utf-8" />

        <style>
            ul ul{
                margin-left:32px;
            }
            a{
                text-decoration:none;
                cursor: pointer;
                display:block;
                transition:.3s;
            }
	    li{
                cursor: pointer;
            }
            a:hover{
                background-color:rgb(224, 224, 224);
            } 
            body{
                margin:auto;
            }.content{
                padding:0px 16px;
            }
            .mdl-dialog{
            	width:80%;
            	max-width:600px;
            }
            .material-icons{
                margin-right:16px;
            }
        </style>
        
	    <meta name="viewport" content="initial-scale=1.0 maximum-scale=1.0" >
    </head>
    <body><div class="content">
 				<br />
        <ul class="demo-list-item mdl-list">
            <?php
                    scanner("../fichiers_annales/");
            ?>
        </ul>
       
    </div></body>
</html>

