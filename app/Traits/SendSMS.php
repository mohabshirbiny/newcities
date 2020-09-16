<?php
namespace App\Traits;

trait SendSMS
{

    public function send($to,$body) {
        
        $GUID = $this->create_guid() ;
        
        $data1 = [
            "UserName"      => "NewCities",
            "Password"      => "9n5E919999",
            "SMSText"       => $body,
            "SMSSender"     => "City Club",
            "SMSReceiver"   => $to,
            "SMSID"         => $GUID,
            "SMSLang"       => "a",
        ];
        // dd($data1);
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsvas.vlserv.com/KannelSending/service.asmx",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data1),
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        
        
        curl_close($curl);
        // dd($response);
        if ($response == "0") {
            return true;
        }else{
            return $response;
        }
        
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
