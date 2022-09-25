<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\CasesInterface;
use Illuminate\Http\Request;

class CasesController extends Controller
{
    protected $casesInterface;

    public function __construct(CasesInterface $casesInterface)
    {
        $this->casesInterface = $casesInterface;
    }

    public function allCases(Request $request)
    {
        return $this->casesInterface->allCases($request);
    }

    public function specificCase(Request $request)
    {
        return $this->casesInterface->specificCase($request);
    }

    public function addCase(Request $request)
    {
        return $this->casesInterface->addCase($request);
    }

    public function updateCase(Request $request)
    {
        return $this->casesInterface->updateCase($request);
    }

    public function deleteCase(Request $request)
    {
        return $this->casesInterface->deleteCase($request);
    }

}
