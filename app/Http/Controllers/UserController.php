<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function verify($username, $password) {
        $response = [
            "status" => "OK",
            "message" => "",
            "user" => null, 
        ];
        if($username == "foo" && $password == "bar") {
            $apiResponse = '{ "username": "foo", "displayName": "Foo Bar Foo", "roles": [ "basic-user" ] }';
            $apiResponse = json_decode($apiResponse);
            $response["user"] = $apiResponse;
        }
        else {
            $apiResponse = '{ "message": "Invalid username or password." }';
            $apiResponse = json_decode($apiResponse);
            $response["status"] = "ERROR";
            $response["message"] = $apiResponse->message;
        }
        return $response;
    }

    public function login(Request $request) {
        $username = $request->input("username");
        $password = $request->input("password");
        $response = $this->verify($username, $password);

        return response(json_encode($response), 200)->header('Content-Type', 'application/json');
    }
}
