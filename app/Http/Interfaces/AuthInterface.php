<?php

namespace App\Http\Interfaces;

/** Created By Mohamed Gouda.*/

interface AuthInterface{

    public function login($request);

    public function updatePassword($request);


}
