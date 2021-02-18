<?php

use Agent\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Lambda\Config\Lambda;

function authUser()
{
    $request = \Config\Services::request();
    $token = getJWTFromRequest($request);

    return validateJWTFromRequest($token);
}
function getJWTFromRequest($request): string
{
    $authenticationHeader = $request->getServer('HTTP_AUTHORIZATION');
    if (is_null($authenticationHeader)) { //JWT is absent
        helper('cookie');
        $token = get_cookie("token");
        if ($token) {
            return $token;
        }
        throw new Exception('Missing or invalid JWT in request');
    }
    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];

}

function validateJWTFromRequest(string $encodedToken)
{
    $key = Lambda::getJWTSECRETKEY();
    $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
    $userModel = new UserModel();
    $user = $userModel->findUserByLoginAddress($decodedToken->login);

    if (!$user)
        throw new Exception('User does not exist for specified email address');

    unset($user['password']);

    return $user;
}

function getExpire(string $encodedToken)
{
    $key = Lambda::getJWTSECRETKEY();
    $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
    return $decodedToken->exp;
}

function getSignedJWTForUser(string $login)
{
    $issuedAtTime = time();
    $tokenTimeToLive = Lambda::getJWTTIMETOLIVE();
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'login' => $login,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    $jwt = JWT::encode($payload, Lambda::getJWTSECRETKEY());
    return $jwt;
}

