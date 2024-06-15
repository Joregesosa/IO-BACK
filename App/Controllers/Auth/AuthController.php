<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Models\Session;
use Models\User;

class AuthController
{
    private $secretKey;

    public function __construct()
    {
        /* $this->secretKey = $_ENV['APP_KEY']; */
        $this->secretKey = 'NjRkZmk0eHF4Z2Vzems0OHpsbnZ0azdpNm03MnNiOXc';
    }

    function login($request)
    {

        $find_user = new User();
        $user = $find_user->where('email', $request['data']['email']);
        if ($user) {
            if (password_verify($request['data']['password'], $user['password'])) {

                $tokenId    = base64_encode(random_bytes(32));
                $issuedAt   = new \DateTimeImmutable();
                $expire     = $issuedAt->modify('+30 day')->getTimestamp();
                $serverName = 'locallhost';

                /*
                      * Create the token as an array
                */
                $data = [
                    'iat'  => $issuedAt->getTimestamp(),
                    'jti'  => $tokenId,
                    'iss'  => $serverName,
                    'nbf'  => $issuedAt->getTimestamp(),
                    'exp'  => $expire,
                    'data' => [
                        'userId'   => $user['id'],
                        'userName' => $user['name'],
                    ]
                ];

                $jwt = JWT::encode(
                    $data,
                    $this->secretKey,
                    'HS512'
                );

                $session = new Session();
                $session->create([
                    'user_id' => $user['id'],
                    'token' => $jwt,
                ]);

                $unencodedArray = ['jwt' => $jwt];
                echo json_encode($unencodedArray);
            } else {
                echo json_encode(['error' => 'Invalid password']);
            }
        } else {
            echo json_encode(['error' => 'User not found']);
        }
    }

    function logout()
    {
        try {
            $token = str_replace("Bearer ", '', $_SERVER["HTTP_AUTHORIZATION"]);
            $session = new Session();
            $session_data = $session->where('token', $token);
            $session->update($session_data['id'], ['status' => 0]);

            echo json_encode(['message' => 'User logged out']);

        } catch (\Exception $e) {
            echo json_encode(['error' => 'An error occurred while logging out' . $e->getMessage()]);
        }
    }

    function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS512'));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }
}
