<?php


namespace App\Http\Interfaces;


interface CompanyInterface
{
    public function allCases($request);

    public function specificCase($request);

    public function addCase($request);

    public function updateCase($request);

    public function deleteCase($request);

}
