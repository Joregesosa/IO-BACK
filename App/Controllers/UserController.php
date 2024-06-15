<?php

use Models\User;
use Controllers\Controller;

class UserController extends Controller
{
    /*  public function index()
    {
        try {
            $user = new User();
            $users = $user->all();
            return $users;
        } catch (Exception $e) {
            echo json_encode(["An error occurred: " . $e->getMessage()]);
        }
    } */

    public function show($request)
    {
        try {
            $user = new User();
            $user = $user->find($request['id']);
            if ($user) {
                echo json_encode($user);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'User not found']);
            }
        } catch (Exception $e) {
            echo json_encode(["An error occurred: " . $e->getMessage()]);
        }
    }

    public function create($request)
    {
        try {
            $user = new User();
            $request['data']['password'] = password_hash($request['data']['password'], PASSWORD_DEFAULT);
                
           $rs = $user->create($request['data']);
           
            echo json_encode(['message' => "User created successfully" , 'data'=> $rs]);  
        } catch (Exception $e) {
            echo json_encode(["An error occurred: " . $e->getMessage()]);
        }
    }

    public function update($request)
    {
        try {
            $user = new User();
            $existingUser = $user->find($request['id']);
            if ($existingUser) {
                $user->update($request['id'], $request['data']);
                echo json_encode(['message' => 'User updated successfully', 'data' => $user->find($request['id'])]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'User not found']);
            }
        } catch (Exception $e) {
            echo json_encode(["An error occurred: " . $e->getMessage()]);
        }
    }

    public function delete($request)
    {
        try {
            $user = new User();
            $existingUser = $user->find($request['id']);
            if ($existingUser) {
                $user->delete($request['id']);
                echo json_encode(['message' => 'User deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'User not found']);
            }
        } catch (Exception $e) {
            echo json_encode(["An error occurred: " . $e->getMessage()]);
        }
    }
}
