<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserController;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userController = new UserController();
        if(!$userController->isTokenValid($request->header("token"))) {
            $response = [
                "status" => "ERROR",
                "message" => "Permission denied!",
            ];
            return response(json_encode($response), 200)->header('Content-Type', 'application/json');
        }
        return $next($request);
    }
}
