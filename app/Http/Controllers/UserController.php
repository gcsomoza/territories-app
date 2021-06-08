<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    protected function generateToken($username, $password) {
        $credentials = [
            "username" => $username,
            "password" => $password,
        ];
        return Crypt::encryptString(json_encode($credentials));
    }

    protected function authenticate($username, $password) {
        $response = [
            "status" => "OK",
            "message" => "",
            "profile" => null, 
            "token" => null,
        ];
        $apiArgs = [
            "username" => $username,
            "password" => $password
        ];
        $apiResponse = Http::post("https://netzwelt-devtest.azurewebsites.net/Account/SignIn", $apiArgs);
        $apiResponse = json_decode($apiResponse);
        if(property_exists($apiResponse, "message")) {
            $response["status"] = "ERROR";
            $response["message"] = $apiResponse->message;
        }
        else {
            $response["profile"] = $apiResponse;
        }
        return $response;
    }

    public function isTokenValid($token) {
        try {
            $credentials = json_decode(Crypt::decryptString($token));
            $response = $this->authenticate($credentials->username, $credentials->password);
            return $response["status"] == "OK";
        }
        catch(DecryptException $de) {
            return false;
        }
    }

    public function login(Request $request) {
        $username = $request->input("username");
        $password = $request->input("password");
        $response = $this->authenticate($username, $password);
        if($response["status"] == "OK") {
            $response["token"] = $this->generateToken($username, $password);
        }

        return response(json_encode($response), 200)->header('Content-Type', 'application/json');
    }
}
