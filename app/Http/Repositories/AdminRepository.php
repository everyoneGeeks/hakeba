<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AdminInterface;
use App\Http\Traits\ApiResponseTrait;

use App\Models\client;
use App\Models\library;
use App\Models\role;
use App\Models\User;
use App\Models\user_role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminRepository implements AdminInterface {

    // Use Trait To Design API's.
    use ApiResponseTrait;

    /** Group of model as vars */
    private $user_model;
    private $client_model;
    private $user_role_model;
    private $role_model;
    private $libraryModel;

    /** Construct to handle inject models*
     * @param User $user
     * @param library $library
     * @param client $client
     * @param user_role $user_role
     * @param role $role
     */

    public function __construct(User $user, library $library, client $client, user_role $user_role, role $role){
        $this->user_model = $user;
        $this->client_model = $client;
        $this->user_role_model = $user_role;
        $this->role_model = $role;
        $this->libraryModel = $library;
    }


    public function allStaff()
    {
        $data = $this->user_model::whereHas('userRole', function($q){
            return $q->whereHas('roleData', function($query){
                return $query->whereIn('name', ['mohamy', 'mostshar']);
            });
        })->get();
        return $this->apiResponse(200, 'Done',null, $data);
    }

    public function addStaff($request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|unique:users',
            'name' => 'required',
            'role_id' => 'required',
            'password' => 'min:8|required',
            'confirm_password' => 'required|min:8'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'min' => 'يجب أن لا يقل عن ٨ أحرف',
            'email.unique' => 'هذا الايميل موجود من قبل',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

        $user = $this->user_model::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $this->user_role_model::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
        ]);

        return $this->apiResponse(200, 'نم إضافة الموظف بنجاح');
    }

    public function deleteStaff($request)
    {
        $staff = $this->user_model::find($request->staff_id);
        if($staff){
         $staff->delete();
            return $this->apiResponse(200, 'تم مسح الموظف بنجاح');
        }
        return $this->apiResponse(422, 'غير موجود');

    }

    public function updateStaff($request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|unique:users,email,'.$request->user_id,
            'name' => 'required',
            'user_id' => 'required|exists:users,id'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'min' => 'يجب أن لا يقل عن ٨ أحرف',
            'email.unique' => 'هذا الايميل موجود من قبل',
            'user_id.exists' => 'برجاء اختيار موظف صحيح'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

       $this->user_model->find($request->user_id)->update([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
        ]);

        if($request->has('role_id')){
            $userRole = $this->user_role_model::where('user_id', $request->user_id)->first();
            $userRole->update([
                'role_id' => $request->role_id
            ]);
        }

        return $this->apiResponse(200 , "تم التعديل بنجاح" );

    }

    public function specificStaff($request)
    {
        $validation = Validator::make($request->all(),[
            'staff_id' => 'required|exists:users,id',
        ],[
            'required' => 'هذا الحقل مطلوب',
            'exists' => 'هذا المستخدم غير موجود من قبل',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

        $data = $this->user_model::find($request->staff_id);

        return $this->apiResponse(200, 'Done',null, $data);
    }

    public function allClients()
    {
        $data = $this->user_model::whereHas('userRole', function($q){
            return $q->whereHas('roleData', function($query){
                return $query->where('name', 'client');
            });
        })->get();
        return $this->apiResponse(200, 'Done',null, $data);
    }

    public function specificClient($request){

        $validation = Validator::make($request->all(),[
            'client_id' => 'required|exists:users,id',
        ],[
            'required' => 'هذا الحقل مطلوب',
            'exists' => 'هذا المستخدم غير موجود من قبل',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

        $data = $this->user_model::where('id', $request->client_id)->with('clientData')->first();

        return $this->apiResponse(200, 'Done',null, $data);
    }

    public function addClient($request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|unique:users',
            'name' => 'required',
            'national_id' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'fixed_line' => 'required',
            'address' => 'required',
            're_phone' => 'required',
            'password' => 'min:8|required',
            'confirm_password' => 'required|min:8'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'min' => 'يجب أن لا يقل عن ٨ أحرف',
            'email.unique' => 'هذا الايميل موجود من قبل',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

        $user = $this->user_model::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $this->client_model::create([
            'national_id' => $request->national_id,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'fixed_line' => $request->fixed_line,
            'address' => $request->address,
            're_phone' => $request->re_phone,
            'user_id' => $user->id,
        ]);

        $role = $this->role_model::where('name', 'client')->first();

        $this->user_role_model::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        return $this->apiResponse(200, 'نم إضافة العميل بنجاح');

    }

    public function deleteClient($request)
    {
        $client = $this->user_model::find($request->staff_id);
        if($client){
            $client->delete();
            return $this->apiResponse(200, 'تم حذف الموظف بنجاح');
        }
        return $this->apiResponse(422, 'غير موجود');
    }

    public function updateClient($request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|unique:users,email,'.$request->user_id,
            'name' => 'required',
            'user_id' => 'required|exists:users,id'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'min' => 'يجب أن لا يقل عن ٨ أحرف',
            'email.unique' => 'هذا الايميل موجود من قبل',
            'user_id.exists' => 'برجاء اختيار موظف صحيح'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

        $this->user_model->find($request->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->apiResponse(200 , "تم التعديل بنجاح" );
    }

    public function staffRoles()
    {
        $data = $this->role_model::where('name', '!=', 'Client')->get();
        return $this->apiResponse(200,  'Done', null, $data);
    }

    public function allLibraryItems()
    {
        $data = $this->libraryModel::get();
        return $this->apiResponse(200,  'Done', null, $data);
    }

    public function addLibraryItem($request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'file' => 'required'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'min' => 'يجب أن لا يقل عن ٨ أحرف',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = $this->uploadFile($file, 'Hakiba/library');
        }

        $this->libraryModel::create([
            'name' => $request->name,
            'file' => $fileName
        ]);

        return $this->apiResponse(200,  'File Was Added');

    }

    public function deleteLibraryItem($request)
    {
        $validation = Validator::make($request->all(),[
            'file_id' => 'required|exists:libraries,id'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'file_id.exists' => 'برجاء اختيار موظف صحيح'
        ]);

        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }
        $this->libraryModel::find($request->file_id)->delete();

        return $this->apiResponse(200,  'File Was Deleted');

    }
}
