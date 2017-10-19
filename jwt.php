<?php

	// HEADER
	$header = [
		'alg' => 'HS256',
		'typ' => 'JWT'
	];

	// PAYLOAD
	$payload = [
		'name' => 'Maiglon Lubacheuski',
		'email' => 'maiglonl@gmail.com'
	];

	$header = json_encode($header);
	$payload = json_encode($payload);

	$header = base64_encode($header);
	$payload = base64_encode($payload);

	// SIGNATURE

	//$key = 'biwdb208rvb874s734v9uhkjznlw0s7z4098j';
	$key = 'y81c21SUDwkAhgScSHWxAVKrLSJ3c9C3';

	$signature = hash_hmac('sha256', "$header.$payload", $key, true);
	$signature = base64_encode($signature);
?>