<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function login(Request $request) {
        $apiResponse = '{ "username": "foo", "displayName": "Foo Bar Foo", "roles": [ "basic-user" ] }';
        // $apiResponse = '{ "message": "Invalid username or password." }';

        return response($apiResponse, 200)->header('Content-Type', 'application/json');
    }
}
