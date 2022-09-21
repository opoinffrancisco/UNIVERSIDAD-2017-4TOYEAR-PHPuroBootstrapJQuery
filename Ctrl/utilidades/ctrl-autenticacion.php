<?php
use Firebase\JWT\JWT;

class Auth
{
    private static $secret_key = 'Sdw1s9x8@'; // CAMBIARLO A PREFERENCIA - LUEGO COLOCAR DE FORMA DINAMICA
    private static $encrypt = ['HS256'];
    private static $aud = null;
    
    public static function SignIn($data)
    {
        $time = time();
        
        $token = array(
            //'exp' => $time + (60*60),
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    }
    // para verificar si es la de la computadora
    public static function Check($token)
    {
        $valida = 0;

        if(empty($token))
        {
            $valida = 1;
            //throw new Exception("Invalid token supplied.");
        }
        
        $decode = JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );
        
        if($decode->aud !== self::Aud())
        {
            $valida = 2;
            //throw new Exception("Invalid user logged in.");
        }
        return $valida;
    }
/*    
    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }
*/
    public static function GetData($token)
    {
        return  JWT::decode(
                    $token,
                    self::$secret_key,
                    self::$encrypt
                )->data;
    }

    private static function Aud()
    {
        $aud = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();
        
        return sha1($aud);
    }
}