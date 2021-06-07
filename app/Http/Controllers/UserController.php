<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function login(Request $request) {
        $username = $request->user["username"];
        $password = $request->user["password"];
        if($username == "foo" && $password == "bar") {
            $apiResponse = '{ "username": "foo", "displayName": "Foo Bar Foo", "roles": [ "basic-user" ] }';
        }
        else {
            $apiResponse = '{ "message": "Invalid username or password." }';
        }

        return response($apiResponse, 200)->header('Content-Type', 'application/json');
    }
}
