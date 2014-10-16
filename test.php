<?php
require_once("token.php");
session_start();
error_reporting(0);
$token		=	token(20);//Funcion que me genera un valor de 20 caracteres en forma aleatoria
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>File upload progress bar | Bardcrack</title>
<meta name='description' content='Bardcrack Blog Productions'>
<meta name='author' content='Julio Bardcrack Blog'>
<link href='bootstrap.css' rel='stylesheet'>
<link href='bootstrap-responsive.css' rel='stylesheet'>
<style>
	//Definimos el estilo de nuestra barra de progreso
	#porciento{
		font-weight:bold;
		font-size:14px;
		color:#000;
		z-index:1000;
	}
	label{
		font-weight:bold;
		font-size:14px;
		color:#000;
	}
</style>
<script src='http://code.jquery.com/jquery-2.1.0.min.js'></script>
<script>
	function upload_images_ajax_testing(token){
		//Le damos un efecto a la barra de progreso al momento de dar clic en upload
		$('#progress').slideDown('collapse');
		$('#bar').slideDown('collapse');
		var url='get_progress.php';
		
		//Extraermos con querySelector las propiedades de estos 5 objetos
		var inputFileImage = document.querySelector('#userImage');
		var progressBar = document.querySelector('#progress');
		var percentage = document.querySelector('#bar');
		var porciento = document.querySelector('#porciento');
		var APC_UPLOAD_PROGRESS	= document.querySelector('#APC_UPLOAD_PROGRESS');
		
		//Extraemos al primer elemento de nuestro array de Archivos [files]
		var file = inputFileImage.files[0];

		//Con esta variable enviaremos los elementos de nuestro formulario
		var data = new FormData();
		data.append('userImage',file);
		data.append('APC_UPLOAD_PROGRESS',APC_UPLOAD_PROGRESS.value);
		
		var request = new XMLHttpRequest();
		
		//Durante el progreso de subida realizara las siguientes acciones.
		request.upload.onprogress = function(event) {
			
			porciento.max = event.total;
			porciento.value = event.loaded;
			porciento.innerHTML = Math.round(event.loaded / event.total * 100) + '%';
			
			percentage.max = event.total;
			percentage.value = event.loaded;
			
			//Aqui modifico el estilo de nuestro div, el cual realiza la animacion de nuestra barra
			$('#bar').css('width',Math.round(event.loaded / event.total * 100) + '%');
			if((Math.round(event.loaded / event.total * 100))==100){
				//Cuando finaliza la subida le digo que espero por un segundo antes de desaparecer nuestra barra
				//barra de progreso, asi como nuestro contador de subida
				setTimeout(function m(){
					$('#progress').slideUp('collapse');
					$('#porciento').slideUp('collapse');
					$('#porciento').hide();
					//Inicializo a 0 de nuevo nuestro contador
					porciento.innerHTML = 0 + '%';
					setTimeout(function o(){
						//Inicializo tambien nuestra barra de progreso
						$('#bar').css('width',0 + '%');
						$('#uploadImage').each(function(){
							this.reset();
						});
					}, 1000);
				}, 2000);
			}
		};
		request.open('POST', url);
		request.send(data);
		request.onreadystatechange=function(){
			//Aqui verificamos los cuatro tipos de resultados que devuelve nuestro archivo get_process.php
			if (request.readyState==4 && request.status==200){
				var estado	=	request.responseText;
				if(estado=='1'){
					$('#msj_grande').slideDown('collapse');
					$('#msj_grande').delay(3000).slideUp('collapse');
				}
				if(estado=='2'){
					$('#msj_exito').slideDown('collapse');
					$('#msj_exito').delay(3000).slideUp('collapse');
				}
				if(estado=='3'){
					$('#msj_error').slideDown('collapse');
					$('#msj_error').delay(3000).slideUp('collapse');
				}
				if(estado=='4'){
					$('#msj_invalid').slideDown('collapse');
					$('#msj_invalid').delay(3000).slideUp('collapse');
				}
			}
		}
	}
</script>
</head>
<body>
<center><h2>File Upload Progress Bar. Julio Barcrack Blog&#8482;</h2></center>
<div class='alert alert-info' id='msj_grande' style='display:none'>Archivo demasiado grande!</div>
<div class='alert alert-success' id='msj_exito' style='display:none'>Archivo Subido con exito!</div>
<div class='alert alert-danger' id='msj_error' style='display:none'>El archivo no pudo ser subido al servidor.</div>
<div class='alert alert-info' id='msj_invalid' style='display:none'>Tipo de Archivo no valido.</div>
<form name='uploadImage' id='uploadImage' enctype='multipart/form-data' method='post' class='well' onsubmit='return false;'>
	<input name='APC_UPLOAD_PROGRESS' id='APC_UPLOAD_PROGRESS' type='hidden' value='$token'>
	<label>Upload File</label> 
	<input type='file' name='userImage' id='userImage'/>
	<span class='badge badge-info' style='display:none;'>0%</span>                  
	<input type='submit' class='btn btn-success' name='upload_image' id='upload_image' value='UPLOAD' onclick=\"upload_images_ajax_testing('$token');\"/>
	<div class='progress' id='progress' style='display:none;'>            	
		<div class='bar' id='bar' style='width:0%;'></div>
	</div>
	<center><span id='porciento'></span></center>
</form>
</body>
</html>";
?>
