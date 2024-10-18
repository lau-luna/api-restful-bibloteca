<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use App\Models\User;

class JwtAuth {
    public $key;

    public function __construct()
    {
        $this->key = 'esto_es_una_clave_super_secreta-298765171';
    }
    
    public function signup($email, $password, $getToken = null) {
        // Buscar si existe el usuario con su email
        $user = User::where('email', $email)->first();

        // Comprobar si el usuario existe y la contraseña es correcta
        if (is_object($user) && password_verify($password, $user->password)) {
            // Generar el token con los datos del usuario identificado
            $token = [
                'sub'       => $user->id,
                'email'     => $user->email,
                'name'      => $user->name,
                'surname'   => $user->surname,
                'iat'       => time(),
                'exp'       => time() + (7 * 24 * 60 * 60) // 1 semana
            ];

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);

            // Devolver los datos decodificados o el token, en función de un parámetro
            $data = is_null($getToken) ? $jwt : $decoded;
        } else {
            // Login incorrecto
            $data = [
                'status' => 'error',
                'message' => 'Login incorrecto'
            ];
        }

        return $data;
    }

    public function checkToken($jwt, $getIdentity = false) {
        $auth = false;
        $decoded = null;

        try {
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch(\UnexpectedValueException | \DomainException $e) {
            // Manejo de errores opcional
            $auth = false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        }

        if ($getIdentity && $decoded) {
            return $decoded;
        }

        return $auth;
    }
}
