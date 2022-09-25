<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\TypesInterface;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    private $typesInterface;

    public function __construct(TypesInterface $typesInterface)
    {
        $this->typesInterface = $typesInterface;
    }

    public function allTypes(Request $request)
    {
        return $this->typesInterface->allTypes($request);
    }

    public function addType(Request $request)
    {
        return $this->typesInterface->addType($request);
    }

    public function updateType(Request $request)
    {
        return $this->typesInterface->updateType($request);
    }

    public function deleteType(Request $request)
    {
        return $this->typesInterface->deleteType($request);
    }
}
