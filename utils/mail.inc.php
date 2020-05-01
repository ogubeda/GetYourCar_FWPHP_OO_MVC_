<?php
//////
class mail {
    function setEmail($email) {
        $content = "";
        //////
        switch ($email['type']) {
            case 'contact';
                $email['fromEmail'] = 'support@getyourcar.com';
                $email['inputMatter'] = 'Your request has been sended.';
                $content .= "<h2>Thank $email[inputName] you for sending us an email</h2><br>";
                $content .= "<p>You will recive an email soon answering your request.</p><br>";
                break;
                //////
            case 'admin';
                $email['toEmail'] = 'og.ubeda@gmail.com';
                break;
                //////
        }// end_switch
        //////
        $content .= "<br><a href = 'http://192.168.0.182/frameworkCars.v.1.3/'>Get Your Car</a>";
        $email['inputMessage'] .= $content;
        //////
        return self::sendMailGun($email);
    }// end_setEmail
    
    function sendMailGun($values) {
        $ini_file = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/model/api-keys/apis.ini');
        $config = array();
        //////
        $config['api_key'] = $ini_file['mailGunKey'];
        $config['api_url'] = $ini_file['mailGunURL'];
        $message = array();
        $message['from'] = $values['fromEmail'];
        $message['to'] = $values['toEmail'];
        $message['h:Reply-To'] = $values['inputEmail'];
        $message['subject'] = $values['inputMatter'];
        $message['html'] = $values['inputMessage'];
        //////
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
        //////
        return $result;
    }// end_sendMailGun
}// end_mal
