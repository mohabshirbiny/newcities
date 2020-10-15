<?php
namespace App\Traits;
use Bellal\VictoryLinkSMS\VictoryLink;

trait SendSMS
{

    public function send($to,$body) {

        $message = new VictoryLink([
            'username' => 'NewCities',
            'password' => '9n5E919999',
            'sender' => 'New Cities',
            'language' => 'a',
        ]);

        $message->send([
            'to' => '+2'.$to,
            'message' => $body,
        ]);
        return $message->response();
        
    }
    
    // Create GUID (Globally Unique Identifier)
    public function create_guid() { 
        $guid = '';
        $namespace = rand(11111, 99999);
        $uid = uniqid('', true);
        $data = $namespace;
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash,  0,  8) . '-' .
        substr($hash,  8,  4) . '-' .
        substr($hash, 12,  4) . '-' .
        substr($hash, 16,  4) . '-' .
        substr($hash, 20, 12);
        return $guid;
    }
}
