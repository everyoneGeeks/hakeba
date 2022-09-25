<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\AuthInterface;

class AuthController extends Controller
{
    /** interface as vars */
    protected $authInterface;

    /** Construct to handle inject models
     * @param AuthInterface $authInterface
     */
    public function __construct(AuthInterface $authInterface){
        $this->authInterface = $authInterface;
    }

    public function login(Request $request){
        return $this->authInterface->login($request);
    }


    public function updatePassword(Request $request){
        return $this->authInterface->updatePassword($request);
    }




    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }


}
