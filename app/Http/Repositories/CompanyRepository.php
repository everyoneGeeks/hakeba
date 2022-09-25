<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\CasesInterface;
use App\Http\Interfaces\CompanyInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\FileUploaderTrait;
use App\Models\case_staff;
use App\Models\cases;
use App\Models\company_case;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyRepository implements CompanyInterface
{
    use ApiResponseTrait;
    use FileUploaderTrait;


    /**
     * @var case_staff
     */
    private $case_staff_model;
    private $cases_model;
    private $company_cases_model;

    public function __construct(case_staff $case_staff, company_case $company_case)
    {
        $this->case_staff_model = $case_staff;
        $this->company_cases_model = $company_case;
    }


    public function allCases($request)
    {
        if (auth()->user()->userRole->name === 'company') {
            $data = $this->company_cases_model::where('user_id', auth()->user()->id)->get();
        } else {
            $data = $this->company_cases_model::get();
        }
        return $this->apiResponse(200 , 'Success',null, $data);
    }

    public function specificCase($request){
        $validation = Validator::make($request->all(),[
            'case_id' => 'required|exists:company_cases,id'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $data = $this->company_cases_model::where('id',$request->case_id)->with(['user', 'caseType'])->first();
        return $this->apiResponse(200 , 'Success',null, $data);

    }

    public function addCase($request)
    {
        $validation = Validator::make($request->all(),[
            'company_name' => 'required|min:3',
            'case_type' => 'required|exists:case_types,id',
            'client_name' => 'required',
            'phone' => 'required',
            'start_work_date' => 'required',
            'end_work_date' => 'required',
        ],[
            'company_name.min' => 'يجب أن لا يقل عن 3 أحرف',
            'required' => 'هذا الحقل مطلوب'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

         $this->company_cases_model::create([
             'company_name' => $request->company_name,
             'case_type' => $request->case_type,
            'client_name' => $request->client_name,
            'phone' => $request->phone,
            'start_work_date' => $request->start_work_date,
            'end_work_date' => $request->end_work_date
        ]);

        return $this->apiResponse(422, 'تم إنشاء القضية بنجاح');
    }

    public function updateCase($request)
    {
        $validation = Validator::make($request->all(),[
            'company_name' => 'required|min:3',
            'case_type' => 'required|exists:case_types,id',
            'client_name' => 'required',
            'phone' => 'required',
            'start_work_date' => 'required',
            'end_work_date' => 'required',
            'case_id' => 'required|exists:company_cases,id'
        ],[
            'company_name.min' => 'يجب أن لا يقل عن 3 أحرف',
            'required' => 'هذا الحقل مطلوب'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $case = $this->company_cases_model::find($request->case_id);
            $case->update([
                'company_name' => $request->company_name,
                'case_type' => $request->case_type,
                'client_name' => $request->client_name,
                'phone' => $request->phone,
                'start_work_date' => $request->start_work_date,
                'end_work_date' => $request->end_work_date
            ]);

            return $this->apiResponse(200, 'Updated');
    }

    public function deleteCase($request)
    {
        $validation = Validator::make($request->all(),[
            'case_id' => 'required'
        ],[
            'required' => 'هذا الحقل مطلوب'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $this->company_cases_model::find($request->case_id)->delete();

        return $this->apiResponse(200, 'Deleted');

    }
}
