<?php

class JWT_Data extends Jwt_Caller{
    
    public function set_JWT($data, $iat, $exp){
        // $iat = time();       
        // $exp = $iat+$time;     

        $encode = parent::jwt_Encode($data, $iat, $exp);

        setcookie(USER_COOCKIE_NAME, $encode, $exp, "/", null, null, TRUE);

        $response = json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>'Coockie set successfully'));
        
        return $response;
    }

    public function get_JWT(){
        if(isset($_COOKIE[USER_COOCKIE_NAME])){
            
            $encode = $_COOKIE[USER_COOCKIE_NAME];
        
            $data = json_decode(parent::jwt_Decode($encode));
            $response = json_encode($data);
        
        }else{
            $response = json_encode(array('Status'=>ACCESS_TOKEN_ERRORS, 'Message'=>'Coockie not found!'));
        }
        return $response;
    }

    //recives encripted data and boolan data
    public function encript_256($data_E, $encript){
            if($encript == true){
                //Define cipher 
                $cipher = "aes-256-cbc"; 

                $encryption_key = ENCRIPTION_KEY; 

                // Generate an initialization vector 
                $iv_size = openssl_cipher_iv_length($cipher); 
                $iv = openssl_random_pseudo_bytes($iv_size); 

                $iv_encript = base64_encode($iv);

                //Data to encrypt 
                $data = $data_E; 
                $encrypted_data = base64_encode(openssl_encrypt($data, $cipher, $encryption_key, 0, $iv)); 
                return array($encrypted_data, $iv_encript);
            }else{
                return $data_E;                
            }
            
        }

        public function decript_256($encrypted_data, $encript){
            if($encript == true){
                $cipher = "aes-256-cbc"; 
                $encryption_key = ENCRIPTION_KEY;
                $encripted_Data_ToOpen = base64_decode($encrypted_data[0]);
                $iv = base64_decode($encrypted_data[1]);
                //Decrypt data 
                $decrypted_data = openssl_decrypt($encripted_Data_ToOpen, $cipher, $encryption_key, 0, $iv); 
                return $decrypted_data;
            }else{
                return $encrypted_data;
            }
        }
}

?>