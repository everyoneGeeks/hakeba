<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\CasesInterface;
use App\Http\Interfaces\CompanyInterface;
use Illuminate\Http\Request;

class CompanyCasesController extends Controller
{
    protected $companyInterface;

    public function __construct(CompanyInterface $companyInterface)
    {
        $this->companyInterface = $companyInterface;
    }

    public function allCases(Request $request)
    {
        return $this->companyInterface->allCases($request);
    }

    public function specificCase(Request $request)
    {
        return $this->companyInterface->specificCase($request);
    }

    public function addCase(Request $request)
    {
        return $this->companyInterface->addCase($request);
    }

    public function updateCase(Request $request)
    {
        return $this->companyInterface->updateCase($request);
    }

    public function deleteCase(Request $request)
    {
        return $this->companyInterface->deleteCase($request);
    }

}
