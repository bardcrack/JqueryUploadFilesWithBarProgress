<?php
require_once("token.php");
session_start();
error_reporting(0);
//Configuracion													================> AQUI
$directorio		=		"uploads/";												//Carpeta de Destino
$max_size		=		"5242880"; 												//5MB
$files_ok		=		array("jpeg","jpg","gif","png");						//Tipos de Archivos Permitidos
$variable		=		token(20);												//Funcion que me genera un valor de 20 caracteres en forma aleatoria
$size			=		$_FILES['userImage']['size'];							//El tamaño del archivo actual
$type			=		strtolower(str_replace("image/","",$_FILES['userImage']['type']));	//El tipo del archivo que se intenta subir al servidor
$name_image		=		md5(microtime().$variable).'.'.strtolower($type);		//El nuevo nombre del archivo

//En caso de que la carpeta no exista la creamos con los permisos necesarios
if(!file_exists($directorio)){
	mkdir($directorio);
	chmod($directorio,0777);
}


if(in_array($type,$files_ok)){
	if($size>$max_size){
		echo 1;			//Si el tamaño del archivo es muy grande
	}
	else{
		if(move_uploaded_file($_FILES['userImage']['tmp_name'],$directorio.$name_image)){
			echo 2;		//Si se logro guardar el archivo de imagen
		}
		else{
			echo 3;		//Si hubo algun error al subir el archivo al servidor
		}
	}
}
else{
	echo 4;				//Si el tipo de archivo es invalido
}
?>
