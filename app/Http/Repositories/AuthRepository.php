<?php

namespace App\Http\Repositories;

/** Created By Mohamed Gouda.*/

use App\Http\Interfaces\AuthInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\TokenTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;

class AuthRepository implements AuthInterface{

    // Use Trait To Design API's.
    use ApiResponseTrait;
    use TokenTrait;

    /** Group of model as vars */
    protected $user_model;
    protected $role_model;
    protected $user_role_model;

    /** Construct to handle inject models
     * @param User $user
     */
    public function __construct(User $user){
        $this->user_model = $user;

    }

    public function login($request)
    {
        /**
         * Build:[
         *  request validation
         *  check if the user is active or not
         *  Login data
         * ]
        */
        $Validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8',
        ],
        [
            'email.required' => 'يجب ادخال البريد',
            'password.required' => 'يرجى إدخال كلمة المرور الصحيحة',
            'password.min' => 'يرجى إدخال كلمة المرور الصحيحة',
        ]
        );

        if($Validator->fails()){
            return $this->apiResponse(422 , "Validation Errors", $Validator->errors());
        }

        $credentials = $request->only('email', 'password');

        if ($token = auth()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return $this->apiResponse(400 , 'البريد أو كلمة المرور غير صحيح');

    }

    /** update password*/
    public function updatePassword($request)
    {

        $validation = validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'min:8|different:password',
        ],[
            'required' => 'هذا الحقل مطلوب',
            'new_password.min' => 'يجب أن لا يقل عن ٨ أحرف',
            'new_password.different' => 'الرقم السري غير متطابق'
        ]);


        if($validation->fails()){
            return $this->apiResponse(422 , "Validation Errors" , $validation->errors());
        }

        $userData = $this->getAuthenticatedUser();
        $user = $this->user_model::where('id', $userData->id)->first();


        if (Hash::check($request->password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return $this->apiResponse(200 , 'تم التغير بنجاح');
        }
        else {
            return $this->apiResponse(422 , 'الرقم السري غير صحيح');
        }
    }

    // User Data Function
    public function userData($id , $token){
        $user = User::where("id" , $id)->with('userRole')->first();

        return [
            'id' => $user['id'],
            'name' => $user['fullname'],
            'email' => $user['email'],
            'token' => $token,
            'role' => $user->userRole['role_id'],
            'role_type' => $user->userRole->roleData['name'],

        ];
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data =  $this->userData(auth()->user()->id , $token);

        return $this->apiResponse(200 , 'Successfully', null ,$data);

    }

}
