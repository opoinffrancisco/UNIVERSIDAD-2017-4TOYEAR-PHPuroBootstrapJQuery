<?php
// require_once __DIR__ . '../../vendor/autoload.php';
use Firebase\JWT\JWT;

class blickyerSIGMANSTEC
{
    private static $secret_key = 'Sdw1s9x8@'; // CAMBIARLO A PREFERENCIA - LUEGO COLOCAR DE FORMA DINAMICA
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function set($data)
    {
        //$time = time();
        $token = array(
            //'exp' => $time + (60*60),
            'data' => $data
        );
        return JWT::encode($token, self::$secret_key);
    }

    public static function get($token)
    {
        return  JWT::decode(
                    $token,
                    self::$secret_key,
                    self::$encrypt
                )->data;
    }
    // para verificar si es la de la computadora
    public static function Check($token)
    {
        return (empty($token))?false:true;
    }
}