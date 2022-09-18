<?php
include_once 'JWT.php';
include_once 'Key.php';
include_once 'SignatureInvalidException.php';
include_once 'ExpiredException.php';
include_once 'BeforeValidException.php';
include_once 'JWK.php';
include_once 'CachedKeySet.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

    class Jwt_Caller extends JWT{
        private $payload;
        private $key;
        private $issuedAt;
        private $expire;
        private $url;

        

        public function jwt_Encode($data, $iat, $exp){  
            $this->key = base64_encode(SECRETE_KEY);
            $this->url = URL;
            $this->issuedAt = $iat;
            $this->expire = $exp;

            $this->payload = [
                'iss' => $this->url,
                'aud' => $this->url,
                'iat' => $this->issuedAt,
                'exp' => $this->expire,
                'data' => $data
            ];          
            $jwt = JWT::encode($this->payload, $this->key, 'HS256');
            return $jwt;
        }

        public function jwt_Decode($jwt){
            try{
                $key = base64_encode(SECRETE_KEY);
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
                
                $decoded_Return = json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$decoded->data, 'iat'=>$decoded->iat));
            }catch(Exception $e) {
                $decoded_Return = json_encode(array('Status'=>JWT_PROCESSING_ERROR, 'Message'=>$e->getMessage()));
            }

            return $decoded_Return;
        }
     }
?>