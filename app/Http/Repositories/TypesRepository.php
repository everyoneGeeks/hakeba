<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\TypesInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\case_type;
use App\Models\contract_type;
use Illuminate\Support\Facades\Validator;


class TypesRepository implements TypesInterface{

    // Use Trait To Design API's.
    use ApiResponseTrait;

    /** Group of model as vars */
    private $case_type_model;
    private $contract_type_model;

    /** Construct to handel inject models
     * @param case_type $case_type
     * @param contract_type $contract_type
     */
    public function __construct(case_type $case_type, contract_type $contract_type){
        $this->case_type_model = $case_type;
        $this->contract_type_model = $contract_type;
    }


    public function allTypes($request)
    {
        $modelName = $this->case_type_model;

        if($request->type == 'contract'){
            $modelName = $this->contract_type_model;
        }

        $types = $modelName::get();

        return $this->apiResponse(200, 'Done', null, $types);
    }

    public function addType($request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'type' => 'required'
        ],[
            'required' => 'هذا الحقل مطلوب'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $modelName = $this->case_type_model;

        if($request->type == 'contract'){
            $modelName = $this->contract_type_model;
        }
        $modelName::create([
            'name' => $request->name
        ]);

        return $this->apiResponse(422, 'Added');

    }

    public function updateType($request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'type' => 'required',
            'type_id' => 'required'
        ],[
            'required' => 'هذا الحقل مطلوب'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $modelName = $this->case_type_model;

        if($request->type == 'contract'){
            $modelName = $this->contract_type_model;
        }

        $type = $modelName::where('id', $request->type_id)->first();
        if($type){
            $type->update([
                'name' => $request->name
            ]);
            return $this->apiResponse(200, 'Updated');
        }
        return $this->apiResponse(422, 'Not Found');

    }

    public function deleteType($request)
    {
        $validation = Validator::make($request->all(),[
            'type_id' => 'required'
        ],[
            'required' => 'هذا الحقل مطلوب'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422, 'Validation Errors', $validation->errors());
        }

        $modelName = $this->case_type_model;

        if($request->type == 'contract'){
            $modelName = $this->contract_type_model;
        }

        $type = $modelName::find($request->type_id);
        if($type){
            $type->delete();
            return $this->apiResponse(200, 'Deleted');
        }

        return $this->apiResponse(422, 'Not Found');


    }
}
