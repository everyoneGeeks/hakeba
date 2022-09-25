<?php

namespace App\Http\Interfaces;

/** Created By Mohamed Gouda */

interface TypesInterface{

    public function allTypes($request);

    public function addType($request);

    public function updateType($request);

    public function deleteType($request);

}
