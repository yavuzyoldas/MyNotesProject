<?php

class JWT{


    public function generate_token($user_id){

        $data = array(
            'userId'=>$user_id,
            'login'=>time(),
            'logout'=> time() + 60*1,
            'issuedAt'=>date(DATE_ISO8601, strtotime("now"))
        );


        return  ($this->urlsafeB64Encode($this->jsonEncode($data)));
    }



    public function urlsafeB64Decode($input)
    {

        return base64_decode($input);
    }

    public function urlsafeB64Encode($input)
    {
        return base64_encode($input);
    }
    /**
     * @param string $input JSON string
     *
     * @return object Object representation of JSON string
     */
    public function jsonDecode($input)
    {
        $obj = json_decode($input);
        return $obj;
    }

    /**
     * @param object|array $input A PHP object or array
     *
     * @return string JSON representation of the PHP object or array
     */
    public function jsonEncode($input)
    {
        $json = json_encode($input);

        if (function_exists('json_last_error') && $errno = json_last_error()) {
            $this->handleJsonError($errno);
        }
        else if ($json === 'null' && $input !== null) {
            throw new DomainException('Null result with non-null input');
        }
        return $json;
    }

    public function decode_token($token){
        return $this->jsonDecode($this->urlsafeB64Decode($token));


    }
    public function isLogin($token){
        $userId = @($this->jsonDecode($this->urlsafeB64Decode($token)))->userId;
        if (!$userId)
            return false;
        else
            return $userId;
    }


}