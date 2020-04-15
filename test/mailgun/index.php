<?php
    //https://github.com/mailgun/mailgun-php
    //Authorized Recipients -> afegir a 'yomogan@gmail.com'
    
    function send_mailgun($email){
        $ini_file = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/model/api-keys/apis.ini');
        $config = array();
    	$config['api_key'] = $ini_file['mailGunKey'];
    	$config['api_url'] = $ini_file['mailGunURL'];

    	$message = array();
    	$message['from'] = $ini_file['testEmail'];
    	$message['to'] = $email;
    	$message['h:Reply-To'] = $ini_file['testEmail'];
    	$message['subject'] = "Hello, this is a test";
    	$message['html'] = 'Hello ' . $email . ',</br></br> This is a test';
     
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $config['api_url']);
    	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    	curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    	curl_setopt($ch, CURLOPT_POST, true); 
    	curl_setopt($ch, CURLOPT_POSTFIELDS,$message);
    	$result = curl_exec($ch);
    	curl_close($ch);
    	return $result;
    }
    
    $json = send_mailgun('og.ubeda@gmail.com');
    print_r($json);