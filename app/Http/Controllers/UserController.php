<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function verify(Request $request) {
        $username = $request->input("username");
        $password = $request->input("password");
        $response = [
            "status" => "OK",
            "message" => "",
            "user" => null, 
        ];
        $apiResponse = Http::post("https://netzwelt-devtest.azurewebsites.net/Account/SignIn", [
            "username" => $username,
            "password" => $password
        ]);
        $apiResponse = json_decode($apiResponse);
        if(property_exists($apiResponse, "message")) {
            $response["status"] = "ERROR";
            $response["message"] = $apiResponse->message;
        }
        else {
            $response["user"] = $apiResponse;
        }
        return $response;
    }

    public function login(Request $request) {
        $response = $this->verify($request);

        return response(json_encode($response), 200)->header('Content-Type', 'application/json');
    }
}
