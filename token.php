<?php

/******************************************************************************
 * file    	: 	token.php
 * author  	: 	julío.escalante
 * version 	: 	1.0.0
 * Created	:	  02-10-2015.
*****************************************************************************/
function token_generator($length){
	// Parametros para el token que voy a generar
	$keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	// Generador del token
	$randkey = "";
	$max=strlen($keychars)-1;
	for ($i=0;$i<$length;$i++) {
		$randkey .= substr($keychars, rand(0, $max), 1);
	}
	return $randkey;
}
