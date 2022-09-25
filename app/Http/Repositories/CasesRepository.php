<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\CasesInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\FileUploaderTrait;
use App\Models\case_staff;
use App\Models\cases;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CasesRepository implements CasesInterface
{
    use ApiResponseTrait;
    use FileUploaderTrait;


    /**
     * @var case_staff
     */
    private $case_staff_model;
    private $cases_model;

    public function __construct(case_staff $case_staff, cases $cases)
    {
        $this->case_staff_model = $case_staff;
        $this->cases_model = $cases;
    }


    public function allCases($request)
    {
        if (auth()->user()->userRole->name === 'mohamy') {
            $data = $this->cases_model::where('user_id', auth()->user()->id)->with('caseType')->get();
        } else {
            $data = $this->cases_model::with(['user', 'caseType'])->get();
        }
        return $this->apiResponse(200 , 'Success',null, $data);
    }

    public function specificCase($request){
        $validation = Validator::make($request->all(),[
            'case_id' => 'required|exists:cases,id'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $data = $this->cases_model::where('id',$request->case_id)->with(['user', 'caseType'])->first();
        return $this->apiResponse(200 , 'Success',null, $data);

    }

    public function addCase($request)
    {
        $validation = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'case_type' => 'required|exists:case_types,id',
            'defendant_name' => 'required|min:3',
            'defendant_address' => 'required',
            'civil' => 'required',
            'defendant_status' => 'required',
            'case_date' => 'required',
            'session_date' => 'required',
            'file_office_number' => 'required',
            'file_court_number' => 'required',
            'registration_number' => 'required',
            'circle_case' => 'required',
            'id_card_file' => 'required',
            'commercial_register_file' => 'required',
            'establishment_contract_file' => 'required',
            'case_document_file' => 'required',
            'note_file' => 'required',
            'adjust_session_file' => 'required',
            'start_authorization_date' => 'required',
            'end_authorization_date' => 'required',
            'lawyers' => 'required'
        ],[
            'defendant_name.min' => 'يجب أن لا يقل عن 3 أحرف',
            'required' => 'هذا الحقل مطلوب'
        ]);


        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $idCardFile = '';
        if($request->hasFile('id_card_file')){
            $file = $request->file('id_card_file');
            $idCardFile = $this->uploadFile($file, 'Hakiba/Cases');
        }


        $commercialRegisterFile = '';
        if($request->hasFile('commercial_register_file')){
            $file = $request->file('commercial_register_file');
            $commercialRegisterFile = $this->uploadFile($file, 'Hakiba/Cases');
        }


        $establishmentContractFile = '';
        if($request->hasFile('establishment_contract_file')){
            $file = $request->file('establishment_contract_file');
            $establishmentContractFile = $this->uploadFile($file, 'Hakiba/Cases');
        }


        $caseDocumentFile = '';
        if($request->hasFile('case_document_file')){
            $file = $request->file('case_document_file');
            $caseDocumentFile = $this->uploadFile($file, 'Hakiba/Cases');
        }

        $noteFile = '';
        if($request->hasFile('note_file')){
            $file = $request->file('note_file');
            $noteFile = $this->uploadFile($file, 'Hakiba/Cases');
        }

        $adjustSessionFile = '';
        if($request->hasFile('adjust_session_file')){
            $file = $request->file('adjust_session_file');
            $adjustSessionFile = $this->uploadFile($file, 'Hakiba/Cases');
        }

        $case = $this->cases_model::create([
            'user_id' => $request->user_id,
            'case_type' => $request->case_type,
            'defendant_name' => $request->defendant_name,
            'defendant_address' => $request->defendant_address,
            'civil' => $request->civil,
            'defendant_status' => $request->defendant_status,
            'case_date' => $request->case_date,
            'session_date' => $request->session_date,
            'file_office_number' => $request->file_office_number,
            'file_court_number' => $request->file_court_number,
            'registration_number' => $request->registration_number,
            'circle_case' => $request->circle_case,

            'id_card_file' => $idCardFile,
            'commercial_register_file' => $commercialRegisterFile,
            'establishment_contract_file' => $establishmentContractFile,
            'case_document_file' => $caseDocumentFile,
            'note_file' => $noteFile,
            'adjust_session_file' => $adjustSessionFile,

            'start_authorization_date' => $request->start_authorization_date,
            'end_authorization_date' => $request->end_authorization_date,

        ]);

        if($request->has('lawyers')){
            foreach ($request->lawyers as $lawyer){
                $this->case_staff_model::create([
                    'case_id' => $case->id,
                    'user_id' => $lawyer
                ]);
            }
        }

        return $this->apiResponse(200, 'تم إنشاء القضية بنجاح');

    }

    public function updateCase($request)
    {
        $validation = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'case_type' => 'required|exists:case_types,id',
            'defendant_name' => 'required|min:3',
            'defendant_address' => 'required',
            'civil' => 'required',
            'defendant_status' => 'required',
            'case_date' => 'required',
            'session_date' => 'required',
            'file_office_number' => 'required',
            'file_court_number' => 'required',
            'registration_number' => 'required',
            'circle_case' => 'required',
            'id_card_file' => 'required',
            'commercial_register_file' => 'required',
            'establishment_contract_file' => 'required',
            'case_document_file' => 'required',
            'note_file' => 'required',
            'adjust_session_file' => 'required',
            'start_authorization_date' => 'required',
            'end_authorization_date' => 'required',
            'case_id' => 'required',

        ],[
            'defendant_name.min' => 'يجب أن لا يقل عن 3 أحرف',
            'required' => 'هذا الحقل مطلوب'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $case = $this->cases_model::where('id', $request->case_id)->first();
        if($case){

            $idCardFile = $case->id_card_file;
            if($request->hasFile('id_card_file')){
                $file = $request->file('id_card_file');
                $idCardFile = $this->uploadFile($file, 'Hakiba/Cases');
            }

            $commercialRegisterFile = $case->commercial_register_file;
            if($request->hasFile('commercial_register_file')){
                $file = $request->file('commercial_register_file');
                $commercialRegisterFile = $this->uploadFile($file, 'Hakiba/Cases');
            }

            $establishmentContractFile = $case->establishment_contract_file;
            if($request->hasFile('establishment_contract_file')){
                $file = $request->file('establishment_contract_file');
                $establishmentContractFile = $this->uploadFile($file, 'Hakiba/Cases');
            }

            $caseDocumentFile = $case->case_document_file;
            if($request->hasFile('case_document_file')){
                $file = $request->file('case_document_file');
                $caseDocumentFile = $this->uploadFile($file, 'Hakiba/Cases');
            }

            $noteFile = $case->note_file;
            if($request->hasFile('note_file')){
                $file = $request->file('note_file');
                $noteFile = $this->uploadFile($file, 'Hakiba/Cases');
            }

            $adjustSessionFile = $case->adjust_session_file;
            if($request->hasFile('adjust_session_file')){
                $file = $request->file('adjust_session_file');
                $adjustSessionFile = $this->uploadFile($file, 'Hakiba/Cases');
            }

            $case->update([
                'user_id' => $request->user_id,
                'case_type' => $request->case_type,
                'defendant_name' => $request->defendant_name,
                'defendant_address' => $request->defendant_address,
                'civil' => $request->civil,
                'defendant_status' => $request->defendant_status,
                'case_date' => $request->case_date,
                'session_date' => $request->session_date,
                'file_office_number' => $request->file_office_number,
                'file_court_number' => $request->file_court_number,
                'registration_number' => $request->registration_number,
                'circle_case' => $request->circle_case,

                'id_card_file' => $idCardFile,
                'commercial_register_file' => $commercialRegisterFile,
                'establishment_contract_file' => $establishmentContractFile,
                'case_document_file' => $caseDocumentFile,
                'note_file' => $noteFile,
                'adjust_session_file' => $adjustSessionFile,

                'start_authorization_date' => $request->start_authorization_date,
                'end_authorization_date' => $request->end_authorization_date,
            ]);

            if($request->has('lawyers')){
                $oldLawyers = $this->case_staff_model::where('case_id', $case->id)->get();
                foreach ($oldLawyers as $lawyer){
                    $listOldLawyersIds[] = $lawyer->user_id;
                }
                $listDeletedLawyers = array_diff($listOldLawyersIds, $request->lawyers);

                foreach ($listDeletedLawyers as $lawyer){
                    $this->case_staff_model::where('user_id', $lawyer)->delete();
                }

                $lisNewLawyers = array_diff($request->lawyers, $listOldLawyersIds);
                foreach ($lisNewLawyers as $lawyer){
                    $this->case_staff_model::create([
                        'case_id'=> $case->id,
                        'user_id'=> $lawyer,
                    ]);

                }
            }

            return $this->apiResponse(200, 'Updated');
        }
        return $this->apiResponse(422, 'Not Found');

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

        $type = $this->cases_model::find($request->case_id);
        if($type){
            $type->delete();
            return $this->apiResponse(200, 'Deleted');
        }

        return $this->apiResponse(422, 'Not Found');

    }
}
